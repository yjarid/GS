import $ from 'jquery';
class MobileMenu {
  constructor() {

    this.button = $(".menuIcon");
    this.nav = $(".main-navigation");
    this.header = $(".headerNav");
    this.events();
  }

  events() {
    var self = this;
    self.button.on("click", self.toggleMenu.bind(this) );
    }

  toggleMenu() {
      this.nav.toggleClass('main-navigation-is-visible');
      this.header.toggleClass('headerNav-background');
      this.button.toggleClass('menuIcon__close');

    }
  }


export default MobileMenu;
