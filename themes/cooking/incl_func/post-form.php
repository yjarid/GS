<?php

function yj_frontend_form_postRecipe() {
	$cmb = new_cmb2_box( array(
		'id'           => 'front-end-post-form',
		'object_types' => array( 'recipe' ),
		'hookup'       => false,
		'save_fields'  => false,
	) );
	$cmb->add_field( array(
		'default_cb' => 'yj_maybe_set_default_from_posted_values',
		'name'    => __( 'Recipe Title', 'GS' ),
		'id'      => 'new_recipe_title',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'default_cb' => 'yj_maybe_set_default_from_posted_values',
		'name'       => __( 'Recipe Description', 'GS' ),
		'id'         => 'new_recipe_description',
		'type'       => 'textarea_small',
		'attributes' => array(
			'class'		 => 'comment-form-textarea',
		)
	) );

	$cmb->add_field( array(
		'default_cb' => 'yj_maybe_set_default_from_posted_values',
		'name'       => __( 'Ingredients', 'GS' ),
		'id'         => 'new_recipe_ingredient',
		'type'       => 'wysiwyg',
		'options'    => array(
			'textarea_rows' => 6,
			'media_buttons' => false,
			'teeny' => true,
		    'quicktags' => false
		),
	) );

	$cmb->add_field( array(
		'default_cb' => 'yj_maybe_set_default_from_posted_values',
		'name'       => __( 'Preparation', 'GS' ),
		'id'         => 'new_recipe_prep',
		'type'       => 'wysiwyg',
		'options'    => array(
			'textarea_rows' => 6,
			'media_buttons' => false,
			'teeny' => true,
		    'quicktags' => false
		),
	) );


	
	$cmb->add_field( array(
		'default_cb' => 'yj_maybe_set_default_from_posted_values',
		'name'       => __( 'Categories', 'GS' ),
		'id'         => 'new_recipe_taxonomy',
		'type'       => 'taxonomy_select',
		'taxonomy'   => 'cuisine',
		'query_args' => array( 'parent'   => 0 ) 
	) );

		// Primary Picture 
		$cmb->add_field( array(
			'name'       => __( 'Choose Images', 'GS' ),
			'id'         => 'new_recipe_image',
			'type'       => 'text',	
			'desc'		=> 'upload up to 3 images',
			'attributes' => array(
				'type' => 'button', 
				'class' => 'upload-pic',
				'value' => 'Upload Images'
			),
		));


	$cmb->add_field( array(
		'id'   => 'recipe_image_0',
		'type' => 'hidden',
	) );

	$cmb->add_field( array(
		'id'   => 'recipe_image_1',
		'type' => 'hidden',
	) );

	$cmb->add_field( array(
		'id'   => 'recipe_image_2',
		'type' => 'hidden',
	) );
	$cmb->add_field( array(
		'id'   => 'recipe_image_3',
		'type' => 'hidden',
	) );	

}
add_action( 'cmb2_init', 'yj_frontend_form_postRecipe' );
/**
 * Sets the front-end-post-form field values if form has already been submitted.
 *
 * @return string
 */
function yj_maybe_set_default_from_posted_values( $args, $field ) {
	if ( ! empty( $_POST[ $field->id() ] ) ) {
		return $_POST[ $field->id() ];
	}
	return '';
}

/**
 * Gets the front-end-post-form cmb instance
 *
 * @return CMB2 object
 */
function yj_recipe_cmb2_get() {
	// Use ID of metabox in yj_frontend_form_postRecipe
	$metabox_id = 'front-end-post-form';
	// Post/object ID is not applicable since we're using this form for submission
	$object_id  = 'fake-oject-id';
	// Get CMB2 metabox object
	return cmb2_get_metabox( $metabox_id, $object_id );
}

/**
 * Handle the cmb_frontend_form shortcode
 *
 * @param  array  $atts Array of shortcode attributes
 * @return string       Form html
 */
function yj_do_frontend_form_submission_shortcode( $atts = array() ) {
	// Get CMB2 metabox object
	$cmb = yj_recipe_cmb2_get();
	// Get $cmb object_types

	$post_types = $cmb->prop( 'object_types' );
	// Current user
	$userId = get_current_user_id();

	// Parse attributes
	$atts = shortcode_atts( array(
		// 'post_author' => $user_id ? $user_id : 1, // Current user, or admin
		'post_status' => 'pending',
		'post_type'   => reset( $post_types ), // Only use first object_type in array
		'user_id'	=> $userId
	), $atts, 'cmb_frontend_form' );
	/*
	 * Let's add these attributes as hidden fields to our cmb form
	 * so that they will be passed through to our form submission
	 */
	foreach ( $atts as $key => $value ) {
		$cmb->add_hidden_field( array(
			'field_args'  => array(
				'id'    => $key,
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
		$output .= '<h3>' . sprintf( __( 'There was an error in the submission: %s', 'GS' ), '<strong>'. $error->get_error_message() .'</strong>' ) . '</h3>';
	}


	// If the post was submitted successfully, notify the user. 
	if ( isset( $_GET['post_submitted'] )  ) {
		// Get submitter's name
		$name = $user->display_name;
		$name = $name ? ' '. $name : '';
		// Add notice of submission to our output
		$output .= '<h3>' . sprintf( __( 'Thank you%s, your new post has been submitted and is pending review by a site administrator.', 'GS' ), esc_html( $name ) ) . '</h3>';
	}

	// Get our form
	$output .= cmb2_get_metabox_form( $cmb, 'fake-oject-id', array( 
		'save_button' => __( 'Submit Post', 'GS' ) ,
		'form_format' => '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-cmb" value="%4$s" class="btn btn--register" id="post_form_submit"></form>') );

	return $output;

}

add_shortcode( 'cmb_frontend_form', 'yj_do_frontend_form_submission_shortcode' );


/**
 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
 *
 * @return void
 */
function yj_handle_frontend_new_post_form_submission() {

	// Get CMB2 metabox object
	$cmb = yj_recipe_cmb2_get();

	if($cmb->cmb_id =='front-end-post-form') {

		// If no form submission, bail
		if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
			return false;
		}


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
		// Check title submitted
		foreach($_POST as $field) {
			if ( empty( $field )  ) {
				return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'New post requires a title.' ) ) );
			}
		}

	
		/**
		 * Fetch sanitized values
		 */
		$sanitized_values = $cmb->get_sanitized_values( $_POST );


		// Set our post data arguments
		$post_data['post_title']   = $sanitized_values['new_recipe_title'];
		unset( $sanitized_values['new_recipe_title'] );
		$post_data['post_content'] = $sanitized_values['new_recipe_prep'];
		unset( $sanitized_values['new_recipe_prep'] );
		// Create the new post


		$new_submission_id = wp_insert_post( $post_data, true );
		// If we hit a snag, update the user
		if ( is_wp_error( $new_submission_id ) ) {
			return $cmb->prop( 'submission_error', $new_submission_id );
		}

		// will save the remaining values in the $sanitized_values to post_meta plus save the taxonomy in the tax table

		$cmb->save_fields( $new_submission_id, 'post', $sanitized_values );
		/**
		 * Other than post_type and post_status, we want
		 * our uploaded attachment post to have the same post-data
		 */
		unset( $post_data['post_type'] );
		unset( $post_data['post_status'] );
		// Try to upload the featured image
		$img_id = yj_frontend_form_photo_upload( $new_submission_id, $post_data );
		// If our photo upload was successful, set the featured image
		if ( $img_id && ! is_wp_error( $img_id ) ) {
			set_post_thumbnail( $new_submission_id, $img_id );
		}
		/*
		 * Redirect back to the form page with a query variable with the new post ID.
		 * This will help double-submissions with browser refreshes
		 */
		wp_redirect( esc_url_raw( add_query_arg( 'post_submitted', $new_submission_id ) ) );
		exit;
	}
}
add_action( 'cmb2_after_init', 'yj_handle_frontend_new_post_form_submission' );
/**
 * Handles uploading a file to a WordPress post
 *
 * @param  int   $post_id              Post ID to upload the photo to
 * @param  array $attachment_post_data Attachement post-data array
 */
function yj_frontend_form_photo_upload( $post_id, $attachment_post_data = array() ) {
	// Make sure the right files were submitted
	if (
		empty( $_FILES )
		|| ! isset( $_FILES['new_recipe_image'] )
		|| isset( $_FILES['new_recipe_image']['error'] ) && 0 !== $_FILES['new_recipe_image']['error']
	) {
		return;
	}
	// Filter out empty array values
	$files = array_filter( $_FILES['new_recipe_image'] );
	// Make sure files were submitted at all
	if ( empty( $files ) ) {
		return;
	}
	// Make sure to include the WordPress media uploader API if it's not (front-end)
	if ( ! function_exists( 'media_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
	}
	// Upload the file and send back the attachment post ID
	return media_handle_upload( 'new_recipe_image', $post_id, $attachment_post_data );
}
