<?php
get_header(); ?>

<div class="container container--narrow">
  <div class="postNewRecipeTop">
  <h2 class="postNewRecipeTitle">Post New Recipe</h2>
  <p class="postNewRecipeDescription"> 
    Please fill out this form in order to post a new recipe. all the fields in this form are required and should be appropritely filled. once submitted the information will be reviewed by The Golden Spoon before posting.
  </p>
  </div>
  

<?php
while(have_posts()){
  the_post();

the_content();
} ?>

<div class="uploaded-image-container hidden" > 
  <div class="saved_image saved_image_0"><img src="" alt="" title="" /></div>
  <div class="saved_image saved_image_1"><img src="" alt="" title="" /></div>
  <div class="saved_image saved_image_2"><img src="" alt="" title="" /></div> 
  <div class="saved_image saved_image_3"><img src="" alt="" title="" /></div> 
</div>

</div>



<?php get_footer();
