import $ from 'jquery';
class Search {
    // 1. describe and create/initiate our object
    constructor() {
      this.addSearchHTML();
      this.resultDiv = $("#search-overlay__results");
      this.openButton = $(".overlay");
      this.closeButton = $(".search-overlay__close");
      this.searchOverlay = $(".search-overlay");
      this.searchField = $("#search-term");
      this.events();
      this.isOverlayOpen = false;
      this.previousValue;
      this.typingTimer;
      this.spinnerVisible = false;
    }

    // events
    events() {
      this.openButton.on("click", this.openOverlay.bind(this));
      this.closeButton.on("click", this.closeOverlay.bind(this));
      $(document).on("keydown", this.keyDispatcher.bind(this) );
      this.searchField.on("keyup", this.typingLogic.bind(this) );

    }

    //methods
    typingLogic() {
      if(this.searchField.val() != this.previousValue ) {
        clearTimeout(this.typingTimer);
        if(this.searchField.val()) {
          if(!this.spinnerVisible) {
            this.resultDiv.html('<div class="spinner-loader"></div>');
            this.spinnerVisible = true ;
          }
            this.typingTimer = setTimeout(this.getResults.bind(this), 800);
        } else {
          this.resultDiv.html('');
          this.spinnerVisible = false ;
        }
      }
      this.previousValue = this.searchField.val();
    }


    getResults() {
      $.getJSON(jsData.root_url + '/wp-json/recipe/v1/search?key=' + this.searchField.val(), results => {
        this.resultDiv.html(`
          <div class = "container">
            <div class="one-third">
              <h2 class="search-overlay__section-title>General Info</h2>
              ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information</p>'}
                ${results.generalInfo.map(item => `<li><a href="${item.permalink} ">${item.title} </a>${item.type == 'post' ? `by ${item.authorName}` : ''} </li>`)}
              ${results.generalInfo.length ? '</ul>' : ''}
            </div>
            <div class="one-third">
              <h2 class="search-overlay__section-title">recipes</h2>
                ${results.recipe.length ? '<ul class="link-list min-list">' : '<p>No recipe</p>'}
                ${results.recipe.map(item => `<li><a href="${item.permalink} ">${item.title} </a> by ${item.authorName} </li>`)}
                ${results.recipe.length ? '</ul>' : ''}
              <h2 class="search-overlay__section-title">chef</h2>
                ${results.chef.length ? '<ul class="link-list min-list">' : '<p>No Chef</p>'}
                ${results.chef.map(item => `<li><a href="${item.permalink} ">${item.title} </a> </li>`)}
                ${results.chef.length ? '</ul>' : ''}
            </div>
            <div class="one-third">
              <h2 class="search-overlay__section-title">Events</h2>
                ${results.event.length ? '<ul class="link-list min-list">' : '<p>No Events</p>'}
                ${results.event.map(item => `<li><a href="${item.permalink} ">${item.title} </a></li>`)}
                ${results.event.length ? '</ul>' : ''}

              <h2 class="search-overlay__section-title">Location</h2>
                ${results.location.length ? '<ul class="link-list min-list">' : '<p>No Location</p>'}
                ${results.location.map(item => `<li><a href="${item.permalink} ">${item.title} </a> </li>`)}
                ${results.location.lengthtttt ? '</ul>' : ''}


            </div>
          </div>

          `);

          this.spinnerVisible = false;

      } );
    }

    keyDispatcher(e) {
      if(e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus') ) { this.openOverlay();}
      if(e.keyCode == 27 && this.isOverlayOpen) { this.closeOverlay();}
    }

    openOverlay() {
      this.searchOverlay.addClass("search-overlay--active");
      $("body").addClass("body-no-scroll");
      this.searchField.val('');
      setTimeout(() => this.searchField.focus(), 301);
      this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
    }

    addSearchHTML() {
      $("body").append(`
        <div class="search-overlay">
          <div class="search-overlay__top">
            <div class="container">
              <a href="#"><span class="icon--facebook icon search-overlay__icon"></span></a>
              <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
                <a href="#"><span class="icon--facebook icon search-overlay__close"></span></a>
            </div>
          </div>
          <div class="container">
            <div id="search-overlay__results">

            </div>
          </div>
        </div>
        `)
    }

  }

  export default Search;
