<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS;

// use \Login\BaseController;


class Media 
{
	public function register() {

        // Remove media library tab from media Uploader
        add_filter( 'ajax_query_attachments_args', array($this ,'restrict_non_Admins') );

        // Sanitize tinyMce editor input when pasting from the web 
        add_filter( 'teeny_mce_before_init', array($this , 'my_format_TinyMCE') , 10, 2);

    
    }
    
    function restrict_non_Admins($query){

        if ( ! current_user_can( 'manage_options' ) ){
        $query['author'] = get_current_user_id();
        return $query;
      }
        return $query;
    
      }

      function my_format_TinyMCE( $init, $id  ) {
  
        $init['plugins'] = 'colorpicker,lists,fullscreen,image,wordpress,wpeditimage,wplink,paste';
        $init['paste_as_text'] = true;
          
         return $init;
      }
	
	
}