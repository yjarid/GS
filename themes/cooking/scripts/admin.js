jQuery(document).ready(function($) {
    // edit Post Page 
    // delete an image 

    $(".admin_image_delete").on("click", edit_post_delete_image);
    $(".admin_image_setFI").on("click", edit_post_set_featured_image);

    function edit_post_delete_image(e){
        let imageCont =  $(e.target).closest(".admin_image");
        let image = imageCont.find("img");
        let imageID = image.data("img");

        $.ajax({

          beforeSend: (xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', jsData.rest_nonce);
          },
         url: jsData.root_url + '/wp-json/wp/v2/media/' + imageID + '?force=true' ,
            type: 'DELETE', 
                
            success:(data) => {
              imageCont.animate({width:'toggle'},350);
                console.log(data);
            },
            error: (res) => {
          console.log(res);
        }
          });
    }


    function edit_post_set_featured_image(e){
      let imageCont =  $(e.target).closest(".admin_image");
      let image = imageCont.find("img");
      let imageID = image.data("img");
      let postID = image.data("post");

      $.ajax({

        beforeSend: (xhr) => {
          xhr.setRequestHeader('X-WP-Nonce', jsData.rest_nonce);
        },
          url: jsData.root_url + '/wp-json/wp/v2/recipe/' + postID ,
          type: 'PUT', 
          data : {
            "featured_media": imageID
          },
              
          success:(data) => {
              console.log(data);
          },
          error: (res) => {
        console.log(res);
      }
        });
  }

  })