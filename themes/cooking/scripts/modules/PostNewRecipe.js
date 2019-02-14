import $ from 'jquery';
class PostNewRecipe {

  constructor() {
    this.mediaUploader;
    this.attachement;
    this.form = $("#front-end-post-form");
    this.submit = $("#post_form_submit");
    this.errMessage = [];
    this.events(); 
    this.image_container = $(".uploaded-image-container");
  }

  // events
  events() {
    $('#new_recipe_image').on("click", this.uploadPostPic.bind(this));
    this.form.on("submit", this.newPostSaving.bind(this));
  }


    uploadPostPic(e) {
      var that = this ;
      e.preventDefault();
      if (this.mediaUploader) {
        this.mediaUploader.open();
        return;
      }

      this.mediaUploader = wp.media.frames.file_frame = wp.media({
        title: 'Upload Post Images',
        button: {
          text: 'Select'
        },
        multiple: true
      });
      
      this.mediaUploader.on('select' , () => {
        this.attachement = this.mediaUploader.state().get('selection').toJSON().slice(0, 5);
        console.log(this.attachement);
      
       

        this.attachement.forEach((val, i)=> {
          var image_saved = $('#recipe_image_' + i) ;
          
          image_saved.val(val.sizes.medium.url);

        
            that.image_container.removeClass("hidden").addClass("uploaded-image-grid").find(".saved_image_" + i).find('img').attr('src', image_saved.val() ).slideUp().slideDown(2000);
           
            $('html, body').animate({
              scrollTop: (that.image_container.offset().top)
             },4000);
        });
      

      });

      this.mediaUploader.open();
    }

    newPostSaving(e) {
      
      e.preventDefault();

      var that = this;

      // disable the submit button to prevent multiple sent
      that.submit.attr("disabled", true);

      // to allow the value from the tinymce to be saved otherwise the first submit will send empty fields for the wysiwyg 
      tinyMCE.triggerSave();

      var formData = this.getFormData(this.form);

     if(!this.newRecipeHandler(formData))   return false;    

      $.ajax({

        url: jsData.ajax_url,
        dataType: "json",
        data: {
          'action': 'newPostForm', //
          'nonceFilter' : jsData.filter_nonce, // nonce
          'formData' : formData, 
          'attachement' : this.attachement ,
        },
        type: 'POST', // POST

        success:function(data){
          that.form.find(".message").remove();
          if(data) {
                 
            if(data.postCreated =='false'){
             
              that.form.prepend(`<div class="message message-err">${data.html} </div>`);
            }
  
            if(data.postCreated == 'true') {
              // add success message + reset form to emty + scroll up to the success message
              that.form.prepend(`<div class="message message-red">${data.html} </div>`);
              that.form[0].reset();

              for(var i=0 ; i < that.attachement.length; i++) {
                that.image_container.addClass('hidden').find(".saved_image_" + i).find('img').attr('src', '' );
              }
              

              $('html, body').animate({
                scrollTop: (that.form.offset().top)
               },600);

              //  enable the submit button
               that.submit.removeAttr("disabled");
            }
          }

        },
        error: function(jqxhr, status, exception) {
          that.form.find(".message").remove();
          console.log('Exception:'+ exception);

          //  enable the submit button
          that.submit.removeAttr("disabled");
    }
      });
    return false;
  }

  getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
  }

  newRecipeHandler(formData) {

    let that = this ;
    let recipeData = {
      new_recipe_title : {
        obj: this.form.find("#new_recipe_title"),
        maxChar: 50
      },
      new_recipe_description : {
        obj: this.form.find("#new_recipe_description"),
        maxChar: 250
      },
      new_recipe_ingredient :  {
        obj: this.form.find("#new_recipe_ingredient"),
        maxChar: 1000
      },
      new_recipe_prep :  {
        obj: this.form.find("#new_recipe_prep"),
        maxChar: 2000 
      },
      new_recipe_taxonomy :  {
        obj: this.form.find("#new_recipe_taxonomy"),
      },
      recipe_image_0 :  {
        obj: this.form.find("#new_recipe_image"),
      }

    }

      // remove the previous err message and clean the array of errors 
    $.each(recipeData, function(key, elem) {   
      let index = $.inArray(key, that.errMessage);
      if( index !== -1) {
        elem.obj.prevAll('div.message-err-postRecipe').remove();
        elem.obj.removeClass("border-red");
        that.errMessage.splice( index, 1 ); 
      }
      
      // if the field is empty dispaly the error message and push to the array
      var textAreaVal = $.trim(formData[key].replace(/\s+/g, " "));
      var textAreaLength = textAreaVal.length;

      if(textAreaVal.length===0){ 
        elem.obj.parent().closest('div').prepend(`<div class="message-err-postRecipe">**This field is required </div>`);
        elem.obj.addClass("border-red");
        that.errMessage.push(key);
      }

      if(elem.maxChar && textAreaLength > elem.maxChar ){ 
        elem.obj.parent().closest('div').prepend(`<div class="message-err-postRecipe">max Character is ${elem.maxChar} you wrote ${textAreaLength} </div>`);
        elem.obj.addClass("border-red");
        that.errMessage.push(key);
      }

  });



  if(that.errMessage.length !== 0) return false;

  return true;
  }
}


export default PostNewRecipe;
