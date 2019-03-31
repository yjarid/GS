<?php
/**
 * @package  PersonalizeLogin
 */
namespace Login;

use Login\BaseController;


/**
*
*/
class Login extends BaseController
{

  public function register() {
    add_shortcode( 'custom-login-form', array( $this, 'render_login_form' ) );
    add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );
   add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
   add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );
   add_action( 'init', array( $this, 'block_wpadmin_access' ) );
  }



  /**
* A shortcode for rendering the login form.
*
* @param  array   $attributes  Shortcode attributes.
* @param  string  $content     The text content for shortcode. Not used.
*
* @return string  The shortcode output
*/
  public function render_login_form( $attributes, $content = null ) {
     // Parse shortcode attributes
     $default_attributes = array( 'show_title' => false );
     $attributes = shortcode_atts( $default_attributes, $attributes );
     $show_title = $attributes['show_title'];

     // Pass the redirect parameter to the WordPress login functionality: by default,
     // don't specify a redirect, but if a valid redirect URL has been passed as
     // request parameter, use it.
     $attributes['redirect'] = '';
     if ( isset( $_REQUEST['redirect_to'] ) ) {
         $attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
   }

 // Error messages
   $errors = array();
   if ( isset( $_REQUEST['error'] ) ) {
       $error_codes = explode( ',', $_REQUEST['error'] );

       foreach ( $error_codes as $code ) {
           $errors []= $this->get_error_message( $code );
       }
   }
   $attributes['errors'] = $errors;



 // Render the login form using an external template
 return $this->get_template_html( 'login_form', $attributes );
}



/**
 * the action is fired right before the login functionality 
* Redirect the user to the custom login page instead of wp-login.php.
*this is only in case of the GET request exp clicking a link or trying to access the admin dashboard(not submitting a the form which is a post request)
*/
function redirect_to_custom_login() {
 if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
     $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;

     if ( is_user_logged_in() ) {
         $this->redirect_logged_in_user( $redirect_to );
         exit;
     }

     // The rest are redirected to the login page
     $login_url = home_url( 'login' );
     if ( ! empty( $redirect_to ) ) {
         $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
     }

     wp_redirect( $login_url );
     exit;
 }
}



/**
* Redirect the user if there were any errors in the  authentication .
*
* @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
* @param string            $username   The user name used to log in.
* @param string            $password   The password used to log in.
*
* @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
*/
function maybe_redirect_at_authenticate( $user, $username, $password ) {
 // Check if the earlier authenticate filter (most likely,
 // the default WordPress authentication) functions have found errors
 if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

   if( ! isset( $_POST['loginNonce'] ) || ! wp_verify_nonce( $_POST['loginNonce'], 'login-nonce' )) {
      die('nonce problem');
   }

   $login_url = home_url( 'login' );
   if ( is_wp_error( $user ) ) {
       $error_codes = join( ',', $user->get_error_codes() );

       $login_url = home_url( 'login' );
       $login_url = add_query_arg( 'error', $error_codes, $login_url );

       wp_redirect( $login_url );
       exit;
   }
   if($user && !is_wp_error( $user )) {
     $code = get_user_meta( $user->ID, '_Activation_key', true );
     if($code) {
        $login_url = add_query_arg( 'status', 'NotActif', $login_url );
       wp_redirect( $login_url );
       exit;
      }
   }
 }
 return $user;

}


/**
* Returns the URL to which the user should be redirected after the (successful) login.
*
* @param string           $redirect_to           The redirect destination URL.
* @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
* @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
*
* @return string Redirect URL
*/
public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {
 $redirect_url = home_url();

 if ( ! isset( $user->ID ) ) {
     return $redirect_url;
 }

 if ( user_can( $user, 'manage_options' ) ) {
     // Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
     if ( $requested_redirect_to == '' ) {
         $redirect_url = admin_url();
     } else {
         $redirect_url = $requested_redirect_to;
     }
 } else {
    if ( $requested_redirect_to == '' ) {
         // Non-admin users always go to account page after login if redirect_to is not set
         $redirect_url = home_url( 'user-profile' );
    } else {
        $redirect_url = $requested_redirect_to;
    }
    
 }

 return wp_validate_redirect( $redirect_url, home_url() );
}

/**
* this will prevent non admin logged in users from accessing admin pages

*/

public function block_wpadmin_access() {
if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
 wp_redirect( home_url() );
 exit;
 }
}

}
