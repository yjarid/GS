<?php

/**
 * @package  
 */
namespace NewPost;


class AdminNewRecipe 
{

  public function register() {

    //*************************** 
    // customize recipe amin edit page
    //*****************************

    add_action( 'cmb2_admin_init', array( $this , 'newRecipe_adminField') );
    add_action( 'save_post_recipe',   array($this , 'save_edited_recipe') );

    //*************************** 
    //customize recipe  admin Columns
    //*****************************

    add_filter( 'manage_recipe_posts_columns', array( $this , 'admin_columns') );
    add_action( 'manage_recipe_posts_custom_column', array($this , 'admin_column'), 10, 2);
    add_filter( 'manage_edit-recipe_sortable_columns', array($this , 'sort_admin_column') );
    add_action( 'pre_get_posts', array($this , 'orderbyViews') );
  
  }


  //*************************** 
//  new recipe CMB2 Fields 
// *****************************

function newRecipe_adminField(){

	$prefix = 'GS_';

	

	
$newRecipeFields = new_cmb2_box( array(
	'id'           => $prefix .'newRecipeData',
	'title'        => __( 'New Recipe Data', 'yourtextdomain' ),
	'object_types' => array( 'recipe' ), // Post type
	'context'      => 'normal',
	'priority'     => 'high',
	'show_names'   => false, // Show field names on the left
	
) );

$newRecipeFields->add_field( array(
	'default_cb' => array( $this , 'newRecipeMeta'),
	'name'    => __( 'Ingredients', 'GS' ),
	'desc'    => __( 'edit the Ingredients field', 'GS' ),
	'id'      => $prefix . 'ingredients_edit',
	'type'    => 'wysiwyg',
	
	'options' => array(
		'media_buttons' => false,
	),
) );

$newRecipeFields->add_field( array(
	'default_cb' =>  array( $this , 'newRecipeMeta'),
	'name'       => __( 'Description', 'GS' ),
	'id'         => $prefix . 'description_edit',
	'type'       => 'textarea',
) );


$newRecipeFields->add_field( array(
	'name' => esc_html__( 'Post Images', 'cmb2' ),
	'id'   => $prefix . 'admin_post_img',
	'type' => 'text',
	 'render_row_cb' => array($this , 'renderPostImage'),
) );

}

/**
 * Save the meta field when the post is saved via admin 
 * 
 *  @param int $post_id The ID of the post being saved.
 */

function save_edited_recipe( $post_id ) {

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

//*************************** 
//customize recipe  admin Columns
//*****************************

    function admin_columns( $columns ) {
    $columns['views'] = __( 'Views', 'GS' );
   unset($columns['taxonomy-mood']);
    return $columns;
    }

    function admin_column( $column, $post_id ) {
    // views column
  
        $t=date('d-m-Y');
        $year = date("Y",strtotime($t));
    
        if ( 'views' === $column ) {
        $num_views = get_post_meta($post_id, 'views_count_'.$year, true);
        echo $num_views;
        }
    }

    function sort_admin_column($columns) {

        $columns['views'] = 'views';
        $columns['author'] = 'author';
        return $columns;
      
      }

      function orderbyViews( $query ) {
        if( ! is_admin() )
            return;
    
        $orderby = $query->get( 'orderby');
    
    
        if( 'views' == $orderby ) {
          $t=date('d-m-Y');
          $year = date("Y",strtotime($t));
          $test = 'views_count_'.$year;
            $query->set('meta_key',$test);
            $query->set('orderby','meta_value_num');
        }
    }

    // 
    // 
    // Helper Function 
    // 
    // 

    function newRecipeMeta( $args , $field ) {
        // the default value for the recipe ingredients 
        $postMeta = get_post_meta( get_the_id() , 'post_meta', true ) ;
        
    
        $ingredient = isset($postMeta['post_ingredient']) ? $postMeta['post_ingredient'] : '';
        $desc = isset($postMeta['post_desc']) ? $postMeta['post_desc'] : '';
    
        if($args['name'] == 'Ingredients'){
            return $ingredient;
        } else if($args['name'] == 'Description') {
            return $desc;
        }
            
    }
    
    function renderPostImage($field_args, $field ){
    
        $id = get_the_id();
        ?>
        <div class="admin_images_container" > 
            <?php
                $attachements = get_attached_media( 'image', $id ) ;
                    
                    foreach( $attachements as $attach) {  ?>     			
                        <div class="admin_image">
                            <img src="<?php echo esc_url(wp_get_attachment_image_src($attach->ID, 'thumbnail')[0]) ?>" alt="" title="" data-post=<?php echo $id ?> data-img=<?php echo $attach->ID ?>  />
                            <div class="admin_image_action">
                                <span  class="admin_image_delete">Delete</span>
                                <span class="admin_image_setFI">Set Featured</span>
                            </div>	
                        </div>				
                <?php } ?>
    
        </div>
    <?php }
    
    
    

}