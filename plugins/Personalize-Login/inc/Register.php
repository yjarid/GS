<?php
/**
 * @package  PersonalizeLogin
 */
namespace Login;

use \Login\BaseController;

/**
*
*/
class Register extends BaseController{

  public function register() {
    add_action( 'wp_print_footer_scripts', array( $this, 'add_captcha_js_to_footer' ) );
    add_shortcode( 'custom-register-form', array( $this, 'render_register_form' ) );
    add_action( 'login_form_register', array( $this, 'redirect_to_custom_register' ) );
    add_action( 'login_form_register', array( $this, 'do_register_user' ) );
    add_filter( 'admin_init' , array( $this, 'register_settings_fields' ) );
  }




    /**
     * A shortcode for rendering the new user registration form.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_register_form( $attributes, $content = null ) {
        // Parse shortcode attributes
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );

        // Retrieve recaptcha key
        $attributes['recaptcha_site_key'] = get_option( 'personalize-login-recaptcha-site-key', null );

        // Error messages
          $errors = array();
          if ( isset( $_REQUEST['errors'] ) ) {
              $error_codes = explode( ',', $_REQUEST['errors'] );

              foreach ( $error_codes as $code ) {
                  $errors []= $this->get_error_message( $code );
              }
          }
          $attributes['errors'] = $errors;

            return $this->get_template_html( 'register_form', $attributes );



    }

    /**
   * Redirects the user to the custom registration page instead
   * of wp-login.php?action=register.
   */
  public function redirect_to_custom_register() {
      if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
          if ( is_user_logged_in() ) {
              $this->redirect_logged_in_user();
          } else {
              wp_redirect( home_url( 'register' ) );
          }
          exit;
      }
  }

  /**
   * Validates and then completes the new user signup process if all went well.
   *
   * @param string $email         The new user's email address
   * @param string $first_name    The new user's first name
   * @param string $last_name     The new user's last name
   *
   * @return int|WP_Error         The id of the user that was created, or error if failed.
   */
  private function register_user( $email, $psw) {
      $errors = new \WP_Error();

      // Email address is used as both username and email. It is also the only
      // parameter we need to validate
      if ( ! is_email( $email ) ) {
          $errors->add( 'email', $this->get_error_message( 'email' ) );
          return $errors;
      }

      if ( username_exists( $email ) || email_exists( $email ) ) {
          $errors->add( 'email_exists', $this->get_error_message( 'email_exists') );
          return $errors;
      }

      if ( strlen( $psw ) < 6 ) {
          $errors->add( 'weak_password', $this->get_error_message( 'weak_password') );
          return $errors;
      }


      $explode = explode("@", $email);
      $name = $explode[0];

      $user_data = array(
          'user_login'    => $name,
          'user_email'    => $email,
          'user_pass'     => $psw,
      );

      $user_id = wp_insert_user( $user_data );
      return $user_id;
  }

  /**
   * Handles the registration of a new user.
   *
   * Used through the action hook "login_form_register" activated on wp-login.php
   * when accessed through the registration action.
   */
  public function do_register_user() {
      if ( 'POST' == $_SERVER['REQUEST_METHOD']  && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) )  {
        $redirect_url = home_url( 'register' );

        if( ! isset( $_POST['registerNonce'] ) || ! wp_verify_nonce( $_POST['registerNonce'], 'register-nonce' ))
        {    die('nonce problem');  }
        elseif ( ! $this->verify_recaptcha() ) {
            // Recaptcha check failed, display error
            $redirect_url = add_query_arg( 'errors', 'captcha', $redirect_url );

            } else {

              $email = sanitize_email( $_POST['user_email'] );
              $psw = sanitize_text_field( $_POST['password'] );

              $result = $this->register_user( $email, $psw );

              if ( is_wp_error( $result ) ) {
                  // Parse errors into a string and append as parameter to redirect
                  $errors = join( ',', $result->get_error_codes() );
                  $redirect_url = add_query_arg( 'errors', $errors, $redirect_url );
              } else {
                  // Success, redirect to login page.

                  $salt = wp_generate_password(20); // 20 character "random" string
                  $key = sha1($salt . $email. uniqid(time(), true));
                  $activation_link = add_query_arg( array( 'key' => $key, 'user' => $result ), esc_url( get_permalink( get_page_by_title( 'Activation Page' ) ) ));

                  add_user_meta( $result, '_Activation_key', $key, true );
                  wp_mail( $email, 'Activate your Golden Spoon Acount', 'CONGRATS BLA BLA BLA. HERE IS YOUR ACTIVATION LINK: ' . $activation_link );

                   $redirect_url = add_query_arg( array( 'register' => 'true' ), home_url( 'register' ) ) ;
              }
            }
          }

          wp_redirect( $redirect_url );
          exit;
      }

      //
  	// SETTINGS FIELDS
  	//
  	/**
  	 * Registers the settings fields needed by the plugin.
  	 */
  	public function register_settings_fields() {
  		// Create settings fields for the two keys used by reCAPTCHA
  		register_setting( 'general', 'personalize-login-recaptcha-site-key' );
  		register_setting( 'general', 'personalize-login-recaptcha-secret-key' );
  		add_settings_field(
  			'personalize-login-recaptcha-site-key',
  			'<label for="personalize-login-recaptcha-site-key">' . __( 'reCAPTCHA site key' , 'personalize-login' ) . '</label>',
  			array( $this, 'render_recaptcha_site_key_field' ),
  			'general'
  		);
  		add_settings_field(
  			'personalize-login-recaptcha-secret-key',
  			'<label for="personalize-login-recaptcha-secret-key">' . __( 'reCAPTCHA secret key' , 'personalize-login' ) . '</label>',
  			array( $this, 'render_recaptcha_secret_key_field' ),
  			'general'
  		);
  	}
  	public function render_recaptcha_site_key_field() {
  		$value = get_option( 'personalize-login-recaptcha-site-key', '' );
  		echo '<input type="text" id="personalize-login-recaptcha-site-key" name="personalize-login-recaptcha-site-key" value="' . esc_attr( $value ) . '" />';
  	}
  	public function render_recaptcha_secret_key_field() {
  		$value = get_option( 'personalize-login-recaptcha-secret-key', '' );
  		echo '<input type="text" id="personalize-login-recaptcha-secret-key" name="personalize-login-recaptcha-secret-key" value="' . esc_attr( $value ) . '" />';
  	}

    /**
   * An action function used to include the reCAPTCHA JavaScript file
   * at the end of the page.
   */
  public function add_captcha_js_to_footer() {
      echo "<script type='text/javascript' src='https://www.google.com/recaptcha/api.js'></script>";
  }

  /**
   * Checks that the reCAPTCHA parameter sent with the registration
   * request is valid.
   *
   * @return bool True if the CAPTCHA is OK, otherwise false.
   */
  private function verify_recaptcha() {
      // This field is set by the recaptcha widget if check is successful
      if ( isset ( $_POST['g-recaptcha-response'] ) && $_POST['g-recaptcha-response'] ) {
          $captcha_response = $_POST['g-recaptcha-response'];
        } else {
          return false;
      }

      // Verify the captcha response from Google
      $response = wp_remote_post(
          'https://www.google.com/recaptcha/api/siteverify',
          array(
              'body' => array(
                  'secret' => get_option( 'personalize-login-recaptcha-secret-key' ),
                  'response' => $captcha_response
              )
          )
      );

      $success = false;
      if ( $response && is_array( $response ) ) {
          $decoded_response = json_decode( $response['body'] );
          $success = $decoded_response->success;
      }


      return $success;
  }



}
