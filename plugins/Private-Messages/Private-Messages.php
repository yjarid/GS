<?php
/**
 * Plugin Name: Private Messages
  * Description: This is a plugin responsible for all the functionalities of the private Messaging System
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
     function GS_Message_activate_plugin() {
     	Message\Activate::activate();
     }
     register_activation_hook( __FILE__, 'GS_Message_activate_plugin' );

 /**
  * The code that runs during plugin deactivation
  */
 function GS_Message_deactivate_plugin() {
 	flush_rewrite_rules();
 }
 register_deactivation_hook( __FILE__, 'GS_Message_deactivate_plugin' );

 /**
  * Initialize all the core classes of the plugin
  */
 if ( class_exists( 'Message\\Init' ) ) {
 	Message\Init::register_services();
 }
