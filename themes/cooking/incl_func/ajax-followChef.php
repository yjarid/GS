<?php

add_action('wp_ajax_followChef', 'youssef_followChef');


function youssef_followChef(){

check_ajax_referer( 'sortNonce', 'nonceSort' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

  $user = $_POST['user'];
  $chef = $_POST['chefToFollow'];
  $isFollowing = $_POST['isFollowing'];

  
//   add the chef to the list of chefs foolowed by logged in user 

$followedChef = get_user_meta($user, 'followed_chef', true);
$followedChef = (($followedChef) ? $followedChef : array());
$index_followedChef = array_search($chef , $followedChef );
  
  if($index_followedChef === false) {
    array_push($followedChef , $chef);
    $status = "follow";
  } else {
    unset($followedChef[$index_followedChef]);
    $status = "unFollow";
  }

  update_user_meta( $user, 'followed_chef', $followedChef);

  


  //   add the logged in user  to the list of users following the chef

  $followingUser = get_user_meta($chef, 'following_user', true);
  $followingUser = (($followingUser) ? $followingUser : array());
  $index_followingUser = array_search($user , $followingUser );

  if( $index_followingUser === false ) {
    array_push($followingUser , $user);
  } else {
    unset($followingUser[$index_followingUser]);
  }

  update_user_meta( $chef, 'following_user', $followingUser);
 

  $json = array('status'=>$status);

    echo json_encode($json);



    }


    die();


}
