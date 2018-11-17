<?php


                $relatedpost = new WP_Query(array(
                  'posts_per_page' => -1,
                  'post_type' => 'post',
                  'orderby' => 'title',
                  'order' => 'ASC',
                  'meta_query' => array(
                      array( 'key' => 'GS_attached_posts' , 'compare' => 'LIKE', 'value' => '"'. get_the_ID() . '"')
                   )
                ));

                if ($relatedpost->have_posts()) {


                echo '<ul>';
                while($relatedpost->have_posts()) {
                    $relatedpost->the_post(); ?>


                    <li>
                      <?php the_title(); ?>
                     </li>

                <?php  }
                echo '</ul>';

                }

                wp_reset_postdata();
