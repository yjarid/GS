<?php

/**
 * @package  
 */
namespace Profile;


class LoveMadeRoute
{

  public function register() {
    add_action('rest_api_init', array($this , 'loveMadeRoute'));
  }

 function  loveMadeRoute(){
    register_rest_route('recipe/v1', 'loveMade', array(
        'methods' => 'POST'  ,
        'callback' => array($this , 'loveMadeResults')
      ));
  }

  function loveMadeResults( $request){
    $postID = $request['postID'];
    $action = $request['action'];

    $loveUser = get_current_user_id();
    $chef = get_post_field( 'post_author', $postID);
    
    $date = date('d-m-Y');
    $month = date("M",strtotime($date));
    $year = date("Y",strtotime($date));

    

    if($loveUser && $chef) {

      // verify if a user already loved a post
      $userLovedRecipe =  get_user_meta($loveUser, $action.'_recipe'  , true) ;
      $userLovedRecipe = ( $userLovedRecipe ? $userLovedRecipe : array());
      $index_lovedRecipe = array_search($postID, $userLovedRecipe );

      // get the post meta for love or made 
      $month_key = $action.'_'.$month.'_'.$year;
      $year_key =  $action.'_'.$year;
      $loveCount = get_post_meta($postID, $action, true);
      $loveCountMonth = get_post_meta($postID, $month_key, true);
      $loveCountYear = get_post_meta($postID, $year_key, true);
      
      // get the chef meta for love or made for Month and Year
      
      $chefLoveMonth =  get_user_meta($chef, 'user_'.$month_key  , true) ;
      $chefLoveYear =  get_user_meta($chef, 'user_'.$year_key  , true) ;



      // if he hasnt already loved or Made a post
      if($index_lovedRecipe === false) {

     


        // update user  list of loved recipe by adding the post id to the array
        array_push($userLovedRecipe, $postID ); 
        
        // update Post meta love count++ 
        $loveCount = ($loveCount ? $loveCount + 1 : 1);
        
         // update Post meta love count++ for month
        $loveCountMonth = ($loveCountMonth ? $loveCountMonth + 1 : 1);

        // update Post meta love count++ for year
        $loveCountYear = ($loveCountYear ? $loveCountYear + 1 : 1);

          // update chef meta love count++ for Month
        $chefLoveMonth = ($chefLoveMonth ? $chefLoveMonth + 1 : 1);

        // update chef meta love count++ for Year
        $chefLoveYear = ($chefLoveYear ? $chefLoveYear + 1 : 1);


      } else { // if he has already loved or Made a post

          // update user  list of loved recipe by removing the post id from the array
        unset($userLovedRecipe[$index_lovedRecipe]);

        // decrease Post meta love count--
        $loveCount = ($loveCount ? $loveCount - 1 : 0);

          // decrease Post meta love count-- for month
        $loveCountMonth = ($loveCountMonth ? $loveCountMonth - 1 : 0);
        
         // decrease Post meta love count-- for year
        $loveCountYear = ($loveCountYear ? $loveCountYear - 1 : 0);

          // decrease chef meta love count--  for month
        $chefLoveMonth = ($chefLoveMonth ? $chefLoveMonth - 1 : 0);

         // decrease chef meta love count-- for Year
        $chefLoveYear = ($chefLoveYear ? $chefLoveYear - 1 : 0);
     
      }

      //  update POST meta
      update_post_meta($postID, $action , $loveCount ); // update Post meta
      update_post_meta($postID, $month_key , $loveCountMonth); // update Post meta month
      update_post_meta($postID, $year_key, $loveCountYear); // update Post meta year


      //  update USER meta
      update_user_meta($loveUser, $action.'_recipe'  , $userLovedRecipe) ; //update the user loved Recipe array
      update_user_meta($chef, 'user_'.$month_key  , $chefLoveMonth) ; // update chef meta Month
      update_user_meta($chef, 'user_'.$year_key  , $chefLoveYear) ; // update chef meta yesr


      

      return $loveCount;

    } else {
      die('You can not perform this action');
    }

   
}



}