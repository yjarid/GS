$(document).ready(function() {
    $('#_add_cuisine_image').on('click', (e) => {
        console.log('hello');

            e.preventDefault();

            var mediaUploader;
          
            if (mediaUploader) {
              mediaUploader.open();
              return;
            }
       
            mediaUploader = wp.media.frames.file_frame = wp.media({
              title: 'Upload Cuisine Avatar',
              button: {
                text: 'Select'
              },
              multiple: false
            });
            
            mediaUploader.on('select' , () => {
              var attachement = mediaUploader.state().get('selection').first().toJSON();
              console.log(attachement.sizes.thumbnail);
       
              $('#cuisine_image').val(attachement.sizes.thumbnail.url);
              $('#cuisine-image-container').find('img').attr('src', attachement.sizes.thumbnail.url );
       
            });
            mediaUploader.open();
          
    });
});