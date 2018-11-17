<?php
/**
 * @link http://webdevstudios.com/2015/03/30/use-cmb2-to-create-a-new-post-submission-form/ Original tutorial
 */
/**
 * Register the form and fields for our front-end submission form
 */

function YJ_frontend_profile_register() {

	$user = wp_get_current_user();

	$cmb = new_cmb2_box( array(
		'id'           => 'front-end-profile',
		'object_types' => array( 'user' ),
		'hookup'       => false,
		'save_fields'  => false,
	) );
	$cmb->add_field( array(
		'name'    => __( 'Display Name', 'YOURTEXTDOMAIN' ),
		'id'      => 'submitted_name',
		'type'    => 'text',
		'default' => esc_attr($user->display_name) ?:__( 'Enter your name', 'YOURTEXTDOMAIN' )

	) );



	$cmb->add_field( array(
		'name'       => __( 'Your Email', 'YOURTEXTDOMAIN' ),
		'desc'       => __( 'Please enter your email so we can contact you if we use your post.', 'YOURTEXTDOMAIN' ),
		'id'         => 'submitted_author_email',
		'type'       => 'text_email',
		'default' => esc_attr($user->user_email) ?:__( 'Enter your name', 'YOURTEXTDOMAIN' )
	) );

	$cmb->add_field( array(
		'name'       => __( 'Profile Image', 'YOURTEXTDOMAIN' ),
		'id'         => 'button_profile_image',
		'type'       => 'text',
		'attributes' => array(
			'type' => 'button', // Let's use a standard file upload field
			'value' => 'Upload your Picture'

	)));

	$cmb->add_field( array(
	'id'   => 'submitted_profile_image',
	'type' => 'hidden',
	'default' => esc_url( get_user_meta( get_current_user_id(), 'picture', true ) ) ?:__( '', 'YOURTEXTDOMAIN' )
) );
}
add_action( 'cmb2_init', 'YJ_frontend_profile_register' );

/**
 * Gets the front-end-profile cmb instance
 *
 * @return CMB2 object
 */
function YJ_frontend_cmb2_profile_get() {
	// Use ID of metabox in YJ_frontend_profile_register
	$metabox_id = 'front-end-profile';
	// Post/object ID is not applicable since we're using this form for submission
	$object_id  = 'fake-oject-id';
	// Get CMB2 metabox object
	return cmb2_get_metabox( $metabox_id, $object_id );
}
/**
 * Handle the cmb_frontend_profile shortcode
 *
 * @param  array  $atts Array of shortcode attributes
 * @return string       Form html
 */
function YJ_do_frontend_Profile_submission_shortcode( $atts = array() ) {
	// Get CMB2 metabox object
	$cmb = YJ_frontend_cmb2_profile_get();
	// Get $cmb object_types
	$post_types = $cmb->prop( 'object_types' );
	// Current user
	$user_id = get_current_user_id();
	// Parse attributes
	$atts = shortcode_atts( array(
		'post_author' => $user_id ? $user_id : 1, // Current user, or admin
		'post_type'   => reset( $post_types ), // Only use first object_type in array
	), $atts, 'cmb_frontend_profile' );
	/*
	 * Let's add these attributes as hidden fields to our cmb form
	 * so that they will be passed through to our form submission
	 */
	foreach ( $atts as $key => $value ) {
		$cmb->add_hidden_field( array(
			'field_args'  => array(
				'id'    => "atts[$key]",
				'type'  => 'hidden',
				'default' => $value,
			),
		) );
	}
	// Initiate our output variable
	$output = '';
	// Get any submission errors
	if ( ( $error = $cmb->prop( 'submission_error' ) ) && is_wp_error( $error ) ) {
		// If there was an error with the submission, add it to our ouput.
		$output .= '<h3>' . sprintf( __( 'There was an error in the submission: %s', 'YOURTEXTDOMAIN' ), '<strong>'. $error->get_error_message() .'</strong>' ) . '</h3>';
	}
	// If the post was submitted successfully, notify the user.
	if ( isset( $_GET['profile_updated'] ) && ( 'success' == $_GET['profile_updated'] ) ) {

		// Add notice of submission to our output
		$output .= '<h3>' .  __( 'Thank you , your profile has been updated .', 'YOURTEXTDOMAIN' ) . '</h3>';
	}

	// Get our form
	$output .= cmb2_get_metabox_form( $cmb, 'fake-oject-id', array( 'save_button' => __( 'Submit Post', 'YOURTEXTDOMAIN' ) ) );
	return $output;
}
add_shortcode( 'cmb_frontend_profile', 'YJ_do_frontend_Profile_submission_shortcode' );
/**
 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
 *
 * @return void
 */
function YJ_handle_frontend_new_post_form_submission() {

	// If no form submission, bail
	if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
		return false;
	}
	// Get CMB2 metabox object
	$cmb = YJ_frontend_cmb2_profile_get();
	$post_data = array();

		// Get our shortcode attributes and set them as our initial post_data args
	if ( isset( $_POST['atts'] ) ) {
		foreach ( (array) $_POST['atts'] as $key => $value ) {
			$post_data[ $key ] = sanitize_text_field( $value );
		}
		unset( $_POST['atts'] );
	}
	// Check security nonce
	if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
	}
	// Check email submitted
	if ( empty( $_POST['submitted_author_email'] ) ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'New post requires an Email.' ) ) );
	}

	/*// And that the title is not the default title
	if ( $cmb->get_field( 'submitted_post_title' )->default() == $_POST['submitted_post_title'] ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'Please enter a new title.' ) ) );
	}*/
	/**
	 * Fetch sanitized values
	 */
	$sanitized_values = $cmb->get_sanitized_values( $_POST );
	// Set our post data arguments

	wp_update_user( array(
		'ID'=>get_current_user_id(),
		'display_name' => $sanitized_values['submitted_name'],
		'user_email' => $sanitized_values['submitted_author_email']
	)
 );

	// $post_data['display_name']   = $sanitized_values['submitted_name'];
	unset( $sanitized_values['submitted_name'] );
	// $post_data['user_email'] = $sanitized_values['submitted_author_email'];

	unset( $sanitized_values['submitted_author_email'] );




	$post_data['picture'] = $sanitized_values['submitted_profile_image'];
	unset( $sanitized_values['submitted_profile_image'] );
	// Create the new post
	foreach ( $post_data as $key => $value ) {
		update_user_meta( get_current_user_id(), $key, $value );
	}

	// // If we hit a snag, update the user
	// if ( is_wp_error( $new_submission_id ) ) {
	// 	return $cmb->prop( 'submission_error', $new_submission_id );
	// }
	//$cmb->save_fields( $new_submission_id, 'post', $sanitized_values );
	/**
	 * Other than post_type and post_status, we want
	 * our uploaded attachment post to have the same post-data
	 */
	//unset( $post_data['post_type'] );
	//unset( $post_data['post_status'] );
	// Try to upload the featured image
	// $img_id = YJ_frontend_form_photo_upload( $new_submission_id, $post_data );
	// // If our photo upload was successful, set the featured image
	//
	//
	// if ( $img_id && ! is_wp_error( $img_id ) ) {
	// 	set_post_thumbnail( $new_submission_id, $img_id );
	// }
	/*
	 * Redirect back to the form page with a query variable with the new post ID.
	 * This will help double-submissions with browser refreshes
	 */
	  wp_redirect( esc_url_raw( add_query_arg( 'profile_updated', 'success' ) ) );
	 exit;
}
add_action( 'cmb2_after_init', 'YJ_handle_frontend_new_post_form_submission' );
/**
 * Handles uploading a file to a WordPress post
 *
 * @param  int   $post_id              Post ID to upload the photo to
 * @param  array $attachment_post_data Attachement post-data array
 */
// function YJ_frontend_form_photo_upload( $post_id, $attachment_post_data = array() ) {
// 	// Make sure the right files were submitted
// 	if (
// 		empty( $_FILES )
// 		|| ! isset( $_FILES['submitted_profile_image'] )
// 		|| isset( $_FILES['submitted_profile_image']['error'] ) && 0 !== $_FILES['submitted_profile_image']['error']
// 	) {
// 		return;
// 	}
// 	// Filter out empty array values
// 	$files = array_filter( $_FILES['submitted_profile_image'] );
//
//
// 	// Make sure files were submitted at all
// 	if ( empty( $files ) ) {
// 		return;
// 	}
// 	// Make sure to include the WordPress media uploader API if it's not (front-end)
// 	if ( ! function_exists( 'media_handle_upload' ) ) {
// 		require_once( ABSPATH . 'wp-admin/includes/image.php' );
// 		require_once( ABSPATH . 'wp-admin/includes/file.php' );
// 		require_once( ABSPATH . 'wp-admin/includes/media.php' );
// 	}
// 	// Upload the file and send back the attachment post ID
// 	return media_handle_upload( 'submitted_profile_image', $post_id, $attachment_post_data );
// }
