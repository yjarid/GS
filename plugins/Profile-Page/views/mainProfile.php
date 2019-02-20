<div>

    <div class="recipeInfo-section">

    <p class="average-rating">Rating: <?php    ?></p>
    <p>Reviews: <?php  ?></p>
    <p>Favorited: <?php  ?></p>
    <p>Made it: <?php  ?></p>

    <div class="recipeDesc">
    <h4>Description:</h4>
    <p> <?php  ?></p>
    </div>

    
    <span class="">
        <a href="<?php echo site_url('/user-profile/edit-profile')?>">Edit Profile</a>
    </span>
    </div>

    <div class="profile-rep" data-user=<?php echo get_current_user_id(); ?>>
        <div class="profile-rep-chart profile-rep-views">
            <canvas id="rep-views" width="400" height="400"></canvas>
        </div>
        <div class="profile-rep-chart profile-rep-like">
            <canvas id="rep-like" width="400" height="400"></canvas>
        </div>
        <div class="profile-rep-chart profile-rep-madeIt">
            <canvas id="rep-madeIT" width="400" height="400"></canvas>
        </div>
    </div>

    
</div>