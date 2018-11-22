
<div class="wrapper wrapper--narrow login-form">
  <div class="login-form-container">
    <h2>Welcome to Golden Spoon </h2>
    <form  id="yj-register-form" action="<?php echo wp_registration_url(); ?>" method="post" >
      <div class="message">
          <?php
          if ( count( $attributes['errors'] ) > 0 ) {
            echo '<div class="message-err" id="message-err">';
           foreach ( $attributes['errors'] as $error ) { echo '<p>'.$error.'</p>';}
           echo '</div>';
         }
          if( 'true' == filter_input( INPUT_GET, 'register' ))   echo '<div class="message-red"> Please check your email and Activate ur account </div>';
          ?>
      </div>
      <div class="login-form--inside">
        <label for="useremail">Email</label>
        <input id="registeremail" type="text" name="user_email">
        <div class="error" id="reg-error-email">Please enter a valid Email</div>
      </div>
      <div class="login-form--inside">
        <label for="password">Password <span class='register-desc'>(at least 6 characters)</span>  </label>
        <input id="registerPassword" type="password" name="password">
        <div class="error" id="reg-error-password">your password must be atleast 6 characters</div>
      </div>
      <?php if ( $attributes['recaptcha_site_key'] ) : ?>
        <div class="recaptcha-container ">
            <div class="g-recaptcha " data-sitekey="<?php echo $attributes['recaptcha_site_key']; ?>"></div>
        </div>
      <?php endif; ?>
      <div class="login-form--inside">
        <input class="btn btn--register" name="wp-submit" id="registerbutton" type="submit" value="register" name="submit">
      </div>
      <!-- <p class="status" id="reg-status"></p> -->
      <div class="actions ">
        <a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a> - <a href="<?php echo wp_registration_url(); ?>">Register</a>
      </div>
      <?php wp_nonce_field( 'register-nonce', 'registerNonce' ); ?>
    </form>

  </div>
</div>
