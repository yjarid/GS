<?php 
use GS\Data\UserData;
$user = get_current_user_ID();
$lovedRecipes = UserData::getUserLovedRecipe($user, 'love');
$madeRecipes = UserData::getUserLovedRecipe($user, 'made');

$lovedRecipes = array_diff($lovedRecipes, $madeRecipes);

?>

<div class="UPsectionCont">
    <h3 class="UPsectionCont_Title">Made it </h3>

    <?php 
    if($madeRecipes){
        $args = [
            'post_type' => 'recipe',
            'post__in' => $madeRecipes,
            'posts_per_page' => 20,
            'no_found_rows' => true
            ];
    
        $made = new WP_Query($args);
        if($made) { ?>
            <div class="cardsContainer">
    
                <?php while($made->have_posts()) {
                    $made->the_post() ; ?>
                    <?php get_template_part( 'content/recipeCard' );    
                } ?>
    
            </div>
        <?php } 
        } else {
            echo "You haven't made any recipe";
    }
   
    ?>
</div>

<div class="UPsectionCont">
    <h3 class="UPsectionCont_Title">Waiting to Be Made (Loved it) </h3>

    <?php 
    if($lovedRecipes) {
        $args = [
            'post_type' => 'recipe',
            'post__in' => $lovedRecipes,
            'posts_per_page' => 20,
            'no_found_rows' => true
        ];
    
         $love = new WP_Query($args);
        if($love ) { ?>
            <div class="cardsContainer">
    
                <?php while($love->have_posts()) {
                    $love->the_post() ; ?>
                    <?php get_template_part( 'content/recipeCard' );    
                } ?>
    
            </div>
        <?php } 
        } else {
            echo "You dont have any recipes loved and not made";
    }
    
    ?>
</div>
