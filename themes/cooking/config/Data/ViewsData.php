<?php
/**
 * diffent helper functions to display specific content 
 */
namespace GS\Data;

 use GS\DisplayFunc;


class ViewsData 
{
    // public function register() { 

    // }
    

      static function setPostViews($postID) {
          $data =[];
          $user_ip = $_SERVER['REMOTE_ADDR']; //retrieve the current IP address of the visitor
          $key = $user_ip . 'x' . $postID; //combine post ID & IP to form unique key
          $value = array($user_ip, $postID); // store post ID & IP as separate values (see note)
          $visited = get_transient($key); //get transient and store in variable
          //check to see if the Post ID/IP ($key) address is currently stored as a transient
          if ( false === ( $visited ) ) {
              //store the unique key, Post ID & IP address for 12 hours if it does not exist
              set_transient( $key, $value, 10 );
              // POST VIEW COUNT
              $date = DisplayFunc::getDate();
              $month = $date['M'];
              $year = $date['Y'];
              $month_key = 'post_views_'.$month.'_'.$year;
              $year_key = 'post_views_'.$year;
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
                $term_month_key = 'term_views_'.$month.'_'.$year;
                $term_year_key = 'term_views_'.$year;
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
              $user = get_current_user_ID();
              $user_month_key = 'user_views_'.$month.'_'.$year;
              $user_year_key = 'user_views_'.$year;
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
              return $data =[ 'status' =>'yes' , 'client' => $user_ip ];
          }
          return $data =[ 'status' =>'no' , 'client' => null ];
        }


      // display Post Views
      static function getPostViews($postID, $interval = "Month" ,$period = "0 Month" ) {
          // get the month and year
          $date = DisplayFunc::getDate($period);

          if($interval == 'Month') { 
            $metakey = 'post_views_'.$date['M'].'_'.$date['Y'] ; 
          } else {
            $metakey = 'post_views_'.$date['Y'] ;
          }

          $views = get_post_meta($postID, $metakey, true);
          $views = ($views ?: 0);
         
          return $views;
      }

        // display TERM  Views
        static function getTermViews($ID, $interval = "Month" , $period = "0 Month" ) {
            // get the month and year
          $date = DisplayFunc::getDate($period);

          if($interval == 'Month') { 
            $metakey = 'term_views_'.$date['M'].'_'.$date['Y'] ; 
          } else {
            $metakey = 'term_views_'.$date['Y'] ;
          }

          $views = get_term_meta($ID, $metakey, true);
          $views = ($views ?: 0);
         
          return $views;
      }
        

        // display User  Views
        static function getUserViews($ID, $interval = "Month" ,$period = "0 Month" ) {
            // get the month and year
          $date = DisplayFunc::getDate($period);

          if($interval == 'Month') { 
            $metakey = 'user_views_'.$date['M'].'_'.$date['Y'] ; 
          } else {
            $metakey = 'user_views_'.$date['Y'] ;
          }

          $views = get_user_meta($ID, $metakey, true);
          $views = ($views ?: 0);
         
          return $views;
        }

    
}