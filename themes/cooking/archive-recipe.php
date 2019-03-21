<?php
get_header();


  ?>

<div class="container ">

    <h1>Enjoy our ectended</h1>

      <form  action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="post" id="filter" style="padding : 1rem">
          <label>Select Meal:</label>
            <select name="meal" id="meal" >
              <option selected=""  value="">All</option>
              <?php
              $meals = get_terms( array( 'taxonomy' => 'meal',    'hide_empty' => true  ) );
              foreach ($meals as $meal) {?>
                <option value="<?php echo $meal->term_id ?>"><?php echo $meal->name ?></option>
              <?php  } ?>

            </select>

          <label>Select Ingredient:</label>
            <select name="ingredient" id="ingredient" >
              <option selected=""  value="">All</option>
              <?php
              $terms = get_terms( array( 'taxonomy' => 'ingredient',  'hide_empty' => true  ) );
              foreach ($terms as $term) {?>
                <option value="<?php echo $term->term_id ?>"><?php echo $term->name ?></option>
              <?php  } ?>

            </select>


          <button type="submit" name="">Filter</button>
          <input type="hidden" name="action" value="filter">
          <input type="hidden" name="nonce_filter" value="<?php wp_create_nonce( 'filterNonce' ); ?>">

      </form>
  <div id="cardsContainer--withSpinner">
    <div class="cardsContainer" id="recipeCards">

    <?php while(have_posts()) { the_post();
      get_template_part( 'content/recipeCard' );
      }    ?>

    </div>
  </div>

<div class="loadMoreButton" id="loadMoreButtonFilter" data-page="1"  data-max="<?php echo $wp_query->max_num_pages;?>">
  <div class="loadMoreButton--Container">
    <span class="icon--refresh icon"></span>
    <span class="loadMoreButton--text text" > Load More </span>
  </div>

</div>


</div>

 <?php get_footer();
