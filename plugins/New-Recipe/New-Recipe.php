<?php
/**
 * Plugin Name: NewRecipe Funtion
  * Description: This is a plugin groups most of the functionalities for Post new recipe. including the admin page
 * Version: 1.0.0
 * Author: Youssef Jarid
 * License: GPL2
 * Text Domain: NewPostForm
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
     function NewPost_activate_plugin() {
        NewPost\Activate::activate();
     }
     register_activation_hook( __FILE__, 'NewPost_activate_plugin' );

 /**
  * The code that runs during plugin deactivation
  */
 function NewPost_deactivate_plugin() {
 	flush_rewrite_rules();
 }
 register_deactivation_hook( __FILE__, 'NewPost_deactivate_plugin' );

 /**
  * Initialize all the core classes of the plugin
  */
 if ( class_exists( 'NewPost\\Init' ) ) {
    NewPost\Init::register_services();
 }