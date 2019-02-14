import $ from 'jquery';
class Comment {
    // 1. describe and create/initiate our object

    constructor() {
        this.form = $("#commentform");
        this.textArea = this.form.find("#comment");
        this.submitBtn = this.form.find("#submit");
        this.commentRatingContainer = this.form.find("#comments-rating-container");
        this.events();
        console.log('helooooppp');

    }

    // events
     events() {

        this.submitBtn.on("click", this.commentFormHandle.bind(this));
      
     }

    //methods
    commentFormHandle(e) {
        // e.preventDefault();
        var textAreaVal = $.trim(this.textArea.val().replace(/\s+/g, " "));
        var countTextAreaCharacter = textAreaVal.length;
        var rating = this.form.find("input[name=rating]:checked").val();
        var errMessage = this.form.find(".message-err-comment");

        if(!rating) {
            if( errMessage)  errMessage.remove();
            

            this.commentRatingContainer.prepend("<div class='message-err-comment '>Please give a Rating</div>");
            return false;
        }

        if(countTextAreaCharacter > 500 || countTextAreaCharacter < 10) {
            if( errMessage)  errMessage.remove();

            this.commentRatingContainer.prepend(`<div class='message-err-comment'>You wrote ${countTextAreaCharacter} letter, The message should be between 5 and 500 letters</div>`);
            return false;
        }

        if( errMessage)  errMessage.remove();

        console.log(countTextAreaCharacter);
        

   }
}

export default Comment;