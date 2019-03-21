<?php
/**
 *
 */



 // Require once the Composer Autoload
 if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
 	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
 }

 

 /**
  * Initialize all the core classes of the plugin
  */
 if ( class_exists( 'GS\\Init' ) ) {
 	GS\init::register_services();
 }
