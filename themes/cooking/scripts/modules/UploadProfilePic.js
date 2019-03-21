import $ from 'jquery';
class UploadProfilePic {

  constructor() {
    this.mediaUploader;
    this.attachement;
    this.form = $('#front-end-profile');
    this.events();

  }

  // events
  events() {
    this.form.find('#button_profile_image').on("click", this.uploadProfilPic.bind(this));  
  }

  uploadProfilPic(e) {

     e.preventDefault();
   
     if (this.mediaUploader) {
       this.mediaUploader.open();
       return;
     }

     this.mediaUploader = wp.media.frames.file_frame = wp.media({
       title: 'Upload Profile Picture',
       button: {
         text: 'Select'
       },
       multiple: false
     });
     
     this.mediaUploader.on('select' , () => {
       this.attachement = this.mediaUploader.state().get('selection').first().toJSON();
       console.log(this.attachement.sizes.thumbnail);

       $('#user_picture').val(this.attachement.sizes.thumbnail.url);
       $('#avatar-image-container').find('img').attr('src', $('#user_picture').val() );

     });
     this.mediaUploader.open();
   }
 

  }



export default UploadProfilePic;
