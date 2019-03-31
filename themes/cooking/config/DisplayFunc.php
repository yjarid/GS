<?php
/**
 * diffent helper functions to display specific content 
 */
namespace GS;

// use \Login\BaseController;


class DisplayFunc 
{

  public function register() {

    // Remove p tags from tax description get_the_archive_description()
    remove_filter('term_description','wpautop'); 
  
  }
    
    // to change the format of the date the comment is posted exp: posted 2 days ago
    
    static function get_time_elapsed($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);
      
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
      
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
      
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
      }

    //   function to format and display stars

      static function display_stars( $rating ) {


        if ( !$rating  ) {
            echo 'No rating yet';
        }
        
        $stars   = '';
      
        for ( $i = 1; $i <= $rating + 1; $i++ ) {
            
            $width = intval( $i - $rating > 0 ? 20 - ( ( $i - $rating ) * 20 ) : 20 );
    
            if ( 0 === $width ) {
                continue;
            }
    
            $stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="dashicons dashicons-star-filled"></span>';
    
            if ( $i - $rating > 0 ) {
          $stars .= '<span style="overflow:hidden; position:relative; left:-' . $width .'px;" class="dashicons dashicons-star-empty"></span>';
        }
        
      }
      
      if($rating <= 4 && $rating) {
        for($i = 1; $i <= (5-$rating); $i++) {
    
          $stars .= '<span style="overflow:hidden; position:relative; left:-' . $width .'px; " class="dashicons dashicons-star-empty"></span>';
        }
        
      }
        
        echo $stars;
        
    }
    

    // to get the month and year
    
    static function getDate($period = "0 Month") {
      $date = [];
      $t=date('d-m-Y' , strtotime($period));
      $date['M'] = date("M",strtotime($t));
      $date['Y'] = date("Y",strtotime($t));
      $date['J'] = date("j",strtotime($t));

      return $date;
    }

        // to get the paged number based on the day of the month 
    
        static function getPaged($dayNumber) {
          
          if( $dayNumber < 8) $paged = 1;
          if($dayNumber >= 8 and $dayNumber < 15) $paged = 2;
          if($dayNumber >= 15 and $dayNumber < 22) $paged = 3;
          if($dayNumber >= 22 and $dayNumber < 27) $paged = 4;
          if($dayNumber >= 27 ) $paged = 5;
    
          return $paged;
        }

         // to display user by GS rating or any other meta key used in the front page and user profile

      static function displayUser($numb , $metaKey, $content, $include =[], $paged =null ){
        $user_args = array(
          'include' => $include,
          'number' => $numb,
          'meta_key' => $metaKey,
          'orderby' => 'meta_value_num',
          'order' => 'DESC',
          'paged' => $paged
        );
    
        $myFollowers = new \WP_User_Query($user_args);

        ob_start();
    
        foreach($myFollowers->get_results() as $chef) {
            $data = [];
            $data['id']=  esc_attr( $chef->ID );
            $data['name'] = esc_html($chef->display_name);
            $data['img_url'] = esc_url( get_user_meta($data['id'], 'picture', true)) ;
            $data['url'] =get_author_posts_url($data['id']) ;
            $data['alt'] = 'hello';
          
            set_query_var( 'data', $data );
            get_template_part( 'content/'.$content );
    
          } 

          $html = ob_get_contents();
          ob_end_clean();

         echo $html;
        }


        
        
}