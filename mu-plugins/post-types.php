<?php

function GS_post_type() {

  //CREATING CUSTOM POST TYP


  register_post_type('recipe', array(
    'map_meta_cap' => true,
    'supports' => array('title', 'editor', 'excerpt','thumbnail','author'),
    'has_archive' => true,
    'rewrite' => array('slug' => 'recipes'),
    'public' => true,
    'labels' => array( 'name' => 'Recipes' , 'add_new_item' => 'Add New Recipe', 'edit_item' => 'Edit Recipe',
                        'all_items' => 'All Events', 'singular_name' => 'Recipe'),
    'menu_icon' => 'dashicons-universal-access'
  ));

  // Event Post type

  register_post_type('event', array(
  'supports' => array('title', 'editor'),
  'rewrite' => array('slug' => 'events'),
  'has_archive' => true,
  'public' => true,
  'labels' => array(
    'name' => 'Events',
    'add_new_item' => 'Add New Event',
    'edit_item' => 'Edit Event',
    'all_items' => 'All Events',
    'singular_name' => 'Event'
  ),
  'menu_icon' => 'dashicons-calendar'
));

// Chef Post Type
register_post_type('chef', array(
  'show_in_rest' => true,
  'supports' => array('title', 'editor', 'thumbnail'),
  'public' => true,
  'labels' => array(
    'name' => 'Chefs',
    'add_new_item' => 'Add New Chef',
    'edit_item' => 'Edit Chef',
    'all_items' => 'All Chefs',
    'singular_name' => 'Chef'
  ),
  'menu_icon' => 'dashicons-welcome-learn-more'
));

register_post_type('location', array(
  'supports' => array('title', 'editor', 'excerpt'),
  'rewrite' => array('slug' => 'location'),
  'has_archive' => true,
  'public' => true,
  'labels' => array(
    'name' => 'Location',
    'add_new_item' => 'Add New Location',
    'edit_item' => 'Edit Location',
    'all_items' => 'All Location',
    'singular_name' => 'Location'
  ),
  'menu_icon' => 'dashicons-location-alt'
));


}
add_action('init', 'GS_post_type');



// create two taxonomies, genres and writers for the post type "book"
function GS_recipe_taxonomies() {

	// Add Cuisine taxonomy, make it hierarchical (like categories)

	$labels = array(
		'name'              => _x( 'Cuisines', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Cuisine', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Cuisines', 'textdomain' ),
		'all_items'         => __( 'All Cuisines', 'textdomain' ),
		'parent_item'       => __( 'Parent Cuisine', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Cuisine:', 'textdomain' ),
		'edit_item'         => __( 'Edit Cuisine', 'textdomain' ),
		'update_item'       => __( 'Update Cuisine', 'textdomain' ),
		'add_new_item'      => __( 'Add New Cuisine', 'textdomain' ),
		'new_item_name'     => __( 'New Cuisine Name', 'textdomain' ),
		'menu_name'         => __( 'Cuisine', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'cuisine' ),
	);

	register_taxonomy( 'cuisine', array( 'recipe' ), $args );

  // Add Type taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => _x( 'Meals', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'Meal', 'taxonomy singular name', 'textdomain' ),
    'search_items'      => __( 'Search Meals', 'textdomain' ),
    'all_items'         => __( 'All Meals', 'textdomain' ),
    'parent_item'       => __( 'Parent Meal', 'textdomain' ),
    'parent_item_colon' => __( 'Parent Meal:', 'textdomain' ),
    'edit_item'         => __( 'Edit Meal', 'textdomain' ),
    'update_item'       => __( 'Update Meal', 'textdomain' ),
    'add_new_item'      => __( 'Add New Meal', 'textdomain' ),
    'new_item_name'     => __( 'New Meal Name', 'textdomain' ),
    'menu_name'         => __( 'Meal', 'textdomain' ),
  );

  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'meal' ),
  );

  register_taxonomy( 'meal', array( 'recipe' ), $args );

  // Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Ingredient', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Ingredient', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Ingredients', 'textdomain' ),
		'popular_items'              => __( 'Popular Ingredients', 'textdomain' ),
		'all_items'                  => __( 'All Ingredients', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Ingredient', 'textdomain' ),
		'update_item'                => __( 'Update Ingredient', 'textdomain' ),
		'add_new_item'               => __( 'Add New Ingredient', 'textdomain' ),
		'new_item_name'              => __( 'New Ingredient Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate ingredients with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove ingredients', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used ingredients', 'textdomain' ),
		'not_found'                  => __( 'No ingredients found.', 'textdomain' ),
		'menu_name'                  => __( 'Ingredient', 'textdomain' ),

	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,

		'rewrite'               => array( 'slug' => 'ingredient' ),
	);

	register_taxonomy( 'ingredient', 'recipe', $args );


}

add_action( 'init', 'GS_recipe_taxonomies');
