<?php
/**
 * diffent helper functions to display specific content 
 */
namespace GS\Data;

use \GS\DisplayFunc;


class PostData 
{

    private static $date ;

    function __construct() {
        self::$date = DisplayFunc::getDate();
    }

    // get the post ingredient and description 
    static function getPostMeta($id) {
        $meta = get_post_meta( $id , 'post_meta', true );
        $meta = ($meta ?: array());
        return $meta;
    }


    // get the chef comment rating 

    static function getPostRating($id, $period = 'Month') {
        $data = array('nbr' => 0 , 'avg' => 0);

        if($period = 'Month') $rating = get_post_meta($id, 'rating_'.self::$date['M'].'_'.self::$date['Y'], true);
        if($period = 'Year') $rating = get_post_meta($id, 'rating_'.self::$date['Y'], true);
        
        if($rating) {
                // number of reviews
            $data['nbr'] = ($rating[0] ?: 0) ;
            // average rating
            $data['avg'] = ($rating[2] ?: 0) ;
        }
      
        return $data;
    }

    // number of love or made 
    static function getLove($postId, $loveOrMade) {
        $nbrLove = get_post_meta($postId, $loveOrMade, true);
        $nbrLove = ($nbrLove ? $nbrLove : 0);
        return $nbrLove;
    }

    //   number of Love Or Made by chef both Month and year   

    static function nbrPostLove($id, $loveOrMade, $period = 'Month') {

        if($period = 'Month') { $metaKey = $loveOrMade.'_'.self::$date['M'].'_'.self::$date['Y']; } //exp: user_made_Mar_2019
        else { $metaKey = $loveOrMade.'_'.self::$date['Y']; } // exp: user_made_2019

        $Love = get_post_meta($id, $metaKey, true);
        $Love = ($Love ? $Love : 0);
        return $Love;
    }

     // get GS rating 
     static function getGSRating($postID) {
        $GSRating =   get_post_meta($postID, 'GSRating',true);
        $GSRating = ($GSRating ?: 0);
        return $GSRating ;
     }
 
      // get GS rating input
      static function getGSRatingInput($postID) {
         $GSRating =   get_post_meta($postID, 'GSRating_input',true);
         $GSRating = ($GSRating ?: array());
         return $GSRating ;
      }

       // get GS rating 
     static function getGSRatingDiff($postID) {
        $GSRating =   get_post_meta($postID, 'GSRating_diff',true);
        $GSRating = ($GSRating ?: 0);
        return $GSRating ;
     }
 
      // get GS rating input
      static function getGSRatingInputDiff($postID) {
         $GSRating =   get_post_meta($postID, 'GSRating_input_diff',true);
         $GSRating = ($GSRating ?: array());
         return $GSRating ;
      }
    
          // get GS rating Rank 
    static function getGSRatingRank($postID) {
        $GSRating =   get_post_meta($postID, 'RankGSRating',true);
        $GSRating = ($GSRating ?: 0);
        return $GSRating ;
     }

     // get GS rating diff Rank 
     static function getGSRatingDiffRank($postID) {
        $GSRating =   get_post_meta($postID, 'RankGSRating_diff',true);
        $GSRating = ($GSRating ?: 0);
        return $GSRating ;
     }

     static function getPost($numb , $metaKey,  $include =[], $paged =null, $tax=[] ){
        $args = array(
          'post_status' => 'publish',
          'post_type' => 'recipe',
          'posts_per_page' => $numb,
          'tax_query'=>$tax,
          'paged'=>$paged
        );

        if ($metaKey) {
            $args['meta_key'] = $metaKey;
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';

        }

        $posts= new \wp_Query($args);

        return $posts; 
        
      }


}