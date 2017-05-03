<div class="well">
<?php
    //Message shown when categories cannot be found and the id for the message box(used as selector in js)
    $missing_acc_msg = "No banned admin accounts were found. Once you ban admin accounts, they will appear here";
    $missing_acc_id = "missing_acc_msg";
    $admin_accounts = Dbinfo::GetBannedAdminAccounts();

    //Countries and regions
    $countries = DbInfo::GetAllCountries();
    $regions = null;
    
    //If admin accounts were found
    if($admin_accounts && $admin_accounts->num_rows>0):
        //Print hidden message for display when items run out
        MessageDisplay::PrintHiddenInfo($missing_acc_msg,$missing_acc_id);
?>
    <!--Category list-->
    <div class="container manage-content">
        <!--Category list-->
        <div class="col-xs-12 col-sm-6">
            <p>Manage banned accounts here.</p>
        </div>
        <div class="col-xs-12 col-sm-6 pull-right row clearfix">
            <div class="col-xs-10">
                <input class="form-control" type="search" id="search_manage_acccounts" placeholder="Search Accounts">
            </div>
        </div>
    </div><hr>
        
    <!--Accordion-->
    <div class="panel-group manage-content" id="manage_accounts_group">
    <?php
        $acc_id="";
//        $count = 0;#iterator
        $open_state = "";
        
        
        //Loop through each category creating a dropdown item
        foreach($admin_accounts as $acc):
            $acc_id = $acc["acc_id"];
            $acc_name = $acc["first_name"]." ".$acc["last_name"];
            $cat_id = $acc["cat_id"];
            
            $category = "Unknown Category";
            //Set the category name
            if($cat = DbInfo::GetCategoryById($cat_id))
            {
                $category = $cat["cat_name"];
            }
            
            $business_name = $acc["business_name"];
            $business_descr = $acc["business_description"];
        
            $collapse_id="acc_".$acc_id; #Collapse trigger id
            
            //Ids
            $first_name_id = $collapse_id."_first_name";
            $last_name_id = $collapse_id."_last_name";
            $email_id = $collapse_id."_email";
            $bus_name_id = $collapse_id."_bus_name";
            $cat_dom_id = $collapse_id."_cat";
            $bus_descr_id = $collapse_id."_bus_descr";
        
            //If it is the first category, make the collapsible open by default
//            if($count==0)
//            {   $open_state="in";}
//            else
//            {   $open_state="";}
    ?>
      <div class="panel panel-default manage-items" data-acc-id="<?php echo $acc_id;?>">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#manage_accounts_group" href="#<?php echo $collapse_id;?>">
            <span class="accordion-title"><?php echo $acc_name.", ".$business_name;?></span> <span class="caret"></span></a>
            <div class="pull-right action-buttons">
                <a class="btn btn-info editable-trigger-btn" data-edit-type="accounts" data-state-toggle="save"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                <a class="btn btn-info manage-reset-btn"><span class="glyphicon glyphicon-refresh"></span> Reset</a>
                <a class="btn btn-info manage-unban-btn"><span class="glyphicon glyphicon-ban-circle"></span> Unban</a>
                <a class="btn btn-warning manage-delete-btn delete_admin_account" data-toggle="modal" data-target=".confirm-delete-modal"><span class="glyphicon glyphicon-trash"></span> Delete</a>
            </div>
          </h4><br>
        </div>
          
        <div id="<?php echo $collapse_id;?>" class="panel-collapse collapse <?php echo $open_state;?>">
          <div class="panel-body">
            <h4>ACCOUNT DETAILS</h4><hr>
            <form class="row editable-list" method="post">  
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $first_name_id;?>" >First name <sup>(Required)</sup> </label>
                    <input class="editable form-control admin_first_name" required disabled type="text" placeholder="First name" id="<?php echo $first_name_id;?>" title="First name of the business owner" value="<?php echo $acc["first_name"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $last_name_id;?>" >Last name <sup>(Required)</sup> </label>
                    <input class="editable form-control admin_last_name" required disabled type="text" placeholder="Last name" id="<?php echo $last_name_id;?>" title="Last name of the business owner" value="<?php echo $acc["last_name"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $email_id;?>" >Email address <sup>(Required)</sup></label>
                    <input class="editable form-control admin_email" required disabled type="email" placeholder="Email address" id="<?php echo $email_id;?>" title="Email of the business/business owner. Used to login to the account." value="<?php echo $acc["email"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="admin_phone_<?php echo $acc_id;?>">Phone number <sup>(Required)</sup></label>
                    <input class="editable form-control admin_phone" required disabled type="text" placeholder="Phone number" id="admin_phone_<?php echo $acc_id;?>" title="Phone number of the business/business owner. Used to login to the account." value="<?php echo $acc["phone"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $bus_name_id;?>">Business name <sup>(Required)</sup> </label>
                    <input class="editable form-control admin_business_name" required disabled type="text" placeholder="Business name" id="<?php echo $bus_name_id;?>" title="Name of the business/company that owns this account" value="<?php echo $business_name;?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $cat_dom_id;?>" >Category <sup>(Required)</sup> </label>
                    <select id="<?php echo $cat_dom_id;?>" required title="Category the business belongs to" class="editable form-control business_category" disabled>
                        <?php
                            $categories = DbInfo::GetAllCategories();

                            //If there are any categories
                            if($categories):
                                foreach($categories as $cat):
                                    $selected_attr = "";
                                    //Make the current account's cat_id the actively selected category 
                                    if($cat["cat_id"]==$cat_id)
                                    {
                                        $selected_attr = 'selected="selected"';
                                    }
                            
                        ?>
                            <option value="<?php echo $cat["cat_id"];?>" <?php echo $selected_attr;?>><?php echo $cat["cat_name"];?></option>
                        <?php
                                endforeach;
                            else:
                        ?>
                        <option value="0">No Categories found</option>
                        <?php
                            endif;
                        ?>
                    </select>
                </div>
                
                <?php
                    $cur_region_id = $acc["region_id"];
                    $cur_country_id = DbInfo::GetCountryByRegion($cur_region_id);
                ?>
                <div class="col-xs-12 col-sm-4 col-md-3 form-group location_control input-container">
                    <br>
                    <label for="in_country_<?php echo $acc_id?>" class="control-label country">Country <sup>(Required)</sup></label>
                    <select class="editable form-control country_list" required disabled id="in_country_<?php echo $acc_id?>" title="Country your business is located in">
                        <?php
                            if(@$countries && $countries->num_rows>0):
                                $count = 0;
                                $selected_state = "";
                                foreach($countries as $country):
                                    $country_id = $country["country_id"];
                                    $country_name = $country["country_name"];

                                    if($country_id == $cur_country_id)
                                    {
                                        $selected_state = "selected";
                                    }
                                    else
                                    {
                                       $selected_state = "";          
                                    }
                           
                                    #If the country is the first country
                                    if($count==0)
                                    {
                                        #get the regions for that country
                                        $regions = DbInfo::GetRegionsInCountry($country_id);
                                    }
                        ?>
                        <option value="<?php echo $country_id?>" <?php echo $selected_state?>><?php echo strtoupper($country_name)?></option>
                        <?php
                                $count++;
                                endforeach;
                            else:
                        ?>
                        <option value="0" selected disabled>No countries found</option>
                        <?php
                            endif;
                        ?>
                    </select>
                </div>

                <div class="col-xs-12 col-sm-4 col-md-3 form-group location_control input-container">
                    <br>
                    <label for="in_region_<?php echo $acc_id?>" class="control-label region">Region <sup>(Required)</sup></label>
                    <select class="editable form-control region_list" required disabled id="in_region_<?php echo $acc_id?>" required title="Region your business is located in">
                        <?php
                            if(@$regions && $regions->num_rows>0):
                                $selected_state = "";
                                foreach($regions as $region):
                                    $region_id = $region["region_id"];
                                    
                                    if($region_id == $cur_region_id)
                                    {
                                        $selected_state = "selected";
                                    }
                                    else
                                    {
                                       $selected_state = "";          
                                    }
                           
                                    $region_name = $region["region_name"];
                        ?>
                        <option value="<?php echo $region_id;?>" <?php echo $selected_state?>><?php echo strtoupper($region_name);?></option>
                        <?php
                                endforeach;
                            else:
                        ?>
                        <option value="0" selected disabled>No regions found</option>
                        <?php
                            endif;
                        ?>
                    </select>
                </div>

                <div class="col-xs-12 col-sm-4 col-md-6 form-group input-container">
                    <br>
                    <label for="in_location_<?php echo $acc_id?>" class="control-label">Location <sup>(Recommended)</sup></label>
                    <input type="text" class="editable form-control location" id="in_location_<?php echo $acc_id?>" placeholder="Specific location (Optional)" title="Specific location for the business. Users can find your business by searching for businesses in this location" disabled value="<?php echo $acc['specific_location'];?>">
                </div>
                
                <div class="col-xs-12 col-md-6 input-container">
                    <br>
                    <label for="<?php echo $bus_descr_id;?>">Business description <sup>(Optional)</sup> </label>
                    <textarea class="editable form-control business_description" disabled placeholder="No business description set" id="<?php echo $bus_descr_id;?>" title="Business description. Brief description of what the business does"><?php echo $business_descr;?></textarea>
                </div>
            </form>
            <hr><h4>EXTRA INFORMATION</h4><hr>
            <div class="container">
                <p><strong>Date Created : </strong>
                    <span><?php echo $acc["date_created"]?></span>
                </p>
                <p><strong>Date Activated : </strong>
                    <span><?php echo $acc["date_activated"]?></span>
                </p>
                <p><strong>Date Expires : </strong>
                    <span><?php echo $acc["date_expires"]?></span>
                </p>              
            </div>

          </div>
        </div>
      </div>
    <?php
//            $count++;
        endforeach;   
    ?>
    </div>
<?php
    else:#No accounts were found
?>
    <div>
        <?php
            MessageDisplay::PrintInfo($missing_acc_msg,$missing_acc_id);
        ?> 
    </div>
<?php
    endif;
?>
</div>