import $ from 'jquery';
class Register {

  // 1. describe and create/initiate our object
  constructor() {
   this.form = $("#yj-register-form");
   this.loginButton = this.form.find("#registerbutton");
   // this.userName = this.form.find("#registerName");
   this.userEmail = this.form.find("#registeremail");
   this.userPass = this.form.find("#registerPassword");
   this.errorEmail = this.form.find("#reg-error-email");
   this.errorPass = this.form.find("#reg-error-password");
   this.registerStatusMessage = this.form.find("#reg-status");
   console.log('hello');
   this.events();
    }

    events() {
        this.userEmail.on("blur", this.emailValidation.bind(this));
        this.userPass.on("blur", this.passValidation.bind(this));
        this.loginButton.on("click", this.registerfunc.bind(this));
    }



    emailValidation(){
      this.errorEmail.hide();
      var email = $.trim(this.userEmail.val());

      if(email && !this.strongEmail(email)) {
        this.userEmail.removeClass('success');
        this.userEmail.addClass('fail');
        this.errorEmail.show();
        return false;
      }
      this.userEmail.removeClass('fail');
      this.userEmail.addClass('success');

    }

    passValidation(){
      this.errorPass.hide();
      var pass = this.userPass.val().toLowerCase();
      pass = pass.replace(/ /g,'');

      if(pass && !this.strongPass(pass)) {
        this.userPass.removeClass('success');
        this.userPass.addClass('fail');
        this.errorPass.show();
        return false;
      }
      this.userPass.removeClass('fail');
      this.userPass.addClass('success');
    }


    registerfunc(e) {

      var that = this;
      this.errorEmail.hide();
      this.errorPass.hide();

      var email = this.userEmail.val();
      var pass = this.userPass.val();


      if(!email) {
        this.userEmail.removeClass('success');
        this.userEmail.addClass('fail');
        this.errorEmail.show();
        return false;
      }

      if(email && !this.strongEmail(email)) {
        this.userEmail.removeClass('success');
        this.userEmail.addClass('fail');
        this.errorEmail.show();
        return false;
      }

      if(!pass) {
        this.userPass.removeClass('success');
        this.userPass.addClass('fail');
        this.errorPass.show();
        return false;
      }

      if(pass && !this.strongPass(pass)) {
        this.userPass.removeClass('success');
        this.userPass.addClass('fail');
        this.errorPass.show();
        return false;
      }

      this.registerStatusMessage.html('Wait we are regigistring you ...');

      $.ajax({
        url: jsData.ajax_url,
        dataType: "json",

        data: {
          'action': 'register', //
          'nonceRegister' : jsData.register_nonce, // nonce
          'email' : email,
          'pass' :pass
        },
        type: 'POST', // POST

        success:function(data){


          if(data) {

            if(data.reg == 'false') {
                var err_msg;
                  switch(data.html) {
                    case 'existing_user_email' : err_msg = 'this email address exist?'; break;
                     default: err_msg = 'Something is wrong please verify your login info';
                    }
                  that.registerStatusMessage.html(err_msg);
              }

            if(data.reg == 'true') {
              that.registerStatusMessage.html(data.html);
              var url = jsData.root_url +'/register/?register=true';
              $(location).attr('href',url);

            }
          }
        },
        error: function(jqxhr, status, exception) {
      console.log('Exception:'+ exception);

  }
      });


      return false;

    }

    strongName(name) {
      var name_regex = /^[a-zA-Z0-9._-]{6,20}$/i;
      return name_regex.test(name)  ;
    }

    strongEmail(email) {
      var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
      return email_regex.test(email)  ;
    }

    strongPass(pass) {
      return pass.length >= 6 ;
    }

}

export default Register;
