import $ from 'jquery';
class LoadMore {
    // 1. describe and create/initiate our object
    constructor() {
      this.loadMore =$('#loadMoreButton');
      this.loadMoreFilter = $('#loadMoreButtonFilter');
      this.loadMoreSort = $('#loadMoreButtonSort');
      this.events();
     this.loading = false;
    }

    events(){
      this.loadMore.on("click", {clickedButton : this.loadMore } ,this.loadMorefunc.bind(this));
      this.loadMoreFilter.on("click", {clickedButton : this.loadMoreFilter }, this.loadMorefunc.bind(this));
      this.loadMoreSort.on("click", {clickedButton : this.loadMoreSort }, this.loadMorefunc.bind(this));
    }

    loadMorefunc(button) {
      

      if(!this.loading) {
        var page =  button.data.clickedButton.data('page') ;
        var max_pages = button.data.clickedButton.data('max');
        var newpage = page + 1;
        console.log(newpage);
        console.log(max_pages);
        if(max_pages === 1 && newpage  == max_pages){
          button.data.clickedButton.hide();
          return false;
        }
        button.data.clickedButton.find(".text").slideUp(400);
        button.data.clickedButton.find(".icon").addClass("spin");
     
        this.loading = true;
        

        if(button.data.clickedButton == this.loadMore) {
          var metaKey = this.loadMore.data('key');
        }

        if(button.data.clickedButton == this.loadMoreFilter){
          var filterForm = $('#filter');
          var meal = filterForm.find("#meal").val();
          var ingredient = filterForm.find("#ingredient").val();
        }

        if(button.data.clickedButton == this.loadMoreSort) {
          var sortBy = $('#sortBy');
          var sortByValue = sortBy.val();
          var tax = sortBy.data('tax');
          var term = sortBy.data('term');
        };


        $.ajax({
            url : jsData.ajax_url,
            data : {
              'action': 'loadmorebutton', //
              'metaKey': metaKey, //
              'page' : newpage,
              'nonce' : jsData.ajax_nonce, // nonce
              'meal' : meal,
              'ingredient' :ingredient,
              'sortBy' : sortByValue,
              'tax' : tax,
              'term' : term
            },
            type : 'POST',



            success : ( data )=> {
              if( data ) {

                button.data.clickedButton.data('page', newpage ) ;

                $('.cardsContainer').append( data ); // insert new posts
                  button.data.clickedButton.find(".text").slideDown(400);
                  button.data.clickedButton.find(".icon").removeClass("spin");
                  this.loading = false;

              }


                if (  newpage == 4 || newpage == max_pages  ) {
                    button.data.clickedButton.hide().find(".icon").removeClass("spin"); // if last page, HIDE the button

                    }

            },

            error : ( e )=> {
              console.log(e);
            }
          });

          return false;

        }
    	}

}

export default LoadMore;
