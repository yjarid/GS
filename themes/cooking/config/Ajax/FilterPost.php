<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS\Ajax;
use GS\Data\PostData;

 


class FilterPost 
{
	public function register() {

        add_action('wp_ajax_myfilter', array($this , 'filter'));
        add_action('wp_ajax_nopriv_myfilter', array($this , 'filter'));
    
    }

    function filter() {
        check_ajax_referer( 'filterNonce', 'nonceFilter' );

        if( defined( 'DOING_AJAX' ) && DOING_AJAX) {

          

            $tax = array('relation' => 'AND');

            if(isset($_POST['meal']) && $_POST['meal']) {
               
                $tax[] =  array( 'taxonomy' => 'meal', 'field' => 'id', 'terms' => $_POST['meal'] ?: '');
            }

            if(isset($_POST['ingredient']) && $_POST['ingredient']) {

                $tax[]  = array( 'taxonomy' => 'ingredient', 'field' => 'id', 'terms' => $_POST['ingredient'] ?: '' );
            }

            $filter = PostData::getPost(1, $_POST['metaKey'], [], $paged, $tax ) ;

            if( $filter->have_posts() ) {
            ob_start();
            while( $filter->have_posts() ) {
                $filter->the_post();

                get_template_part( 'content/recipeCard' );


            }
            $html = ob_get_contents(); // we pass the posts to variable
                ob_end_clean();
                $max = $filter->max_num_pages;
            }

        wp_reset_postdata();

        $json = array('html'=>$html, 'max'=>$max);

        echo json_encode($json);



        }

        die();


    }
    
}