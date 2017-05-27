$(document).ready(function(){

    var ajax_handler_path = "../handlers/ajax_handler.php";

//    $("#item_files").file
    //Initialize file input plugin
    $("#item_files").fileinput({
        uploadAsync: false,
        showUpload:false,
        uploadUrl: "../handlers/ajax_handler.php", // your upload server url
        uploadExtraData: function() {
            console.log("Initialized");
            return {
                userid: $("#userid").val(),
                username: $("#username").val()
            };
        }
    });
    
//    $('#item_files').fileinput('disable')
    
    function ValidateInputs($input_list)
    {
        toastr.options.preventDuplicates = true;
        //If the input list is undefined
        if($input_list == "undefined" || $input_list.length == 0)
        {
            return null;
        }

        //Input containers found.
        var $input_containers = $input_list.find(".input-container")

        var is_valid = true;//If the content is valid ~ defaults to true
        var error_class = "has-error";
        //var success_class = "has-success";

        //Check each item and show message if they are valid or invalid
        $input_containers.each(function(){
            $self = $(this);

            var $input_array = $(this).children("input,textarea");
            var is_required = typeof($input_array.attr("required"));

            //If the item a required item
            if(!(is_required == false || is_required == "undefined"))
            {
                //Check if the value is blank
                if($input_array.val()=="" || $input_array.val=="undefined")
                {
                    //$self.removeClass(success_class);
                    $self.addClass(error_class);
                    is_valid = false;//A value is blank, therefore it is not valid
                }
                else
                {
                    $self.removeClass(error_class);
                    //$self.addClass(success_class);
                }
            }
        });

        return is_valid;
    }
    //EDITING AND SAVING
    //Toggle state between edit and save modes for the button provided as value for $button parameter
    function ToggleEditState($button)
    {
        var EDIT_STATE = "edit";
        var SAVE_STATE = "save";

        var $state_toggle = "data-state-toggle"; //State toggle selector
        var current_state = $button.attr($state_toggle);

        var btn_class="btn-info";
        var btn_icon_class="glyphicon-edit";
        var btn_text = "Edit";

        var is_editable=false;
        //Toggle between the edit and save states
        switch(current_state)
        {
            case "edit":
                is_editable = false;
                btn_class="btn-info";
                btn_icon_class="glyphicon-edit";
                btn_text = "Edit";

                //Remove the btn-success class from the previous state
                $button.removeClass("btn-success");

                $button.attr($state_toggle,SAVE_STATE);
            break;
            case "save":
                is_editable = true;
                btn_class="btn-success";
                btn_icon_class="glyphicon-floppy-disk";
                btn_text = "Save ";

                //Remove the btn-success class from the previous state
                $button.removeClass("btn-info");

                $button.attr($state_toggle,EDIT_STATE);
            break;
            default://Default to the edit state
                is_editable=false;
                btn_class="btn-info";
                btn_icon_class="glyphicon-edit";
                btn_text = "Edit";

                //Remove the btn-success class from the previous state
                $button.removeClass("btn-success");

                $button.attr($state_toggle,EDIT_STATE);
            break;
        }

        //Update the button to the new state
        $button.html('<span class="glyphicon '+btn_icon_class+'"></span> '+btn_text+'');

        $button.addClass(btn_class);
        return is_editable;
    }

    $(".editable-trigger-btn").click(function(){
        var $self = $(this);
        var is_editable = ToggleEditState($self);
        var $parents = $self.parents(".manage-items");//Accordion contents parent
        var $editable_list = $parents.find(".editable-list");//Get the editable list

        var $editable_items = $editable_list.find(".editable");

        //Make all the content editable
        if(is_editable)
        {
            //Make all editable fields editable
            $editable_items.each(function(){
                $(this).removeAttr("disabled");
            });
        }
        else //Make the content uneditable
        {
            //Make all editable fields disabled
            $editable_items.each(function(){
                $(this).attr("disabled","");
            });
        }
    });

    //Request account
    function RequestAccount(data,$form)
    {
        $.post(ajax_handler_path,{"action":"RequestAdminAccount","data":data},function(response,status){
            if(response != "" && response)
            {
              toastr.success("If your credentials are accepted by femcity, your account will be created and you will be informed.","Successfully requested the admin account");
              $form.find("input").val("");
              $form.find("textarea").text("");
            }
            else
            {
                toastr.error("Failed to request the account. If the problem persists, contact femcity.","Error. Possibly invalid input provided");
            }
        });
    }

    //Request button clicked
    $("#btn_request_account").click(function(){
      $form  = $("#request_form");
      $input_list = $(".input-list");

      //Admin account data
      var first_name = $("#first_name").val();
      var last_name = $("#last_name").val();
      var email = $("#email").val();
      var phone = $("#phone").val();
      var business_name = $("#business_name").val();
      var business_category = $("#business_category").val();
      var business_description = $("#business_description").val();
      var region_id = $("#region").val();
      var specific_location = $("#location").val();

      //Store the data as JSON data
      var data = {
          "first_name":first_name,
          "last_name":last_name,
          "business_name":business_name,
          "business_description":business_description,
          "region_id":region_id,
          "specific_location":specific_location,
          "cat_id":business_category,
          "email":email,
          "phone":phone,
          "subbed":1
      };

      var data_is_valid = ValidateInputs($input_list);
      console.log(data_is_valid);
      //If all the inputs are valid input
      if(data_is_valid)
      {
        //Request the actual account
        RequestAccount(data,$form);
      }
      else
      {
          toastr.error("One or more required fields are missing","Error: Failed to request account");
          console.log("Failed to request the account. One or more required fields are empty");
      }

    });

    //FILE UPLOAD
    /*
        PSEUDOCODE
        - Select the files
        - Mark primary file
        - Click post item [event]
        - Show progress for the uploads
        - Add the records of the item uploaded to the db
        - Upload the files to the appropriate locations & store file paths in db
        - Empty the inputs for the item upload section
        
        ->TODO: Find a way of using the krajee plugin. Currently does not initialize (meaning the rest won't work as expected)
    */
    
    $(".fileinput-upload-button").click(function(e){
//        alert("Upload clicked");
        console.log($("#item_files"));
        e.preventDefault();
    });

});
