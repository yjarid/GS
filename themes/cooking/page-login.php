<?php

get_header();


if( 'actif' == filter_input( INPUT_GET, 'status' )) { ?>

  <div class="">
    Congratulation your account is activated, Please Login.
  </div>

<?php }
if( 'confirm' == filter_input( INPUT_GET, 'checkemail' )) { ?>

  <div class="">
    Check your email for a link to reset your password.
  </div>

<?php }

while(have_posts()){
 the_post();

the_content();

}


get_footer();
