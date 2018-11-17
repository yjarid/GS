<?php
/**
 * Plugin Name: wp Authenticate
 * Description: to override the core wp_authenticate function
 * Version: 1.0.0
 * Author: Youssef Jarid
 * Author URI: http://danielpataki.com
 * License: GPL2
 */


 // override core function
 if ( !function_exists('wp_authenticate') ) :
 function wp_authenticate($username, $password) {
     $username = sanitize_user($username);
     $password = trim($password);

     $user = apply_filters('authenticate', null, $username, $password);

     if ( $user == null ) {
         // TODO what should the error message be? (Or would these even happen?)
         // Only needed if all authentication handlers fail to return anything.
         $user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));
     }
     elseif ( get_user_meta( $user->ID, '_Activation_key', true ) != false ) {
         $user = new WP_Error('activation_failed', __('<strong>ERROR</strong>: User is not activated.'));
     }

     $ignore_codes = array('empty_username', 'empty_password');

     if (is_wp_error($user) && !in_array($user->get_error_code(), $ignore_codes) ) {
         do_action('wp_login_failed', $username);
     }

     return $user;
 }
 endif;
