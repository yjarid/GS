
import $ from 'jquery';
class IPViews {
  // 1. describe and create/initiate our object
  constructor() {
      this.IPData = $('#IPData');
      this.status = this.IPData.data('status');

    if(this.status == 'yes' ) {
      
        $.getJSON('http://ip-api.com/json', data => {
              
            let PostID = $('#loveit-button').data('postid');
            
            $.ajax({
                beforeSend: (xhr) => {
                  xhr.setRequestHeader('X-WP-Nonce', jsData.nonceRest);
                },
                url: jsData.root_url + '/wp-json/recipe/v1/ipViews' ,
                type: 'POST',
                data: {
                  'city' : data.city,
                  'postId' : PostID
                },
                success: (response) => {
                  console.log(response);
                  
                },
                error: (response) => {
                  
                }
              });    


        });
    }
   
  }
 

}

export default IPViews;
