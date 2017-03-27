$(document).ready(function(){
    
    /*CREATE FUNCTIONS*/
    //Create a category
    $("#createCategory").click(function(){
        
    });
    
    //Create an admin account
    $("#createAdminAccount").click(function(){
        
    });
    
    //Create a featured item
    $("#createFeaturedItem").click(function(){
        
    });
    
    //Create a featured item
    $("#createOffer").click(function(){
        
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