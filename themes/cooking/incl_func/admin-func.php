
<?php

/**
 * Change Avatar Picture
 */

function slug_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

    //in case of a comment we pass the comment object instead so we need to retreive the id 

    if ( is_object( $id_or_email ) && isset( $id_or_email->comment_ID ) ) {
        $id_or_email = $id_or_email->user_id;
    }

    //If is email, try and find user ID
    if( ! is_numeric( $id_or_email ) && is_email( $id_or_email ) ){
        $user  =  get_user_by( 'email', $id_or_email );
        if( $user ){
            $id_or_email = $user->ID;
        }
    }

    

    //if not user ID, return
    // if( ! is_numeric( $id_or_email ) ){
    //     return $avatar;
    // }

    //Find URL of saved avatar in user meta
    $saved = get_user_meta( $id_or_email, 'picture', true );


    //check if it is a URL
    // if( filter_var( $saved, FILTER_VALIDATE_URL ) ) {   UNCOMENT THIS WHEN GOING LIVE
        //return saved image
        return sprintf( '<img src="%s" alt="%s" />', esc_url( $saved ), esc_attr( $alt ) );
    // }

    //return normal
    return $avatar;

}

add_filter( 'get_avatar', 'slug_get_avatar', 10, 5 );


/**
 * Save the meta field when the post is saved via admin 
 * 
 *  @param int $post_id The ID of the post being saved.
 */

add_action( 'save_post_recipe',   'save_edited_post' );

function save_edited_post( $post_id ) {

    //check that the post is not deleted
   
    if ( isset($_POST['action']) && $_POST['action'] =='editpost' ) {

    /*
     * If this is an autosave, our form has not been submitted,
     * so we don't want to do anything.
     */
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    // Check the user's permissions.
   
    if ( 'recipe' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Sanitize the user input.
    $mydata['post_ingredient'] = sanitize_textarea_field(htmlentities($_POST['GS_ingredients_edit']));
    $mydata['post_desc'] =sanitize_textarea_field($_POST['GS_description_edit']);

    // Update the meta field.
    $test = update_post_meta( $post_id, "post_meta", $mydata );

}
}