<?php
/**
 * @package  NewPOSTForm
 */
namespace NewPost;

use \NewPost\BaseController;



class Enqueue extends BaseController
{
	public function register() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin'));
	}
	//
	function enqueue() {
		wp_enqueue_script( 'newRecipe', $this->plugin_url . 'assets/PostNewRecipe.js', array('jquery'), '1.0', true );
	}

	function enqueue_admin() {
		 wp_enqueue_script('admin_js', $this->plugin_url . 'assets/admin.js', array('jquery'), '1.0', true);
		 wp_enqueue_style('admin_style', $this->plugin_url . 'assets/admin.css');
		 wp_localize_script('admin_js', 'jsData', array(
		  	'root_url' => get_site_url(),
			'ajax_url' => site_url() . '/wp-admin/admin-ajax.php',
			'rest_nonce' => wp_create_nonce( 'wp_rest' ),
		) );
	}
}
