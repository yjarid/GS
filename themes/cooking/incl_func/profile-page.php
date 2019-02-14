<?php



function YJ_frontend_profile_register() {

	$user = wp_get_current_user();

	$cmb = new_cmb2_box( array(
		'id'           => 'front-end-profile',
		'object_types' => array( 'user' ),
		'hookup'       => false,
		'save_fields'  => false,
	) );

	$cmb->add_field( array(
		'name'       => __( 'Profile Image', 'profile' ),
		'id'         => 'button_profile_image',
		'type'       => 'text',
		'attributes' => array(
			'type' => 'button', 
			'value' => 'Upload New Picture',
			'class' => 'upload-pic'
		
	)));
	$cmb->add_field( array(
		'name'    => __( 'Display Name', 'profile' ),
		'id'      => 'user_name',
		'type'    => 'text',
		'default' => esc_attr($user->display_name) ?:__( 'Enter your name', 'profile' ),
		//'attributes' => array('name' => 'display_name')
		) );

	
	$cmb->add_field( array(
		'name'    => __( 'About You', 'profile' ),
		'id'      => 'user_description',
		'default' =>  get_user_meta($user->ID, 'description', true)?: 'write a short description about you, it will be posted in your page',
		'type' 	  => 'textarea',
		'attributes' => array(
			'class' => 'comment-form-textarea',
			'cols' => '40',
			'rows' => '8'
			)

	) );

	$cmb->add_field( array(
		'name'    => __( 'Favorite Food ', 'profile' ),
		'id'      => 'user_fav_food',
		'type'    => 'text',
		'default' => get_user_meta($user->ID, 'fav-food', true)?: '',
		//'attributes' => array('name' => 'fav-food')
		

	) );

	$cmb->add_field( array(
		'name'    => __( 'Your Country', 'profile' ),
		'id'      => 'user_country',
		'type'    => 'text',
		'default' => get_user_meta($user->ID, 'country', true)?: '',
		//'attributes' => array('name' => 'country')

	) );

	$cmb->add_field( array(
	'id'   => 'user_picture',
	'type' => 'hidden',
	'default' => esc_url( get_user_meta( get_current_user_id(), 'picture', true ) ) ?:__( '', 'profile' ),
	//'attributes' => array('name' => 'picture')
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

	// user ID 

	$userId = get_current_user_id();

	// Parse attributes
	$atts = shortcode_atts( array(
		'post_author' => $userId ?: 1, // Current user, or admin
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
		$output .= '<h3>' . sprintf( __( 'There was an error in the submission: %s', 'profile' ), '<strong>'. $error->get_error_message() .'</strong>' ) . '</h3>';

	}
	// If the post was submitted successfully, notify the user.
	elseif ( isset( $_GET['profile_updated'] ) && ( 'success' == $_GET['profile_updated'] ) ) {

		// Add notice of submission to our output
		$output .= '<h3>' .  __( 'Thank you , your profile has been updated .', 'profile' ) . '</h3>';
	}

	// Get our form
	$output .= '<div class="edit-profile-container">';
	$output .= '<div id="avatar-image-container" "> <img src="'.esc_url( get_user_meta( get_current_user_id(), 'picture', true ) ) .'" alt="" title="" /></div>';
	$output .= cmb2_get_metabox_form( $cmb, 'fake-oject-id', array( 
		'save_button' => __( 'Update Profile', 'profile' ) ,
		'form_format' => '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-cmb" value="%4$s" class="btn btn--register"></form>') );
	$output .= '</div>';
	

	return $output;
}
add_shortcode( 'cmb_frontend_profile', 'YJ_do_frontend_Profile_submission_shortcode' );
/**
 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
 *
 * @return void
 */
function YJ_handle_frontend_profile_form_submission() {

			// Get CMB2 metabox object
			$cmb = YJ_frontend_cmb2_profile_get();
			$userId = get_current_user_id();

				if($cmb->cmb_id =='front-end-profile') {
					// If no form submission, bail
					if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
						return false;
					}

					// Check security nonce
					if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
						return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
					}
					//Check email submitted
					if ( empty( $_POST['user_name'] ) || empty( $_POST['user_description'] )  ) {
						return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'Please don\'t leave the Name and About you sections empty') ) );
					}

					 
					 $post_data = array();

					 

					// Get our shortcode attributes and set them as our initial post_data args
					// if ( isset( $_REQUEST['atts'] ) ) {
					// 	foreach ( (array) $_REQUEST['atts'] as $key => $value ) {
					// 		$post_data[ $key ] = sanitize_text_field( $value );
					// 	}
					// 	 unset( $_POST['atts'] );
					// }

					// Fetch sanitized values
					 
					$sanitized_values = $cmb->get_sanitized_values( $_POST );



					// Set our post data arguments

					$subm_user_id = wp_update_user( array(
						'ID'=>$userId,
						'display_name' => $sanitized_values['user_name']
					)
					);

					unset( $sanitized_values['user_name'] );

					$post_data['description'] = $sanitized_values['user_description'];
					$post_data['fav-food'] = isset($sanitized_values['user_fav_food']) ? $sanitized_values['user_fav_food'] : '';
					$post_data['picture'] = isset($sanitized_values['user_picture']) ? $sanitized_values['user_picture'] : '';
					$post_data['country'] = isset($sanitized_values['user_country']) ? $sanitized_values['user_country'] : '';
					
					unset($sanitized_values);




					// If we hit a snag, update the user
					if ( is_wp_error( $subm_user_id ) ) {
						return $cmb->prop( 'submission_error', $subm_user_id );
					}


					foreach ( $post_data as $key => $value ) {

						update_user_meta($userId, $key, $value);
						
					}



					 unset( $post_data);
							
								 
				wp_redirect( esc_url_raw( add_query_arg( 'profile_updated', 'success' ) ) );
				exit;
				}




}
add_action( 'cmb2_after_init', 'YJ_handle_frontend_profile_form_submission' );
