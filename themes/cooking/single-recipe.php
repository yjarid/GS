<?php get_header();

while(have_posts()) {
    the_post() ;

      setPostViews(get_the_id()); // to track the views

      echo get_the_author_meta('ID');

     ?>

    <section class="recipeTop">
      <div class="recipeTitle">
        <h1><?php the_title(); ?></h1>
      </div>
      <div class="recipeTopcontainer">
        <div class="recipeMedia">
          <div class="recipeMainImage">
            <img src="./incl/img/IMG2-m.jpg" alt="">
          </div>
          <div class="recipeImage">
            <?php
             // cmb2_output_file_list( 'GS_file_list', 'small' );
             ?>
        </div>
      </div>

          <div class="recipeInfo">
            <div class="recipeInfo-section">
              <h2>Recipe by</h2>
              <h3><?php the_author(); ?> </h3>
              <p>Prepared on: <?php the_time('M y') ?></p>
            </div>
            <div class="recipeInfo-section">
              <p>Rating: 9</p>
              <p>Reviews: 40</p>
              <div class="recipeDesc">
                <h4>Description:</h4>
                <p> <?php the_excerpt(); ?></p>
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
            <?php echo get_post_meta( get_the_ID(), 'GS_wysiwyg', true )  ?>
          </div>
      </div>

      <div class="recipeDirection">
          <h2>Preparation</h2>

        <div class="directionDetail">
          <?php the_content(); ?>
        </div>
      </div>

      <div class="similarRecipe">
        <h3>Similar Recipes</h3>
      </div>









    </section>



  </div>
<?php }

 $test = get_post_meta( get_the_ID(), '_wp_attachment_metadata', true ) ;
print_r($test)	;

get_footer()?>
