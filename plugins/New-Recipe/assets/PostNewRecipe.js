jQuery(document).ready(function($) {

      var mediaUploader;
      var attachement;
      var form = $("#front-end-post-form");
      var submit = $("#post_form_submit");
      var errMessage = [];
      var image_container = $(".uploaded-image-container");
    
      
    //   Event 
  
    $('#new_recipe_image').on("click", uploadPostPic);
    form.on("submit", newPostSaving);

    //  
    // Events  Callback Functions 
    // 
    // 

  
      function uploadPostPic(e) {
        e.preventDefault();
        if (mediaUploader) {
          mediaUploader.open();
          return;
        }
  
        mediaUploader = wp.media.frames.file_frame = wp.media({
          title: 'Upload Post Images',
          button: {
            text: 'Select'
          },
          multiple: true
        });
        
        mediaUploader.on('select' , () => {
          attachement = mediaUploader.state().get('selection').toJSON().slice(0, 5);
          console.log(attachement);
        
         
  
          attachement.forEach((val, i)=> {
            var image_saved = $('#recipe_image_' + i) ;
            
            image_saved.val(val.sizes.medium.url);
  
          
              image_container.removeClass("hidden").addClass("uploaded-image-grid").find(".saved_image_" + i).find('img').attr('src', image_saved.val() ).slideUp().slideDown(2000);
             
              $('html, body').animate({
                scrollTop: (image_container.offset().top)
               },4000);
          });
        
  
        });
  
        mediaUploader.open();
      }


  
      function newPostSaving(e) {
        
        e.preventDefault();
  
              // disable the submit button to prevent multiple sent
        submit.attr("disabled", true);
  
        // to allow the value from the tinymce to be saved otherwise the first submit will send empty fields for the wysiwyg 
        tinyMCE.triggerSave();
  
        var formData = getFormData(form);
        
        if(!newRecipeHandler(formData))   {
            submit.removeAttr("disabled");
            return false;  
        }
       
        $.ajax({
  
          url: jsData.ajax_url,
          dataType: "json",
          data: {
            'action': 'newPostForm', //
            'nonceFilter' : jsData.filter_nonce, // nonce
            'formData' : formData, 
            'attachement' : attachement ,
          },
          type: 'POST', // POST
  
          success:function(data){
            form.find(".message").remove();
            if(data) {
                   
              if(data.postCreated =='false'){
               
                form.prepend(`<div class="message message-err">${data.html} </div>`);
              }
    
              if(data.postCreated == 'true') {
                // add success message + reset form to emty + scroll up to the success message
                form.prepend(`<div class="message message-red">${data.html} </div>`);
                form[0].reset();
  
                for(var i=0 ; i < attachement.length; i++) {
                  image_container.addClass('hidden').find(".saved_image_" + i).find('img').attr('src', '' );
                }
                
  
                $('html, body').animate({
                  scrollTop: (form.offset().top)
                 },600);
  
                //  enable the submit button
                submit.removeAttr("disabled");
              }
            }
  
          },
          error: function(jqxhr, status, exception) {
            form.find(".message").remove();
            console.log('Exception:'+ exception);
  
            //  enable the submit button
            submit.removeAttr("disabled");
      }
        });
      return false;
    }

    //  
    // Helper Functions 
    // 
    // 

  
    function getFormData(form){
      var unindexed_array = form.serializeArray();
      var indexed_array = {};
  
      $.map(unindexed_array, function(n, i){
          indexed_array[n['name']] = n['value'];
      });
  
      return indexed_array;
    }
  
   function  newRecipeHandler(formData) {
  
      
      let recipeData = {
        new_recipe_title : {
          obj: form.find("#new_recipe_title"),
          maxChar: 50
        },
        new_recipe_description : {
          obj: form.find("#new_recipe_description"),
          maxChar: 250
        },
        new_recipe_ingredient :  {
          obj: form.find("#new_recipe_ingredient"),
          maxChar: 1000
        },
        new_recipe_prep :  {
          obj: form.find("#new_recipe_prep"),
          maxChar: 2000 
        },
        new_recipe_taxonomy :  {
          obj: form.find("#new_recipe_taxonomy"),
        },
        recipe_image_0 :  {
          obj: form.find("#new_recipe_image"),
        }
  
      }
  
        // remove the previous err message and clean the array of errors 
      $.each(recipeData, function(key, elem) {   
        let index = $.inArray(key, errMessage);
        if( index !== -1) {
          elem.obj.prevAll('div.message-err-postRecipe').remove();
          elem.obj.removeClass("border-red");
          errMessage.splice( index, 1 ); 
        }
        
        // if the field is empty dispaly the error message and push to the array
        var textAreaVal = $.trim(formData[key].replace(/\s+/g, " "));
        var textAreaLength = textAreaVal.length;
  
        if(textAreaVal.length===0){ 
          elem.obj.parent().closest('div').prepend(`<div class="message-err-postRecipe">**This field is required </div>`);
          elem.obj.addClass("border-red");
          errMessage.push(key);
        }
  
        if(elem.maxChar && textAreaLength > elem.maxChar ){ 
          elem.obj.parent().closest('div').prepend(`<div class="message-err-postRecipe">max Character is ${elem.maxChar} you wrote ${textAreaLength} </div>`);
          elem.obj.addClass("border-red");
          errMessage.push(key);
        }
  
    });
  
  
  
    if(errMessage.length !== 0) return false;
  
    return true;
    }
  });
  