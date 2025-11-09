<?php
/**
 * Slackware-Es theme functions
 *
 * Copyright (C) 2025 Pavel Espinal
 * Licensed under GNU General Public License v2 (or later)
 * https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'SLACKWAREES_THEME_VERSION' ) ) {
    define( 'SLACKWAREES_THEME_VERSION', '2.0.2' );
}

if ( ! function_exists( 'slackwarees_setup' ) ) :
    function slackwarees_setup() {
        // Let WP manage the document title.
        add_theme_support( 'title-tag' );

        // Add support for HTML5 markup for search forms, comment forms, comment lists, galleries, captions
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

        // Support for post thumbnails (optional)
        add_theme_support( 'post-thumbnails' );

        // Register sidebar-only menu location to manage from WP Admin
        register_nav_menus( array(
            'sidebar' => __( 'Sidebar Menu', 'slackwarees' ),
        ) );

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * `grunt pot` or `wp i18n make-pot` can be used to generate a .pot file.
         */
        load_theme_textdomain( 'slackwarees', get_template_directory() . '/languages' );
    }
endif;
add_action( 'after_setup_theme', 'slackwarees_setup' );

/**
 * Enqueue styles and scripts
 */
function slackwarees_enqueue_assets() {
    // Load the canonical stylesheet from assets/ (staged source-of-truth).
    $assets_path = get_theme_file_path( '/assets/css/style.css' );
    if ( file_exists( $assets_path ) ) {
        // Use file modification time as version for cache-busting during development.
        $ver = filemtime( $assets_path );
        if ( false === $ver ) {
            $ver = SLACKWAREES_THEME_VERSION;
        }
        wp_enqueue_style( 'slackwarees-style', get_theme_file_uri( '/assets/css/style.css' ), array(), $ver );
    }
}
add_action( 'wp_enqueue_scripts', 'slackwarees_enqueue_assets' );

/**
 * Custom walker to render sidebar menu items as <span><a>..</a></span> and
 * insert a separator span after the current item, to mimic legacy markup.
 */
class SlackwareES_Sidebar_Span_Walker extends Walker_Nav_Menu {
    // Track top-level item index and a pending post-current separator
    protected $top_index = 0;
    protected $pending_after_separator = false;
    /**
     * Control visibility of children at each depth. By default only top-level
     * items are visible; child items are shown only when their ancestor
     * branch contains the current item (uses WP's current-menu-* classes).
     *
     * Indexed by depth: display_children[0] corresponds to top-level items,
     * display_children[1] to first-level children, etc.
     *
     * @var array
     */
    protected $display_children = array();
    
    /**
     * Cache of menu item IDs that should be marked as active due to custom field relationships.
     * Populated once per menu render to avoid repeated lookups.
     *
     * @var array
     */
    protected $custom_active_items = array();

    public function __construct() {
        // Allow top-level items to be displayed by default.
        $this->display_children = array();
        $this->display_children[0] = true;
        
        // Pre-calculate which menu items should be active based on custom fields
        $this->calculate_custom_active_items();
    }
    
    /**
     * Pre-calculate which menu items should be marked as active based on
     * the current post's 'parent_page_id' custom field.
     */
    protected function calculate_custom_active_items() {
        global $post;
        
        if ( ! isset( $post->ID ) ) {
            return;
        }
        
        $parent_page_id = get_post_meta( $post->ID, 'parent_page_id', true );
        
        if ( empty( $parent_page_id ) ) {
            return;
        }
        
        // Get all menu items for the sidebar location
        $locations = get_nav_menu_locations();
        if ( ! isset( $locations['sidebar'] ) ) {
            return;
        }
        
        $menu_items = wp_get_nav_menu_items( $locations['sidebar'] );
        
        if ( ! $menu_items ) {
            return;
        }
        
        // Find the menu item that matches our parent_page_id
        foreach ( $menu_items as $menu_item ) {
            if ( isset( $menu_item->object_id ) && (int) $menu_item->object_id === (int) $parent_page_id ) {
                // Mark this item as active (cast to int to ensure type consistency)
                $this->custom_active_items[] = (int) $menu_item->ID;
                
                // Also mark all its ancestors as active (for nested menus)
                $current_ancestor_id = (int) $menu_item->menu_item_parent;
                while ( $current_ancestor_id > 0 ) {
                    if ( ! in_array( $current_ancestor_id, $this->custom_active_items, true ) ) {
                        $this->custom_active_items[] = (int) $current_ancestor_id;
                    }
                    
                    // Find the ancestor menu item to get its parent
                    $found_ancestor = false;
                    foreach ( $menu_items as $potential_ancestor ) {
                        if ( (int) $potential_ancestor->ID === (int) $current_ancestor_id ) {
                            $current_ancestor_id = (int) $potential_ancestor->menu_item_parent;
                            $found_ancestor = true;
                            break;
                        }
                    }
                    
                    // If we didn't find the ancestor or it has no parent, stop
                    if ( ! $found_ancestor || $current_ancestor_id === 0 ) {
                        break;
                    }
                }
                
                break;
            }
        }
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $title = isset( $item->title ) ? $item->title : '';
        $url   = isset( $item->url ) ? $item->url : '';
        $attr_title = esc_attr( wp_strip_all_tags( $title ) );
        $href       = esc_url( $url );

    $classes = is_array( $item->classes ) ? $item->classes : array();

    // Determine if this item is in the current branch (item itself or an ancestor).
    // We'll use this both for showing separators and to decide whether to
    // reveal child levels. This includes WP's current-menu-ancestor/parent
    // markers so that when a submenu is the active page, the top-level parent
    // is treated as "current" for separator placement.
    $active_markers = array(
        'current-menu-item',
        'current-menu-ancestor',
        'current-menu-parent',
        'current_page_item',
        'current_page_parent',
        'current_page_ancestor',
    );
    $has_current_marker = false;
    foreach ( $active_markers as $m ) {
        if ( in_array( $m, $classes, true ) ) {
            $has_current_marker = true;
            break;
        }
    }

    // Check if this item was marked as active by our custom field logic
    // Do this check regardless of $has_current_marker to handle all cases
    $custom_field_active = false;
    if ( in_array( $item->ID, $this->custom_active_items, true ) ) {
        $has_current_marker = true;
        $custom_field_active = true;
    }

    // On home/front, treat the first top-level item as the default section for
    // separator purposes (without affecting CSS classes).
    $is_home_default = ( 0 === (int) $depth && 0 === $this->top_index && ( is_home() || is_front_page() ) );
    $is_current_for_sep = $has_current_marker || $is_home_default;

    // If this item is not at top-level and its parent branch is not the
    // active one, skip rendering it entirely. Visibility for child levels
    // is controlled via $this->display_children[ $depth ]. This keeps the
    // markup minimal and matches the desired behavior of hiding inactive
    // submenus.
    if ( $depth > 0 && empty( $this->display_children[ $depth ] ) ) {
        // Ensure deeper depths are not accidentally visible.
        $this->display_children[ $depth + 1 ] = false;
        return;
    }

    // Children at the next depth are visible only if this item is in the
    // active branch. Default to false for safety when not set.
    $this->display_children[ $depth + 1 ] = $has_current_marker ? true : false;

        $buf = array();

        // For top-level items only, handle separator placement rules
        if ( 0 === (int) $depth ) {
            // If there is a pending "after" separator from the previous current
            // item, print it before this item (this becomes the visual "after"
            // of the previous one).
            if ( $this->pending_after_separator ) {
                $buf[] = '<span class="separator"></span>' . "\n";
                $this->pending_after_separator = false;
            }

            // If this item is current and is not the first top-level item,
            // print a separator BEFORE it.
            if ( $is_current_for_sep && $this->top_index > 0 ) {
                $buf[] = '<span class="separator"></span>' . "\n";
            }
        }

        // Render the item span+link with depth class and WordPress menu classes
        $span_classes = array();
        $span_classes[] = 'menu-item-depth-' . (int) $depth;
        
        // Add WordPress's built-in menu item classes to our span
        if ( is_array( $item->classes ) ) {
            foreach ( $item->classes as $class ) {
                if ( ! empty( $class ) && $class !== 'menu-item' ) {
                    $span_classes[] = $class;
                }
            }
        }
        
        // If this item is active due to custom field, add the appropriate classes
        if ( $custom_field_active ) {
            // Check if this is the direct match or an ancestor
            $is_direct_match = false;
            global $post;
            if ( isset( $post->ID ) ) {
                $parent_page_id = get_post_meta( $post->ID, 'parent_page_id', true );
                if ( ! empty( $parent_page_id ) && isset( $item->object_id ) && (int) $parent_page_id === (int) $item->object_id ) {
                    $is_direct_match = true;
                }
            }
            
            if ( $is_direct_match ) {
                // This is the direct match (the page specified in parent_page_id)
                $span_classes[] = 'current-menu-item';
                $span_classes[] = 'current_page_item';
            } else {
                // This is an ancestor of the matched item
                $span_classes[] = 'current-menu-ancestor';
                $span_classes[] = 'current-menu-parent';
                $span_classes[] = 'current_page_ancestor';
                $span_classes[] = 'current_page_parent';
            }
        }
        
        $class_attr = implode( ' ', array_map( 'esc_attr', $span_classes ) );
        $buf[] = '<span class="' . $class_attr . '">';
        $buf[] = '<a href="' . $href . '" title="' . $attr_title . '">';
        $buf[] = esc_html( $title );
        $buf[] = '</a>';
        $buf[] = '</span>' . "\n";

        if ( 0 === (int) $depth ) {
            // If current, schedule an AFTER separator to be printed before the
            // next top-level item.
            if ( $is_current_for_sep ) {
                $this->pending_after_separator = true;
            }

            // Increment top-level counter after rendering this item
            $this->top_index++;
        }

        $output .= implode( '', $buf );
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}
