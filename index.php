<?php get_header() ?>

            <!-- BODY_CONTAINER START -->
            <div id="body_container" class="">
            <!-- BODY_CONTAINER START -->

                <?php get_sidebar() ?>


                <main id="content" class="" role="main">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>
                   <article class="article_container">
                    <h2 class="content_title strong_border">
                        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                    </h2>

                    <div class="content_date strong_border">
                        <?php the_time(get_option('date_format')); ?>
                    </div>

                    <div class="content_body strong_border">
                        <?php the_content(); ?>
                    </div>
                   </article>
        <?php endwhile; ?>
                    <?php global $wp_query;  if ( $wp_query->max_num_pages > 1 ) : ?>
                    <div class="navigation strong_border"><?php posts_nav_link(); ?></div>
                    <?php endif; ?>

    <?php else : ?>
                    <div class="content_title strong_border">
                        <?php _e( 'Nada Encontrado', 'slackware' ); ?>
                    </div>

                    <!--
                    <div class="content_date strong_border">
                        <?php the_time(get_option('date_format')); ?>
                    </div>
                    -->

                    <div class="content_body strong_border" style="width: auto;">
                        <?php _e( 'Oops, ning&uacute;n resultado fue encontrado para el archivo que solicitaste.', 'slackware' ); ?>
                    </div>
    <?php endif; ?>

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
