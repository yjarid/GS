<div class="wrapper wrapper--narrow login-form">
  <div class="login-form-container">

    <h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>



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
        <div class="login-form--inside">
            <label for="user_login"><?php _e( 'Enter your Email : ', 'personalize-login' ); ?> </label>
            <input type="text" name="user_login" id="user_login">
        </div>


      <input class="btn btn--register btn--register--s" type="submit" name="submit" class="lostpassword-button"
                   value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>

    </form>

  </div>
</div>
