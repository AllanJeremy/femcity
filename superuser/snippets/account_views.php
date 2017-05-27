<div class="well">
    <?php
        $admin_accs = DbInfo::GetAllAdminAccounts();
        if($admin_accs):
            MessageDisplay::PrintInfo("This is a list of businesses as well as the total number of phone number views they have received.<br><b>Note : </b><i>These stats can be used as a general measure of how many people were interested in the business through femcity</i>");
    ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Full names</th>
            <th>Business name</th>
            <th>Country</th>
            <th>Region</th>
            <th>Specific location</th>
            <th>Phone views</th>
        </tr>
        
        <?php
                foreach($admin_accs as $acc):
                    $phone_data = null;
                    $phone_views = 0;
        
                    $full_name = $acc["first_name"]." ".$acc["last_name"];
                    $business_name = $acc["business_name"];
                    
                    $region = $acc["region_name"];
                    $region_id = $acc["region_id"];
                    $country_id = DbInfo::GetCountryByRegion($region_id);
                    $country = DbInfo::GetCountryById($country_id);

                    //Specific location
                    $specific_location = "Not specified";
                    if(!empty($acc["specific_location"]))
                    {
                        $specific_location = $acc["specific_location"];
                    }
                       
                    $phone_data = DbInfo::GetAdminPhoneViews($acc["acc_id"]);
                    if(isset($phone_data->num_rows))
                    {
                        $phone_views = $phone_data->num_rows;
                    }
        ?>
            <tr>
                <td title="Full names of the account owner"><?php echo $full_name;?></td>
                <td title="Name of the business the account belongs to"><?php echo $business_name;?></td>
                <td title="Country the business is located in"><?php echo $country["country_name"]?></td>
                <td title="Region the business is located in"><?php echo $region?></td>
                <td title="Specific location of the business"><?php echo $specific_location?></td>
                <td title="Number of people who viewed <?php echo $business_name."'s";?> phone number"><?php echo $phone_views;?></td>
            </tr>
        <?php
                endforeach;
        ?>
    </table>
    <?php           
        else:
    var_dump($admin_accs);
            MessageDisplay::PrintError("No stats to display. <b>Reason :</b> <i>Could not find any admin accounts</i>");
        endif;
    ?>
</div>