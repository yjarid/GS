<?php
namespace Profile\Views;
use GS\Data\UserData;

// get the user rating 
$rating = UserData::getChefRating($user_ID);
$followingUsers = UserData::getFollowingUsers($user_ID);
?>


<div>
    <span class="">
        <a href="<?php echo site_url('/user-profile/edit-profile')?>">Edit Profile</a>
    </span>

    <div class="reporting-Container"  data-user=<?php echo $user_ID; ?>>
        <div class="topStat">
            <div class="topStat-avgRating">
                <div class="title"> Avg Rating</div>
                <div class="value"> <?php  echo ' '. $rating['avg'] . ' </strong>( ' . $rating['nbr'] . ' reviews)'; ?> </div>
            </div>
            <div class="topStat-avgRating">
                <div class="title"> Recipes  </div>
                <div class="value"> <?php echo count_user_posts( $user_ID , "recipe"  ) ?> </div>
            </div>
            <div class="topStat-avgRating">
                <div class="title">
                    <div class="titleWithdesc">Followers</div>
                </div>
                <div class="value"> <?php echo count($followingUsers) ;?> </div>
            </div>
            <div class="topStat-avgRating">
                <div class="title"> GS Score * </div>
                <div class="value"> 
                   <span class="tpCont" id="userGSRating">
                        <?php echo UserData::getGSRating($user_ID) ?> 
                    </span>
                   <span class="tpCont" id="userGSRatingDiff">  ( <?php echo UserData::getGSRatingDiff($user_ID)?>) </span>   
                </div>

            </div>
            <div class="topStat-avgRating">
                <div class="title"> GS Rank **</div>  
                <div class="value">
                   <span id="userGSRank"><?php echo UserData::getGSRatingRank($user_ID)?></span>  
                   <span id="userGSDiffRank">  ( <?php echo UserData::getGSRatingDiffRank($user_ID)?> ) </span> 
                </div>
            </div>
        </div>

        
        <div class="profile-rep">
            <div class="profile-rep-chart profile-rep-views">
                <canvas id="rep-views" width="100%" height="100%"></canvas>
            </div>
            <div class="profile-rep-chart profile-rep-love">
                <canvas id="rep-love" width="100%" height="100%"></canvas>
            </div>
            <div class="profile-rep-chart profile-rep-made">
                <canvas id="rep-made" width="100%" height="100%"></canvas>
            </div>
        </div>

        <div class="middleStat">
            <div class="middleStat-sexe">
                <canvas id="rep-sexe" width="60%" height="60%"></canvas>
            </div>
            <div class="middleStat-country">
                <canvas id="rep-country" width="60%" height="60%"></canvas>
            </div>
        </div>

       

    </div>

    <div class="reporting-footnote">
            <div>
                * <em>    GS (Golden Spoon) Score is a calculation to evaluate users. it takes into consideration : 
                Being Active , Quality of content, Interaction with others, and other aspects.
                for all users. Two scores are reported : overall-score(monthly-score). </br>
               ** GS Rank : ranks all users based on their scores : overall-rank(monthly-score-rank)
            </em>
           </div>
        
    </div>

</div>