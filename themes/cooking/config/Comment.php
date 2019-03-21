<?php
/**
 * this is for enqueuing Style and script and adding Theme support 
 */
namespace GS;

 use GS\DisplayFunc;


class Comment 
{
	public function register() {

    // $this->formatComment($comment, $args, $depth);

    
    }

    // this function is used to overwrite the default output of Comment HTML 

   static function formatComment($comment, $args, $depth) {
    
        //    $GLOBALS['comment'] = $comment; 
    
    
    ?>
            <li id="comment-<?php comment_ID(); ?>" class="comment">
                <article  class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 32 ); ?>
                            <?php
                                /* translators: %s: comment author link */
                                printf(  '<b class="fn">%s</b>', get_comment_author_link( $comment ) 
                                );
                            ?>
                        </div><!-- .comment-author -->
    
                        <div class="comment-metadata">
                            <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                                <time datetime="<?php comment_time( 'c' ); ?>">
                                    <?php
                                        /* translators: 1: comment date, 2: comment time */
                                        $time = sprintf( __( '%1$s %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
    
                                        // function available at incl_func/time-elapsed
                                        
                                        echo DisplayFunc::get_time_elapsed($time);
                                    ?>
                                </time>
                            </a>
                            <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
                        </div><!-- .comment-metadata -->
    
                        <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
                        <?php endif; ?>
                    </footer><!-- .comment-meta -->
    
                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div><!-- .comment-content -->
    
                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>'
                    ) ) );
                    ?>
                </article><!-- .comment-body -->
    
                    <?php }
    
    
	
}