<?php
 if( post_password_required()) return;
?>

<div id="comments" class="comments-area">

   <?php 
    if( have_comments() ) { ?>

     <h2 class="comment-title">
        <?php 
        // printf( _nx( 'One Review for %2$s', '%1$s Reviews for %2$s', get_comments_number(),'comments title', 'textdomain' ), 
        //  number_format_i18n( get_comments_number() ), 
        //  get_the_title() );
        ?>
     </h2>

      <ol class='comment-list'>

     <?php   $args = array(
            'walker'    => null,
            'max_depth' => 1,
            'style'     => 'ol',
            'callback'  => 'format_comment',
            'end-callback' => null,
            'type'      => 'all',
            'reply_text' => 'reply Hna',
            'page'      => '',
            'per_page'   => 5,
            'avatar_size' => 32,
            'reverse_top_level' => true,
            'reverse_children' => null,
            'format' => 'html5',
            'short_ping' => false,
            'echo' => true


        );

         wp_list_comments($args);
      echo   '</ol>';

     
      if( get_comment_pages_count() > 1 && get_option('page_comments') ) { ?>

       <nav id="comment-nav-top" class="comment-navigation" >
           <h4>Comment Navigation</h4>
           <div class="nav-link">
               <span>
               <?php previous_comments_link('Previous Comments') ?>
               </span>

               <span>
               <?php next_comments_link('Next Comments') ?>
               </span>
           </div>
       
       </nav>

      <?php }

     }

     $args = array(
        'title_reply' =>  sprintf( __( 'Hello <a href="%1$s">%2$s</a>. Leave a Review' ),  admin_url( 'profile.php' ), $user_identity ) ,
        'label_submit'      => __( 'Post Review' ),
        'format'            => 'html5',
        'class_submit'      => 'loadMoreButton--text submit-comment',
        'comment_field' =>  '<textarea class="comment-form-textarea" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
          '</textarea>',
      
        'must_log_in' => '<p class="must-log-in">' .
          sprintf( __( 'You must be <a href="%s">logged in</a> to review this post.' ),  wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
          ) . '</p>',
      
        'logged_in_as' => ''
       
      ); 
   
   comment_form($args); ?> 

</div>