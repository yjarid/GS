<?php
get_header();


  ?>

<div class="container container--narrow">

  <section class="authorMain">

  <?php 
       $authID = get_query_var('author');
       $user = get_current_user_id();
       $t=date('d-m-Y');
       $year = date("Y",strtotime($t));
       $authName = get_the_author_meta( 'display_name', $authID  ); 

       //   add the chef to the list of chefs foolowed by logged in user 

       $followedChef = get_user_meta($user, 'followed_chef', true);
       $followedChef = (($followedChef) ? $followedChef : array());
       $index_followedChef = array_search($authID , $followedChef );

      

  ?>

    <div class="authorSummary">
      <div class="authorAvatar">
        <?php         
          
          echo get_avatar( $authID,  20 );
        ?>
      </div>

      <?php if($authID != $user ) {

        if($index_followedChef !== false ) { ?>

          <p class="btn following" id="auth-follow" data-auth=<?php echo $authID ?> data-user=<?php echo $user ?> > 
          unFollow <?php echo $authName; ?></p>

        <?php } else { ?>

          <p class="btn " id="auth-follow" data-auth=<?php echo $authID ?> data-user=<?php echo $user ?> > 
          +Follow <?php echo $authName; ?> </p>

        <?php } 

      } ?>




      

      <div class="authStat authorNbrPost">
        <?php 
        echo  '<strong>' . count_user_posts( $authID , "recipe"  ) . '</strong> Recipes'; 
        ?>  
      </div>

      <div class="authStat authorViews">
        <?php echo getUserViews($authID, 'user_count_'.$year )  ?>
      </div>

      <div class="authStat authorAvgRating">
        Average rating :
      </div>

      <div class="authStat authorReviews">
        Reviews : 
      </div>

    </div>

    <div class="authorAdditional">

      <div class="authorDesc">       
        <h2 class=authName><?php  echo $authName; ?></h2> 
        <div class="authDescText">
          <?php echo wp_trim_words(get_the_author_meta( 'description', $authID ), 100); ?>
        </div>
      </div>

      <div class="authorfollower">
        <span>
          <strong><em> Top Follower:</em></strong>  
        </span>    
      </div>

    </div>



  </section>

  


  <section class="listCards ">
    <div class="mainCardsContainer">
      <div class="cardTop">
        <h2 class="cardsTitle"><?php echo $authName ?>  's Popular Recipes</h2>
      </div>

    <div class="cardsContainer">
      <?php
     

        $args = array(
                        'post_status' => 'publish',
                        'author' => $authID ,
                        'post_type' => 'recipe',
                        'posts_per_page' => 5,
                        'meta_key' => 'views_count_'.$year,
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC'
                    );

                  $recipesByAuthor = new wp_Query($args);


                  while($recipesByAuthor->have_posts()) {
                      $recipesByAuthor->the_post() ;

                      get_template_part( 'content/recipeCard' );
              }
              wp_reset_postdata() ;
          ?>

    </div>

  </div>
  </section>

  
  <section class="listCards ">
    <div class="mainCardsContainer">
      <div class="cardTop">
        <h2 class="cardsTitle"><?php echo $authName ?> 's Recent Recipes</h2>
      </div>

    <div class="cardsContainer">
      <?php
      
        $args = array(
                        'post_status' => 'publish',
                        'author' => $authID ,
                        'post_type' => 'recipe',
                        'posts_per_page' => 5,

                    );

                  $recentByAuthor = new wp_Query($args);


                  while($recentByAuthor->have_posts()) {
                      $recentByAuthor->the_post() ;

                      get_template_part( 'content/recipeCard' );
              }
              wp_reset_postdata() ;
          ?>

    </div>

  </div>
  </section>

</div>



 <?php get_footer();