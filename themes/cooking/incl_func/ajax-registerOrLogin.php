<?php
/**
* Handeling the Login
*/

add_action('wp_ajax_nopriv_login', 'youssef_login');

function youssef_login(){

check_ajax_referer( 'loginNonce', 'nonceLogin' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {
  $creds = array();
$creds['user_login'] = $_POST['email'];
$creds['user_password'] = sanitize_text_field( $_POST['password'] );
$creds['remember'] = true;


$user = wp_signon( $creds, false );

$data = [];

if ( is_wp_error($user) ) {
  $data['login'] = 'false';
  $data['html'] = $user->get_error_code();
}

else
{
  wp_set_current_user( $user );

    $data['login'] = 'true';
    $data['html'] = 'Login successful, redirecting...';
  }



echo json_encode( $data );

  }
  die();
}

/**
* Handeling the Registration
*/

add_action('wp_ajax_nopriv_register', 'youssef_register');

function youssef_register(){

// check_ajax_referer( 'registerNonce', 'nonceRegister' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

$email = sanitize_email($_POST['email']);
$explode = explode("@", $email );
$name = $explode[0];
if( username_exists( $name )) {
  $rand = wp_generate_password(2);
  $name =$name.'_'.$rand;
}

$userInfo = array();
$userInfo['user_login'] = $name;
$userInfo['user_email'] = $email;
$userInfo['user_pass'] = sanitize_text_field( $_POST['pass'] );





$user = wp_insert_user( $userInfo ) ;

$data = [];

if ( is_wp_error($user) ) {
  $data['reg'] = 'false';
  $data['html'] =  $user->get_error_code();
  $data['html_msg'] =  $user->get_error_message();
}

else if($user && !is_wp_error($user))
{
  $salt = wp_generate_password(20); // 20 character "random" string
  $key = sha1($salt . $_POST['email']. uniqid(time(), true));
  $activation_link = add_query_arg( array( 'key' => $key, 'user' => $user ), esc_url( get_permalink( get_page_by_title( 'Activation Page' ) ) ));

  add_user_meta( $user, '_Activation_key', $key, true );
  wp_mail( $_POST['email'], 'Activate your Golden Spoon Acount', 'CONGRATS BLA BLA BLA. HERE IS YOUR ACTIVATION LINK: ' . $activation_link );


  $data['reg'] = 'true';
  $data['html'] = 'Registration successful, redirecting...';

}

echo json_encode( $data );


  }
die();
}
