$(document).ready(function(){
    var realname  = $("#realname");
    var username  = $("#username");
    var jobnumber = $("#jobnumber");
    var onecard   = $("#onecard");
    var identity  = $("#identity");
    var sex       = $("#sex");
    var email     = $("#email");
    var tel       = $("#tel");
    var password  = $( "#password" );

    var realnameInfo  = $("#realnameInfo");
    var usernameInfo  = $("#usernameInfo");
    var jobnumberInfo = $("#jobnumberInfo");
    var onecardInfo   = $("#onecardInfo");
    var identityInfo  = $("#identityInfo");
    var emailInfo     = $("#emailInfo");
    var telInfo       = $("#telInfo");
    var passwordInfo  = $("#passwordInfo");

    var createButton  = $("#createAccount");

    var ERROR_CSS_CLASS = "help-block error";
    
    //On blur
    realname.blur(validateRealName);
    username.blur(validateUserName);
    jobnumber.blur(validateJobNumber);
    onecard.blur(validateOneCard);
    identity.blur(validateIdentity);
    email.blur(validateEmail);
    tel.blur(validateTel);
    password.blur(validatePassword);

    //On key press
    realname.keyup(validateRealName);
    username.keyup(validateUserName);
    jobnumber.keyup(validateJobNumber);
    onecard.keyup(validateOneCard);
    identity.keyup(validateIdentity);
    email.keyup(validateEmail);
    tel.keyup(validateTel);
    password.keyup(validatePassword);

    //On Submitting
    createButton.click(function(){
        if(validateName() & validatePassword()) {
            $.post("register.php",
                    {realname : realname .val(),
                    username  : username .val(),
                    jobnumber : jobnumber.val(),
                    onecard   : onecard  .val(),
                    identity  : identity .val(),
                    email     : email    .val(),
                    tel       : tel      .val(),
                    password  :password  .val()},
                    function(result) {
                        if (result == "true") {
                            //jump to reserve.htm
                            window.location.href="reserve.htm";
                        } else {
                	        //add warning to register.htm
                            $("#name-div").before("<div class='alert alert-block alert-error'>" +
                    	    "<ul>" +
                    	    "<li>Please check your information." +
                    	    "Note that all fields may be case-sensitive.</li>" +
                    	    "</ul>" +
                    	    "</div>");
                        }
                    });
            return true;
        }
        else
            return false;
    });

    function validateRealName() {
        var ret = checkLength(realname, realnameInfo, 2, 16);
        if (!ret) {
            return false;
        } else {
            return true;
        }
    }
      
    function validateUserName() {
        var ret  = checkLength(username, usernameInfo, 3, 16);
        if (!ret) {
            return false;
        }

        ret = checkRegexp(username, usernameInfo, /^[a-z]([0-9a-z_])+$/i,
            "Username may consist of a-z, 0-9, underscores, begin with a letter.");
        if (!ret) {
            return false;
        }

        return true;
    }

    function validateJobNumber() {
        var ret = checkLength(jobnumber, jobnumberInfo, 6, 20);
        if (!ret) {
            return false;
        }

        ret = checkRegexp(jobnumber, jobnumberInfo, /^[0-9]+$/i,
            "jobnumber only consist of 0-9.");
        if (!ret) {
            return false;
        }

        return true;
    }

    function validateOneCard() {
        var ret = checkLength(onecard, onecardInfo, 8, 12);
        if (!ret) {
            return false;
        }

        ret = checkRegexp(onecard, onecardInfo, /^[0-9]+$/i,
            "One-card only consist of 0-9");
        if (!ret) {
            return false;
        }

        return true;
    }

    function validateIdentity() {
        var ret = checkRegexp(identity, identityInfo, /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/,
            "The ID card No. is illegal");
        if (!ret) {
            return false;
        }

        return true;
    }

    function validateEmail() {
        var ret = checkRegexp(email, emailInfo, /^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$/,
            "The email is illegal");
        if (!ret) {
            return false;
        }

        return true;
    }

    function validateTel() {
        var ret = checkLength(tel, telInfo, 7, 11);
        if (!ret) {
            return false;
        }

        ret = checkRegexp(tel, telInfo, /^[0-9]+$/i,
            "The tel only consist of 0-9");
        if (!ret) {
            return false;
        }

        return true;
    }
    
    function validatePassword() {
        var ret  = checkLength(password, passwordInfo, 5, 16);
        if (!ret) {
            return false;
        }

        return true;
    }

    function checkLength( input, inputInfo, min, max) {
        if (input.val().length > max || input.val().length < min) {
            input.addClass(ERROR_CSS_CLASS);
            inputInfo.text("The length of " + input.attr("name") + 
                " should between " + min + " and " + max);
            inputInfo.addClass(ERROR_CSS_CLASS);
            return false;
        } else {
            input.removeClass(ERROR_CSS_CLASS);
            inputInfo.text("");
            inputInfo.removeClass(ERROR_CSS_CLASS);
            return true;
        }
    }
 
    function checkRegexp(input, inputInfo, regexp, tips) {
        if (!(regexp.test(input.val()))) {
            input.addClass(ERROR_CSS_CLASS);
            inputInfo.text(tips);
            inputInfo.addClass(ERROR_CSS_CLASS);
            return false;
        } else {
            input.removeClass(ERROR_CSS_CLASS);
            inputInfo.text("");
            inputInfo.removeClass(ERROR_CSS_CLASS);
            return true;
        }
    }
 
});