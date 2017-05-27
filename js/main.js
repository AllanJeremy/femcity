/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
    var ajax_handler_path = "handlers/ajax_handler.php";
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
    
    //
    $(".view-phone").click(function(){
        //Hide the view phone button and show the loading widget
        var $btn_view_phone = $(this);
        var $loading_phone = $btn_view_phone.siblings(".loading-phone");
        
        $btn_view_phone.hide();
        $loading_phone.removeClass("hide");
        
        var acc_id = $btn_view_phone.attr("data-acc-id");//Account id
        
        //Perform ajax request. If the phone number was successfully retrieved, show it
        $.post(ajax_handler_path,{"action":"ViewPhone","acc_id":acc_id},function(response,status){
            
            //Phone number was not found
            if(response == "" || !response)    
            {
                $loading_phone.addClass("hide");
                $btn_view_phone.show();
            }
            else//Response is the phone number
            {
                var $phone_cont = $btn_view_phone.parents(".phone-container");
                $phone_cont.html("<b>Phone : </b>"+response+"<br>");
            }
        });
        
        //Otherwise return the button view phone button
    });
});
