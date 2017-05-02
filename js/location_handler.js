//This file controls how location dropdowns are displayed
//Dropdowns update when country changes
$(document).ready(function(){
    var ajax_handler_path = "../handlers/ajax_handler.php";
    var location_ctrl_class = ".location_control";
    
    //Create an option* tag and return the string
    function CreateOptionTag(value,text)
    {
        return ("<option value='"+value+"'>"+(text.toUpperCase())+"</option>");
    }
    
    //Update regions
    function UpdateRegionList($country_list)
    {
        var $location_controls = $country_list.parents(".location_control").siblings(".location_control")
        var $region_list = $location_controls.find("select.region_list");
        var country_id = $country_list.val();
        
        if($region_list && typeof($region_list)!="undefined")
        {
            //perform get request for the regions
            $.get(ajax_handler_path,{"action":"GetRegionsInCountry","country_id":country_id},function(response,status){
                //Options content
                var options_content = "";
                
                //If we got a response that was not empty ~ assume valid JSON
                if( (status=="success" || status==200) && response!="")
                {
                    var response_json = JSON.parse(response);
                    var cur_region;
                    var cur_option;
                    
                    /*template : <option value="$region_id">$region_name</option>*/
                    for (var i=0; i<response_json.length;i++)
                    {
                        cur_region = response_json[i];
                        cur_option = CreateOptionTag(cur_region["region_id"],cur_region["region_name"]);
                        options_content += cur_option;
                    }
                }
                else
                {
                    console.log("No regions found");
                    options_content = CreateOptionTag("0","No regions found");
                }
                
                $region_list.html(options_content);
            });
        }
        else
        {
            console.log("Failed to update regions");
        }``
    }
    //country list changed
    $("select.country_list").change(function(){
        $country_list = $(this);
        
        UpdateRegionList($country_list);
    });
});