<?php
get_header();

?>



<div class="container container--narrow">


<div class="acf-map">


    <div class="marker" data-lat="<?php echo $post->GS_location_latitude; ?>" data-lng="<?php echo $post->GS_location_longitude; ?>">

    </div>

</div>

</div>

<?php
get_footer();
