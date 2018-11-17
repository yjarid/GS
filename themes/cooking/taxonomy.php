
<?php get_header(); ?>

<div class="container ">


<?php
echo get_the_archive_title();
echo get_the_archive_description();


$t=date('d-m-Y');
$month = date("M",strtotime($t));
$year = date("Y",strtotime($t));
?>


  <div class="cardTop">
    <div  class="cardsTitle">Recipes</div>
    <div class="sortedBY">
      <div class="containerSort">
          <label class="toSort1">Sort by :</label>
            <select name="sortBy" id="sortBy" class="toSort2" data-tax="<?php echo get_query_var('taxonomy'); ?>" data-term="<?php echo get_query_var('term'); ?>">
              <option selected=""  value="date">Date</option>
              <option   value="<?php echo'views_count_'.$month.'_'.$year ?>">Views</option>
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


  <div class="loadMoreButton" id="loadMoreButtonSort" data-page="1"  data-max="1">
    <div class="loadMoreButton--Container">
      <span class="icon--refresh icon"></span>
      <span class="loadMoreButton--text text" > Load More </span>
    </div>

  </div>
</div><!-- .container  -->


<?php get_footer(); ?>
