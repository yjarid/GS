<?php
get_header();

use  \GS\Data\UserData;
use  \GS\Data\ViewsData;
use   GS\DisplayFunc;


$chef = get_query_var('author');
$user = get_current_user_id();
$date = DisplayFunc::getDate();
$authName = get_the_author_meta( 'display_name', $chef  ); 

// chef rating 
$data = UserData::getChefRating($chef, 'Month');

// get following Users
$followingUsers = UserData::getFollowingUsers($chef);
?>

<div class="container container--narrow">

  <section class="authorMain">
    <div class="authorSummary">
      <div class="authorAvatar">
        <?php          
          echo get_avatar( $chef,  20 );
        ?>
      </div>

      <?php if($chef != $user ) {
        // check if the chef is followed by the user
        $index_followedChef = UserData::isFollowedChef($chef, $user);

        if($index_followedChef !== false ) { ?>

          <p class="btn following" id="auth-follow" data-auth=<?php echo $chef ?> data-user=<?php echo $user ?> data-follow='yes'> 
          unFollow <?php echo $authName; ?></p>

        <?php } else { ?>

          <p class="btn " id="auth-follow" data-auth=<?php echo $chef ?> data-user=<?php echo $user ?>  data-follow='no'> 
          +Follow <?php echo $authName; ?> </p>

        <?php } 

      } ?>

      <div class="authStat authorNbrPost">
        <?php 
        echo  '<strong>' . count_user_posts( $chef , "recipe"  ) . '</strong> Recipes'; 
        ?>  
      </div>

      <div class="authStat authorViews">
        <?php echo ViewsData::getUserViews($chef)  ?>
      </div>

      <div class="authStat authorAvgRating">
        <strong> Rating : <?php echo ' '.$data['avg']  . ' </strong>( ' . $data['nbr'] . ' reviews)'?> 
      </div>

      <div class="authStat authorReviews">
        Followers : <?php echo ' '. sizeof($followingUsers) ?>
      </div>

      <div class="authStat authorGSGrade">
        GS Grade : <?php  ?>
      </div>

    </div>

    <div class="authorAdditional">

      <div class="authorDesc">       
        <h2 class=authName><?php  echo $authName; ?></h2> 
        <div class="authDescText">
          <?php echo wp_trim_words(get_the_author_meta( 'description', $chef ), 100); ?>
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
                        'author' => $chef ,
                        'post_type' => 'recipe',
                        'posts_per_page' => 5,
                        'meta_key' => 'views_count_'.$date['Y'],
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
                        'author' => $chef ,
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