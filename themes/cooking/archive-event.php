<?php
get_header();?>

<div class="container container--narrow">

hello
  <?php while(have_posts()){
    the_post(); ?>

<div class="event-summary">
         <a class="event-summary__date " href="#">
           <span class="event-summary__month">Mar</span>
           <span class="event-summary__day">25</span>
         </a>
         <div class="event-summary__content">
           <h5 class="event-summary__title headline headline--tiny"><a href="#">Poetry in the 102</a></h5>
           <p>Bring poems you&rsquo;ve wrote to the 100 building this Tuesday for an open mic and snacks. <a href="#" class="nu gray">Learn more</a></p>
         </div>
  </div>
<?php } ?>

</div>

 <?php get_footer();
