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
        case 'profile':
         require_once( "$this->plugin_path/views/mainProfile.php" );
        break;

        case 'recipe':
        require_once( "$this->plugin_path/views/myRecipes.php" );
        break;

        case 'fav':
        require_once( "$this->plugin_path/views/myFavorite.php" );
        break;

        case 'friend':
        require_once( "$this->plugin_path/views/myFriends.php" );
        break;

        case 'made':
        require_once( "$this->plugin_path/views/madeIt.php" );
        break;
    }
    
    $html = ob_get_contents(); // we pass the posts to variable
    ob_end_clean();

    $json = array('html'=>$html, 'status'=>true);

       echo json_encode($json);


    }

    die();


}
}