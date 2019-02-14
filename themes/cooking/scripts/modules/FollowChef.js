import $ from 'jquery';
class FollowChef {
    // 1. describe and create/initiate our object

    constructor() {

      this.followBtn = $("#auth-follow");
      this.events();

      console.log('htht');
      
    }

    // events
     events() {

        this.followBtn.on("click", this.toggleChefToFavourite.bind(this));
      
     }

    //methods
    toggleChefToFavourite() {

      var that = this;
      let user = this.followBtn.data('user');
      let chefToFollow = this.followBtn.data('auth');
      let isFollowing = this.followBtn.data('auth');

   
      if(!user) {
        $("body").append(`
        <div id="loginOverlay">
         <div class="loginOverlay-content">

          <h4 class="loginOverlay-title">This Action is for Member Only ! </h4>
          <a href="${jsData.root_url }/login "> <p class="btn btn--author">Please Login </p></a>

         </div>
        </div>
        `);
        return;
      }
       

      $.ajax({
        url : jsData.ajax_url,
        dataType: "json",
        data : {
          'action': 'followChef', //
          'nonceSort' : jsData.sort_nonce,// nonce
          'user': user,
          'chefToFollow' : chefToFollow,
          'isFollowing' : isFollowing
        },

        type : 'POST',



        success : ( data )=> {

           if( data.status =="follow" ) {
              this.followBtn.addClass("following").text("Unfollow");    
          } else if ( data.status ==="unFollow" ) {
              this.followBtn.removeClass("following").text("+Follow"); 
          }

        },

        error : ( e )=> {
          console.log(e);
        }
      });

      return false;

   }
}

export default FollowChef;