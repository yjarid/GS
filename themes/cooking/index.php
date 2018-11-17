<?php

get_header();?>

<div class="container container--narrow">
  <?php while(have_posts()){
    the_post(); ?>

<h3><?php the_title(); ?></h3>

</br>


<?php


$attached = $post->GS_attached_posts;
if($attached) {?>

<ul>
  <?php foreach ( $attached as $attached_post ) {
  	$post = get_post( $attached_post );
    ?>
    <li><?php echo $post->post_title ?></li>

  <?php

}

} ?>
</ul>


<?php } ?>

</div>

 <?php get_footer();


 ?>
