import $ from 'jquery';
class DropDown {
    // 1. describe and create/initiate our object
    constructor() {
     this.button = $("#cuisine");
     this.filterForm = $('#filter');
     this.loadMore =$('#loadMoreButton');
     this.events();
      }

    //  Event
    events() {
        this.button.on("change", this.moveMenu.bind(this));
        this.loadMore.on("click", this.loadMorefunc.bind(this));
       this.filterForm.on("submit", this.submitForm.bind(this));


    }


// Method


moveMenu() {
 var cuisineID = this.button.val();
     if(cuisineID){
      $.ajax({
          type:'POST',
          url:jsData.ajax_url,
          data:{

            action : 'getTermChild',
            cuisine_id: cuisineID
          },

          success:function(html){


              $("#category").empty().append(html);
                  }
             });
           }
        }


    loadMorefunc() {
      var page =  this.loadMore.data('page') ;
      var metaKey = this.loadMore.data('key');
      var newpage = page + 1;

      $.ajax({
    			url : jsData.ajax_url, // AJAX handler
    			data : {
    				'action': 'loadmorebutton', // the parameter for admin-ajax.php
    				'metaKey': metaKey, // loop parameters passed by wp_localize_script()
    				'page' : newpage // current page
    			},
    			type : 'POST',



    			success : ( data )=> {
            if( data ) {
              this.loadMore.data('page', newpage ) ;
    					$('.cardsContainer').append( data ); // insert new posts
            }

    					if (  newpage == 4 || !$.trim(data)){
    						this.loadMore.hide(); // if last page, HIDE the button
    				      }

    			},

          error : ( e )=> {
            console.log(e);
          }
    		});
    		return false;
    	}



submitForm() {

		$.ajax({
			url: this.filterForm.attr('action'),
			data: this.filterForm.serialize(), // form data
      dataType : 'json',
			type: this.filterForm.attr('method'), // POST

			success:function(data){

        // when filter applied:
				// set the current page to 1
				jsData.current_page = 1;

				// set the new query parameters
				jsData.posts = data.posts;

				// set the new max page parameter
				jsData.max_page = data.max_page;

        //	 this.filterForm.find('button').text('Apply filter'); // changing the button label back
      $('.cardsContainer').empty().html(data.content); // insert data


				// hide load more button, if there are not enough posts for the second page
				if ( data.max_page < 2 ) {
					$('#loadmore').hide();
				} else {
					$('#loadmore').show();
				}

			},
      error: function(jqxhr, status, exception) {
    alert('Exception:'+ exception);
}
		});
		return false;
}




}




  export default DropDown;
