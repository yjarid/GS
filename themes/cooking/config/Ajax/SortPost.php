<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS\Ajax;

 use GS\Data\PostData;


class SortPost 
{
	public function register() {
        add_action('wp_ajax_sortRecipes', array($this , 'sortRecipes'));
        add_action('wp_ajax_nopriv_sortRecipes', array($this , 'sortRecipes'));
    }

    function sortRecipes(){
        check_ajax_referer( 'sortNonce', 'nonceSort' );

if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

  $sortBy = $_POST['sortBy'];
  $term = $_POST['term'];
  $tax = $_POST['tax'];

  $taxQuery = array(
    array( 'taxonomy' => $tax,   'field' => 'name',  'terms'  => $term )
   );
  
  if($sortBy == 'date' ) {

    $sort = PostData::getPost(1, '', [], null, $taxQuery  ) ;
  }
  else if ($sortBy && $sortBy != 'date') {

    $sort = PostData::getPost(1, $sortBy, [], null, $taxQuery  ) ; 
  }



    

        if( $sort->have_posts() ) {
          ob_start();
          while( $sort->have_posts() ) {
            $sort->the_post();

             get_template_part( 'content/recipeCard' );


          }
          $html = ob_get_contents(); // we pass the posts to variable
             ob_end_clean();
            $max = $sort->max_num_pages;
        }

      wp_reset_postdata();

      $json = array('html'=>$html, 'max'=>$max);
     
       echo json_encode($json);



     }

    die();
    }
}