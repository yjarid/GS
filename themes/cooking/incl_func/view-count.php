<?php

// Add Post Views

      function setPostViews($postID) {

          $user_ip = $_SERVER['REMOTE_ADDR']; //retrieve the current IP address of the visitor
          $key = $user_ip . 'x' . $postID; //combine post ID & IP to form unique key
          $value = array($user_ip, $postID); // store post ID & IP as separate values (see note)
          $visited = get_transient($key); //get transient and store in variable

          //check to see if the Post ID/IP ($key) address is currently stored as a transient
          if ( false === ( $visited ) ) {

              //store the unique key, Post ID & IP address for 12 hours if it does not exist
              set_transient( $key, $value, 1 );

              // POST VIEW COUNT

              $t=date('d-m-Y');
              $month = date("M",strtotime($t));
              $year = date("Y",strtotime($t));


              $month_key = 'views_count_'.$month.'_'.$year;
              $year_key = 'views_count_'.$year;
              $count_m = get_post_meta($postID, $month_key, true);
              $count_y = get_post_meta($postID, $year_key, true);


              if($count_m){
                $count_m++;
                update_post_meta($postID, $month_key, $count_m);
              }

              if($count_y){
                $count_y++;
                update_post_meta($postID, $year_key, $count_y);
              }


              if (!$count_m){
                   update_post_meta($postID, $month_key, 1);
               }

              if(!$count_y  ) {
                  update_post_meta($postID, $year_key, 1);
              }

              // TERM VIEW COUNT

              $terms =  wp_get_post_terms($postID , 'cuisine',  array("fields" => "ids"));



              foreach($terms as $term) {

                $term_month_key = 'term_count_'.$month.'_'.$year;
                $term_year_key = 'term_count_'.$year;
                $term_m = get_term_meta($term, $term_month_key, true);
                $term_y = get_term_meta($term, $term_year_key, true);

                if($term_m){
                  $term_m++;
                  update_term_meta($term, $term_month_key, $term_m);
                }

                if($term_y){
                  $term_y++;
                  update_term_meta($term, $term_year_key, $term_y);
                }


                if (!$term_m ){
                     update_term_meta($term, $term_month_key, 1);
                 }

                if(!$term_y ) {
                    update_term_meta($term, $term_year_key, 1);
                    }
              }

              // USER VIEW COUNT

              $user = get_the_author_meta('ID');

              $user_month_key = 'user_count_'.$month.'_'.$year;
              $user_year_key = 'user_count_'.$year;
              $user_m = get_user_meta($user, $user_month_key, true);
              $user_y = get_user_meta($user, $user_year_key, true);

              if($user_m){
                $user_m++;
                update_user_meta($user, $user_month_key, $user_m);
              }

              if($user_y){
                $user_y++;
                update_user_meta($user, $user_year_key, $user_y);
              }


              if ($user_m == ''){
                   update_user_meta($user, $user_month_key, 1);
               }

              if($user_y == '' ) {
                  update_user_meta($user, $user_year_key, 1);
              }
          }
        }

// display Post Views

function getPostViews($postID, $meta) {
    $count = get_post_meta($postID, $meta, true);
    if($count=='') {
          update_post_meta($postID, $meta, '0');
        return "0 View";
    }
    return $count.' views';
}

// display user Views

    function getTermViews($ID, $meta) {
        $count = get_term_meta($ID, $meta, true);
        if($count=='') {
            update_term_meta($ID, $meta, '0');
            return "0 View";
        }
        return $count.' Views';
    }

    function getUserViews($ID, $meta) {
        $count = get_user_meta($ID, $meta, true);
        if($count=='') {
              add_user_meta($ID, $meta, '0');
            return "0 View";
        }
        return $count.' Views';
    }





// Remove issues with prefetching adding extra views
//remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
