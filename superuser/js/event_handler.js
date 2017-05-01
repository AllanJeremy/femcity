$(document).ready(function(){
    var $input_list_class = ".input-list";
    var ajax_handler_path = "../handlers/ajax_handler.php";
    
    //Init toastr options
    toastr.options = {
          "closeButton": false,
          "positionClass": "toast-bottom-full-width",
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
    
    //Returns if true if the input is considered valid, used for AJAX responses
    function IsValid(input)
    {
        return (input!=false && input!=null && (typeof(input)!="undefined"));
    }
    
    //Validate inputs ~ returns true if the inputs were valid(not empty), false if otherwise
    function ValidateInputs($input_list)
    {   
        toastr.options.preventDuplicates = true;
        //If the input list is undefined
        if($input_list == "undefined" || $input_list.length == 0)
        {
            return null;
        }
        
        //Input containers found.
        var $input_containers = $input_list.children(".input-container")
        
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
    
    /*CREATE FUNCTIONS*/
    var missingDataMessage = "One or more required fields are empty.";
    var creatingCategory=false;
    
    //Reset Create category inputs
    function ResetCreateCategoryInputs()
    {
        $("#in_cat_name").val("");
        $("#in_cat_description").val("");
    }
    
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
                if(IsValid(response))
                {
                    toastr.success("Successfully created the category");
                    ResetCreateCategoryInputs();
                }
                else //Failed to create the category
                {
                    toastr.error("Failed to create the category","AJAX Server-side error");
                }
            });
        }
    });
    
    //Reset the values of the input fields for create admin account
    function ResetCreateAdminInputs()
    {
        $("#in_admin_first_name").val("");
        $("#in_admin_last_name").val("");
        $("#in_admin_email").val("");
        $("#in_admin_phone").val("");
        $("#in_admin_business_name").val("");
        $("#in_business_category").val("");
        $("#in_business_description").val("");
    }
    
    //Create an admin account
    $("#createAdminAccount").click(function(){
        //Get input list and validate the inputs
        var $input_list = GetInputList($(this));
        var data_is_valid = ValidateInputs($input_list);
        
        //Admin account data
        var first_name = $("#in_admin_first_name").val();
        var last_name = $("#in_admin_last_name").val();
        var email = $("#in_admin_email").val();
        var phone = $("#in_admin_phone").val();
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
            "phone":phone,
            "password":email,
            "subbed":1
        };
        
        //Form data is invalid
        if(!data_is_valid)
        {
            toastr.error(missingDataMessage,"Failed to create category");
        }
        else//Form data is valid
        {
            //Send ajax request
            $.post(ajax_handler_path,{"action":"CreateAdminAccount","data":data},function(response,status){
                //Successfully created the category
                if(IsValid(response))
                {
                    toastr.options.timeOut = "2000";
                    toastr.success("Successfully created the admin account. Note: the password for the account defaults to the email address entered for the business.");
                    ResetCreateAdminInputs();
                }
                else //Failed to create the category
                {
                    toastr.error("Failed to create the category","AJAX Server-side error");
                }
            });
        }
    });
    
    //Reset create offer inputs
    function ResetCreateOfferInputs()
    {
        $("#in_offer_text").val("");
        $("#in_offer_description").val("");
        $("#in_category").val("1");
    }
    
    //Create an offer
    $("#createOffer").click(function(){
        //Get input list and validate the inputs
        var $input_list = GetInputList($(this));
        var data_is_valid = ValidateInputs($input_list);
        
        //Admin account data
        var offer_text = $("#in_offer_text").val();
        var description = $("#in_offer_description").val();
        var cat_id = $("#in_category").val();
        
        //Store the data as JSON data
        var data = {
            "offer_text":offer_text,
            "description":description,
            "cat_id":cat_id
        };
        
        //Form data is invalid
        if(!data_is_valid)
        {
            toastr.error(missingDataMessage,"Failed to create offer");
        }
        else//Form data is valid
        {
            //Send ajax request
            $.post(ajax_handler_path,{"action":"CreateOffer","data":data},function(response,status){
                //Successfully created the category
                console.log(IsValid(response));
                if(IsValid(response))
                {
                    toastr.options.timeOut = "2000";
                    toastr.success("Successfully created the offer");
                    ResetCreateOfferInputs();
                }
                else //Failed to create the category
                {
                    toastr.error("Failed to create the offer","AJAX Server-side error");
                }
            });
        }       
    });
    

    /*UPDATE FUNCTIONS*/
    //Get the title of the accordion ~ we will be dynamically updating this title
    function GetAccordionTitle($editable_list)
    {
        var $parents = $editable_list.parents(".manage-items");
        var $accordion_title = $parents.find(".accordion-title");
        
        return $accordion_title;
    }
    
    //Update categories
    function UpdateCategory(id,$editable_list)
    {
        //Accordion title
        var $accordion_title = GetAccordionTitle($editable_list);
        
        //Input containers and data
        var $input_containers = $editable_list.children(".input-container");
        var cat_name = $input_containers.children(".cat_name").val();
        var cat_description = $input_containers.children(".cat_description").val();
        
        //Data in JSON format
        var data = {
            "cat_name":cat_name,
            "cat_description":cat_description
        }
        
        //AJAX request
        $.post(ajax_handler_path,{"action":"UpdateCategory","id":id,"data":data},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully updated the category");
                //Update the Accordion title accordingly
                $accordion_title.text(cat_name);
            }
            else
            {
                toastr.error("Failed to update the category","AJAX Server-side error");
            }
            
            return status;
        });
    }
    
    //Update accounts
    function UpdateAdminAccount(id,$editable_list)
    {
        //Accordion title
        var $accordion_title = GetAccordionTitle($editable_list);
        
        //Input containers and data
        var $input_containers = $editable_list.children(".input-container");
        var first_name = $input_containers.children(".admin_first_name").val();
        var last_name = $input_containers.children(".admin_last_name").val();
        var business_name = $input_containers.children(".admin_business_name").val();
        var business_description = $input_containers.children(".business_description").val();
        var cat_id = $input_containers.children(".business_category").val();
        var email = $input_containers.children(".admin_email").val();
        var phone = $input_containers.children(".admin_phone").val();
        
        //Store the data as JSON data
        var data = {
            "first_name":first_name,
            "last_name":last_name,
            "business_name":business_name,
            "business_description":business_description,
            "cat_id":cat_id,
            "email":email,
            "phone":phone,
        };
        
        //AJAX request
        $.post(ajax_handler_path,{"action":"UpdateAdminAccount","id":id,"data":data},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully updated the admin account");
                
                //Update the Accordion title accordingly
                $accordion_title.text(first_name+" "+last_name+", "+business_name);
            }
            else
            {
                toastr.error("Failed to update the admin account","AJAX Server-side error");
            }
            
            return status;
        });
    }
    
    //Update offers
    function UpdateOffer(id,$editable_list)
    {
        //Accordion title
        var $accordion_title = GetAccordionTitle($editable_list);
        
        //Input containers and data
        var $input_containers = $editable_list.children(".input-container");
        var offer_text = $input_containers.children(".offer_text").val();
        var description = $input_containers.children(".offer_description").val();
        var cat_id = $input_containers.children(".offer_category").val();
        
        //Data in JSON format
        var data = {
            "offer_text":offer_text,
            "description":description,
            "cat_id":cat_id
        }
        
        //AJAX request
        $.post(ajax_handler_path,{"action":"UpdateOffer","id":id,"data":data},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully updated the offer");
                //Update the Accordion title accordingly
                $accordion_title.text(offer_text);
            }
            else
            {
                toastr.error("Failed to update the offer","AJAX Server-side error");
            }
            
            return status;
        });
    }
    
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
                    UpdateCategory(primary_id,$editable_list);
                break;

                case "accounts":
                    primary_id = $parents.attr("data-acc-id");
                    UpdateAdminAccount(primary_id,$editable_list);
                break;

                case "offers":
                    primary_id = $parents.attr("data-offer-id");
                    UpdateOffer(primary_id,$editable_list);
                break;

                default:
                    console.log("Unhandled edit type. Check javascript switch statement");
            }
        }

    });
    
    //Container variables
    $featured_container = $("#manage_featured_group");
    $other_container = $("#manage_other_group");

    //Toggle the message that is displayed when there are no items
    function ToggleNoItemMessage()
    {
        var hidden_class = "hidden";

        var $f_count = $featured_container.children(".manage-items").length;
        //If there are no featured items ~ show the message , else: hide it
        if($f_count===0)
        {
            $featured_container.children("#no_featured_msg").removeClass(hidden_class);
        }
        else
        {
            $featured_container.children("#no_featured_msg").addClass(hidden_class);
        }
        
        var $o_count = $other_container.children(".manage-items").length;
        //If there are no other items ~ show the message , else: hide it
        if($o_count===0)
        {
            $other_container.children("#no_other_msg").removeClass(hidden_class);
        }
        else
        {
            $other_container.children("#no_other_msg").addClass(hidden_class);
        }
    }
    
    //Add a featured item
    function AddFeaturedItem($btn,$accordion,$item_id)
    {
        $.post(ajax_handler_path,{"action":"AddFeaturedItem","id":$item_id},function(response,status){
            if(IsValid(response))
            {
                $btn.removeClass("btn-info add-trigger-btn");
                $btn.addClass("btn-warning remove-trigger-btn");
                $btn.html("<span class='glyphicon glyphicon-minus'></span> Remove");
                
                $featured_container.append($accordion);            
                
                toastr.success("Successfully added the featured item");
                ToggleNoItemMessage();
            }
            else
            {
                toastr.error("Failed to add the featured item.","AJAX Server-side error");
            }
        });
    }
    
    //Remove a featured item
    function RemoveFeaturedItem($btn,$accordion,$item_id)
    {
        $.post(ajax_handler_path,{"action":"RemoveFeaturedItem","id":$item_id},function(response,status){
            if(IsValid(response))
            {
                $btn.removeClass("btn-warning remove-trigger-btn");
                $btn.addClass("btn-info add-trigger-btn");
                $btn.html("<span class='glyphicon glyphicon-plus'></span> Add");
                
                $other_container.append($accordion);   
                
                toastr.success("Successfully removed the featured item");
                ToggleNoItemMessage();
            }
            else
            {
                toastr.error("Failed to remove the featured item.","AJAX Server-side error");
            }
        });
    }
    
    //If the function is an add function, returns true, otherwise returns false
    function IsAddButton($btn)
    {
        return ($btn.hasClass("add-trigger-btn") && !$btn.hasClass("remove-trigger-btn"));
    }
    
    //Add or remove a featured item
    $(".updateFeaturedItem").click(function(){
        
        $self = $(this);
        $accordion = $self.parents(".manage-items");
        $item_id = $accordion.attr("data-item-id");
        //Adding a featured item
        if(IsAddButton($self))
        {
            AddFeaturedItem($self,$accordion,$item_id);
        }
        else //Adding other item
        {
            RemoveFeaturedItem($self,$accordion,$item_id);
        } 
    });
    
    /*DELETE FUNCTIONS*/
    //Reference to the confirm delete modal
    var $confirmDeleteModal = $("#confirmDeleteModal");
    
    //Delete the category with the given id
    function DeleteCategory(id,$parents)
    {
        $.post(ajax_handler_path,{"action":"DeleteCategory","id":id},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully deleted the category");
                $parents.remove();//Remove item from DOM
            }
            else
            {
                toastr.error("Failed to delete the category. Possible reason: the item has already been deleted. If the problem persists contact your technical team.","AJAX Server-side error");
            }
        });
    }
    
    //Delete the admin account with the given id
    function DeleteAdminAccount(id,$parents)
    {
        $.post(ajax_handler_path,{"action":"DeleteAdminAccount","id":id},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully deleted the admin account");
                $parents.remove();//Remove item from DOM
            }
            else
            {
                toastr.error("Failed to delete the admin account. Possible reason: the item has already been deleted. If the problem persists contact your technical team.","AJAX Server-side error");
            }
        });
    }
    
    //Delete the item with the given id
    function DeleteItem(id,$parents)
    {
        $.post(ajax_handler_path,{"action":"DeleteItem","id":id},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully deleted the item");
                $parents.remove();//Remove item from DOM
                ToggleNoItemMessage();
            }
            else
            {
                toastr.error("Failed to delete the item. Possible reason: the item has already been deleted. If the problem persists contact your technical team.","AJAX Server-side error");
            }
        });
    }

    //Delete the item with the given id
    function DeleteFeaturedItem(id,$parents)
    {
        $.post(ajax_handler_path,{"action":"DeleteFeaturedItem","id":id},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully deleted the featured item as well as the corresponding item","Successfully deleted the item");
                $parents.remove();//Remove item from DOM
                ToggleNoItemMessage();
            }
            else
            {
                toastr.error("Failed to delete the item. Possible reason: the item has already been deleted. If the problem persists contact your technical team.","AJAX Server-side error");
            }
        });
    }
    //Delete the offer with the given id
    function DeleteOffer(id,$parents)
    {
        $.post(ajax_handler_path,{"action":"DeleteOffer","id":id},function(response,status){
            if(IsValid(response))
            {
                toastr.success("Successfully deleted the offer");
                $parents.remove();//Remove item from DOM
            }
            else
            {
                toastr.error("Failed to delete the offer. Possible reason: the item has already been deleted. If the problem persists contact your technical team.","AJAX Server-side error");
            }
        });
    }
    
    //Delete button clicked
    $(".manage-delete-btn").click(function(){
        var $delete_type = "item";
        var $del_btn = $(this);//Reference to the clicked button
        
        //Classes for the different types of deletes
        var DELETE_CATEGORY_CLASS = "delete_category";
        var DELETE_ADMIN_ACC_CLASS = "delete_admin_account";
        var DELETE_OFFER_CLASS = "delete_offer";
        var DELETE_ITEM_CLASS = "delete_item";
        
        //TODO: Find a way to DRY this code
        //If delete category is clicked 
        if($del_btn.hasClass(DELETE_CATEGORY_CLASS))
        {
            $delete_type = "category";
        }
        //If delete admin account
        else if($del_btn.hasClass(DELETE_ADMIN_ACC_CLASS))
        {
            $delete_type = "admin account";
        }
        //If delete item
        else if($del_btn.hasClass(DELETE_ITEM_CLASS))
        {
            $delete_type = "item (The actual item posted by the admin)";
        }
        //If delete offer
        else if($del_btn.hasClass(DELETE_OFFER_CLASS))
        {
            $delete_type = "offer";
        }
        
        //Update the modal text based on what has been clicked then display the modal
        $confirmDeleteModal.find("#confirmDeleteType").text($delete_type);
        $confirmDeleteModal.modal("show");
        
        var $parents = $del_btn.parents(".manage-items");//Accordion contents parent
        
        /*Confirm delete clicked  
          ~ This is nested here so that if the modal is accessed from a non-delete btn, it's not handled
        */
        //Unbind the click event before calling the event handler to ensure it runs only once
        $(".btn_confirm_delete").off("click").click(function(){
            
            $confirmDeleteModal.modal("hide");
            var primary_id = null;
            
            //If delete category is clicked
            if($del_btn.hasClass(DELETE_CATEGORY_CLASS))
            {
                primary_id = $parents.attr("data-cat-id");
                
                //Delete from Database and remove from DOM
                DeleteCategory(primary_id,$parents);
                return;
            }
            
            //If delete admin account
            else if($del_btn.hasClass(DELETE_ADMIN_ACC_CLASS))
            {
                console.log($parents);
                primary_id = $parents.attr("data-acc-id");
                
                //Delete from Database and remove from DOM
                DeleteAdminAccount(primary_id,$parents);
                return;
            }
            //If delete an item
            else if($del_btn.hasClass(DELETE_ITEM_CLASS))
            {
                primary_id = $parents.attr("data-item-id");
                
                //If it is a featured item
                var is_featured = $del_btn.siblings(".remove-trigger-btn").length > 0;
                
                //Delete from Database and remove from DOM 
                if(!is_featured)
                {
                    DeleteItem(primary_id,$parents); 
                }
                else
                {
                    DeleteFeaturedItem(primary_id,$parents);
                    /*
                    //TODO: Consider allowing people to delete featured items
                    toastr.error("If you would like to delete the item. Remove it from the featured items then delete it","Error: Cannot delete a featured item");
                    */
                }
                
                return;
            }
            //If delete offer
            else if($del_btn.hasClass(DELETE_OFFER_CLASS))
            {
                primary_id = $parents.attr("data-offer-id");
                
                //Delete from Database and remove from DOM
                DeleteOffer(primary_id,$parents);
                return;
            }
            
        });
    });//End of delete trigger function
    
    /*ACCOUNT REQUESTS*/
    //Get the request id
    function GetRequestId($parents)
    {
        return $parents.attr("data-request-id");
    }
    
    //Show or hide the message showing that there are no more account requests
    function ToggleNoRequestMessage()
    {
        var $parents = $("#manage_account_requests");
        var request_count = $parents.find(".manage-items").length;
        
        //If there are no account requests, show the message
        if(request_count === 0)
        {
            $parents.children("#missing_acc_request_msg").removeClass("hidden");
        }
    }
    
    //Accept account request
    $(".accept-request-btn").click(function(){
        var $parents = $(this).parents(".manage-items");
        var $input_list = $parents.find(".editable-list").children(".input-container");
        
        //Admin account data
        var first_name = $input_list.children(".admin_first_name").val();
        var last_name = $input_list.children(".admin_last_name").val();
        var email = $input_list.children(".admin_email").val();
        var phone = $input_list.children(".in_admin_phone").val();
        var business_name = $input_list.children(".admin_business_name").val();
        var business_category = $input_list.children(".admin_business_category").val();
        var business_description = $input_list.children(".admin_business_description").val();
        
        var req_id = GetRequestId($parents);
        
        //Store the data as JSON data
        var data = {
            "first_name":first_name,
            "last_name":last_name,
            "business_name":business_name,
            "business_description":business_description,
            "cat_id":business_category,
            "email":email,
            "phone":phone,
            "password":email,
            "subbed":1
        };

        $.post(ajax_handler_path,{"action":"AcceptAccountRequest","id":req_id,"data":data},function(response,status){
            if(IsValid(response))
            {
                $parents.remove();//Remove the accordion from the DOM
                toastr.success("Successfully accepted the account request");
                ToggleNoRequestMessage();
            }
            else
            {
                toastr.error("Failed to accepted the account request","AJAX Server-side error");
            }
        });
    });
    
    //Deny account request
    $(".deny-request-btn").click(function(){
        $parents = $(this).parents(".manage-items");
        var req_id = GetRequestId($parents);
        
        $.post(ajax_handler_path,{"action":"DenyAccountRequest","id":req_id},function(response,status){
            if(IsValid(response))
            {
                $parents.remove();//Remove the accordion from the DOM
                toastr.success("Successfully denied the account request");
                ToggleNoRequestMessage();
            }
            else
            {
                toastr.error("Failed to deny the account request","AJAX Server-side error");
            }
        });
    });
    
    //Ban an account
    function BanAccount(acc_id,$parent)
    {
        $.post(ajax_handler_path,{"action":"BanAdminAccount","acc_id":acc_id},function(response,status){
            if(IsValid(response))
            {
                //Remove the item from DOM
                $parent.remove();
                
                toastr.success("The banned account can be found in settings>banned accounts","Successfully banned the account");
            }
            else
            {
                toastr.error("Failed to ban the account. Possibly an invalid account","AJAX server-side error");    
            }
        });
    }
    
    //Unban an account;
    function UnbanAccount(acc_id,$parent)
    {
        $.post(ajax_handler_path,{"action":"UnbanAdminAccount","acc_id":acc_id},function(response,status){
            if(IsValid(response))
            {
                //Remove the item from DOM
                $parent.remove();
                
                toastr.success("The account can now be accessed from the accounts>manage section.","Successfully unbanned the account");
            }
            else
            {
                toastr.error("Failed to unban the account. Possibly an invalid account","AJAX server-side error");    
            }
        });
    }
    
    //Ban button clicked
    $(".manage-ban-btn").click(function(){
        var $parent = $(this).parents(".manage-items");
        var acc_id = $parent.attr("data-acc-id");
        
        BanAccount(acc_id,$parent);
    });
    
    //Unban button clicked
    $(".manage-unban-btn").click(function(){
        var $parent = $(this).parents(".manage-items");
        var acc_id = $parent.attr("data-acc-id");
        
        UnbanAccount(acc_id,$parent);
    });
    
    //Reset admin account
    function ResetAccount(acc_id)
    {
        $.post(ajax_handler_path,{"action":"ResetAdminAccount","acc_id":acc_id},function(response,status){
            if(IsValid(response))
            {   
                //TODO: Consider showing the actual account name instead of "the selected account" in toast
                toastr.success("The account password is now equal to the email address of the account","Successfully reset the selected account");
            }
            else
            {
                toastr.error("Failed to reset the account. Possibly an invalid account","AJAX server-side error");    
            }
        });
    }
    
    //Reset admin account clicked
    $(".manage-reset-btn").click(function(){
        var $parent = $(this).parents(".manage-items");
        var acc_id = $parent.attr("data-acc-id");
        
        ResetAccount(acc_id);
    });
    
    /*LOCATIONS*/
    //Add new country
    function AddNewCountry($input,data,$table)
    {
        var country_name = data["country_name"];
        var content = "<tr><td>"+country_name+"</td><td>No actions available</td></tr>";
        $.post(ajax_handler_path,{"action":"CreateCountry","data":data},function(response,status)
        {
            if(IsValid(response))
            {
                toastr.success("Successfully created the country");
                $input.val("");
                
                //Add the data to the table
                $table.append(content);
            }
            else
            {
                toastr.error("Failed to create the country","Error");
            }
        }); 
    }
    
    //Add new region
    function AddNewRegion($input,data,$table)
    {
        var region_name = data["region_name"];
        var country_name = data["country_name"];
        var content = "<tr><td>"+region_name+"</td><td>"+country_name+"</td><td>No actions available</td></tr>";
        $.post(ajax_handler_path,{"action":"CreateRegion","data":data},function(response,status)
        {
            if(IsValid(response))
            {
                toastr.success("Successfully created the region");
                $input.val("");
                
                //Add the data to the table
                $table.append(content);
            }
            else
            {
                toastr.error("Failed to create the region","Error");
            }
        }); 
    }
    
    //Add new country button clicked
    $(".add_country").click(function(){
        var $input = $("#in_country_name");
        var country_name = $input.val();
        
        var data  = {"country_name":country_name};
        var $table = $(".country_list");
        
        //If the country name is not empty
        if(country_name != "")
        {
            AddNewCountry($input,data,$table);
        }
        else
        {
            toastr.error("Enter a country name to create country","A required field is empty or invalid");
        }
    });
    
    //Add new region button clicked
    $(".add_region").click(function(){
        var $input = $("#in_region_name");
        var $country_input = $("#in_region_country :selected");
        
        var country_id = $country_input.val();
        var country_name = $country_input.text();
        var region_name = $input.val();
        
        var data  = {"country_id":country_id,"country_name":country_name,"region_name":region_name};
        var $table = $(".region_list");
        //If the country name is not empty
        if(country_name != "")
        {
            AddNewRegion($input,data,$table);
        }
        else
        {
            toastr.error("Enter a region and select a valid country name to create region","A required field is empty or invalid");
        }
    });
});