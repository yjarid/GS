<?php
get_header();?>

<div class="container container--narrow">


<div class="acf-map">

  <?php while(have_posts()){
    the_post(); ?>

    <div class="marker" data-lat="<?php echo $post->GS_location_latitude; ?>" data-lng="<?php echo $post->GS_location_longitude; ?>">
<?php the_title(); ?>
    </div>



<?php } ?>

</div>

</div>


<?php

get_footer();
