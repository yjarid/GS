
 <div class="contentCardContainer">

    <a href="<?php the_permalink() ?>">
    <div class="cardImage">
      <?php the_post_thumbnail( 'medium') ?>
    </div>
    <div class="">
      <span class="cardTitle"><?php the_title( ) ; ?> </span>
      <span class="cardViews">
        <?php
        $t=date('d-m-Y');
        $month = date("M",strtotime($t));
        $year = date("Y",strtotime($t));
        echo getPostViews(get_the_id(), 'views_count_'.$year)
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
