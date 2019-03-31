<?php
 get_header(); ?>

 <div class="container container--narrow">

 <nav>
  <ul class="nav nav-tabs" id="userProfile">
    <li class="active main" id="h"> <a href="<?php echo site_url('/user-profile/')?>"> My Profile</a></li>
    <li class=""> <a href="recipe"> My Recipes</a></li>
    <li class=""> <a href="made"> Made it</a></li>
    <li class=""> <a href="friend"> Following</a></li>
    <li class="main"> <a href="<?php echo site_url('/user-profile/message')?>"> Messages</a></li>
    
  </ul>
</nav>
</div>
<div class="tab-content" >

  <div id="tab-1" class="tab-pane active">
   <?php 
    $template_file = WP_PLUGIN_DIR.'/Profile-Page/inc/Views/mainProfile.php' ;
    load_template(  $template_file, $require_once = true );
   ?>
 
  </div>

 </div>


 



<?php
 get_footer();
