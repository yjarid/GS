<?php
/**
 * @package  PersonalizeLogin
 */
namespace Inc;

use \Inc\BaseController;


/**
*
*/
class ResetPass extends BaseController
{
  public function register() {
    add_action( 'login_form_rp', array( $this, 'redirect_to_custom_password_reset' ) );
    add_action( 'login_form_resetpass', array( $this, 'redirect_to_custom_password_reset' ) );
    add_shortcode( 'custom-password-reset-form', array( $this, 'render_password_reset_form' ) );
    add_action( 'login_form_rp', array( $this, 'do_password_reset' ) );
    add_action( 'login_form_resetpass', array( $this, 'do_password_reset' ) );
  }

  /**
   * Redirects to the custom password reset page, or the login page
   * if there are errors.
   */
  public function redirect_to_custom_password_reset() {
      if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
          //verify the request is trigred by the emqil link if not redirect to password lost form

          if(!isset($_REQUEST['key'])) {
            wp_redirect( home_url( 'password-lost' ) );
            exit;
          }

          // Verify key / login combo
          $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
          if ( ! $user || is_wp_error( $user ) ) {
              if ( $user && $user->get_error_code() === 'expired_key' ) {
                  wp_redirect( home_url( 'password-reset?error=expiredkey' ) );
              } else {
                  wp_redirect( home_url( 'password-reset?error=invalidkey' ) );
              }
              exit;
          }

          $redirect_url = home_url( 'password-reset' );
          $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
          $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

          wp_redirect( $redirect_url );
          exit;
      }
  }

  /**
 * A shortcode for rendering the form used to reset a user's password.
 *
 * @param  array   $attributes  Shortcode attributes.
 * @param  string  $content     The text content for shortcode. Not used.
 *
 * @return string  The shortcode output
 */
public function render_password_reset_form( $attributes, $content = null ) {
    // Parse shortcode attributes
    $default_attributes = array( 'show_title' => false );
    $attributes = shortcode_atts( $default_attributes, $attributes );

    if ( is_user_logged_in() ) {
        return __( 'You are already signed in.', 'personalize-login' );
    } else {
        if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
          $attributes['login'] = $_REQUEST['login'];
          $attributes['key'] = $_REQUEST['key'];
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

            return $this->get_template_html( 'password_reset_form', $attributes );
        }
    }


  /**
 * Resets the user's password if the password reset form was submitted.
 */
public function do_password_reset() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $rp_key = $_REQUEST['rp_key'];
        $rp_login = $_REQUEST['rp_login'];

        $user = check_password_reset_key( $rp_key, $rp_login );

        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
              wp_redirect( home_url( 'password-reset?error=expiredkey' ) );
          } else {
              wp_redirect( home_url( 'password-reset?error=invalidkey' ) );
            }
            exit;
        }

        if ( isset( $_POST['pass1'] ) ) {
            if ( $_POST['pass1'] != $_POST['pass2'] ) {
                // Passwords don't match
                $redirect_url = home_url( 'password-reset' );

                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

            if ( strlen($_POST['pass1']) < 6)  {
                // Password is empty
                $redirect_url = home_url( 'password-reset' );

                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'weak_password', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

            // Parameter checks OK, reset password
            reset_password( $user, $_POST['pass1'] );
            wp_redirect( home_url( 'login?password=changed' ) );
        } else {
            echo "Invalid request.";
        }

        exit;
    }
  }
}
