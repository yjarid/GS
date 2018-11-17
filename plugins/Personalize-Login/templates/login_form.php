<!-- Show errors if there are any -->
<?php if ( count( $attributes['errors'] ) > 0 ) {
        foreach ( $attributes['errors'] as $error ) { ?>
        <p class="">  <?php echo $error; ?> </p>
      <?php }
      }

      if($_GET['status'] == 'NotActif') { ?>
        <p class="">  please check your email and Activate ur accout before logging in </p>
      <?php }
 ?>


<div class="wrapper wrapper--narrow login-form">
  <div class="login-form-container">
    <h2>Welcome to Golden Spoonnn</h2>
    <form id="yj-login-form" action="<?php echo wp_login_url(); ?>" method="post" >
      <label for="useremail">Email</label>
      <input id="useremail"  type="text" name="log">
      <div class="error"  id="error-email">Please enter a valid Email</div>
      <label for="password">Password</label>
      <input id="password" name="pwd" type="password" name="password">
      <div class="error" id="error-password">your password must be atleast 6 characters</div>
      <input class="btn btn--large btn--center" id="loginbutton" type="submit" value="Login" name="submit">
      <p class="status" id="status"></p>
      <p class="actions">
          <a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a> - <a href="<?php echo wp_registration_url(); ?>">Register</a>
      </p>
      <?php wp_nonce_field( 'ajax-login-nonce', 'loginNonce' ); ?>
    </form>

    <div class="login-social-media">
      <h3>Login with facebook</h3>
    </div>
  </div>
</div>
