
<div class="UPsectionCont">

<h3 class="UPsectionCont_Title"> My Recipes </h3>

<?php 
    $args = [
        'post_type' => 'recipe',
        'author' => get_current_user_id(),
        'posts_per_page' => 50,
        'no_found_rows' => true
    ];

     $myRecipes = new WP_Query($args);
    if($myRecipes ) { ?>
        <table id="Recipes_table">
            <tr>
                <th>Recipes</th>
                <th>Views</th>
                <th>Made</th>
                <th>Love</th>
                <th>Rating</th>
                <th>Reviews</th>
            </tr>

            <?php while($myRecipes->have_posts()) {
                $myRecipes->the_post() ; ?>
                <?php get_template_part( 'content/recipeList' );    
            } ?>

        </table>
    <?php } else { ?>
            <p>You don 't have any recipes posted</p>
    <?php }
    
    ?>

</div>
