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
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

        <!-- GLOBAL_CONTAINER START -->
        <div id="global_container">
        <!-- GLOBAL_CONTAINER START -->

            <div id="header_container" class="">
                <div id="slogan" class="strong_border">
                    <a href="<?php echo esc_url( site_url() ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
                    <!--  <?php bloginfo('description'); ?> -->
                </div>
                <div id="logo" class="strong_border">
                </div>
            </div>
