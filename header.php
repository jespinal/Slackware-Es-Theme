<!DOCTYPE html>
<html>
    <head <?php language_attributes(); ?>>
        <title>
            <?php
                /*
                 * Print the <title> tag based on what is being viewed.
                 */
                global $page, $paged;
                
                wp_title( '-', true, 'right' );
                
                // Add the blog name.
                bloginfo( 'name' );
                
                // Add the blog description for the home/front page.
                $site_description = get_bloginfo( 'description', 'display' );
                
                if ( $site_description && ( is_home() || is_front_page() ) ) {
                    echo " | $site_description";
                }
                
                // Add a page number if necessary:
                if ( $paged >= 2 || $page >= 2 )
                    echo ' | ' . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
                ?>      
        </title>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/images/slackicon.ico">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        <?php wp_head(); ?>
    </head>
    <body>
        
        <!-- GLOBAL_CONTAINER START -->
        <div id="global_container">
        <!-- GLOBAL_CONTAINER START -->
        
            <div id="header_container" class="">
                <div id="slogan" class="strong_border">
                    <a href="<?php print site_url() ?>"><?php bloginfo('name'); ?></a>
                    <!--  <?php bloginfo('description'); ?> -->
                </div>
                <div id="logo" class="strong_border">
                </div>
            </div>
