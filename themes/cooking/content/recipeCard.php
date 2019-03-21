<?php
use \GS\Data\ViewsData;
?>

 <div class="contentCardContainer">

    <a href="<?php the_permalink() ?>">
    <div class="cardImage">
      <?php the_post_thumbnail( 'medium') ?>
    </div>
    <div class="">
      <span class="cardTitle"><?php the_title( ) ; ?> </span>
      <span class="cardViews">
        <?php
        echo ViewsData::getPostViews(get_the_id(), 'Year') . ' Views' ;
        ?>
      </span>
      <div class="cardDescription">
        <?php
          if(has_excerpt( get_the_id() )) {
            the_excerpt();
          } else {
            echo wp_trim_words(get_the_content(), 25);
          }

        ?>
      </div>
    </div>
    </a>
      <div class="cardTags">
        <div class="mealType">
          <?php  the_terms( $post->ID, 'meal', 'Meal : ', ', ', ' ' ); ?>
        </div>
        <div class="Ingredient">
          <?php the_terms( $post->ID, 'ingredient', 'Ingredients : ', ', ', ' ' );  ?>
        </div>

      </div>


  </div>
