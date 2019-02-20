<?php
/**
 * @package  
 */
namespace Profile;

class Activate
{

  /**
  * Plugin activation hook.
  * Creates all WordPress pages needed by the plugin.
  */
       public static function activate() {
            // wp_insert_post(
            //            array(
            //                'post_content'   => 'test',
            //                'post_title'     => 'profile test 122322233',
            //                'post_status'    => 'publish',
            //                'post_type'      => 'page',
            //                'ping_status'    => 'closed',
            //                'comment_status' => 'closed',
            //            )
            //        );
           flush_rewrite_rules();
       }


	}