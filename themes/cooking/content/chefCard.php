<?php 
    use \GS\Data\ViewsData;
    use \GS\Data\UserData;

     
?>

<div class="categoryCard">
            <a href="<?php echo $data['url'] ?>" class="categoryCardLink">
                <div class="categoryImg">
                    <img src="<?php echo $data['img_url'] ?>" class="categoryCardImage" alt="<?php echo $data['alt']; ?>">
                </div>
            </a>
            <div class="categoryCardTitle">
              <span class="categoryText"><?php echo $data['name'];  ?></span>
              <span class="categoryViews">
                  <span><?php echo 'Views: '.  ViewsData::getUserViews($data['id']). ' '   ?> </span> 
                  <span><?php echo 'Score: '.  UserData::getGSRating($data['id'])   ?> </span> 
              </span>
            </div>

          </div>