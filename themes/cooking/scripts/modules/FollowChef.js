import $ from 'jquery';
class FollowChef {
    // 1. describe and create/initiate our object

    constructor() {
      this.followBtn = $("#auth-follow");
      this.Modal = $("#checkLoginOverlay");
      this.events();

      
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
      let isFollowing = this.followBtn.data('follow');

   
      if(!user) {
        this.Modal.addClass("loginOverlay--active");
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
              that.followBtn.data('follow', 'yes').addClass("following").text("Unfollow");    
          } else if ( data.status ==="unFollow" ) {
              that.followBtn.data('follow', 'no').removeClass("following").text("+Follow"); 
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