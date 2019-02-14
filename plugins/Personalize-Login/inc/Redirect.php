<?php
/**
 * @package  PersonalizeLogin
 */
namespace Login;

/**
*
*/
class Redirect
{
  public function register() {
    add_action( 'template_redirect', array($this, 'yj_login_template_redirect' ));
  }

  function yj_login_template_redirect()
  {
      if( is_page( ['login', 'register', 'password-lost'] ) &&  is_user_logged_in() )
      {
          wp_redirect( home_url( 'user-profile' ) );
          die;
      }

      if( is_page( 'user-profile' ) &&  !is_user_logged_in() )
      {
          wp_redirect( home_url('login'  ) );
          die;
      }

      if ( is_page('activation-page')  ) {
          $user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
          if ( $user_id ) {
              // get user meta activation hash field
              $code = get_user_meta( $user_id, '_Activation_key', true );
              if ( $code == filter_input( INPUT_GET, 'key' ) ) {
                  delete_user_meta( $user_id, '_Activation_key' );
                  $link = esc_url(add_query_arg( array( 'status' => 'actif' ),  get_permalink( get_page_by_title( 'login' ) ) ));
                  wp_redirect(  $link );
                  die;
              }

              else {
                wp_redirect(  home_url(  ));
              }
          }
      }

      if (is_page('password-reset') && !filter_input( INPUT_GET, 'key' ) ){
        wp_redirect(  home_url('password-lost'));
      }
  }
}
