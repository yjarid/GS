

<div class="wrapper wrapper--narrow login-form">
  <div class="login-form-container">
    <h2>Welcome to Golden Spoon </h2>
    <form id="yj-register-form" action="<?php echo wp_registration_url(); ?>" method="post" >
      <label for="useremail">Email</label>
      <span class='register-desc'></span>
      <input id="registeremail" type="text" name="user_email">
      <div class="error" id="reg-error-email">Please enter a valid Email</div>
      <label for="password">Password</label>
      <span class='register-desc'>(at least 6 characters)</span>
      <input id="registerPassword" type="password" name="password">
      <div class="error" id="reg-error-password">your password must be atleast 6 characters</div>

      <?php if ( $attributes['recaptcha_site_key'] ) : ?>
        <div class="recaptcha-container">
            <div class="g-recaptcha" data-sitekey="<?php echo $attributes['recaptcha_site_key']; ?>"></div>
        </div>
      <?php endif; ?>

      <input class="btn btn--large btn--center" name="wp-submit" id="registerbutton" type="submit" value="register" name="submit">
      <p class="status" id="reg-status"></p>
      <p class="actions">
          <a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a> - <a href="<?php echo wp_registration_url(); ?>">Register</a>
      </p>
      <?php wp_nonce_field( 'register-nonce', 'registerNonce' ); ?>
    </form>

    <div class="login-social-media">
      <h3>Login with facebook</h3>
    </div>
  </div>
</div>
