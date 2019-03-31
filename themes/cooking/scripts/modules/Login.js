
import $ from 'jquery';
class Login {
  // 1. describe and create/initiate our object
  constructor() {
   this.form = $("#yj-login-form");
   this.loginButton = this.form.find("#loginbutton");
   this.userEmail = this.form.find("#useremail");
   this.userPass = this.form.find("#password");
   this.errorEmail = this.form.find("#error-email");
   this.errorPassword = this.form.find("#error-password");
   this.loginErrMessage = this.form.find(".message-err");
   this.loginRedMessage = this.form.find(".message-red");
   this.redirect = this.form.find("#redirect_to");
   this.events();
  }

    events() {
        this.userEmail.on("blur", this.emailValidation.bind(this));
        this.userPass.on("blur", this.passValidation.bind(this));
        this.loginButton.on("click", this.loginfunc.bind(this));
    }

    emailValidation(){
      this.errorEmail.hide();
      var email = this.userEmail.val();
      if(email && !this.strongEmail(email)) {
        this.errorEmail.show();
        return false;
      }
    }

    passValidation(){
      this.errorPassword.hide();
      var password = this.userPass.val();
      if(password && !this.strongPassword(password)) {
        this.errorPassword.show();
        return false;
      }
    }


    loginfunc() {

      var that = this;
      this.errorEmail.hide();
      this.errorPassword.hide();
      var email = this.userEmail.val();
      var password = this.userPass.val();
      var redirect = this.redirect.val();

      console.log(redirect);


      if(!email) {
        this.errorEmail.show();
        return false;
      }

      if(email && !this.strongEmail(email)) {
        this.errorEmail.show();
        return false;
      }

      if(!password) {
        this.errorPassword.show();
        return false;
      }

      if(password && !this.strongPassword(password)) {
        this.errorPassword.show();
        return false;
      }
      $.ajax({

        url: jsData.ajax_url,
        dataType: "json",
        data: {
          'action': 'login', //
          'nonceLogin' : jsData.login_nonce, // nonce
          'email' : email,
          'password' :password,
          'redirect' : redirect
        },
        type: 'POST', // POST

        success:function(data){

        if(data.login == 'false') {
          that.form.find(".message-err").remove();
          var err_msg;
            switch(data.html) {
              case 'empty_username' : err_msg = 'You do have an email address, right?'; break;
              case 'empty_password' : err_msg = 'You need to enter a password to login.'; break;
              case 'invalid_email' : err_msg = 'We don\'t have any users with that email address. Maybe you used a different one when signing up?'; break;
              case 'incorrect_password' : err_msg = 'The password you entered wasn\'t quite right.'; break;
              case 'activation_failed' : err_msg = 'Please Activate your Account'; break;
            }
            
            that.form.prepend(`<div class="message-err">${err_msg} </div>`);
          }

            if(data.login == 'true') {
              that.form.prepend(`<div class="message-red">${data.html} </div>`);
              var url = data.redirect;
              console.log(url);
              $(location).attr('href',url);
            }
          }
        ,
        error: function(jqxhr, status, exception) {
          console.log('Exception:'+ exception);
        }
      });

      return false;
    }


    strongEmail(email) {
      var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
      return email_regex.test(email)  ;
    }

    strongPassword(pass) {
      return pass.length >= 6 ;
    }

}

export default Login;
