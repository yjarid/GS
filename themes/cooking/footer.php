<?php 
use GS\Redirect;
?>
    <div class = "loginOverlay" id="checkLoginOverlay">
     <div class="loginOverlay-content">
    
      <span class="close-loginOverlay" > X </span>
      <h4 class="loginOverlay-title">This Action is for Member Only ! </h4>
      <a href=" <?php echo Redirect::urlLoginRedirect() ?>">
       <p class="btn btn--author">Please Login </p></a>
    
     </div>
    </div>
<footer>
</footer>


<?php wp_footer(); ?>
  </body>
</html>
