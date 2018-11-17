import $ from 'jquery';
class UploadProfilePic {

  constructor() {
    this.mediaUploader;
    this.attachement;
    this.events();
  }

  // events
  events() {
    $('#button_profile_image').on("click", this.uploadPic.bind(this));

  }

   uploadPic(e) {

     e.preventDefault();
     if (this.mediaUploader) {
       //console.log(this.mediaUploader);
       this.mediaUploader.open();
       return;
     }

     this.mediaUploader = wp.media.frames.file_frame = wp.media({
       title: 'Upload Your Nice Picture',
       button: {
         text: '3zeleee'
       },
       multiple: false
     });
     
     this.mediaUploader.on('select' , () => {
       this.attachement = this.mediaUploader.state().get('selection').first().toJSON();
       console.log(this.attachement);
       console.log('helloo');
       $('#submitted_profile_image').val(this.attachement.url);
     });

     this.mediaUploader.open();
   }

}

export default UploadProfilePic;
