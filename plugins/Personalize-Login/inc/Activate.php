<?php
/**
 * @package  AlecadddPlugin
 */
namespace Inc;

class Activate
{

  /**
  * Plugin activation hook.
  * Creates all WordPress pages needed by the plugin.
  */
       public static function activate() {
           // Information needed for creating the plugin's pages
           $page_definitions = array(
               'login' => array(
                   'title' => __( 'Login', 'personalize-login' ),
                   'content' => '[custom-login-form]'
               ),
               'register' => array(
                   'title' => __( 'Register', 'personalize-login' ),
                   'content' => '[custom-register-form]'
               ),
               'Activate' => array(
                   'title' => __( 'Activation Page', 'personalize-login' ),
               ),
              'password-lost' => array(
                  'title' => __( 'Forgot Your Password?', 'personalize-login' ),
                  'content' => '[custom-password-lost-form]'
              ),
              'password-reset' => array(
                  'title' => __( 'Pick a New Password', 'personalize-login' ),
                  'content' => '[custom-password-reset-form]'
              )
               // 'member-account' => array(
               //     'title' => __( 'Your Account', 'personalize-login' ),
               //     'content' => '[account-info]'
               // ),
           );

           foreach ( $page_definitions as $slug => $page ) {
               // Check that the page doesn't exist already
               $query = new \WP_Query( 'pagename=' . $slug );
               if ( ! $query->have_posts() ) {
                   // Add the page using the data from the array above
                   wp_insert_post(
                       array(
                           'post_content'   => $page['content'],
                           'post_name'      => $slug,
                           'post_title'     => $page['title'],
                           'post_status'    => 'publish',
                           'post_type'      => 'page',
                           'ping_status'    => 'closed',
                           'comment_status' => 'closed',
                       )
                   );
               }
           }
           flush_rewrite_rules();
       }


	}
