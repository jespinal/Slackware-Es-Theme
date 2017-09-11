                <!-- SIDEBAR START -->
                <div id="sidebar" class="strong_border">
                <!-- SIDEBAR START -->
                    
                    <?php 
                        $laPages = get_pages(array('sort_column' => 'menu_order'));
                        $loNews  = get_term_by('slug','noticias','category');
                        $loTut   = get_term_by('slug','tutoriales','category');
                        $laCategories = array();
                        
                        global $post;
                        
                        // List of categories of the current post
                        foreach(get_the_category($post->ID) as $loCat) {
                            $laCategories[] = $loCat->term_id;
                        }
                    ?>

                    <!-- Noticias START -->
                    <span>
                        <!-- <a href="<?php echo get_category_link($loNews->term_id) ;?>" title="<?php echo $loNews->name; ?>"> -->
                        <a href="<?php echo site_url($loNews->slug.'/') ;?>" title="<?php echo $loNews->name; ?>">
                            <?php echo $loNews->name; ?>
                        </a>
                    </span>
                    <?php if(  is_home() 
                            || is_category($loNews->term_id) 
                            || (is_single() && in_array($loNews->term_id, $laCategories)) ): ?>
                    <span class="separator"></span>
                    <?php endif; ?>
                    <!-- Noticias END -->
                                        
                
                    <?php foreach ( $laPages as $loPage ): ?>
                
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
                    
                    <?php endforeach; ?>
                    
                    <!-- Tutoriales START -->
                    <?php if(  is_category($loTut->term_id)
                            || (is_single() && in_array($loTut->term_id, $laCategories))): ?>
                    <span class="separator"></span>
                    <?php endif; ?>
                    <span>
                    <!-- <a href="<?php echo get_category_link($loTut->term_id) ;?>" title="<?php echo $loTut->name; ?>">-->
                        <a href="<?php echo site_url($loTut->slug.'/') ;?>" title="<?php echo $loTut->name; ?>">
                            <?php echo $loTut->name; ?>
                        </a>
                    </span>
                    <!-- Tutoriales END -->
                
                <!-- SIDEBAR END -->    
                </div>
                <!-- SIDEBAR END -->
