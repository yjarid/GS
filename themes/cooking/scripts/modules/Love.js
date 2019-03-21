import $ from 'jquery';
class Love {
    // 1. describe and create/initiate our object
    constructor() {
      this.loveIt =$('#loveit-button');
      this.madeIt = $('#madeit-button');
      this.Modal = $("#checkLoginOverlay");
      this.events();

     
    }

    events(){
        this.loveIt.on("click", {clickedButton : this.loveIt, action : 'love' }, this.loveItfunc.bind(this));
        this.madeIt.on("click", {clickedButton : this.madeIt , action : 'made' }, this.loveItfunc.bind(this));
        this.Modal.find(".close-loginOverlay").on("click",this.closeLoginModalfunc.bind(this));
    
      }

      loveItfunc(button){
          var btnContainer = button.data.clickedButton;
          var lovePost = btnContainer.data("postid");
          var loveUser = btnContainer.data("user");
          var loveCount = btnContainer.data("count");

          if(!loveUser) { 
            this.Modal.addClass("loginOverlay--active");
            return;
            }

            //disable the button to prevent sending many request 
            btnContainer.attr("disabled", "disabled");

            if(btnContainer.hasClass( "active" )) {
               loveCount--;
              btnContainer.removeClass("active");
              btnContainer.data('count', loveCount).find(".icon").removeClass(`icon--${button.data.action}-full`).addClass(`icon--${button.data.action}-empty`);
            } else {
              loveCount++;
              btnContainer.addClass("active");
              btnContainer.data('count', loveCount).find(".icon").removeClass(`icon--${button.data.action}-empty`).addClass(`icon--${button.data.action}-full`);
            }

            btnContainer.find(".loveMade-btn-cont-count").html(loveCount);
         
            $.ajax({
              beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', jsData.nonceRest);
              },
              url: jsData.root_url + '/wp-json/recipe/v1/loveMade' ,
              type: 'POST',
              data: {
                'postID': lovePost ,
                'action' : button.data.action
              },
              success: (response) => {
                
                btnContainer.prop("disabled", false).find(".loveMade-btn-cont-count").html(response);
              },
              error: (response) => {
                if(btnContainer.hasClass( "active" )) {
                  loveCount--;
                  btnContainer.removeClass("active");
                  btnContainer.find(".icon").removeClass(`icon--${button.data.action}-full`).addClass(`icon--${button.data.action}-empty`);
                } else {
                  loveCount++;
                  btnContainer.addClass("active");
                  btnContainer.find(".icon").removeClass(`icon--${button.data.action}-empty`).addClass(`icon--${button.data.action}-full`);
                }
            
                btnContainer.prop("disabled", false).find(".loveMade-btn-cont-count").html(loveCount);
              }
            });          
          
          
      }

      madeItfunc(){

      }

    //   Helper function 


    closeLoginModalfunc(){
      this.Modal.removeClass("loginOverlay--active");
    }
}


export default Love;