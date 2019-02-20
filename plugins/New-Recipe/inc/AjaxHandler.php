<?php


namespace NewPost;


class AjaxHandler 
{

  public function register() {
    
    add_action('wp_ajax_newPostForm', array( $this , 'postingNewRecipe'));
  
  }

  function postingNewRecipe() {
     
    check_ajax_referer( 'filterNonce', 'nonceFilter' );

    if( defined( 'DOING_AJAX' ) && DOING_AJAX) {
 
        $post_data['post_title']   = sanitize_text_field($_POST['formData']['new_recipe_title']); 
        $post_data['post_content'] = sanitize_textarea_field(htmlentities($_POST['formData']['new_recipe_prep']));
        $post_data['post_status'] = sanitize_text_field($_POST['formData']['post_status']);
        $post_data['post_type'] = sanitize_text_field($_POST['formData']['post_type']);

        $post_id =  wp_insert_post(  $post_data,   true );

        if ( is_wp_error($post_id) ) {
            $data['postCreated'] = 'false';
            $data['html'] = $post_id->get_error_code();
          }

        if($post_id) {

            // asign taxonomy 
            $tax = sanitize_text_field($_POST['formData']['new_recipe_taxonomy']);
            $term_id = term_exists( $tax, 'cuisine' );
            if($term_id){
                wp_set_object_terms($post_id, $tax, 'cuisine');
            }

            //  insert remaining fields into the postmeta
            $postmeta_data['post_desc']   = sanitize_textarea_field($_POST['formData']['new_recipe_description']);
            $postmeta_data['post_ingredient'] = sanitize_textarea_field(htmlentities($_POST['formData']['new_recipe_ingredient']));
            update_post_meta( $post_id, 'post_meta', $postmeta_data );
            
            // asign featured image and other attachement

            $attachements = $_POST['attachement'];
            $i = 0;

            foreach($attachements as $attach ) {
                $arg = array(
                'ID' => $attach['id'],
                'post_parent' => $post_id
                );

                $updated_post = wp_update_post($arg , true);

                if ( is_wp_error($updated_post) ) {
                    $data['attachUpdated'] = 'false';
                    $data['html'] = $post_id->get_error_code();
                  } 

                if($i === 0) {
                    $post_thumb = set_post_thumbnail($post_id, $attach['id']);  
                }
                $i++;  
            }

            $data['postCreated'] = 'true';
            $data['html'] = 'Post successfully created! if everything is ok it will be published within 24h';
        }

        echo json_encode( $data );
            
        }
        die();
}
}
