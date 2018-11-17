<?php

add_action('wp_ajax_sortRecipes', 'youssef_sortRecipes');
add_action('wp_ajax_nopriv_sortRecipes', 'youssef_sortRecipes');


function youssef_sortRecipes(){

check_ajax_referer( 'sortNonce', 'nonceSort' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

  $sortBy = $_POST['sortBy'];
  $term = $_POST['term'];
  $tax = $_POST['tax'];

  $args = array();

  if($sortBy == 'date' ) {
    $args = array('post_status' => 'publish',
                 'post_type' => 'recipe',
                 'posts_per_page' => 5,
                 'tax_query' => array(
                      array(
                      'taxonomy' => $tax,
                      'field'    => 'name',
                      'terms'    => $term,
                      )
                    )
                  );
  }
  else if ($sortBy && $sortBy != 'date') {
    $args = array('post_status' => 'publish',
                 'post_type' => 'recipe',
                 'posts_per_page' => 5,
                 'meta_key' => $sortBy,
                 'orderby' => 'meta_value_num',
                 'order' => 'DESC',
                 'tax_query' => array(
                      array(
                      'taxonomy' => $tax,
                      'field'    => 'name',
                      'terms'    => $term,
                      )
                    )
                  );
  }



    $sort = new WP_Query( $args );

        if( $sort->have_posts() ) {
          ob_start();
          while( $sort->have_posts() ) {
            $sort->the_post();

             get_template_part( 'content/recipeCard' );


          }
          $html = ob_get_contents(); // we pass the posts to variable
             ob_end_clean();
            $max = $sort->max_num_pages;
        }

      wp_reset_postdata();

      $json = array('html'=>$html, 'max'=>$max);

       echo json_encode($json);



    }

    die();


}
