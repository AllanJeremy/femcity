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
        toastr.options.preventDuplicates = true;
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
        
        //Get input list and validate the inputs
        var $input_list = GetInputList($(this));
        var data_is_valid = ValidateInputs($input_list);
        
        //Category data
        var $cat_name = $("#in_cat_name").val();
        var $cat_descr = $("#in_cat_description").val();
        
        //Store the data as JSON data
        var data = {
            "cat_name":$cat_name,
            "cat_description":$cat_descr
        };
        
        //Form data is invalid
        if(!data_is_valid)
        {
            toastr.error(missingDataMessage,"Failed to create category");
        }
        else//Form data is valid
        {
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
    });
    
    //Create an admin account
    $("#createAdminAccount").click(function(){
        //Get input list and validate the inputs
        var $input_list = GetInputList($(this));
        var data_is_valid = ValidateInputs($input_list);
        
        //Admin account data
        var first_name = $("#in_admin_first_name").val();
        var last_name = $("#in_admin_last_name").val();
        var email = $("#in_admin_email").val();
        var business_name = $("#in_admin_business_name").val();
        var business_category = $("#in_business_category").val();
        var business_description = $("#in_business_description").val();
        
        //Store the data as JSON data
        var data = {
            "first_name":first_name,
            "last_name":last_name,
            "business_name":business_name,
            "business_description":business_description,
            "cat_id":business_category,
            "email":email,
        };
        
        //Form data is invalid
        if(!data_is_valid)
        {
            toastr.error(missingDataMessage,"Failed to create category");
        }
        else//Form data is valid
        {
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
    //Update categories
    function UpdateCategories(id,$editable_list)
    {
        //Data in JSON format
//        var data = {
//            "cat_name":,
//            "cat_description":
//        };
        
        $.post(ajax_handler_path,{"action":"UpdateCategory","id":id,"data":data},function(response,status){
            
        });
        
    }
    
    function UpdateAccounts(id,$editable_list)
    {
        
    }
    
    function UpdateCategories(id,$editable_list)
    {
        
    }
    
    //Update accounts
    
    //Update offers
    
    
    /*EDIT BUTTON*/
    var $state_toggle = "data-state-toggle"; //State toggle selector
    //Make button edit button
    function ShowEditButton($button,is_valid)
    {
        var EDIT_STATE = "edit";
        btn_class="btn-success";
        btn_icon_class="glyphicon-floppy-disk";
        btn_text = "Save ";

        //Remove the btn-success class from the previous state
        $button.removeClass("btn-info");

        $button.attr($state_toggle,EDIT_STATE);        

        //Update the button to the new state
        $button.html('<span class="glyphicon '+btn_icon_class+'"></span> '+btn_text+'');

        $button.addClass(btn_class);
    }
    
    //Make button save button
    function ShowSaveButton($button)
    {
        var SAVE_STATE = "save";
        
        btn_class="btn-info";
        btn_icon_class="glyphicon-edit";
        btn_text = "Edit";

        //Remove the btn-success class from the previous state
        $button.removeClass("btn-success");

        $button.attr($state_toggle,SAVE_STATE);
        
        //Update the button to the save state
        $button.html('<span class="glyphicon '+btn_icon_class+'"></span> '+btn_text+'');
        
        $button.addClass(btn_class);
    }
    
    //Toggle state between edit and save modes for the button provided as value for $button parameter
    function ToggleEditState($button,is_valid)
    {
        var current_state = $button.attr($state_toggle);
        var is_editable=false;
        
        //Toggle between the edit and save states
        if(current_state=="edit")
        {
            if(is_valid)
            {
                is_editable = false
            }
            else
            {
                is_editable = true;
            }
        }
        else
        {
            is_editable = true;
        }
        
        return is_editable;
    }
    
    //When the edit button is clicked
    $(".editable-trigger-btn").click(function(){
        var $self = $(this);
        var $parents = $self.parents(".manage-items");//Accordion contents parent
        var $editable_list = $parents.find(".editable-list");//Get the editable list
        var $editable_items = $editable_list.find(".editable");
        
        var is_valid = ValidateInputs($editable_list);//Checks if the data in the input fields is valid
        var is_editable = ToggleEditState($self,is_valid);

        
        var $data_state = $self.attr("data-state-toggle");//State of the button. 
        
        
        //Make all the content editable
        if(is_editable)
        {
            ShowEditButton($self);

            //Make all editable fields editable
            $editable_items.each(function(){
                $(this).removeAttr("disabled");
            });
        }
        else //Make the content uneditable
        {
            ShowSaveButton($self);
            //If the content is valid ~ make the input fields disabled
            if(is_valid)
            {
                //Make all editable fields disabled
                $editable_items.each(function(){
                    $(this).attr("disabled","");
                });
            }
            else
            {
                $self.attr("disabled");
            }
        }
        
        //If we are currently editing the content
        if($data_state == "edit")
        {
            //Determine what kind of item was clicked
            var $edit_type = $self.attr("data-edit-type");
            var primary_id = null;
            
            //If the data is invalid ~ one or more fields were not filled in
            if(!is_valid)
            {
                //Prevent the save button from being updated
                toastr.error(missingDataMessage,"Failed to update category");
                return;
            }
            
            //The data is valid ~ proceed to check what type of item is being edited
            switch($edit_type)
            {
                case "categories": //Update categories
                    primary_id = $parents.attr("data-cat-id");
//                    UpdateCategories(primary_id,$editable_list);
                break;

                case "accounts":
                    primary_id = $parents.attr("data-acc-id");
//                    UpdateAccounts(primary_id,$editable_list);
                break;

                case "offers":
                    primary_id = $parents.attr("data-offer-id");
//                    UpdateOffers(primary_id,$editable_list);
                break;

                default:
                    console.log("Unhandled edit type");
            }
        }

        
    });
    /*DELETE FUNCTIONS*/
});