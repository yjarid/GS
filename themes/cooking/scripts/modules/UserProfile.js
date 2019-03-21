import $ from 'jquery';
class UserProfile {
    // 1. describe and create/initiate our object

    constructor() {

      this.tabs = $("#userProfile > li").not(".main");
      this.contentContainer = $('.tab-content');
      this.events();
    }

    // events
     events() {

      this.tabs.each((i, elem) => {
          $(elem).on("click", this.switchTab.bind(this));
          });
      
     }

    //methods
    switchTab(event) {

      var that = this;
      event.preventDefault();

      this.tabs.siblings(".active").removeClass("active");
      $(".tab-pane.active").removeClass("active");

      let clickedTab = $(event.currentTarget);
       let anchor = $(event.currentTarget).find("a").attr("href");

       

      clickedTab.addClass("active");
      
      
      that.contentContainer.html('<div class="spinner-loader"></div>');
       

      $.ajax({
        url : jsData.ajax_url,
        dataType: "json",
        data : {
          'action': 'userProfile', //
          'nonceSort' : jsData.sort_nonce,// nonce
          'anchor': anchor //
        },

        type : 'POST',



        success : ( data )=> {

           if( data ) {
            setTimeout(()=> {
              that.contentContainer.html(`<div class="tab-pane">${data.html} </div>`);
            }, 1000)      
          }

        },

        error : ( e )=> {
          console.log(e);
        }
      });

      return false;

  }
}

export default UserProfile;