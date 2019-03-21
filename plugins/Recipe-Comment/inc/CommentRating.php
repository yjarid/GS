<?php

/**
 * @package  
 */
namespace Comment;

use Comment\BaseController;
use GS\DisplayFunc;


class CommentRating extends BaseController
{

  public function register() {
    add_action( 'wp_enqueue_scripts', array($this , 'comment_rating_styles' ));
    add_action( 'comment_form_logged_in_after', array($this , 'comment_rating_field' ));
    add_action( 'comment_post', array($this , 'comment_rating_save_commentMeta'),10, 3 );
    add_filter( 'preprocess_comment', array($this , 'comment_rating_required') );
    add_filter( 'comment_text', array($this , 'comment_rating_display'));
    add_action('wp_set_comment_status', array( $this , 'comment_rating_save_postMeta'), 10, 2);
    add_filter('comments_open', array($this ,'comment_rating_restrict_users'), 10, 2);
  
  }

  //Create the rating interface.

function comment_rating_field ($coment) {
	?>
	<div class="comments-rating-container" id="comments-rating-container">
		<div class="comments-rating">
			<span class="rating-container">
				<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
					<input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" /><label for="rating-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
				<?php endfor; ?>
				<input type="radio" id="rating-0" class="star-cb-clear" name="rating" value="0" /><label for="rating-0">0</label>
			</span>
		</div>
	</div>

<?php }

//Enqueue the plugin's styles.


function comment_rating_styles() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'comment-rating-styles', $this->plugin_url.'assets/style.css' );
}

//Save the rating submitted by the user. in the COMMENT meta 

function comment_rating_save_commentMeta( $comment_id, $comment_approved, $commentdata ) {
	
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
	$rating = intval( $_POST['rating'] );

	//add the rating to the comment meta 
	add_comment_meta($comment_id, 'rating', $rating);

	
}

//Make the rating required.

function comment_rating_required( $commentdata ) {
	if ( ! is_admin() && ( ! isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] ) ) )
	wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
	return $commentdata;
}


//Display the rating on a submitted comment.

function comment_rating_display( $comment_text ){

	if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		$stars = '<p class="stars">';
		for ( $i = 1; $i <= $rating; $i++ ) {
			$stars .= '<span class="dashicons dashicons-star-filled"></span>';
		}
		$stars .= '</p>';
		$comment_text = $stars . $comment_text  ;
		return $comment_text;
	} else {
		return $comment_text;
	}
}


// add comment rating to POST meta

function comment_rating_save_postMeta($comment_ID, $comment_status) {
	$date = DisplayFunc::getDate();
	$monthMetaKey = 'rating_'.$date['M'].'_'.$date['Y'];
	$yearMetaKey = 'rating_'.$date['Y'];

	$comment = get_comment( $comment_ID ); 
	$rating = get_comment_meta($comment_ID, 'rating', true);
	

	// retreive the Post Rating year and month
	$post_id = $comment->comment_post_ID;
	$post_rating_year = get_post_meta($post_id, $yearMetaKey, true);
	$post_rating_month = get_post_meta($post_id, $monthMetaKey, true);

	// retreive the Post Rating year and month
	$user_id = get_post_field( 'post_author', $post_id );
	$user_rating_year = get_user_meta($user_id, $yearMetaKey, true);
	$user_rating_month = get_user_meta($user_id, $monthMetaKey, true);

	$postPeriods = [$monthMetaKey => $post_rating_month , $yearMetaKey => $post_rating_year];
	$userPeriods = [$monthMetaKey => $user_rating_month , $yearMetaKey => $user_rating_year];
	 

	if($comment_status == 'approve') {

		//update the post meta with th new rating for Month and Year

		foreach($postPeriods as $key => $period){
			if(!$period) $period = array(0,0,0);
			$post_commenters = $period[0] + 1;
			$post_rating_tot = $period[1] + $rating;
			$post_rating_avg = round( $post_rating_tot / $post_commenters, 1 );	
			$period = [intval($post_commenters) , intval($post_rating_tot), floatval($post_rating_avg)  ];
			update_post_meta( $post_id, $key, $period );
		}
		
			//update user meta with th new rating for Month and Year

		foreach($userPeriods as $key => $period){
			if(!$period) $period = array(0,0,0);
			$user_commenters = $period[0] + 1;
			$user_rating_tot = $period[1] + $rating;
			$user_rating_avg = round( $user_rating_tot / $user_commenters, 1 );	
			$period = [intval($user_commenters) , intval($user_rating_tot), floatval($user_rating_avg)  ];
			update_user_meta( $user_id, $key, $period );
		}



	} else {
		
		// remove the comment data from the post array 
		foreach($postPeriods as $key => $period){
			if($period) {
				$post_commenters = $period[0] - 1;
				$post_rating_tot = $period[1] - $rating;

				// to avoid dividing  by 0 
				if($post_commenters > 0) {
					$post_rating_avg = round( $post_rating_tot / $post_commenters, 1 );
				} else {
					$post_rating_avg = 0;
				}
				
				$period = [intval($post_commenters) , intval($post_rating_tot), floatval($post_rating_avg)  ];
				update_post_meta( $post_id, $key, $period );
			}
		}

		// remove the comment data from the user array 
		foreach($userPeriods as $key => $period){
			if($period){
				$user_commenters = $period[0] - 1;
				$user_rating_tot = $period[1] - $rating;
					// to avoid dividing by 0 
					if($user_commenters > 0) {
						$user_rating_avg = round( $user_rating_tot / $user_commenters, 1 );
					} else {
						$user_rating_avg = 0;
					}	
				$period = [intval($user_commenters) , intval($user_rating_tot), floatval($user_rating_avg)  ];
				update_user_meta( $user_id, $key, $period );
			}		
		}	
	}
}


// Restrict number of comment per users to 1 review

function comment_rating_restrict_users($open, $post_id) {
   if (intval($post_id) && get_post($post_id)) {
       $args = array('post_id' => $post_id, 'count' => true);
       $user = wp_get_current_user();
       if ($user && intval($user->ID)) { // for registered users
           $skip = false;
           $ignoreTheseRoles = array('administrator', 'editor'); // which user roles should be ignored
           if ($user->roles && is_array($user->roles)) {
               foreach ($user->roles as $role) {
                   if (in_array($role, $ignoreTheseRoles)) {
                       $skip = true;
                       break;
                   }
               }
           }
           if (!$skip) {
               $args['user_id'] = $user->ID;
               $open = get_comments($args) ? false : true;
           }
       } else { // for guests
           $commenter = wp_get_current_commenter();
           if ($commenter && is_array($commenter) && isset($commenter['comment_author_email'])) {
               $args['author_email'] = $commenter['comment_author_email'];
               $open = get_comments($args) ? false : true;
           }
       }
   }
   return $open;
}


}
