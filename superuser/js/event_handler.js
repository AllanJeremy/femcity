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
        
        //Toggle between the edit and save states
        switch(current_state)
        {
            case "edit":
                btn_class="btn-info";
                btn_icon_class="glyphicon-edit";
                btn_text = "Edit";
                
                //Remove the btn-success class from the previous state
                $button.removeClass("btn-success");
                
                $button.attr($state_toggle,SAVE_STATE);
            break;
            case "save":
                btn_class="btn-success";
                btn_icon_class="glyphicon-edit";
                btn_text = "Save ";
                
                //Remove the btn-success class from the previous state
                $button.removeClass("btn-success");
                
                $button.attr($state_toggle,EDIT_STATE);
            break;
            default://Default to the edit state
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
    }
    
    $(".editable-trigger-btn").click(function(){
        $self = $(this);
        alert("edit clicked!");
    });
    /*DELETE FUNCTIONS*/
});