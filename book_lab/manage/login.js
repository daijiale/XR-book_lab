$(document).ready(function(){
    var name = $( "#name" );
    var password = $( "#password" );
    var nameInfo = $("#nameInfo");
    var passwordInfo = $("#passwordInfo");
    var login_button = $("#submit");
    
    //On blur
    name.blur(validateName);
    password.blur(validatePassword);

    //On key press
    name.keyup(validateName);
    password.keyup(validatePassword);

    //On Submitting
    login_button.click(function(){
        $("#warning_tips").remove();
        if(validateName() & validatePassword()) {
                $.post("login.php",{name:name.val(), password:password.val()},function(result){
                if (result == "true") {
                    //jump to reserve.htm
                    window.location.href="reserve.htm";
                } else {
                	//add warning to login.htm
                    $("#name-div").before("<div id='warning_tips' class='alert alert-block alert-error'>" +
                    	"<ul>" +
                    	"<li>Please enter a correct name and password." +
                    	"Note that both fields may be case-sensitive.</li>" +
                    	"</ul>" +
                    	"</div>"
                    );
                }
                });
            return true;
        }
        else
            return false;
    });
      
    function validateName(){
        var ret  = checkLength(name, 3, 16);
        if (!ret) {
            name.addClass("help-block error");
            nameInfo.text("The length of username may between 3 and 16.");
            nameInfo.addClass("help-block error");
            return false;
        }

        ret = checkRegexp(name, /^[a-z]([0-9a-z_])+$/i);
        if (!ret) {
            name.addClass("help-block error");
            nameInfo.text("Username may consist of a-z, 0-9, underscores, begin with a letter.");
            nameInfo.addClass("help-block error");
            return false;
        }

        name.removeClass("help-block error");
        nameInfo.text("what's your name");
        nameInfo.removeClass("help-block error");
        return true;
    
    }
    
    function validatePassword(){
        var ret  = checkLength(password, 5, 16);
        if (!ret) {
            password.addClass("help-block error");
            passwordInfo.text("The length of username may between 5 and 16.");
            passwordInfo.addClass("help-block error");
            return false;
        }

        password.removeClass("help-block error");
        passwordInfo.text("input your password");
        passwordInfo.removeClass("help-block error");
        return true;
    }

    function checkLength( o, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            return false;
        } else {
            return true;
        }
    }
 
    function checkRegexp( o, regexp ) {
        if ( !( regexp.test( o.val() ) ) ) {
            return false;
        } else {
            return true;
        }
    }
 
});