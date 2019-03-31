<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS\Ajax;
use GS\Data\PostData;

 


class LoadMore 
{
	public function register() {
        add_action('wp_ajax_loadmorebutton', array($this , 'loadMore'));
        add_action('wp_ajax_nopriv_loadmorebutton', array($this , 'loadMore'));
    
    }

    function loadMore(){
        check_ajax_referer( 'loadMoreNonce', 'nonce' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {
    
    $paged = $_POST['page'];

if ($_POST['metaKey']) {

  $load = PostData::getPost(1, $_POST['metaKey'], [], $paged ) ;
 
}

else if(isset($_POST['meal']) || isset($_POST['ingredient']))  {
  
      $tax = array('relation' => 'AND');

      if( $_POST['meal']) { 
        $tax[] =   array('taxonomy' => 'meal',   'field' => 'id',   'terms' => $_POST['meal'] ?: '' );
      }

      if( $_POST['ingredient']) {
        $tax[] = array('taxonomy' => 'ingredient', 'field' => 'id',     'terms' => $_POST['ingredient'] );
      }

      $load = PostData::getPost(1, '', [], $paged, $tax ) ;

  }

  else if(isset($_POST['sortBy']) && $_POST['sortBy']) {
    $tax[] = array(
      array(
      'taxonomy' => $_POST['tax'],
      'field'    => 'name',
      'terms'    => $_POST['term'],
      )
    );

    if($_POST['sortBy'] == 'date' ) {

      $load = PostData::getPost(1, '', [], $paged, $tax ) ;
      
    }
    else if ( $_POST['sortBy'] != 'date') {
      $load = PostData::getPost(1, $_POST['sortBy'], [], $paged, $tax ) ;

    }

  }

  else {

    $load = PostData::getPost(1, '', [], $paged );
  }




 if( $load->have_posts() ) {
   // run the loop
   while($load->have_posts()) {
       $load->the_post() ;

       get_template_part( 'content/recipeCard' );

     }
   }

wp_reset_postdata();
}



die(); // here we exit the script and even no wp_reset_query() required!
    }
}