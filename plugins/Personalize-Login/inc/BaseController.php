<?php
/**
 * @package  PersonalizeLogin
 */
namespace Inc;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__ ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__) );
		$this->plugin = plugin_basename( dirname( __FILE__, 2 ) ) . '/personalize.php';
	}

  protected function get_template_html( $template_name, $attributes = null ) {
   if ( ! $attributes ) {
       $attributes = array();
   }

   ob_start();

   do_action( 'personalize_login_before_' . $template_name );
   // print_r($this->plugin_path);

    require( $this->plugin_path.'/templates/'.$template_name.'.php');

   do_action( 'personalize_login_after_' . $template_name );

   $html = ob_get_contents();
   ob_end_clean();

   return $html;
  }
}
