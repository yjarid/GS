<?php



// Lost post_password_required(

add_action( 'login_form_lostpassword', 'redirect_to_custom_lostpassword'  );

function redirect_to_custom_lostpassword() {
  //redirect user to the custom lost password page
  if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
    wp_redirect( home_url( 'lost-password' ) );
    exit;
  }
// Initiates password reset. after the user clicks on Reset Password
  if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
      $errors = retrieve_password();
      if ( is_wp_error( $errors ) ) {
          // Errors found
          $redirect_url = home_url( 'lost-password' );
          $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
      } else {
          // Email sent
          $redirect_url = home_url( 'login' );
          $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
      }

      wp_redirect( $redirect_url );
      exit;
  }
}

/**
 * Customize the Password Reset Email
 */
add_filter( 'retrieve_password_message',  'replace_retrieve_password_message' , 10, 4 );

/**
 * Returns the message body for the password reset mail.
 * Called through the retrieve_password_message filter.
 *
 * @param string  $message    Default mail message.
 * @param string  $key        The activation key.
 * @param string  $user_login The username for the user.
 * @param WP_User $user_data  WP_User object.
 *
 * @return string   The mail message to send.
 */

function replace_retrieve_password_message($message, $key, $user_login, $user_data){
  // Create new message
 $msg  = __( 'Hello!', 'personalize-login' ) . "\r\n\r\n";
 $msg .= sprintf( __( 'You asked us to reset your password for your account using the email address %s.', 'personalize-login' ), $user_login ) . "\r\n\r\n";
 $msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", 'personalize-login' ) . "\r\n\r\n";
 $msg .= __( 'To reset your password, visit the following address:', 'personalize-login' ) . "\r\n\r\n";
 $msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
 $msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";

 return $msg;

}

/**
 * Redirects to the custom password reset page, or the login page
 * if there are errors.
 */

 add_action( 'login_form_rp', 'redirect_to_custom_password_reset'  );
 add_action( 'login_form_resetpass',  'redirect_to_custom_password_reset'  );

  function redirect_to_custom_password_reset() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        // Verify key / login combo
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( 'login?login=expiredkey' ) );
            } else {
                wp_redirect( home_url( 'login?login=invalidkey' ) );
            }
            exit;
        }

        $redirect_url = home_url( 'member-password-reset' );
        $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
        $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

        wp_redirect( $redirect_url );
        exit;
    }
};
