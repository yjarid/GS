<?php
get_header();



while(have_posts()){
  the_post();

the_content();
$profile_pic = get_user_meta( get_current_user_id(), 'picture', true );
print_r($profile_pic);
?>

<div class="image_container" style="display:block; width: 100%; overflow: hidden; text-align: center;">
  <div class="profile_picture" style=" width: 140px; height: 140px; overflow: hidden; " >

    <?php
      echo get_avatar( get_current_user_id(), $size = 96, $default = '', $alt = 'best pict', $args = null ); ?>

  </div>
</div>

<?php }






 get_footer();
