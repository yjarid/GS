<div class="wrapper wrapper--narrow login-form">
  <div class="login-form-container">

    <h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>

    <p> <?php _e("Enter your email address and we'll send you a link you can use to pick a new password.",
                'personalize_login' ); ?> </p>

    <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
      <div class="message">
          <?php
          if ( count( $attributes['errors'] ) > 0 ) {
            echo '<div class="message-err">';
           foreach ( $attributes['errors'] as $error ) { echo '<p>'.$error.'</p>';}
            echo '</div>';
         }
        ?>
      </div>
        <p class="form-row">
            <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?>
            <input type="text" name="user_login" id="user_login">
        </p>

        <p class="lostpassword-submit">
            <input type="submit" name="submit" class="lostpassword-button"
                   value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
        </p>
    </form>

  </div>
</div>
