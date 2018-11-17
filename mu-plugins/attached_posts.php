<?php
/*
 * Example setup for the custom Attached Posts field for CMB2.
 */

/**
 * Get the bootstrap! If using as a plugin, REMOVE THIS!
 */
require_once WPMU_PLUGIN_DIR . '/cmb2/init.php';
require_once WPMU_PLUGIN_DIR . '/cmb2-attached-posts/cmb2-attached-posts-field.php';

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb2_attached_posts_field_metaboxes_example() {

$prefix = 'GS_';

	$rel_event = new_cmb2_box( array(
		'id'           => $prefix .'attached_posts_field',
		'title'        => __( 'Attached Posts', 'yourtextdomain' ),
		'object_types' => array( 'post' ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => false, // Show field names on the left
	) );

	$rel_event->add_field( array(
		'name'    => __( 'Attached Posts', 'yourtextdomain' ),
		'desc'    => __( 'Drag posts from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'yourtextdomain' ),
		'id'      => $prefix . 'attached_posts',
		'type'    => 'custom_attached_posts',
		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => 10,
				'post_type'      => 'event',
			), // override the get_posts args
		),
	) );



	$rel_chef = new_cmb2_box( array(
		'id'           => $prefix .'related_chef_field',
		'title'        => __( 'Related Chef', 'yourtextdomain' ),
		'object_types' => array( 'recipe' ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => false, // Show field names on the left
	) );

	$rel_chef->add_field( array(
		'name'    => __( 'Related Chefs', 'yourtextdomain' ),
		'desc'    => __( 'Drag posts from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'yourtextdomain' ),
		'id'      => $prefix . 'related_chefs',
		'type'    => 'custom_attached_posts',
		'column'  => false, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => 10,
				'post_type'      => 'chef',
			), // override the get_posts args
		),
	) );


}
add_action( 'cmb2_init', 'cmb2_attached_posts_field_metaboxes_example' );
