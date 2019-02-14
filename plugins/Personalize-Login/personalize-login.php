<?php
/**
 * Plugin Name: Personalize login
  * Description: This is a plugin that allows to customise the Atuthentication system
 * Version: 1.0.0
 * Author: Youssef Jarid
 * License: GPL2
 * Text Domain: personalize-login
 */


 // If this file is called firectly, abort!!!
 defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

 // Require once the Composer Autoload
 if ( file_exists( dirname(dirname( __FILE__ ) ). '/vendor/autoload.php' ) ) {
 	require_once dirname(dirname( __FILE__ ) ) . '/vendor/autoload.php';
 }

 /**
  * The code that runs during plugin activation
  */
     function GS_activate_plugin() {
     	Login\Activate::activate();
     }
     register_activation_hook( __FILE__, 'GS_activate_plugin' );

 /**
  * The code that runs during plugin deactivation
  */
 function GS_deactivate_plugin() {
 	flush_rewrite_rules();
 }
 register_deactivation_hook( __FILE__, 'GS_deactivate_plugin' );

 /**
  * Initialize all the core classes of the plugin
  */
 if ( class_exists( 'Login\\Init' ) ) {
 	Login\Init::register_services();
 }
