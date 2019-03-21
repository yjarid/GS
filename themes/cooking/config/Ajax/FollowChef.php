<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS\Ajax;

 


class FollowChef 
{
	public function register() {
        add_action('wp_ajax_followChef', array($this , 'followChef'));
    }

    function followChef() {
        check_ajax_referer( 'sortNonce', 'nonceSort' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

  $user = $_POST['user'];
  $chef = $_POST['chefToFollow'];
  $isFollowing = $_POST['isFollowing'];

  
//   add the chef to the list of chefs foolowed by logged in user 

$followedChef = get_user_meta($user, 'followed_chef', true);
$followedChef = (($followedChef) ? $followedChef : array());
$index_followedChef = array_search($chef , $followedChef );
  
  if($index_followedChef === false && $isFollowing =='no') {
    array_push($followedChef , $chef);
    $status = "follow";
  } 
  elseif($index_followedChef !== false && $isFollowing =='yes') {
    unset($followedChef[$index_followedChef]);
    $status = "unFollow";
  }

  update_user_meta( $user, 'followed_chef', $followedChef);

  


  //   add the logged in user  to the list of users following the chef

  $followingUser = get_user_meta($chef, 'following_user', true);
  $followingUser = (($followingUser) ? $followingUser : array());
  $index_followingUser = array_search($user , $followingUser );

  $t=date('d-m-Y');
  $month = date("M",strtotime($t));
  $year = date("Y",strtotime($t));

  $metaKey = 'nbr_following_user_'.$month.'_'.$year ;

  $nbrFollowingUserMonth = get_user_meta($chef , $metaKey , true);

  if( $index_followingUser === false ) {
    array_push($followingUser , $user);
    $nbrFollowingUserMonth = ($nbrFollowingUserMonth ? $nbrFollowingUserMonth + 1 : 1);
  } else {
    unset($followingUser[$index_followingUser]);
    $nbrFollowingUserMonth--;
  }

  update_user_meta( $chef, 'following_user', $followingUser);
  update_user_meta( $chef, $metaKey, $nbrFollowingUserMonth);
 

  $json = array('status'=>$status);

    echo json_encode($json);



    }


    die();

    }
}