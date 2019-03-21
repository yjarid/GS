<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS\RestApi;



class SearchRoute 
{
	public function register() {
        add_action('rest_api_init', array($this , 'recipeRegisterSearch'));
    }

    function recipeRegisterSearch() {
        register_rest_route('recipe/v1', 'search', array(
          'methods' => \WP_REST_SERVER::READABLE  ,
          'callback' => array($this ,'searchRoute')
      
        ));
    }

    function searchRoute($data) {
        $mainQuery = new \WP_Query(array(
          'post_type' => array('post', 'page','event', 'recipe', 'chef', 'location'),
          's' => sanitize_text_field($data['key'])
        ));
      
        $results = array(
          'generalInfo' => array(),
          'event' => array(),
          'recipe' => array(),
          'chef' => array(),
          'location' => array()
        );
      
        while($mainQuery->have_posts()) {
          $mainQuery->the_post();
      
          if(get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($results['generalInfo'] , array(
              'title' => get_the_title(),
              'permalink' => get_the_permalink(),
              'type' => get_post_type(),
              'authorName' => get_the_author()
            ));
          }
      
      
          if(get_post_type() == 'event' ) {
            array_push($results['event'] , array(
              'title' => get_the_title(),
              'permalink' => get_the_permalink()
            ));
          }
      
      
          if(get_post_type() == 'recipe' ) {
            global $post;
            array_push($results['recipe'] , array(
              'title' => get_the_title(),
              'permalink' => get_the_permalink(),
              'authorName' => get_the_author(),
              'type' => 'primary'
            ));
      
            $relatedChefs = get_post_meta($post->ID, 'GS_related_chefs', true);
      
            foreach ($relatedChefs as $item) {
              array_push($results['chef'] , array(
                'id'=>$item,
                'title' => get_the_title($item),
                'permalink' => get_the_permalink($item)
                ));
            }
          }
      
      
          if(get_post_type() == 'chef' ) {
            array_push($results['chef'] , array(
              'title' => get_the_title(),
              'permalink' => get_the_permalink(),
              'id' => get_the_ID()
            ));
          }
      
      
          if(get_post_type() == 'location' ) {
            array_push($results['location'] , array(
              'title' => get_the_title(),
              'permalink' => get_the_permalink()
            ));
          }
      
        }
      
      if($results['chef']){
        $chefs = array('relation' => 'OR');
      
        foreach($results['chef'] as $item) {
          array_push($chefs,   array('key' =>'GS_related_chefs' , 'value' =>'"'.$item['id'].'"' , 'compare' =>'LIKE'  ) );
        }
      
        $chefRelated = new \WP_Query(array(
          'post_type' =>'recipe',
          'meta_query' => $chefs
        ));
      
        while($chefRelated->have_posts()) {
          $chefRelated->the_post();
          if(get_post_type() == 'recipe' ) {
            array_push($results['recipe'] , array(
              'title' => get_the_title(),
              'permalink' => get_the_permalink(),
              'authorName' => get_the_author(),
              'type' => 'secondary'
            ));
          }
        }
      
        $results['recipe'] = array_values(array_unique($results['recipe'], SORT_REGULAR));
      }
      
      
        return $results;
      }
      
	
}