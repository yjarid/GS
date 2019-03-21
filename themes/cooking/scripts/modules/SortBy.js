import $ from 'jquery';
class SortBy {
    // 1. describe and create/initiate our object
    constructor() {

     this.select = $("#sortBy");
     this.loadMoreSort = $('#loadMoreButtonSort');
     this.cardsContainerSpinner = $("#cardsContainer--withSpinner");
     this.events();


      }

    //  Event
    events() {

        this.select.on("change", this.sortRecipes.bind(this));

    }


// Method


    sortRecipes() {
      var that = this;
      var sortBy = this.select.val();
      var term = this.select.data('term');
      var tax = this.select.data('tax');

      this.cardsContainerSpinner.html('<div class="spinner-loader"></div>');


      $.ajax({
          url : jsData.ajax_url,
          dataType: "json",
          data : {
            'action': 'sortRecipes', //
            'nonceSort' : jsData.sort_nonce,// nonce
            'sortBy': sortBy, //
            'term' : term,
            'tax' : tax

          },

          type : 'POST',



          success : ( data )=> {
            if( data ) {

              setTimeout(()=> {
                that.cardsContainerSpinner.html('<div class="cardsContainer" id="sortCards"></div>');
                $('#sortCards').html(data.html);
              }, 1000);
              var maxPage = data.max;
              that.loadMoreSort.data('max', maxPage);

              if(that.loadMoreSort.data('max') == 1) {
                that.loadMoreSort.hide();
              } else {
                that.loadMoreSort.show();
              }
            }



          },

          error : ( e )=> {
            console.log(e);
          }
        });

        return false;

    }

}




  export default SortBy;
