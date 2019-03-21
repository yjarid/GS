<?php get_header();

use GS\Data\ViewsData;
use GS\Data\PostData;
use GS\Data\UserData;
use GS\DisplayFunc;

$id = get_the_id();
$rating = PostData::getPostRating($id);
$postMeta = PostData::getPostMeta( $id) ;
$data = ViewsData::setPostViews($id); // to track the views

while(have_posts()) {
    the_post() ;
?>


 <div class="container" >

 <section class="recipeTop"  id="IPData" data-status="<?php echo $data['status']?>" >

<div class="recipeTitle">
  <h1><?php the_title(); ?></h1>
</div>

<div class="recipeTopcontainer">

<div class="recipeMainImg">
  <a  href="<?php the_post_thumbnail_url( 'large'); ?>""  data-lightbox="recipe">
      <?php the_post_thumbnail('large'); ?>
  </a>

  <div class="loveitMadeit-section">
    <?php 
    $userIsLovedRecipe =  UserData::isLovedRecipe($id , $user_ID , 'love') ;
    $loveCount = PostData::getLove($id , 'love');
    ?>

    <span class="loveMadecont" >
        <button class="loveMade-btn-cont <?php echo ($userIsLovedRecipe !== false ? 'active' : '');?> " id="loveit-button" 
          data-postid="<?php echo $id ?>" data-user="<?php echo $user_ID; ?>"  data-count="<?php echo $loveCount ?>">
          <span class="text">Love it</span>
          <span class="loveMade-btn-cont-count"><?php echo $loveCount ?></span> 
          <span class="icon-cont"><span class="icon--love-<?php echo ($userIsLovedRecipe !== false ? 'full' : 'empty'); ?> icon"> </span>  </span>
        </button>
      </span>

    <?php 
    $userIsMadeRecipe =  UserData::isLovedRecipe($id , $user_ID , 'made') ;
    $madeCount = PostData::getLove($id , 'made');
    ?>

    <span class="loveMadecont"  >
      <button class="loveMade-btn-cont <?php echo ($userIsMadeRecipe !== false ? 'active' : '') ?>" id="madeit-button" 
        data-postid="<?php echo $id ?>" data-user="<?php echo $user_ID; ?>"  data-count="<?php echo $madeCount ?>">
        <span class="text">Made it</span>
        <span class="loveMade-btn-cont-count"><?php echo $madeCount ?></span> 
         <span class="icon-cont"><span class="icon--made-<?php echo ($userIsMadeRecipe !== false ? 'full' : 'empty'); ?> icon"> </span>  </span>
      </button>
    </span>

  </div>
    
 

</div>

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

      <p class="average-rating">Rating: <?php echo    DisplayFunc::display_stars($rating['avg'])   ?></p>
      <p>Reviews: <?php echo $rating['nbr']; ?></p>
      <p>Love: <?php echo $loveCount; ?></p>
      <p>Made it: <?php echo $madeCount; ?></p>

      <div class="recipeDesc">
        <h4>Description:</h4>
        <p> <?php echo html_entity_decode($postMeta['post_desc']); ?></p>
      </div>

    </div>

  

      <p class="recipeVideo">watch video</p>

    
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
  

  <?php if($rating['nbr']){  ?>
    <div class="comments-indicator">
    <h4> <?php echo $rating['nbr'] . ' Reviews => ' . 'Average Rating:  ' . $rating['avg'] ?></h4>
    <p><?php echo  DisplayFunc::display_stars($rating['avg']) ; ?></p>
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
