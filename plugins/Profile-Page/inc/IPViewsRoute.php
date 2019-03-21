<?php

/**
 * @package  
 */
namespace Profile;


class IPViewsRoute
{

  public function register() {
    add_action('rest_api_init', array($this , 'ipViewsRoute'));
  }

 function  ipViewsRoute(){
    register_rest_route('recipe/v1', 'ipViews', array(
        'methods' => 'POST'  ,
        'callback' => array($this , 'ipViewsResults')
      ));
  }

  function ipViewsResults( $request){
    $city = $request['city'];
    $postId = $request['postId'];
    $chef = get_post_field( 'post_author', $postId);

    // get term ids for the post
    $terms =  wp_get_post_terms($postId , 'cuisine',  array("fields" => "ids"));  

    if($city ) {

        if($chef) {
              // get the chef meta for views by Country
            $chefLove =  get_user_meta($chef, 'user_views_byCountry' , true) ;
            $chefLove = ( $chefLove ?  $chefLove : []);
            if(!isset($chefLove[ $city])) {
                $chefLove[$city] = 1;
            } else {
                $chefLove[$city]++;
            }

             update_user_meta($chef, 'user_views_byCountry' ,$chefLove);
        }

        if(is_array($terms) && $terms) {
            foreach($terms as $term) {
                $termViewsCountry = get_term_meta($term, 'term_views_byCountry', true);
                $termViewsCountry = ( $termViewsCountry ?  $termViewsCountry : []);

                if(!isset($termViewsCountry[ $city])) {
                    $termViewsCountry[$city] = 1;
                } else {
                    $termViewsCountry[$city]++;
                }
    
                 update_term_meta($term, 'term_views_byCountry' ,$termViewsCountry); 
             
        }

    
   
    }
    return $city;

  }
}
}