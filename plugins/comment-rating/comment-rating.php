<?php
/*
Plugin Name: Comment Rating
Description: Adds a star rating system to WordPress comments
Version: 1.0.0
Author: Youssef Jarid
Author URI: 
*/

//Create the rating interface.
add_action( 'comment_form_logged_in_after', 'ci_comment_rating_rating_field' );
//  add_action( 'comment_form_after_fields', 'ci_comment_rating_rating_field' );

function ci_comment_rating_rating_field ($coment) {
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
add_action( 'wp_enqueue_scripts', 'ci_comment_rating_styles' );

function ci_comment_rating_styles() {

	wp_register_style( 'comment-rating-styles', plugins_url('/', __FILE__) . 'assets/style.css' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'comment-rating-styles' );
}

//Save the rating submitted by the user.
add_action( 'comment_post', 'ci_comment_rating_save_comment_rating',10, 3 );

function ci_comment_rating_save_comment_rating( $comment_id, $comment_approved, $commentdata ) {
	
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
	$rating = intval( $_POST['rating'] );

	//add the rating to the comment meta 
	add_comment_meta($comment_id, 'rating', $rating);

	
}

//Make the rating required.
add_filter( 'preprocess_comment', 'ci_comment_rating_require_rating' );

function ci_comment_rating_require_rating( $commentdata ) {
	if ( ! is_admin() && ( ! isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] ) ) )
	wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
	return $commentdata;
}


//Display the rating on a submitted comment.
add_filter( 'comment_text', 'ci_comment_rating_display_rating');
function ci_comment_rating_display_rating( $comment_text ){

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


add_action('wp_set_comment_status', 'yj_add_commentRating_toPostMeta', 10, 2);

function yj_add_commentRating_toPostMeta($comment_ID, $comment_status) {

	$comment = get_comment( $comment_ID ); 
	$rating = get_comment_meta($comment_ID, 'rating', true);
	$post_id = $comment->comment_post_ID;
	$rating_array = get_post_meta($post_id, 'rating', true);

	if($comment_status == 'approve') {

		//update the post meta with th new rating 
		
		if(!$rating_array) $rating_array = array(0,0,0);

		$commenters = $rating_array[0] + 1;
		$rating_tot = $rating_array[1] + $rating;
		$rating_avg = round( $rating_tot / $commenters, 1 );

		$rating_array = [intval($commenters) , intval($rating_tot), floatval($rating_avg)  ];

		update_post_meta( $post_id, 'rating', $rating_array );

	} else {
		if($rating_array) delete_post_meta( $post_id, 'rating');
	}
}


// Restrict number of comment per users to 1 review

add_filter('comments_open', 'yj_restrict_users', 10, 2);

function yj_restrict_users($open, $post_id) {
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

// //Get the average rating of a post.
// function ci_comment_rating_get_average_ratings( $id ) {
// 	$comments = get_approved_comments( $id );

// 	if ( $comments ) {
// 		$i = 0;
// 		$total = 0;
// 		foreach( $comments as $comment ){
// 			$rate = get_comment_meta( $comment->comment_ID, 'rating', true );
// 			if( isset( $rate ) && '' !== $rate ) {
// 				$i++;
// 				$total += $rate;
// 			}
// 		}

// 		if ( 0 === $i ) {
// 			return false;
// 		} else {
// 			return round( $total / $i, 1 );
// 		}
// 	} else {
// 		return false;
// 	}
// }

// //Display the average rating above the content.
// add_filter( 'comment_form_before', 'ci_comment_rating_display_average_rating' );
// function ci_comment_rating_display_average_rating( $content ) {

// 	global $post;

// 	if ( !$rating = get_post_meta( $post->ID, 'rating', true) ) {
// 		echo '<h3>be the first leave a rating </h3>';
// 	}
	
// 	$stars   = '';
// 	$average = $rating[2];

	

// 	for ( $i = 1; $i <= $average + 1; $i++ ) {
		
// 		$width = intval( $i - $average > 0 ? 20 - ( ( $i - $average ) * 20 ) : 20 );

// 		if ( 0 === $width ) {
// 			continue;
// 		}

// 		$stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="dashicons dashicons-star-filled"></span>';

// 		if ( $i - $average > 0 ) {
// 			$stars .= '<span style="overflow:hidden; position:relative; left:-' . $width .'px;" class="dashicons dashicons-star-empty"></span>';
// 		}
// 	}
	
// 	echo '<p class="average-rating">This post\'s average rating is: ' . $average .' ' . $stars .'</p>';
	
// }

