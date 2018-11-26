<div class="wrapper wrapper--narrow login-form">
  <div class="login-form-container">

    <h3><?php _e( 'Pick a New Password', 'personalize-login' ); ?></h3>
    <form name="resetpassform" id="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
      <div class="message">
          <?php
          if ( count( $attributes['errors'] ) > 0 ) {
            echo '<div class="message-err">';
           foreach ( $attributes['errors'] as $error ) { echo '<p>'.$error.'</p>';}
            echo '</div>';
         }
        ?>
      </div>
        <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" />
        <input type="hidden" name="rp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" />
        <div class="login-form--inside">
            <label for="pass1"><?php _e( 'New password', 'personalize-login' ) ?><span class='register-desc'> (at least 6 characters)</span></label>
            <input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
        </div>
        <div class="login-form--inside">
            <label for="pass2"><?php _e( 'Repeat new password', 'personalize-login' ) ?></label>
            <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
        </div>

          <input class="btn btn--register btn--register--s" type="submit" name="submit" id="resetpass-button"
                   class="button" value="<?php _e( 'Reset Password', 'personalize-login' ); ?>" />

    </form>
  </div>
</div>
