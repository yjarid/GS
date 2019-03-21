<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS;

// use \Login\BaseController;


class Enqueue 
{
	public function register() {

    // Remove the WordPress Admin top Toolbar
      add_filter('show_admin_bar', '__return_false');

    // equeue scripts and style
      add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
      
      add_action('after_setup_theme', array($this , 'university_features'));

      
	}
	
	 function enqueue() {
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
      'nonceRest' => wp_create_nonce( 'wp_rest' ),


  ) );
  wp_enqueue_media( $args = array() );
   }
   

   function university_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
  }

 
}