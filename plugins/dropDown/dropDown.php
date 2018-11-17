<?php
/**
 * Plugin Name: Drop Down
 * Plugin URI: http://danielpataki.com
 * Description: This is a plugin that allows us to test Ajax functionality in WordPress
 * Version: 1.0.0
 * Author: Daniel Pataki
 * Author URI: http://danielpataki.com
 * License: GPL2
 */



/**
* Populate the submenue Filter
*/



  add_action( 'wp_ajax_nopriv_getTermChild', 'yj_getTerm_child' );
  add_action( 'wp_ajax_getTermChild', 'yj_getTerm_child' );

  function yj_getTerm_child() {


    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
      $cuisine_id = $_POST['cuisine_id'];
      $taxonomy_name = 'cuisine';
    $term_children = get_term_children( $cuisine_id, $taxonomy_name );


    echo '<option value="all">All</option>' ;

    foreach ($term_children as $subTerm) {
      $child = get_term_by('id', $subTerm, 'cuisine');

    echo  '<option value="'.  $child->term_id . '">' . $child->name . '</option><br>';

  }

}
  	die();
  }


  /**
  * Handeling the loadMore Button
  */


  add_action('wp_ajax_loadmorebutton', 'youssef_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmorebutton', 'youssef_loadmore_ajax_handler');

function youssef_loadmore_ajax_handler(){

   $paged = $_POST['page'];


  $args = array(
            'post_status' => 'publish',
            'post_type' => 'recipe',
            'posts_per_page' => 5,
            'paged' =>$paged,
            'meta_key' => $_POST['metaKey'],
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
  );



	// it is always better to use WP_Query but not here
	 $load = new WP_Query( $args );

	if( $load->have_posts() ) {
    // run the loop
    while($load->have_posts()) {
        $load->the_post() ;

        get_template_part( 'content/recipeCard' );

      }
    }

  wp_reset_postdata();

	die(); // here we exit the script and even no wp_reset_query() required!
}


  /**
  * Handeling the submenue Filter data
  */

  add_action('wp_ajax_myfilter', 'youssef_filter_function');
  add_action('wp_ajax_nopriv_myfilter', 'youssef_filter_function');


  function youssef_filter_function(){

	$args = array(  'post_type' => 'recipe',
                  'orderby' => 'date',
                  'posts_per_page' => 1 // we will sort posts by date
			);

	// for taxonomies / categories
	if( isset( $_POST['caregory'] ) AND $_POST['caregory'] != 'all' ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'cuisine',
        'field' => 'id',
        'terms' => $_POST['caregory']
      )
    );
  }
    else if( isset( $_POST['cuisine'] ) ) {
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'cuisine',
          'field' => 'id',
          'terms' => $_POST['cuisine']
        )
      );
  }


    $filter = new WP_Query( $args );


    	if( $filter->have_posts() ) :

     		ob_start(); // start buffering because we do not need to print the posts now

    		while( $filter->have_posts() ): $filter->the_post(); ?>

        <div class="contentCardContainer">
          <div class="cardImage">
            <a href="<?php  the_permalink();?>" class="categoryCardLink">
                  <?php the_post_thumbnail( 'thumbnail' ); ?>
          </a>

          </div>
          <div class="">
            <span class="categoryText"><?php the_title(); ?></span>
            <p><?php the_content(); ?></p>
            <?php
            the_terms( $post->ID, 'mood', 'Mood: ', ', ', ' ' );
            ?>
          </div>
        </div>

    		<?php endwhile;

     		$posts_html = ob_get_contents(); // we pass the posts to variable
       		ob_end_clean(); // clear the buffer
    	else:
    		$posts_html = '<p>Nothing found for your criteria.</p>';
    	endif;

      wp_reset_postdata();

     	echo json_encode( array(
    		'posts' => json_encode( $filter->query_vars ),
    		'max_page' => $filter->max_num_pages,
    		'found_posts' => $filter->found_posts,
    		'content' => $posts_html
    	) );

    	die();

}
