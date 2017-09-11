<?php get_header() ?>

            <!-- BODY_CONTAINER START -->
            <div id="body_container" class="">
            <!-- BODY_CONTAINER START -->

                <?php get_sidebar() ?>
            
            
                <div id="content" class="">
                    
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
                    
                </div>
                
            <!-- BODY_CONTAINER END -->    
            </div>
            <!-- BODY_CONTAINER END -->    

            <?php get_footer();?>
            
        <!-- GLOBAL_CONTAINER END -->    
        </div>
        <!-- GLOBAL_CONTAINER END -->    
    </body>
</html>