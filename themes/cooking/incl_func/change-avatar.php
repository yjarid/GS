
<?php
function slug_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

    //If is email, try and find user ID
    if( ! is_numeric( $id_or_email ) && is_email( $id_or_email ) ){
        $user  =  get_user_by( 'email', $id_or_email );
        if( $user ){
            $id_or_email = $user->ID;
        }
    }

    //if not user ID, return
    if( ! is_numeric( $id_or_email ) ){
        return $avatar;
    }

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
