<?php
    
    require_once("../handlers/db_info.php");

    //Current page
    $current_page = "locations";

    //Variables for the different urls
    $countries_url = "index.php?p=".$current_page."&tab=countries";
    $regions_url = "index.php?p=".$current_page."&tab=regions";
    
    //Message shown when locations cannot be found and the id for the message box(used as selector in js)
    $missing_countries_msg = "No countries were found. Once you create countries, they will appear here";
    $missing_countries_id = "missing_countries_msg";
    
    $missing_regions_msg = "No regions were found. Once you create regions, they will appear here";
    $missing_regions_id = "missing_regions_msg";
    
    //Check the current active tab
    $current_tab = htmlspecialchars($_GET["tab"]);
    $countries_tab_class = $regions_tab_class = "";

    const ACTIVE_CLASS = "active";
    if(isset($current_tab)):
        switch($current_tab):
            #Show countries
            case "countries":
                $countries_tab_class = ACTIVE_CLASS;
            break;
                
            #Show regions
            case "regions":
                $regions_tab_class = ACTIVE_CLASS;
            break;
                
            default:#invalid tab provided
?>
    <script>window.location = "<?php echo $countries_url;?>"</script>
<?php
        endswitch;
    else: #Current tab not set ~ set default as $countries
?>
    <script>window.location = "<?php echo $countries_url;?>"</script>
<?php
    endif;
    //Display the tab headers below
?>
    <!--Tab headers-->
    <div class="row">
		<ul class="nav nav-pills col-xs-offset-4 col-sm-offset-5">
            <li class="<?php echo $countries_tab_class;?>"><a href="<?php echo $countries_url; ?>">Countries</a></li>
            <li class="<?php echo $regions_tab_class;?>"><a href="<?php echo $regions_url;?>">Regions</a></li>
		</ul>
    </div><br><br>

    <!--Tab body-->
    <div class="container well tab-body">
        <?php
        $countries = DbInfo::GetAllCountries();
        switch($current_tab):
            case "countries":
            #display countries
        ?>
        <div id="countries_tab">
            <div class="container">
                <div class="col-xs-8 col-sm-4 col-sm-offset-3">
                    <input class="form-control" type="text" placeholder="Country name" title="Name of the country" id="in_country_name">
                </div>
                <div class="col-xs-4 col-sm-2">
                    <a class="btn btn-info form-control add_country" href="javascript:void(0)" title="Add new country. Note: Editing requires tech support">Add</a>
                </div>
            </div><hr>
            
            <div class="container">
            <?php
                //If there are countries in the database
                if(isset($countries) && @$countries->num_rows>0):
                    MessageDisplay::PrintHiddenInfo($missing_countries_msg,$missing_countries_id);
            ?>
                <table class="table table-striped table-responsive country_list">
                    <tr>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>
                
            <?php
                    #For each country found
                    foreach($countries as $country):
                        $country_name = $country["country_name"];
                             
            ?>
                    <tr>
                        <td><?php echo ucfirst($country_name);?></td>
                        <td>
                            No actions available
                        </td>
                    </tr>
            <?php
                    endforeach; 
            ?>
                 </table>   
            <?php
                else:#No countries found
                    MessageDisplay::PrintInfo($missing_countries_msg,$missing_countries_id);
                endif;
            ?>
            </div>
        </div>
        <?php
            break;
                
            case "regions":
            #display regions
            $regions = DbInfo::GetAllRegions();
        ?>
        <div id="regions_tab">
            <div class="container row">
                <div class="form-group col-sm-4 ">
                    <input class="form-control" type="text" placeholder="Region name" title="Name of the region" id="in_region_name">
                </div>
                <div class="form-group col-sm-4 ">
                    <select class="form-control" title="Region name" id="in_region_country">
                        <?php
                            //If there are countries in the database
                            if(isset($countries) && @$countries->num_rows>0):
                                foreach($countries as $country):
                                    $country_id = $country["country_id"];
                                    $country_name = $country["country_name"];
                        ?>
                            <option value="<?php echo $country_id?>"><?php echo $country_name;?></option>
                        <?php   
                                endforeach;
                            else:
                        ?>
                            <option value="0" disabled>No countries found</option>
                        <?php
                            endif;
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-xs- col-sm-2">
                    <a class="btn btn-info form-control add_region" href="javascript:void(0)" title="Add new region. Note: Editing requires tech support">Add</a>
                </div>
            </div><hr>
            
            <div class="container">
            <?php
                //If there are countries in the database
                if(isset($regions) && @$regions->num_rows>0):
                    MessageDisplay::PrintHiddenInfo($missing_regions_msg,$missing_regions_id);
            ?>
                <table class="table table-striped table-responsive region_list">
                    <tr>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>
                
            <?php
                    #For each country found
                    foreach($regions as $region):
                        $region_name = $region["region_name"];
                        $country_name = $region["country_name"];       
            ?>
                    <tr>
                        <td><?php echo ucfirst($region_name);?></td>
                        <td><?php echo ucfirst($country_name);?></td>
                        <td>
                            No actions available
                        </td>
                    </tr>
            <?php
                    endforeach; 
            ?>
                 </table>   
            <?php
                else:#No countries found
                    MessageDisplay::PrintInfo($missing_countries_msg,$missing_countries_id);
                endif;
            ?>
            </div>
        </div>
        <?php
            break;
            default:
        ?>
            <script>window.location = "<?php echo $countries_url;?>"</script>
        <?php
        endswitch;
        ?>
    </div>