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
                        $laPages = get_pages(array('sort_column' => 'menu_order'));
                        $loNews  = get_term_by('slug','noticias','category');
                        $loTut   = get_term_by('slug','tutoriales','category');
                        $laCategories = array();
                        
                        global $post;

                        // List of categories of the current post (defensive)
                        if ( isset( $post ) && function_exists( 'get_the_category' ) ) {
                            $cats = get_the_category( $post->ID );
                            if ( is_array( $cats ) ) {
                                foreach( $cats as $loCat ) {
                                    if ( isset( $loCat->term_id ) ) {
                                        $laCategories[] = $loCat->term_id;
                                    }
                                }
                            }
                        }
                    ?>

                    <!-- Noticias START -->
                    <?php if ( $loNews && isset( $loNews->term_id ) ): ?>
                    <span>
                        <?php $news_link = get_category_link( $loNews->term_id ); ?>
                        <a href="<?php echo esc_url( $news_link ); ?>" title="<?php echo esc_attr( $loNews->name ); ?>">
                            <?php echo esc_html( $loNews->name ); ?>
                        </a>
                    </span>
                    <?php endif; ?>
            <?php if ( $loNews && ( is_home() 
                || ( isset( $loNews->term_id ) && is_category( $loNews->term_id ) ) 
                || ( is_single() && in_array( $loNews->term_id, $laCategories ) ) ) ): ?>
                    <span class="separator"></span>
                    <?php endif; ?>
                    <!-- Noticias END -->
                                        
                
                    <?php if ( is_array( $laPages ) && count( $laPages ) ): foreach ( $laPages as $loPage ): ?>
                
                    <?php if(is_page($loPage->ID)): ?>
                    <span class="separator"></span>
                    <?php endif; ?>
                    
                    <span>
                        <a href="<?php echo get_permalink($loPage->ID) ;?>" title="<?php echo $loPage->post_title; ?>">
                            <?php echo $loPage->post_title; ?>
                        </a>
                    </span>
                    
                    <?php if(is_page($loPage->ID)): ?>
                    <span class="separator"></span>
                    <?php endif; ?>
                    
                    <?php endforeach; endif; ?>
                    
                    <!-- Tutoriales START -->
            <?php if ( $loTut && ( isset( $loTut->term_id ) && is_category( $loTut->term_id )
                || ( is_single() && in_array( $loTut->term_id, $laCategories ) ) ) ): ?>
                    <span class="separator"></span>
                    <?php endif; ?>
                    <?php if ( $loTut && isset( $loTut->term_id ) ): ?>
                    <span>
                        <?php $tut_link = get_category_link( $loTut->term_id ); ?>
                        <a href="<?php echo esc_url( $tut_link ); ?>" title="<?php echo esc_attr( $loTut->name ); ?>">
                            <?php echo esc_html( $loTut->name ); ?>
                        </a>
                    </span>
                    <?php endif; ?>
                    <!-- Tutoriales END -->
                
                <!-- SIDEBAR END -->    
                </aside>
                <!-- SIDEBAR END -->
