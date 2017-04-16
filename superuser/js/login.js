//HANDLES LOGGING IN AND SIGNING UP
$(document).ready(function(){
    var ajax_handler_path = "../handlers/ajax_handler.php";
    
    //Returns if true if the input is considered valid, used for AJAX responses
    function IsValid(input)
    {
        return (input!=false && input!=null && (typeof(input)!="undefined"));
    }
    
    //Validate signup info
    function ValidateSignup(data,$form_inputs)
    {
        var MIN_PASS_LENGTH = 8;
        var pass = data["password"];
        var confirm_pass = data["confirm_pass"];
        
        var empty_found = false;
        //If any value is blank
        $form_inputs.each(function(){
            if($(this).val() == "") 
            {
                empty_found = true;
                $(this).parent().addClass("has-error");
             
                toastr.options.preventDuplicates = true;
                toastr.error("Ensure you have filled in all fields","One or more fields are empty");
            }
        });
        
        //If any empty input field was found
        if(empty_found)
        {
            return false;
        }
        
        
        var pass_is_valid = true;
        var $input_pass = $(".form-control#password");
        var $input_confirm_pass = $(".form-control#confirm_pass");
        
        //check if passwords are within an acceptable range
        if(pass.length<MIN_PASS_LENGTH)
        {
            toastr.error("Password must be at least "+MIN_PASS_LENGTH+" characters long","Password too short");
            pass_is_valid = false;
            
            $input_pass.parent().addClass("has-error");
            $input_confirm_pass.parent().addClass("has-error");
        }
        
        //check if passwords match
        if(pass != confirm_pass)
        {
            toastr.error("Passwords do not match");
            pass_is_valid = false;
            
            $input_pass.parent().addClass("has-error");
            $input_confirm_pass.parent().addClass("has-error");
        }
        
        return pass_is_valid;
    }
    
    //Signup ajax request
    function AttemptSignup(data,$form_inputs)
    {
        $.post(ajax_handler_path,{"action":"SuperuserSignup","data":data},function(response,status){
            if(IsValid(response))
            {
                $form_inputs.attr("disabled");
                //When the toast disappears, redirect to the login page
                toastr.options.onHidden = function() { window.location = ("login.php"); }
                toastr.success("Redirecting to login page...","Successfully created the superuser account");
            }
        });
    }
    
    //Signup button clicked
    $("#btn-signup").click(function(){
        var $form = $(this).parents("form#signupform");
        var $form_inputs = $form.find(".form-control");
        
        $form_inputs.parent().removeClass("has-error");
        
        var first_name = $form.find("#firstname").val();
        var last_name = $form.find("#lastname").val();
        var username = $form.find("#username").val();
        var email = $form.find("#email").val();
        var password = $form.find("#password").val();
        var confirm_pass = $form.find("#confirm_pass").val();
        
        var data = {
        "first_name":first_name,
        "last_name":last_name,
        "username":username,
        "email":email,
        "password":password,
        "confirm_pass":confirm_pass
        };
        
        //Validate signup info
        if(ValidateSignup(data,$form_inputs))
        {
            AttemptSignup(data,$form_inputs);
        }
    });    
    
    //Validate login info
    function ValidateLogin($form_inputs)
    {
        var is_valid = true;
        $form_inputs.each(function(){
            if($(this).val()=="")
            {
                $(this).parent().addClass("has-error");
                is_valid = false;
            }
        });
        
        return is_valid;
    }
    
    //Login
    function AttemptLogin(data,$form_inputs)
    {
        $.post(ajax_handler_path,{"action":"SuperuserLogin","data":data},function(response,status){
            
            if(IsValid(response))
            {
                $form_inputs.attr("disabled");
                //When the toast disappears, redirect to the home page
                toastr.options.onHidden = function() { window.location = ("index.php"); }
                toastr.success("Redirecting to superuser dashboard...","Login successful");
            }
            else
            {
                toastr.error("The email/password combination you entered was incorrect. Try again","Login failed");   
            }
        });
           
    }
    
    //Login button clicked
    $("#btn-login").click(function(){
        var $form =  $(this).parents("form#loginform");
        var $form_inputs = $form.find(".form-control");
        var $input_email = $form.find("#login-email");
        var $input_password = $form.find("#login-password");
        
        $form_inputs.parent().removeClass("has-error");
        var data = {
            "email":$input_email.val(),
            "password":$input_password.val()
        }
        var is_valid = ValidateLogin($form_inputs);
        console.log(is_valid);
        if(is_valid)
        {
            AttemptLogin(data,$form_inputs);    
        }
    });
});