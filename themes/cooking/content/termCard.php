<?php 
    use \GS\Data\ViewsData;    
?>

<div class="categoryCard">
            <div class="categoryImg">
              <a href="<?php echo site_url( $data['term_url'] )?>" class="categoryCardLink">
                      <img src="<?php echo $data['img_url'] ?>" class="categoryCardImage" alt="<?php echo $data['alt']; ?>">
            </a>
            </div>

            <div class="categoryCardTitle">
              <span class="categoryText"><?php echo $data['name'];  ?></span>
              <span class="categoryViews"><?php echo ViewsData::getTermViews($data['id'] ) . ' Views'   ?> </span>
            </div>
</div>