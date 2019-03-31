<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>

<?php 
use GS\Redirect;
?>
  <body>

    <div class="container">
      <header>

        <div class="menuIcon">
          <div class="menuIcon_midle"></div>
        </div>

          <div class="headerNav">
            <div class="layoutHeaderSection">
              <div class="siteLogo">
                  <a href="<?php echo site_url('/')?>">
                  <img alt="GoldenSpoon" src="<?php echo get_theme_file_uri('/incl/img/logo.png') ?>" />
                  </a>
              </div>
              <div class="topRight">
                <div class="socialMedia">
                  <span class="followUs"> Follow Us :  </span>
                  <a href="#"><span class="icon--facebook icon"></span></a>
                  <a href="#"><span class="icon--twiter icon"></span></a>
                  <a href="#"><span class="icon--youtube icon"></span></a>
                    <a href="#"><span class="icon--instagram icon"></span></a>
                </div>
                <div class="searchSignUp">
                  <div class="left">

                      <div class="searchBox">
                        <input type="text" placeholder="Search for a Recipe !!!"class="searchBox-input" >
                        <div class="searchBox-iconcontainer overlay">

                        </div>
                      </div>

                  </div>
                  <div class="right">
                  <?php if(is_user_logged_in())  {?>
                      <div class="login__btn"  id="login">
                        <span class="login__avatar"><?php echo get_avatar( get_current_user_id(),  20 ); ?></span>
                        <span class="login__text"><a href="<?php echo site_url( '/user-profile' ) ?>">Profile</a></span>
                      </div>
                        <span class="logout__text"><a href="<?php echo wp_logout_url( site_url( '/' )) ?>">LogOut</a></span>
                
                      <?php } else { ?>
                      <div class="login__btn login__btn_extraPadding"  id="login">
                        <span class="login__text"><a href="<?php  echo Redirect::urlLoginRedirect() ?>">LogIN</a></span>
                      </div>
                    <?php } ?>
                      </div>
                      
                    </div>
                </div>
              </div>
        </div>

          <!-- MAIN NAvigation -->
            <nav class="main-navigation">
              <ul class="parent">
                <li data-type="MOR"><a href="<?php echo site_url('/cuisine/moroccan')?>">Moroccan</a></li>
                <li data-type="AFR"><a href="<?php echo site_url('/cuisine/african')?>">African</a> </li>
                <li data-type="EUR"><a href="<?php echo site_url('/cuisine/european')?>">European </a> </li>
                <li data-type="ASN"><a href="<?php echo site_url('/cuisine/asian')?>">Asian</a></li>
                <li data-type="AMR"><a href="<?php echo site_url('/cuisine/american')?>">American </a> </li>
                <li data-type="LAT"><a href="<?php echo site_url('/cuisine/latino')?>">Latino </a> </li>
                <li data-type="HLT"><a href="<?php echo site_url('/cuisine/healthy')?>">Healthy</a></li>
              </ul>

                    <!--  -->
              <div class="subMenuList">
                <div class="subMenu" id="Moroccan">
                  <ul class="child">
                    <li><a href="#">Moroccan Main Dish</a></li>
                    <li><a href="#">Moroccan Side Dish</a></li>
                    <li><a href="#">Moroccan Bakery</a></li>
                  </ul>
                </div>

                <div class="subMenu" id="African">
                  <ul class="child">
                    <li><a href="#">North African</a></li>
                    <li><a href="#">South African</a></li>
                    <li><a href="#">Easter African</a></li>
                    <li><a href="#">Central African</a></li>
                    <li><a href="#">African Bakery</a></li>
                  </ul>
                </div>

                <div class="subMenu" id="European">
                  <ul class="child">
                    <li><a href="#">Italian </a></li>
                    <li><a href="#">Spanish </a></li>
                    <li><a href="#">French </a></li>
                    <li><a href="#">North & East European</a></li>
                    <li><a href="#">European Bakery</a></li>
                  </ul>
                </div>

                <div class="subMenu" id="Asian">
                  <ul class="child">
                    <li><a href="#">Thai </a></li>
                    <li><a href="#">Chinese </a></li>
                    <li><a href="#">Indian </a></li>
                    <li><a href="#">Filipino </a></li>
                    <li><a href="#">Vientnam </a></li>
                    <li><a href="#">Asian Bakery</a></li>
                  </ul>
                </div>

                <div class="subMenu" id="American">
                  <ul class="child">
                    <li><a href="#">Burger</a></li>
                    <li><a href="#">American Main Dish</a></li>
                    <li><a href="#">American Side Dish</a></li>
                    <li><a href="#">American Bakery</a></li>
                  </ul>
                </div>

                <div class="subMenu" id="Latino">
                  <ul class="child">
                    <li><a href="#">Caribbean</a></li>
                    <li><a href="#">South American </a></li>
                    <li><a href="#">Latino Bakery</a></li>
                  </ul>
                </div>

                <div class="subMenu" id="Healthy">
                  <ul class="child">
                    <li><a href="#">Healthy Meal</a></li>
                    <li><a href="#">Salad</a></li>
                    <li><a href="#">Soups</a></li>
                  </ul>
                </div>

              </div>

                    <!--  -->

              <div class="navSocialMedia">
                <span class="followUs"> Follow Us :  </span>
                <a href="#"><span class="icon--facebook icon"></span></a>
                <a href="#"><span class="icon--twiter icon"></span></a>
                <a href="#"><span class="icon--youtube icon"></span></a>
                <a href="#"><span class="icon--instagram icon"></span></a>
              </div>

       

    </nav>

  </header>
  </div>
