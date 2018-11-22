
<div class="wrapper wrapper--narrow login-form">
  <div class="login-form-container">
    <h2>Welcome to Golden Spoon</h2>

    <form id="yj-login-form" action="<?php echo wp_login_url(); ?>" method="post" >

          <div class="message">
                <?php
                if ( count( $attributes['errors'] ) > 0 ) {
                  echo '<div class="message-err" id="message-err">';
                 foreach ( $attributes['errors'] as $error ) { echo '<p>'.$error.'</p>';}
                 echo '</div>';
               }

                if( 'actif' == filter_input( INPUT_GET, 'status' )) {
                  echo '<div class="message-red"> Congratulation your account is actif, Please Login. </div>';
                 }

                 if('NotActif' == filter_input( INPUT_GET, 'status' )) {
                   echo ' <div class="message-red">Please check your email and Activate ur accout before logging in </div>';
                  }

                if( 'confirm' == filter_input( INPUT_GET, 'checkemail' )) {
                  echo ' <div class="message-red">Check your email for a link to reset your password.</div>';
                 }

                 if( 'changed' == filter_input( INPUT_GET, 'password' )) {
                   echo ' <div class="message-red">';
                   echo _e( 'Your password has been changed. You can sign in now', 'personalize-login' );
                   echo '</div>';
                 }
                ?>
            </div>
      <label for="useremail">Email</label>
      <input id="useremail"  type="text" name="log">
      <div class="error"  id="error-email">Please enter a valid Email</div>
      <label for="password">Password</label>
      <input id="password" name="pwd" type="password" name="password">
      <div class="error" id="error-password">your password must be atleast 6 characters</div>
      <input class="btn btn--large btn--center" id="loginbutton" type="submit" value="Login" name="submit">
      <p class="status" id="status"></p>
      <p class="actions">
          <a href="<?php echo site_url('password-lost'); ?>">Forgot Password?</a> - <a href="<?php echo site_url('register'); ?>">Register</a>
      </p>
      <?php wp_nonce_field( 'login-nonce', 'loginNonce' ); ?>
    </form>

  </div>
</div>
