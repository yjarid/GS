<?php 
use GS\Data\PostData;
use GS\Data\ViewsData;

$id = get_the_ID();
$rating = PostData::getPostRating($id);

?>

  <tr>
    <td><a href="<?php the_permalink()?>"><?php the_title(); ?></a></td>
    <td><?php echo ViewsData::getPostViews($id , 'post_views_2019'); ?></td>
    <td><?php echo PostData::getLove($id, 'love'); ?></td>
    <td><?php echo PostData::getLove($id, 'made'); ?></td>
    <td><?php echo $rating['avg'] ?></td>
    <td><?php echo $rating['nbr'] ?></td>
  </tr>
  
