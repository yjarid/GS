<?php get_header();

$id = get_the_id();
$rating = get_post_meta($id, 'rating', true);

$comment_nbr = ($rating) ? $rating[0] : 0;
$rating_avg = ($rating) ? $rating[2] : 0;
$postMeta = get_post_meta( $id , 'post_meta', true ) ;

while(have_posts()) {
    the_post() ;
    

      setPostViews($id); // to track the views

      

?>
 <div class="container">

 <section class="recipeTop">

<div class="recipeTitle">
  <h1><?php the_title(); ?></h1>
</div>

<div class="recipeTopcontainer">

  <a class="recipeMainImg" href="<?php the_post_thumbnail_url( 'large'); ?>""  data-lightbox="recipe">
    <?php the_post_thumbnail('large'); ?>
</a>

  <div class="recipeMedia">

  <?php  $attachements = get_attached_media( 'image', $id ) ;  
   
  ?>

    <?php 

      foreach( $attachements as $attach) {  
        if($attach->ID != get_post_thumbnail_id( $id)) {
        ?>  

      
      <a href="<?php echo wp_get_attachment_image_src($attach->ID, 'large')[0]  ?>" class="recipeImg" id="recipeImage" data-lightbox="recipe" > <?php echo wp_get_attachment_image($attach->ID, 'thumbnail') ?></a>
       
        <?php }
      
    } 
?>

  </div>
 

  <div class="recipeInfo">

    <div class="recipeInfo-section">
      <h3>Recipe by <?php the_author(); ?></h3>
      <p>Prepared on: <?php the_time('M y') ?></p>
    </div>

    <div class="recipeInfo-section">

      <p class="average-rating">Rating: <?php echo    yj_display_comment_stars($rating_avg)   ?></p>
      <p>Reviews: <?php echo $comment_nbr; ?></p>
      <p>Favorited: <?php echo $comment_nbr; ?></p>
      <p>Made it: <?php echo $comment_nbr; ?></p>

      <div class="recipeDesc">
        <h4>Description:</h4>
        <p> <?php echo html_entity_decode($postMeta['post_desc']); ?></p>
      </div>

    </div>

    <div class="recipeInfo-section">

      <div class="recipeRate">
        <span> Rate IT </span>
      </div>

      <div class="recipeMade">
        <span> Made IT </span>
      </div>

      <p class="recipeVideo">watch video</p>

    </div>
  </div>
</div>
</section>

<section class="recipeMain">

  <div class="recipeIngredient">
        <h2>Ingredient</h2>

      <div class="IngredientDetail">
        <?php echo html_entity_decode($postMeta['post_ingredient']); ?>
      </div>
  </div>

  <div class="recipeDirection">
      <h2>Preparation</h2>

    <div class="directionDetail">
      <?php echo html_entity_decode(get_the_content()); ?>
    </div>
  </div>

 

</section>

<section class="">
  <div class="similarRecipe">
    <h3>Similar Recipes</h3>
  </div>
</section>

<div class="container container--narrow">
  <section class="recipeComment">

  <h2 class="cardsTitle"> Comments</h2>
  

  <?php if($comment_nbr){?>
    <div class="comments-indicator">
    <h4> <?php echo $comment_nbr . ' Reviews => ' . 'Average Rating:  ' . $rating_avg ?></h4>
    <p><?php echo  yj_display_comment_stars($rating_avg) ?></p>
    </div>
    

 <?php } ?>

    

    <?php 
    //  if(comments_open()) { 
    comments_template();

    // } 
    ?>

  </section>
</div>






</div>

 </div>
  
<?php }


get_footer()

?>
