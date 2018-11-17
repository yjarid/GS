<?php
echo 'hello';
get_header();

$attributes['errors'] = array();
if ( isset( $_REQUEST['errors'] ) ) {
    $error_codes = explode( ',', $_REQUEST['errors'] );

    foreach ( $error_codes as $error_code ) {
        $attributes['errors'] []= get_error_message( $error_code );
    }
}

if ( count( $attributes['errors'] ) > 0 ) :
    foreach ( $attributes['errors'] as $error ) : ?>
        <p>
            <?php echo $error; ?>
        </p>
    <?php endforeach;


    
endif;
?>

<h1>Forgot your Password</h1>
<h4>Enter your email address and we'll send you a link you can use to pick a new password.</h4>
<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
    <label for="user_login"> Email
    <input type="text" name="user_login" id="user_login">

    <input type="submit" name="submit" class="lostpassword-button" value="Reset Password"/>
</form>


<?php get_footer(); ?>
