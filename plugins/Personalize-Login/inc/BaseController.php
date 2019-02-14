<?php
/**
 * @package  PersonalizeLogin
 */
namespace Login;

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

	/**
	* Redirects the Logged in user to the correct page depending on whether he / she
	* is an admin or not.
	*
	* @param string $redirect_to   An optional redirect_to URL for admin users
	*/
	protected function redirect_logged_in_user( $redirect_to = null ) {
	 $user = wp_get_current_user();
	 if ( user_can( $user, 'manage_options' ) ) {
	     if ( $redirect_to ) {
	         wp_safe_redirect( $redirect_to );
	     } else {
	         wp_redirect( admin_url() );
	     }
	 } else {
	     wp_redirect( home_url( 'user-profile' ) );
	 }
	}

	/**
 * Finds and returns a matching error message for the given error code.
 *
 * @param string $error_code    The error code to look up.
 *
 * @return string               An error message.
 */
protected function get_error_message( $error_code ) {
	switch ( $error_code ) {
		// Login errors
		case 'empty_username':
			return __( 'You do have an email address, right?', 'personalize-login' );
		case 'empty_password':
			return __( 'You need to enter a password to login.', 'personalize-login' );
		case 'invalid_username':
			return __(
				"We don't have any users with that email address. Maybe you used a different one when signing up?",
				'personalize-login'
			);
		case 'incorrect_password':
			$err = __(
				"The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
				'personalize-login'
			);
			return sprintf( $err, wp_lostpassword_url() );
		// Registration errors
		case 'email':
			return __( 'The email address you entered is not valid.', 'personalize-login' );
		case 'email_exists':
			return __( 'An account exists with this email address.', 'personalize-login' );
			case 'weak_password':
				return __( 'Password should be atleast 6 letters', 'personalize-login' );
		case 'captcha':
			return __( 'The Google reCAPTCHA check failed. Are you a robot?', 'personalize-login' );
		// Lost password
		case 'invalid_email':
		case 'invalidcombo':
			return __( 'There are no users registered with this email address.', 'personalize-login' );
		// Reset password
		case 'expiredkey':
		case 'invalidkey':
			return __( 'The password reset link you used is not valid .', 'personalize-login' );
		case 'password_reset_mismatch':
			return __( "The two passwords you entered don't match.", 'personalize-login' );
		default:
	return __( 'An unknown error occurred. Please try again later.', 'personalize-login' );
}

}

}
