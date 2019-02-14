<?php

add_action('wp_ajax_userProfile', 'youssef_userProfile');
add_action('wp_ajax_nopriv_userProfile', 'youssef_userProfile');


function youssef_userProfile(){

check_ajax_referer( 'sortNonce', 'nonceSort' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

  $anchor = $_POST['anchor'];

  
  
    ob_start();

    switch ($anchor) {
        case 'profile':
        get_template_part('templates/userProfile/mainProfile');
        break;

        case 'recipe':
        get_template_part('templates/userProfile/myRecipes');
        break;

        case 'fav':
        get_template_part('templates/userProfile/myFavourites');
        break;

        case 'friend':
        get_template_part('templates/userProfile/myFriends');
        break;

        case 'made':
        get_template_part('templates/userProfile/madeIt');
        break;
    }
    
    $html = ob_get_contents(); // we pass the posts to variable
    ob_end_clean();

    $json = array('html'=>$html, 'status'=>true);

       echo json_encode($json);


    }

    die();


}
