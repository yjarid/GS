
<?php session_start();
get_header();

use GS\Data\ViewsData;
use GS\Data\PostData;
use GS\DisplayFunc;

?>
<div class="wrapper">
  <section>
      <h2 class="cardsTitle">What's Trending!!</h2>
      <div class="hero-slider">
        <article class="slider__slide">
            <a href="#" >
                <div class="slider__text">
                    <h3>Tasty Ways To Cook Fish</h3>
                    <p class="slider__description">Browse more than 2,000 ways to fix fish, from quick baked fillets and salmon cakes to fish tacos and tuna casserole.</p>
                </div>
                <img alt="Hudson's Baked Tilapia with Dill Sauce"   class="slider__photo" src="<?php echo get_theme_file_uri('/incl/img/IMG2-s.jpg') ?>">
            </a>
        </article>
        <article class="slider__slide">
            <a  href="#">
                <div class="slider__text">
                    <h3>Peruvian Roast Chicken</h3>
                    <p class="slider__description">Make an incredibly juicy roast chicken with a super-flavorful crispy crust.</p>
                </div>
                <img alt="Peruvian Style Beer Can Chicken"  class="slider__photo" src="<?php echo get_theme_file_uri('/incl/img/IMG1-s.png') ?>">
            </a>
        </article>
        <article class="slider__slide">
            <a href="#">
                <div class="slider__text">
                    <h3>Top Boozy Desserts For St. Patrick's Day</h3>
                    <p class="slider__description">These top-rated recipes are all enhanced with Irish cream, Guinness®, or whiskey.</p>
                </div>
                <img alt="Irish Cream Chocolate Cheesecake"  class="slider__photo " src="<?php echo get_theme_file_uri('/incl/img/IMG3-s.jpg') ?>">
            </a>
        </article>
        <article class="slider__slide">
            <a href="#">
                <div class="slider__text">
                    <h3>Corned Beef and Cabbage Recipes</h3>
                    <p class="slider__description">We look forward to this Irish-American favorite all year! Find a new favorite recipe.</p>
                </div>
                <img alt="Stout Slow Cooker Corned Beef and Veggies"  class="slider__photo " src="<?php echo get_theme_file_uri('/incl/img/IMG4-s.jpg') ?>">
            </a>
        </article>
        <article class="slider__slide">
            <a href="#">
                <div class="slider__text">
                    <h3>Irish Cheddar-Spring Onion Biscuits</h3>
                    <p class="slider__description">See how to make these flaky and cheesy biscuits—the perfect accompaniment to Irish stew.</p>
                </div>
                <img alt="Irish Cheddar Spring Onion Biscuits"  class="slider__photo" src="<?php echo get_theme_file_uri('/incl/img/IMG1-s.png') ?>">
            </a>
        </article>
      </div>

</section>

<!-- most important Chefs -->
<section>
  <h2 class="cardsTitle">Famous Chefs</h2>
  <div class="categoryGrid">
    <?php
    $date = DisplayFunc::getDate();

  // to get the paged number based on the number of the day in the month
    $paged = DisplayFunc::getPaged($date['J']);

  // display the users based on GS rating diff and by day of the month
    DisplayFunc::displayUser(1 , 'GSRating_diff' ,'chefCard',  [], $paged );
    
  ?>

</section>


<!-- most important subcategories -->

<section>
  <h2 class="cardsTitle">Famous cuisine</h2>
  <div class="categoryGrid">
    <?php

    $tax = array(
            'taxonomy' => 'cuisine',
            'number' => 6,
            'meta_key' => 'term_views_'.$date['Y'],
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );

        $PopularCuisines = new WP_Term_Query($tax);
  
        foreach($PopularCuisines->terms as $term) {
          $data =[];
          $data['slug'] = $term->slug;
          $data['id']=  esc_attr( $term->term_id );
          $data['name'] = esc_html($term->name);
          $data['alt'] = esc_textarea( $term->description  );
          $data['img_url'] = esc_url( get_term_meta($data['id'], 'GS_avatar', true)) ;
          $data['term_url'] = '/cuisine/'.$data['slug'];
        
          set_query_var( 'data', $data );
          get_template_part( 'content/termCard' );

       }     ?>

</section>


  <!-- CARDS -->

  <!-- Best Recipes -->

    <section class="listCards ">
      <div class="mainCardsContainer">
        <div class="cardTop">
          <h2 class="cardsTitle">Popular this Month</h2>
          <a class="cardsLink" href="<?php echo site_url('/recipes')?>">All Categories</a>
        </div>
        <div class="cardsContainer">
        <?php


            $mostViewed = PostData::getPost(1, 'post_views_'.$date['M'].'_'.$date['Y'] ) ;


            while($mostViewed->have_posts()) {
                $mostViewed->the_post() ;

                get_template_part( 'content/recipeCard' );

         }

         ?>

        </div>
      </div>
    </section>



    <div class="loadMoreButton" id="loadMoreButton" data-page="1" data-key="
    <?php echo $mostViewed->query['meta_key'] ?>" data-max="<?php echo $mostViewed->max_num_pages ?>">
      <div class="loadMoreButton--Container">
        <span class="icon--refresh icon"></span>
        <span class="loadMoreButton--text text" > Load More </span>
      </div>

    </div>

</div> <!--wrapper-->

<?php get_footer(); ?>
