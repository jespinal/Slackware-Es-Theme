<?php
/**
 * Page template
 *
 * Copyright (C) 2025 Pavel Espinal
 * Licensed under GNU General Public License v2 (or later)
 * https://www.gnu.org/licenses/gpl-2.0.html
 */
get_header(); ?>

            <!-- BODY_CONTAINER START -->
            <div id="body_container" class="">
            <!-- BODY_CONTAINER START -->

                <?php get_sidebar() ?>
            
            
                <main id="content" class="" role="main">
                    
                    <?php while ( have_posts() ) : the_post(); ?>
                    
                    <!-- 
                    <div class="content_title strong_border">
                         <?php the_title(); ?>
                    </div>
                    <div class="content_date strong_border">
                        <?php the_time(get_option('date_format')); ?>
                    </div>
                    -->
                    <div class="content_body strong_border" style="width: auto">
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