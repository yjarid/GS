<?php
/**
 * @package  NewPOSTForm
 */
namespace NewPost;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__ ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__) );
		$this->plugin = plugin_basename( dirname( __FILE__, 2 ) ) . '/post-new-recipe.php';
    }
    
}