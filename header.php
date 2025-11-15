<?php
/**
 * Header template
 *
 * Copyright (C) 2025 Pavel Espinal
 * Licensed under GNU General Public License v2 (or later)
 * https://www.gnu.org/licenses/gpl-2.0.html
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

        <!-- GLOBAL_CONTAINER START -->
        <div id="global_container">
        <!-- GLOBAL_CONTAINER START -->

            <div id="header_container" class="">
                <div id="slogan" class="strong_border">
                    <?php if ( is_front_page() || is_home() ) : ?>
                        <h1><a href="<?php echo esc_url( site_url() ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></h1>
                    <?php else : ?>
                        <?php
                        $title = '';
                        if ( is_singular() ) {
                            $title = single_post_title( '', false );
                        } elseif ( is_category() ) {
                            $title = single_cat_title( '', false );
                        } elseif ( is_tag() ) {
                            $title = single_tag_title( '', false );
                        } elseif ( is_tax() ) {
                            $title = single_term_title( '', false );
                        } elseif ( is_post_type_archive() ) {
                            $title = post_type_archive_title( '', false );
                        } elseif ( is_archive() ) {
                            $title = get_the_archive_title();
                        } elseif ( is_search() ) {
                            $title = sprintf( __( 'Search: %s', 'slackwarees' ), get_search_query() );
                        } elseif ( is_404() ) {
                            $title = __( 'Not Found', 'slackwarees' );
                        } else {
                            $title = wp_get_document_title();
                        }
                        ?>
                        <h1><?php echo esc_html( $title ); ?></h1>
                    <?php endif; ?>
                </div>
                <div id="logo" class="strong_border">
                </div>
            </div>
