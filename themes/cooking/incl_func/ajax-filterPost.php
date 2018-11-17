<?php
/**
* Handeling the submenue Filter data
*/

add_action('wp_ajax_myfilter', 'youssef_filter_function');
add_action('wp_ajax_nopriv_myfilter', 'youssef_filter_function');


function youssef_filter_function(){

check_ajax_referer( 'filterNonce', 'nonceFilter' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

  $args = array('post_status' => 'publish',
               'post_type' => 'recipe',
               'posts_per_page' => 5

      );

      $args['tax_query'] = array('relation' => 'AND');

      if(isset($_POST['meal']) && $_POST['meal']) {
        $args['tax_query'][] =
          array(
            'taxonomy' => 'meal',
            'field' => 'id',
            'terms' => $_POST['meal'] ?: ''
          );
      }

      if(isset($_POST['ingredient']) && $_POST['ingredient']) {
        $args['tax_query'][] =
          array(
            'taxonomy' => 'ingredient',
            'field' => 'id',
            'terms' => $_POST['ingredient'] ?: ''
          );
      }





    $filter = new WP_Query( $args );

        if( $filter->have_posts() ) {
          ob_start();
          while( $filter->have_posts() ) {
            $filter->the_post();

             get_template_part( 'content/recipeCard' );


          }
          $html = ob_get_contents(); // we pass the posts to variable
             ob_end_clean();
            $max = $filter->max_num_pages;
        }

      wp_reset_postdata();

      $json = array('html'=>$html, 'max'=>$max);

       echo json_encode($json);



    }

    die();


}
