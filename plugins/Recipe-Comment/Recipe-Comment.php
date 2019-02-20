<?php
/*
Plugin Name: Comment 
Description: functions related to comment including rating 
Version: 1.0.0
Author: Youssef Jarid
Author URI: 
*/



 // If this file is called firectly, abort!!!
 defined( 'ABSPATH' ) or exit;

 // Require once the Composer Autoload
 if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
 	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
 }

 /**
  * The code that runs during plugin activation
  */
     function Comment_activate_plugin() {
        Comment\Activate::activate();
     }
     register_activation_hook( __FILE__, 'Comment_activate_plugin' );

 /**
  * The code that runs during plugin deactivation
  */
 function Comment_deactivate_plugin() {
 	flush_rewrite_rules();
 }
 register_deactivation_hook( __FILE__, 'Comment_deactivate_plugin' );

 /**
  * Initialize all the core classes of the plugin
  */
 if ( class_exists( 'Comment\\Init' ) ) {
    Comment\Init::register_services();
 }


