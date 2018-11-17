import $ from 'jquery';
class Navigation {
    // 1. describe and create/initiate our object
    constructor() {
     this.button = $("ul.parent > li");
     this.close = $(".subMenu");
     this.events();
     this.isOpen = 0;
      }

    // 2. events
  events() {
    var self = this;

      self.button.on("mouseenter", self.openSub );
      self.button.on("mouseleave", self.closeSub );
      self.close.on("mouseleave", self.closeSub );

      }

      // Methods

    openSub() {
      if(!self.isOpen){
        $(this).find('.subMenu').addClass("subMenu--active");
        self.isOpen = 1;
      }
      }

      closeSub(e) {
        if(self.isOpen) {
          if(e.currentTarget.localName =="div" ) {
            $(this).removeClass("subMenu--active");
          }
           else if (e.currentTarget.localName =="li" ){
            $(this).find('.subMenu').removeClass("subMenu--active");
          }
        }
        self.isOpen = 0;
        e.stopPropagation();

      }
  }

  export default Navigation;
