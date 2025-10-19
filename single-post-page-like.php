<?php
/**
 * Template Name: Page-like Post
 * Template Post Type: post
 *
 * Use the theme's page layout when rendering a single post that selects
 * this template. This copies the `page.php` markup while keeping the
 * semantics of a post (so it remains in post loops and feeds).
 *
 * Place this file in the theme root and select it from the 'Template'
 * dropdown in the post editor (Document sidebar).
 *
 * Copyright (C) 2025 Pavel Espinal
 * Licensed under GNU General Public License v2 (or later)
 * https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

            <!-- BODY_CONTAINER START -->
            <div id="body_container" class="">
            <!-- BODY_CONTAINER START -->

                <?php get_sidebar() ?>
            
            
                <main id="content" class="page_content" role="main">
                    
                    <?php while ( have_posts() ) : the_post(); ?>
                    
                    <!-- title and date removed on pages
                    <div class="content_title strong_border">
                         <?php the_title(); ?>
                    </div>
                    <div class="content_date strong_border">
                        <?php the_time(get_option('date_format')); ?>
                    </div>
                    -->
                    <div class="content_body strong_border page_content">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php endwhile; ?>
                    
                </main>
                
            <!-- BODY_CONTAINER END -->    
            </div>
            <!-- BODY_CONTAINER END -->    

            <?php get_footer();?>
            
        <!-- GLOBAL_CONTAINER END -->    
        </div>
        <!-- GLOBAL_CONTAINER END -->    
    </body>
</html>
