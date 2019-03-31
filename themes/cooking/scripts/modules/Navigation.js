import $ from 'jquery';
class Navigation {
    // 1. describe and create/initiate our object
    constructor() {
     this.button = $("ul.parent > li");
    //  this.close = $(".subMenu");
     this.list = $(".subMenuList");
     this.events();
     this.isOpen = 0;
     this.openType;
     this.timerOn;
     this.prevMenu;
      }

    // 2. events
  events() {
     var self = this;
     
     this.button.each((i, elem) => {
        $(elem).on("mouseenter",self.subLogic.bind(self));
        $(elem).on("mouseleave",self.subLogic.bind(self));
      });
    }

      // Methods

      subLogic(e) {
        var menu = e.target.innerText
  
      //  if no submenu is open or if you moved from the submenu  to the menu execute OpenSub
      // argument : menu => is the ID of the menu entred . prevMenu => is the id of the previous menu entered
        if(!this.isOpen && e.type == 'mouseenter' && menu){  
          this.openSub(menu, this.prevMenu);

      //  if  submenu is open and you left to the menu not into the submenu execute closeSub 
        } else if(this.isOpen && e.type == 'mouseleave' && menu) {
          this.closeSub(e, menu);
          
        }
      }

      openSub(menu, prevMenu) { 
        console.log('o');
        this.list.find(`#${prevMenu}`).slideUp( {duration: 500, queue: false}).animate({duration: 700, opacity: 0}).removeClass("subMenu--active");
        this.list.find(`#${menu}`).slideDown( {duration: 500, queue: false}).animate({duration: 700, opacity: 1}, {queue: false}).addClass("subMenu--active");
      
        this.isOpen = 1;
        this.openType = menu;  
      }

      closeSub(e, menu) {
        console.log('c');
          var isSubmenu = (e.relatedTarget.className == 'subMenu subMenu--active');
          if( !isSubmenu) {
            if(this.openType == menu ){
              this.list.find(`#${menu}`).slideUp({queue: false}).animate({opacity: 0}).removeClass("subMenu--active");
            }
          }    
        this.isOpen = 0;
        this.prevMenu = menu;   
       
      }
  }

  export default Navigation;
