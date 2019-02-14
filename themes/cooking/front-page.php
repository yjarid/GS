
<?php session_start();
get_header();?>
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
    $t=date('d-m-Y');
    $month = date("M",strtotime($t));
    $year = date("Y",strtotime($t));

    $user_args = array(
            //'role__not_in' => 'Administrator',
            'number' => '6',
            'meta_key' => 'user_count_'.$year,
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );

        $PopularChefs = new WP_User_Query($user_args);

        foreach($PopularChefs->get_results() as $chef) {
          $id=  esc_attr( $chef->ID );
          $name = esc_html($chef->display_name);
          $img_url = esc_url( get_user_meta($id, 'picture', true)) ;
          $url =get_author_posts_url($id) ;
          $alt = 'hello';
          ?>

          <div class="categoryCard">
            <a href="<?php echo $url ?>" class="categoryCardLink">
                <div class="categoryImg">
                    <img src="<?php echo $img_url ?>" class="categoryCardImage" alt="<?php echo $alt; ?>">
                </div>
            </a>
            <div class="categoryCardTitle">
              <span class="categoryText"><?php echo $name;  ?></span>
              <span class="categoryViews"><?php echo getUserViews($id, 'user_count_'.$year )  ?> </span>
            </div>

          </div>
      <?php  }     ?>

</section>


<!-- most important subcategories -->

<section>
  <h2 class="cardsTitle">Famous cuisine</h2>
  <div class="categoryGrid">
    <?php

    $tax = array(
            'taxonomy' => 'cuisine',
            'number' => 6,
            'meta_key' => 'term_count_'.$month.'_'.$year,
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );

        $PopularCuisines = new WP_Term_Query($tax);

        foreach($PopularCuisines->terms as $term) {
          $slug = $term->slug;
          $id=  esc_attr( $term->term_id );
          $name = esc_html($term->name);
          $alt = esc_textarea( $term->description  );
          $img_url = esc_url( get_term_meta($id, 'GS_avatar', true)) ;
          $term_url = '/cuisine/'.$slug;
          ?>

          <div class="categoryCard">
            <div class="categoryImg">
              <a href="<?php echo site_url( $term_url )?>" class="categoryCardLink">
                      <img src="<?php echo $img_url ?>" class="categoryCardImage" alt="<?php echo $alt; ?>">
            </a>
            </div>

            <div class="categoryCardTitle">
              <span class="categoryText"><?php echo $name;  ?></span>
              <span class="categoryViews"><?php echo getTermViews($id, 'term_count_'.$year )  ?> </span>
            </div>
          </div>
      <?php  }     ?>

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

          $args = array(
                  'post_status' => 'publish',
                  'post_type' => 'recipe',
                  'posts_per_page' => 5,
                  'meta_key' => 'views_count_'.$month.'_'.$year,
                  'orderby' => 'meta_value_num',
                  'order' => 'DESC'
              );

            $mostViewed = new wp_Query($args);


            while($mostViewed->have_posts()) {
                $mostViewed->the_post() ;

                get_template_part( 'content/recipeCard' );

         }
// var_dump($mostViewed->query['meta_key']);
         ?>

        </div>
      </div>
    </section>



    <div class="loadMoreButton" id="loadMoreButton" data-page="1" data-key="
    <?php echo $mostViewed->query['meta_key'] ?>">
      <div class="loadMoreButton--Container">
        <span class="icon--refresh icon"></span>
        <span class="loadMoreButton--text text" > Load More </span>
      </div>

    </div>

</div> <!--wrapper-->

<?php get_footer(); ?>
