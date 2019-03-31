<?php

/**
 * @package  
 */
namespace Profile\ajax;

use \Profile\BaseController;


class SubPage extends BaseController
{

  public function register() {

    add_action('wp_ajax_userProfile', array($this ,'userProfileSubPage'));
  
  }




function userProfileSubPage(){

 check_ajax_referer( 'sortNonce', 'nonceSort' );

 if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

   $anchor = $_POST['anchor'];

  
  
    ob_start();

    switch ($anchor) {
       
        case 'recipe':
        require_once( "$this->plugin_path/inc/Views/myRecipes.php" );
        break;

        case 'friend':
        require_once( "$this->plugin_path/inc/views/myFriends.php" );
        break;

        case 'made':
        require_once( "$this->plugin_path/inc/views/madeIt.php" );
        break;
    }
    
    $html = ob_get_contents(); 
    ob_end_clean();

    $json = array('html'=>$html, 'status'=>true);

       echo json_encode($json);


     }

    die();


}
}