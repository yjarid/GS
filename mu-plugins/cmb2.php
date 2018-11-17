<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function GS_register_demo_metabox() {
	$prefix = 'GS_';

	/**
	* CMB for Location Post Type
	**/

	$cmb_loc = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'location' ) // Post type
		// 'show_on_cb' => 'GS_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'GS_add_some_classes', // Add classes through a callback.
	) );

	$cmb_loc->add_field( array(
			'name'       => esc_html__( 'Location', 'cmb2' ),
			'desc' => 'Drag the marker to set the exact location',
			'id' => $prefix . 'location',
			'type' => 'pw_map',
		 	'split_values' => true, // Save latitude and longitude as two separate fields
		) );

		/**
		* CMB for Chefs Post Type
		**/

		$cmb_chef = new_cmb2_box( array(
			'id'            => $prefix . 'chef',
			'title'         => esc_html__( 'Chef Metabox', 'cmb2' ),
			'object_types'  => array( 'chef' ) // Post type
			// 'show_on_cb' => 'GS_show_if_front_page', // function should return a bool value
			// 'context'    => 'normal',
			// 'priority'   => 'high',
			// 'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
			// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
			// 'classes_cb' => 'GS_add_some_classes', // Add classes through a callback.
		) );


		$cmb_chef->add_field( array(
			'name' => esc_html__( 'oEmbed', 'cmb2' ),
			'desc' => sprintf(
				/* translators: %s: link to codex.wordpress.org/Embeds */
				esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'cmb2' ),
				'<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
			),
			'id'   => $prefix . 'embed',
			'type' => 'oembed',
		) );

		$cmb_chef->add_field( array(
	'name' => 'Test Date Picker (UNIX timestamp)',
	'id'   => 'wiki_test_textdate_timestamp',
	'type' => 'text_date_timestamp',
	// 'timezone_meta_key' => 'wiki_test_timezone',
	// 'date_format' => 'l jS \of F Y',
) );

$cmb_event = new_cmb2_box( array(
	'id'            => $prefix . 'event',
	'title'         => esc_html__( 'Event Metabox', 'cmb2' ),
	'object_types'  => array( 'event' ) // Post type
	// 'show_on_cb' => 'GS_show_if_front_page', // function should return a bool value
	// 'context'    => 'normal',
	// 'priority'   => 'high',
	// 'show_names' => true, // Show field names on the left
	// 'cmb_styles' => false, // false to disable the CMB stylesheet
	// 'closed'     => true, // true to keep the metabox closed by default
	// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
	// 'classes_cb' => 'GS_add_some_classes', // Add classes through a callback.
) );

$cmb_event->add_field( array(
'name' => 'Test Date Picker (UNIX timestamp)',
'id'   => 'wiki_test_textdate_timestamp',
'type' => 'text_date_timestamp',
// 'timezone_meta_key' => 'wiki_test_timezone',
// 'date_format' => 'l jS \of F Y',
) );


// Term Thumbnail

$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'term',
		'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'cuisine' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );
	$cmb_term->add_field( array(
		'name'     => esc_html__( 'Extra Info', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Term Image', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'avatar',
		'type' => 'file',
	) );



}


add_action( 'cmb2_admin_init', 'GS_register_demo_metabox' );
