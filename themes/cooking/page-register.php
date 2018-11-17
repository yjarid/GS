<?php

get_header();



if( 'true' == filter_input( INPUT_GET, 'register' ))   echo '<div class=""> Please check your email and Activate ur account </div>';

if('email' == filter_input( INPUT_GET, 'errors' )) echo '<div class=""> Please enter a valid Email Address </div>';

if('email_exists' == filter_input( INPUT_GET, 'errors' )) echo '<div class=""> this email exists </div>';
if('captcha' == filter_input( INPUT_GET, 'spam' )) echo '<div class=""> The Google reCAPTCHA check failed. Are you a robot? </div>';

while(have_posts()){
 the_post();

the_content();

}


get_footer();
