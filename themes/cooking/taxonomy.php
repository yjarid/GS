
<?php get_header();

use GS\DisplayFunc;
$date = DisplayFunc::getDate();
?>

<div class="container ">

<div class="postNewRecipeTop">
  <h3 class="postNewRecipeTitle"><?php echo single_term_title(  '',  true ); ?></h3>
  <p class="postNewRecipeDescription"> 
    <?php echo get_the_archive_description();?>
  </p>
 </div>

 
  <div class="cardTop">
    <div  class="cardsTitle">Recipes</div>
    <div class="sortedBY">
      <div class="containerSort">
          <label class="toSort1">Sort by :</label>
            <select name="sortBy" id="sortBy" class="toSort2" data-tax="<?php echo get_query_var('taxonomy'); ?>" data-term="<?php echo get_query_var('term'); ?>">
              <option selected=""  value="date">Date</option>
              <option   value="<?php echo'post_views_'.$date['M'].'_'.$date['Y'] ?>">Views</option>
              <option   value="<?php echo'GSRating_diff' ?>">Score</option>
            </select>

      </div>
    </div>
  </div>

  <div id="cardsContainer--withSpinner">
    <div class="cardsContainer" id="sortCards">
    <?php while ( have_posts() ) {
      the_post();
          get_template_part( 'content/recipeCard' );

     } ?>

    </div>
  </div>


  <div class="loadMoreButton" id="loadMoreButtonSort" data-page="1"  data-max="<?php echo $wp_query->max_num_pages;?>">
    <div class="loadMoreButton--Container">
      <span class="icon--refresh icon"></span>
      <span class="loadMoreButton--text text" > Load More </span>
    </div>

  </div>
</div><!-- .container  -->


<?php get_footer(); ?>
