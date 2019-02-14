<?php
get_header();


  ?>

<div class="container container--narrow">



  <div class="cardsContainer">



  <?php while(have_posts()){
    the_post();


  get_template_part( 'content/recipeCard' );


 }

?>

</div>

</div>

 <?php get_footer();
