import $ from 'jquery';
class FilterPost {
    // 1. describe and create/initiate our object
    constructor() {

     this.button = $("#cuisine");
     this.filterForm = $('#filter');
     this.loadMoreFilter = $('#loadMoreButtonFilter');
     this.cardsContainerSpinner = $("#cardsContainer--withSpinner");
     this.events();

      }

    //  Event
    events() {

         this.filterForm.on("submit", this.submitForm.bind(this));
    }


// Method




submitForm() {
 
  var buttonHidden = false;
  var that = this;
  var meal = this.filterForm.find("#meal").val();
  var ingredient = this.filterForm.find("#ingredient").val();
  this.cardsContainerSpinner.html('<div class="spinner-loader"></div>');
		$.ajax({

  		url: jsData.ajax_url,
      dataType: "json",
			data: {
        'action': 'myfilter', //
        'nonceFilter' : jsData.filter_nonce, // nonce
        'meal' : meal,
        'ingredient' :ingredient
      },
     	type: 'POST', // POST

			success:function(data){
        if(data) {
          setTimeout(()=> {
            that.cardsContainerSpinner.html('<div class="cardsContainer" id="recipeCards"></div>');
            $('#recipeCards').html((data.html));
          }, 1000);

          var maxPage = data.max;
          that.loadMoreFilter.data('max', maxPage);
          

          if(that.loadMoreFilter.data('max') == 1) {
            that.loadMoreFilter.hide();
          } else {
            that.loadMoreFilter.show();
          }
        }
			},
      error: function(jqxhr, status, exception) {
    console.log('Exception:'+ exception);
}
		});
		return false;
}

}




  export default FilterPost;
