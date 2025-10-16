<?php
/**
 * Slackware-Es theme functions
 *
 * Copyright (C) 2025 Pavel Espinal
 * Licensed under GNU General Public License v2 (or later)
 * https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'SLACKWAREES_THEME_VERSION' ) ) {
    define( 'SLACKWAREES_THEME_VERSION', '1.0.0' );
}

if ( ! function_exists( 'slackwarees_setup' ) ) :
    function slackwarees_setup() {
        // Let WP manage the document title.
        add_theme_support( 'title-tag' );

        // Add support for HTML5 markup for search forms, comment forms, comment lists, galleries, captions
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

        // Support for post thumbnails (optional)
        add_theme_support( 'post-thumbnails' );

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
        wp_enqueue_style( 'slackwarees-style', get_theme_file_uri( '/assets/css/style.css' ), array(), SLACKWAREES_THEME_VERSION );
    }
}
add_action( 'wp_enqueue_scripts', 'slackwarees_enqueue_assets' );
