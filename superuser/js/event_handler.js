$(document).ready(function(){
    var $input_list_class = ".input-list";
    var ajax_handler_path = "../handlers/ajax_handler.php";
    
    //Init toastr options
    toastr.options = {
          "closeButton": false,
          "positionClass": "toast-bottom-center",
          "preventDuplicates": false,
          "showDuration": "500",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000"
    } 
    
    //Get the input list form
    function GetInputList($btn)
    {
        return ($btn.parents($input_list_class));
    }
    
    //Validate inputs ~ returns true if the inputs were valid(not empty), false if otherwise
    function ValidateInputs($input_list)
    {   
        toastr.options.positionClass = "toast-bottom-full-width";
        //If the input list is undefined
        if($input_list == "undefined" || $input_list.length == 0)
        {
            return null;
        }
        
        //Input containers found.
        var $input_containers = $input_list.children(".input-container")
        
        var is_valid = true;//If the content is valid ~ defaults to true
        var error_class = "has-error";
        var success_class = "has-success";
        
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
                    $self.removeClass(success_class);
                    $self.addClass(error_class);
                    is_valid = false;//A value is blank, therefore it is not valid
                }
                else 
                {
                    $self.removeClass(error_class);
                    $self.addClass(success_class);
                }
            }
        });
        
        return is_valid;
    }
    
    /*CREATE FUNCTIONS*/
    var missingDataMessage = "One or more required fields are empty.";
    var creatingCategory=false;
    
    //Create a category
    $("#createCategory").click(function(){
        
        //Checking if the required inputs are valid
        var $input_list = GetInputList($(this));
        var data_is_valid = ValidateInputs($input_list);
        
        //Category data
        var $cat_name = $("#in_cat_name").val();
        var $cat_descr = $("#in_cat_description").val();
        
        //Store the data as json data
        var data = {
            "cat_name":$cat_name,
            "cat_description":$cat_descr
        };
        
        //Form data is invalid
        if(!data_is_valid)
        {
            toastr.error(missingDataMessage,"Failed to create category");
        }
        else
        {
            //Only display the creating category message once until the category is created
            if(creatingCategory == false)
            {
                toastr.positionClass = "toast-bottom-center";
                toastr.info("Attempting to create category...","Action in progress");
                creating=true;
                
                //Send ajax request
                $.post(ajax_handler_path,{"action":"CreateCategory","data":data},function(response,status){
                   
                    //Successfully created the category
                    if(response==true)
                    {
                        toastr.success("Successfully created the category");
                    }
                    else //Failed to create the category
                    {
                        toastr.error("Failed to create the category","Server-side error");
                    }
                });
            }            
        }
        

        


    });
    
    //Create an admin account
    $("#createAdminAccount").click(function(){
        alert("Creating admin account...");
    });
    
    //Create a featured item
    $("#createFeaturedItem").click(function(){
         alert("Creating featured item...");
    });
    
    //Create a featured item
    $("#createOffer").click(function(){
         alert("Creating offer...");
    });
    
    /*UPDATE FUNCTIONS*/
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
    /*DELETE FUNCTIONS*/
});