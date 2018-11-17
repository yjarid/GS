<?php /**
* Handeling the loadMore Button
*/


add_action('wp_ajax_loadmorebutton', 'youssef_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmorebutton', 'youssef_loadmore_ajax_handler');

function youssef_loadmore_ajax_handler(){

check_ajax_referer( 'loadMoreNonce', 'nonce' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {
    $paged = $_POST['page'];

if ($_POST['metaKey']) {
  $args = array(
            'post_status' => 'publish',
            'post_type' => 'recipe',
            'posts_per_page' => 5,
            'paged' =>$paged,
            'meta_key' => $_POST['metaKey'],
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
  );
}

else if($_POST['meal'] || $_POST['ingredient'])  {
  $args = array('post_status' => 'publish',
               'post_type' => 'recipe',
               'posts_per_page' => 5,
               'paged' =>$paged

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
            'terms' => $_POST['ingredient']
          );
      }

  }

  else if(isset($_POST['sortBy']) && $_POST['sortBy']) {
    $args = array();

    if($_POST['sortBy'] == 'date' ) {
      $args = array('post_status' => 'publish',
                   'post_type' => 'recipe',
                   'posts_per_page' => 5,
                   'paged' =>$paged,
                   'tax_query' => array(
                        array(
                        'taxonomy' => $_POST['tax'],
                        'field'    => 'name',
                        'terms'    => $_POST['term'],
                        )
                      )
                    );
    }
    else if ( $_POST['sortBy'] != 'date') {
      $args = array('post_status' => 'publish',
                   'post_type' => 'recipe',
                   'posts_per_page' => 5,
                   'paged' =>$paged,
                   'meta_key' => $_POST['sortBy'],
                   'orderby' => 'meta_value_num',
                   'order' => 'DESC',
                   'tax_query' => array(
                        array(
                          'taxonomy' => $_POST['tax'],
                          'field'    => 'name',
                          'terms'    => $_POST['term'],
                        )
                      )
                    );
    }

  }

  else {
    $args = array('post_status' => 'publish',
                 'post_type' => 'recipe',
                 'posts_per_page' => 5,
                 'paged' =>$paged,

        );
  }



  $load = new WP_Query( $args );


 if( $load->have_posts() ) {
   // run the loop
   while($load->have_posts()) {
       $load->the_post() ;

       get_template_part( 'content/recipeCard' );

     }
   }

wp_reset_postdata();
}


die(); // here we exit the script and even no wp_reset_query() required!
}
