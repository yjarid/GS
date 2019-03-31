<?php
/*
Plugin Name: Taxonomy Custom Fields 
Description: functions to manage TCF
Version: 1.0.0
Author: Youssef Jarid
Author URI: 
*/



 // If this file is called firectly, abort!!!
 defined( 'ABSPATH' ) or exit; 


// the template that will be added to the edit cuisine taxonomie  
add_action( 'cuisine_edit_form_fields', 'add_cuisine_image_field');

function add_cuisine_image_field($tag){
    $term_url = get_term_meta($tag->term_id, 'GS_avatar', true);
    require_once dirname( __FILE__ ) . '/templates/avatar-form.php';
}

// enqueu the scripts
add_action( 'admin_enqueue_scripts', 'cuisine_script') ;
	
function cuisine_script() {
    wp_enqueue_media();
    wp_enqueue_script( 'cuisinescript', plugin_dir_url( __FILE__ ) .'/tax.js', array('jquery') );
}

// save the URL in the term meta when updating the taxonomy
add_action( 'edited_cuisine', 'custom_save_avatar', 10, 2 );

function custom_save_avatar($term_id, $tt_id) {

    if ( isset( $_REQUEST['cuisine_image'] ) ) {
        update_term_meta( $term_id, 'GS_avatar', sanitize_text_field( $_REQUEST['cuisine_image'] ) );
    }

}