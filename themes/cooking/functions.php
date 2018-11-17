<?php

require get_theme_file_path('/incl_func/search-route.php');
require get_theme_file_path('/incl_func/post-form.php');
require get_theme_file_path('/incl_func/profile-page.php');
require get_theme_file_path('/incl_func/change-avatar.php');
require get_theme_file_path('/incl_func/view-count.php');
require get_theme_file_path('/incl_func/ajax-sortPost.php');
require get_theme_file_path('/incl_func/ajax-filterPost.php');
require get_theme_file_path('/incl_func/ajax-loadMore.php');
require get_theme_file_path('/incl_func/ajax-registerOrLogin.php');
require get_theme_file_path('/incl_func/template-redirect.php');
require get_theme_file_path('/incl_func/login.php');


// Remove the WordPress Admin top Toolbar
add_filter('show_admin_bar', '__return_false');



add_action('wp_enqueue_scripts', 'main_files');

function main_files() {


  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyD4DK0mXfZhTanX5NUbJC37V8c0fP3jt0Y&callback=new_map', NULL, '1.0', true);
  wp_enqueue_script('main-js', get_theme_file_uri('scripts/app-fin.js'), NULL, '1.0', true);
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('main_styles', get_stylesheet_uri());
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
  add_image_size('small', 200, 200, true);
  add_image_size('meduim', 350, 500, true);
  add_image_size('large', 700, 1000, true);
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
