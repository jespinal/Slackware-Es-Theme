                <?php
                /**
                 * Sidebar template
                 *
                 * Copyright (C) 2025 Pavel Espinal
                 * Licensed under GNU General Public License v2 (or later)
                 * https://www.gnu.org/licenses/gpl-2.0.html
                 */
                ?>
                <!-- SIDEBAR START -->
                <aside id="sidebar" class="strong_border" role="complementary">
                <!-- SIDEBAR START -->
                    
                    <?php
                    // Render a WP menu with legacy-like <span><a>..</a></span> markup using the 'sidebar' location.
                    if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'sidebar' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'sidebar',
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'walker'         => class_exists( 'SlackwareES_Sidebar_Span_Walker' ) ? new SlackwareES_Sidebar_Span_Walker() : null,
                            'fallback_cb'    => false,
                        ) );
                    }
                    // Helpful note to devs if the location is not yet assigned.
                    if ( ! has_nav_menu( 'sidebar' ) ) {
                        echo "<!-- No 'sidebar' menu location assigned. Assign a menu under Appearance > Menus. -->\n";
                    }
                    ?>
                
                <!-- SIDEBAR END -->    
                </aside>
                <!-- SIDEBAR END -->
