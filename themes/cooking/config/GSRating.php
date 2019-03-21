<?php
/**
 * diffent helper functions to display specific content 
 */
namespace GS;

 use GS\Data\UserData;
 use GS\Data\PostData;
 use GS\Data\ViewsData;
 


class GSRating 
{

    function register(){
        $this->userGSRating(); //update the GSrating and GSRating diff and GS rating input for all users 
        $this->postGSRating(); //update the GSrating and GSRating diff and GS rating input for all posts
        $this->rankByGSRating();
        $this->rankByGSRatingDifference();
    }

    function userGSRating() {
        $users = get_users( array( 'fields' => array( 'ID' ) ) );

        foreach($users as $user) {
            $userID = $user->ID;

            // get the previous GS Rating and input
            $previousGSRating = UserData::getGSRating($userID);
            $previousInput = [];
            $previousGSRatingInput = UserData::getGSRatingInput($userID) ;           

            //  retreive initial data fron UserData
            $followers = UserData::getFollowingUsers($userID);
            $followedChef = UserData::getFollowedChefs($userID); 
            $ratingMonth = UserData::getChefRating($userID , 'Month');
            $ratingYear = UserData::getChefRating($userID , 'Year');
            $recipeMadebyYou = UserData::getUserLovedRecipe($userID, 'made');
            $recipeLovedbyYou = UserData::getUserLovedRecipe($userID, 'love');

            //  chef Active AC
            $nbr_Post = UserData::getNbrPostsByUser($userID , 'recipe'); // number of recipes posted by a user *ALL Time*
            $nbr_followers = count($followers); // number of users following the chef

            // Quality of recipes QR
            $made_month = UserData::nbrUserLove($userID, 'made', 'Month');
            $love_month = UserData::nbrUserLove($userID, 'love', 'Month');
            $made_year = UserData::nbrUserLove($userID, 'made', 'Year');
            $love_year = UserData::nbrUserLove($userID, 'love', 'Year');

            // viwers Satisfaction VS
            $reviews_month = $ratingMonth['nbr'] ;
            $rating_month = $ratingMonth['avg'];
            $reviews_year = $ratingYear['nbr'] ;
            $rating_year = $ratingYear['avg'];

            // good branding GB
            $views_month = ViewsData::getUserViews($userID, 'Month') ;
            $views_year = ViewsData::getUserViews($userID, 'Year');

            // Interaction with other chef IC
            $madeby_you = count($recipeMadebyYou ) ;
            $lovedby_you = count($recipeLovedbyYou ) ;
            $chef_yourFollowing = count($followedChef);

            // User GS precalculation
            $AC = round(min(($nbr_Post*2)+$nbr_followers , 100));
            $QR = round(min((($made_year*4)+($love_year*3))/2 , 100) + min((($made_month*4)+($love_month*3)) , 200));
            $VS = round(min(($reviews_year*$rating_year)/3 , 100) + min($reviews_month*$rating_month , 200)) ;
            $GB = round(min($views_year/100 , 100) + min($views_month/10 , 100));
            $IC = round(min($madeby_you + $lovedby_you +$chef_yourFollowing , 100 ));

            // update the GS Rating 
            $userGS = $AC + $QR + $VS + $GB + $IC;
            $userGS = ($userGS ?: 0);

            $input = ['AC' => $AC, 'QR' => $QR, 'VS' => $VS, 'GB' => $GB, 'IC' => $IC];

            update_user_meta($userID , 'GSRating_input', $input );
            update_user_meta($userID , 'GSRating', $userGS );

            // update the GSRating evolution 
            $diffUserGS = $userGS - $previousGSRating;
            $diffInput = array();
            foreach($input as $key => $value ) {
                $diffInput[$key] = $input[$key] - $previousGSRatingInput[$key];
            }

            update_user_meta($userID , 'GSRating_input_diff', $diffInput );
            update_user_meta($userID , 'GSRating_diff', $diffUserGS );



        }
    }

    function postGSRating() {
        $posts = get_posts(array(
            'fields'          => 'ids', // Only get post IDs
            'posts_per_page'  => -1,
            'post_type'        => 'recipe',
            'post_status'      => 'publish'
        ));

        

        foreach($posts as $postID) {      

             // get the previous GS Rating and input
             $previousGSRating = PostData::getGSRating($postID);
             $previousInput = [];
             $previousGSRatingInput = PostData::getGSRatingInput($postID);

                        
            $rating_month = PostData::getPostRating($postID , 'Month');
            $rating_year = PostData::getPostRating($postID , 'Year');


            // Quality of recipes QR
            $made_month = PostData::nbrPostLove($postID, 'made', 'Month');
            $love_month = PostData::nbrPostLove($postID, 'love', 'Month');
            $made_year = PostData::nbrPostLove($postID, 'made', 'Year');
            $love_year = PostData::nbrPostLove($postID, 'love', 'Year');

            // viwers Satisfaction VS
            $reviews_month = $rating_month['nbr'] ;
            $rating_month = $rating_month['avg'];
            $reviews_year = $rating_year['nbr'] ;
            $rating_year = $rating_year['avg'];

            // good branding GB
            $views_month = ViewsData::getPostViews($postID, 'Month') ;
            $views_year = ViewsData::getPostViews($postID, 'Year');


            // User GS precalculation
            $QR = round(min((($made_year*5)+($love_year*4))/2 , 200) + min((($made_month*5)+($love_month*4)) , 200));
            $VS = round(min(($reviews_year*$rating_year)/2 , 100) + min($reviews_year*$rating_year*1.5 , 200)) ;
            $GB = round(min($views_year/40 , 100) + min($views_month/4 , 100));
    

            $postGS = $QR + $VS + $GB;
            $postGS = ($postGS ?: 0);

            $input = [ 'QR' => $QR, 'VS' => $VS, 'GB' => $GB];

            update_post_meta($postID , 'GSRating_input', $input );

            update_post_meta($postID , 'GSRating', $postGS );

             // update the GSRating evolution 
             $diffPostGS = $postGS - $previousGSRating;
             $diffInput = array();
             foreach($input as $key => $value ) {
                 $diffInput[$key] = $input[$key] - $previousGSRatingInput[$key];
             }
 
             update_post_meta($postID , 'GSRating_input_diff', $diffInput );
             update_post_meta($postID , 'GSRating_diff', $diffPostGS );

        }
    }

    function rankByGSRating() {

        // Rank users by GS rating 
        $users = get_users( 
            array( 
                'fields' => array( 'ID' ) ,
                'order'     => 'DESC',
                'meta_key' => 'GSRating',
                'orderby'   => 'meta_value_num'
            ) );

            for($i=0 ; $i < count($users) ; $i++ ) {
                $user = $users[$i]->ID;
                $rank = $i + 1;
                update_user_meta($user , 'RankGSRating', $rank );
            }

           // Rank Posts by GS rating  
            $posts = get_posts(
                array(
                    'fields'          => 'ids', // Only get post IDs
                    'posts_per_page'  => -1,
                    'post_type'        => 'recipe',
                    'post_status'      => 'publish',
                    'order'     => 'DESC',
                    'meta_key' => 'GSRating',
                    'orderby'   => 'meta_value_num'
                ));

            for($i=0 ; $i < count($posts) ; $i++ ) {
                $rank = $i + 1;
                update_post_meta($posts[$i] , 'RankGSRating', $rank );
            }

    }

    function rankByGSRatingDifference() {

        // Rank users by GS rating 
        $users = get_users( 
            array( 
                'fields' => array( 'ID' ) ,
                'order'     => 'DESC',
                'meta_key' => 'GSRating_diff',
                'orderby'   => 'meta_value_num'
            ) );

            for($i=0 ; $i < count($users) ; $i++ ) {
                $user = $users[$i]->ID;
                $rank = $i + 1;
                update_user_meta($user , 'RankGSRating_diff', $rank );
            }

           // Rank Posts by GS rating  
            $posts = get_posts(
                array(
                    'fields'          => 'ids', // Only get post IDs
                    'posts_per_page'  => -1,
                    'post_type'        => 'recipe',
                    'post_status'      => 'publish',
                    'order'     => 'DESC',
                    'meta_key' => 'GSRating_diff',
                    'orderby'   => 'meta_value_num'
                ));

            for($i=0 ; $i < count($posts) ; $i++ ) {
                $rank = $i + 1;
                update_post_meta($posts[$i] , 'RankGSRating_diff', $rank );
            }

    }
}

