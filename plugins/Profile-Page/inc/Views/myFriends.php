<?php 
use GS\Data\UserData;
use GS\DisplayFunc;


$id = get_current_user_ID();
$followers = UserData::getFollowingUsers($id);
$followedChefs = UserData::getFollowedChefs($id);
?>

<h3>Top Followers </h3>
<div class="categoryGrid">

<?php 

if($followers){
    DisplayFunc::displayUser(12 , 'GSRating_diff' ,'chefCard',  $followers, 1 );
} else {
    echo 'You don\'t have any folowers' ;
}
         ?>
</div>

<h3>Top Followed chef </h3>
<div class="categoryGrid">

<?php 

if($followedChefs){
    DisplayFunc::displayUser(12 , 'GSRating_diff' ,'chefCard',  $followedChefs, 1 );
} else {
    echo 'You don\'t have any folowers' ;
}
         ?>
</div>

<h3>Top Followed chef </h3>
<div class="cardsContainer">
        <?php

          $args = array(
                  'post_status' => 'publish',
                  'post_type' => 'recipe',
                  'posts_per_page' => 10,
                  'author__in' => $followedChefs
                  
              );

            $followedChefRecipes = new wp_Query($args);


            while($followedChefRecipes->have_posts()) {
                $followedChefRecipes->the_post() ;

                get_template_part( 'content/recipeCard' );

         }

