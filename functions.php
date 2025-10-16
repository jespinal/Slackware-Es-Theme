<?php
/**
 * Slackware-Es theme functions
 */

if ( ! function_exists( 'slackwarees_setup' ) ) :
    function slackwarees_setup() {
        // Let WP manage the document title.
        add_theme_support( 'title-tag' );

        // Add support for HTML5 markup for search forms, comment forms, comment lists, galleries, captions
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

        // Support for post thumbnails (optional)
        add_theme_support( 'post-thumbnails' );
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
        wp_enqueue_style( 'slackwarees-style', get_theme_file_uri( '/assets/css/style.css' ), array(), filemtime( $assets_path ) );
    }
}
add_action( 'wp_enqueue_scripts', 'slackwarees_enqueue_assets' );
