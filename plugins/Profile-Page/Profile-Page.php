<?php
/**
 * Plugin Name: Profile Page
  * Description: This is a plugin encapsiule the code use to create the Profile page
 * Version: 1.0.0
 * Author: Youssef Jarid
 * License: GPL2
 * Text Domain: profile-page
 */


 // If this file is called directly, abort!!!
 defined( 'ABSPATH' ) or exit();

 // Require once the Composer Autoload
 if ( file_exists( dirname(dirname( __FILE__ ) ). '/vendor/autoload.php' ) ) {
 	require_once dirname(dirname( __FILE__ ) ) . '/vendor/autoload.php';
 }

 /**
  * The code that runs during plugin activation
  */
     function profile_activate_plugin() {
     	Profile\Activate::activate();
     }
     register_activation_hook( __FILE__, 'profile_activate_plugin' );

 /**
  * The code that runs during plugin deactivation
  */
 function profile_deactivate_plugin() {
 	flush_rewrite_rules();
 }
 register_deactivation_hook( __FILE__, 'profile_deactivate_plugin' );

 /**
  * Initialize all the core classes of the plugin
  */
 if ( class_exists( 'Profile\\Init' ) ) {
 	Profile\Init::register_services();
 }
