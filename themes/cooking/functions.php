<?php

require get_theme_file_path('/incl_func/search-route.php');
require get_theme_file_path('/incl_func/view-count.php');
require get_theme_file_path('/incl_func/ajax-sortPost.php');
require get_theme_file_path('/incl_func/ajax-filterPost.php');
require get_theme_file_path('/incl_func/ajax-loadMore.php');
require get_theme_file_path('/incl_func/ajax-followChef.php');
require get_theme_file_path('/incl_func/format-comment.php');


// Remove the WordPress Admin top Toolbar
add_filter('show_admin_bar', '__return_false');


add_action('wp_enqueue_scripts', 'main_files');

function main_files() {


  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyD4DK0mXfZhTanX5NUbJC37V8c0fP3jt0Y&callback=new_map', NULL, '1.0', true);
  wp_enqueue_script('main-js', get_theme_file_uri('scripts/app-fin.js'), NULL, '1.0', true);
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('main_styles', get_stylesheet_uri());
  
  
  if(is_single()){
    wp_enqueue_script('lightbox-js', get_theme_file_uri('vendor/lightbox/dist/js/lightbox-plus-jquery.min.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('lightbox_styles', get_theme_file_uri('vendor/lightbox/dist/css/lightbox.min.css'));
  }
  
  wp_localize_script('main-js', 'jsData', array(
    'root_url' => get_site_url(),
    	'ajax_url' => site_url() . '/wp-admin/admin-ajax.php',
      'ajax_nonce' => wp_create_nonce( 'loadMoreNonce' ),
      'filter_nonce' => wp_create_nonce( 'filterNonce' ),
      'sort_nonce' => wp_create_nonce( 'sortNonce' ),
      'login_nonce' => wp_create_nonce( 'loginNonce' ),
      'register_nonce' => wp_create_nonce( 'registerNonce' ),


  ) );
  wp_enqueue_media( $args = array() );
}




function university_features() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'university_features');



/**
* Remove media library tab from media Uploader
*
*/
function restrict_non_Admins($query){

    if ( ! current_user_can( 'manage_options' ) ){
    $query['author'] = get_current_user_id();
    return $query;
  }
    return $query;

  }

  add_filter( 'ajax_query_attachments_args', 'restrict_non_Admins' );


// to change the format of the date the comment is posted exp: posted 2 days ago

function time_elapsed_string($datetime, $full = false) {
  $now = new DateTime;
  $ago = new DateTime($datetime);
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

function yj_display_comment_stars( $rating ) {


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

// // Sanitize tinyMce editor input when pasting from the web 

function my_format_TinyMCE( $init, $id  ) {
  
  $init['plugins'] = 'colorpicker,lists,fullscreen,image,wordpress,wpeditimage,wplink,paste';
  $init['paste_as_text'] = true;
    
   return $init;
}
add_filter( 'teeny_mce_before_init', 'my_format_TinyMCE' , 10, 2);

