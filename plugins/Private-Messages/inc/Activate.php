<?php
/**
 * @package  
 */
namespace Message;

class Activate
{

  /**
  * Plugin activation hook.
  * Creates all WordPress pages needed by the plugin.
  */
       public static function activate() {
       
          self::createMessageTable();
       }

       private function createMessageTable(){

            global $wpdb;
            global $message_db_version;
            $message_db_version = '1.0';

            $table_name = $wpdb->prefix . 'messages';
            
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                title tinytext NOT NULL,
                content text NOT NULL,
                sender mediumint(9) NOT NULL ,
                receiver mediumint(9) NOT NULL ,
                parent tinyint NOT NULL ,
                PRIMARY KEY  (id),
                INDEX (sender, receiver)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            add_option( 'GS_db_version', $message_db_version );
       }


	}