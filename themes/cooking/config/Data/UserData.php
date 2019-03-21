<?php
/**
 * diffent helper functions to display specific content 
 */
namespace GS\Data;

use \GS\DisplayFunc;


class UserData 
{
    private static $date ;

    function __construct() {
        self::$date = DisplayFunc::getDate();
    }

    //   the array of chefs followed by a user  

    static function getFollowedChefs($user) {
        $chefs = get_user_meta($user, 'followed_chef', true);
        $followedChefs = ($chefs ? $chefs : array());
        return $followedChefs;
    }

    static function isFollowedChef($chef, $user) {
        $followedChefs = self::getFollowedChefs($user);
        $index_followedChef = array_search($chef , $followedChefs );
       return  $index_followedChef;
    }

      //   the array of users following a chef  

    static function getFollowingUsers($chef) {
        $users = get_user_meta($chef, 'following_user', true);
        $followingUsers = ($users ? $users : array());
        return $followingUsers;
    }

    static function isFollowingUser($user, $chef) {
        $followingUsers = self::getFollowingUsers($chef);
        $index_followingUser = array_search($user , $followingUsers );
       return  $index_followingUser;
    }

        //   the array of Posts "Loved OR Made" by a user  

        static function getUserLovedRecipe($user, $loveOrMade) {
            $metaKey = $loveOrMade.'_recipe';
            $userLovedRecipe = get_user_meta($user, $metaKey, true);
            $userLovedRecipe = ($userLovedRecipe ? $userLovedRecipe : array());
            return $userLovedRecipe;
        }
    
        static function isLovedRecipe($post, $user, $loveOrMade ) {
            $lovedRecipe = self::getUserLovedRecipe($user, $loveOrMade);
            $index_lovedRecipe = array_search($post , $lovedRecipe );
           return  $index_lovedRecipe;
        }

            //   number of Love Or Made by chef both Month and year   

        static function nbrUserLove($user, $loveOrMade, $period = 'Month') {

            if($period = 'Month') { $metaKey = 'user_'.$loveOrMade.'_'.self::$date['M'].'_'.self::$date['Y']; } //exp: user_made_Mar_2019
            else { $metaKey = 'user_'.$loveOrMade.'_'.self::$date['Y']; } // exp: user_made_2019

            $userLove = get_user_meta($user, $metaKey, true);
            $userLove = ($userLove ? $userLove : 0);
            return $userLove;
        }
    
 

    // get the chef comment rating 

    static function getChefRating($chef, $period = 'Month') {
        $data = array('nbr' => 0 , 'avg' => 0);
        
        if($period = 'Month') $rating = get_user_meta($chef, 'rating_'.self::$date['M'].'_'.self::$date['Y'], true);
        if($period = 'Year') $rating = get_user_meta($chef, 'rating_'.self::$date['Y'], true);
        
        if($rating) {
             // number of reviews
            $data['nbr'] = ($rating ? $rating[0] : 0) ;
            // average rating
            $data['avg'] = ($rating ? $rating[2] : 0) ;
        }
       
        return $data;
    }

    // get GS rating 
    static function getGSRating($userID) {
       $GSRating =   get_user_meta($userID, 'GSRating',true);
       $GSRating = ($GSRating ?: 0);
       return $GSRating ;
    }

     // get GS rating input
     static function getGSRatingInput($userID) {
        $GSRating =   get_user_meta($userID, 'GSRating_input',true);
        $GSRating = ($GSRating ?: array());
        return $GSRating ;
     }

        // get GS rating difference
    static function getGSRatingDiff($userID) {
        $GSRating =   get_user_meta($userID, 'GSRating_diff',true);
        $GSRating = ($GSRating ?: 0);
        return $GSRating ;
     }
 
      // get GS rating input difference
      static function getGSRatingInputDiff($userID) {
         $GSRating =   get_user_meta($userID, 'GSRating_input_diff',true);
         $GSRating = ($GSRating ?: array());
         return $GSRating ;
      }

        // get GS rating Rank 
    static function getGSRatingRank($userID) {
        $GSRating =   get_user_meta($userID, 'RankGSRating',true);
        $GSRating = ($GSRating ?: 0);
        return $GSRating ;
     }

     // get GS rating diff Rank 
     static function getGSRatingDiffRank($userID) {
        $GSRating =   get_user_meta($userID, 'RankGSRating_diff',true);
        $GSRating = ($GSRating ?: 0);
        return $GSRating ;
     }

    // get count of post by user ID and Post type 
    static function getNbrPostsByUser($userId, $postType){
        global $wpdb;

        $nbrPost = $wpdb->get_var( $wpdb->prepare( 
            "
                SELECT COUNT(*)
                FROM $wpdb->posts
                WHERE post_type = %s AND post_author = %d AND post_status = 'publish'
            ", 
            $postType,
            $userId
           
        ) );

        return $nbrPost;
    }
    


}