<?php
 get_header(); ?>

 <div class="container">

 <nav>
  <ul class="nav nav-tabs" id="userProfile">
    <li class="active" id="h"> <a href="profile"> My Profile</a></li>
    <li class=""> <a href="recipe"> My Recipes</a></li>
    <li class=""> <a href="fav"> My Favourites</a></li>
    <li class=""> <a href="friend"> My Friends</a></li>
    <li class=""> <a href="made"> Made it</a></li>
  </ul>
</nav>

<div class="tab-content" >

  <div id="tab-1" class="tab-pane active">
   <?php get_template_part('templates/userProfile/mainProfile') ;?>
 
  </div>

 </div>


 </div>



<?php
 get_footer();
