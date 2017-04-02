<?php
    //Get the active tab
    require_once("tab_manager.php");#Variables ~ $is_create, $create_tab_class, $manage_tab_class
    
    //Current page
    $current_page = "accounts";

    //Variables for the different urls
    $create_url = "index.php?p=".$current_page."&tab=create";
    $manage_url = "index.php?p=".$current_page."&tab=manage";

    //Display the tab headers below
?>
    <!--Tab headers-->
    <div class="container">
		<ul class="nav nav-pills col-xs-offset-4 col-sm-offset-5">
            <li class="<?php echo $create_tab_class;?>"><a href="<?php echo $create_url; ?>">Create</a></li>
            <li class="<?php echo $manage_tab_class;?>"><a href="<?php echo $manage_url; ?>">Manage</a></li>
		</ul>
    </div><br><br>
    <!--Tab body-->
    <div class="container well tab-body">
<?php
    //If the active tab is the create tab ~ Display the create tab only
    if($is_create):#Create tab active
?>
    <div>
        <p>Create a new admin account here</p>    
    </div><hr>
        
    <form class="row input-list" method="post">  
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_admin_first_name">First name <sup>(Required)</sup> </label>
            <input class="form-control" required type="text" placeholder="First name" id="in_admin_first_name" title="First name of the business owner">
        </div>
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_admin_last_name">Last name <sup>(Required)</sup></label>
            <input class="form-control" required type="text" placeholder="Last name" id="in_admin_last_name" title="Last name of the business owner">
        </div>
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_admin_first_name">Email address <sup>(Required)</sup></label>
            <input class="form-control" required type="email" placeholder="Email address" id="in_admin_email" title="Email of the business/business owner. Used to login to the account.">
        </div>
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_admin_phone">Phone number <sup>(Required)</sup></label>
            <input class="form-control" required type="text" placeholder="Phone number" id="in_admin_phone" title="Phone number of the business/business owner. Used to login to the account.">
        </div>
        
<!--
        <div class="col-xs-12 col-sm-6 col-md-4 input-container">
            <br>
            <label for="in_admin_first_name">Country</label>
            <input class="form-control" required type="text" placeholder="Country the business belongs to" id="in_admin_country" title="Phone number of the business/business owner. Used to login to the account.">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 input-container">
            <br>
            <label for="in_admin_first_name">Region</label>
            <input class="form-control" required type="text" placeholder="Country the business belongs to" id="in_admin_country" title="Phone number of the business/business owner. Used to login to the account.">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 input-container">
            <br>
            <label for="in_admin_first_name">Sub-region</label>
            <input class="form-control" required type="text" placeholder="Country the business belongs to" id="in_admin_country" title="Phone number of the business/business owner. Used to login to the account.">
        </div>
-->
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_admin_business_name">Business name <sup>(Required)</sup> </label>
            <input class="form-control" type="text" required placeholder="Business name" id="in_admin_business_name" title="Name of the business/company that owns this account">
        </div>
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_business_category">Category <sup>(Required)</sup> </label>
            <select id="in_business_category" required title="Category the business belongs to" class="form-control">
                <?php
                    $categories = DbInfo::GetAllCategories();
                    
                    //If there are any categories
                    if($categories):
                        foreach($categories as $cat):
                ?>
                    <option value="<?php echo $cat["cat_id"];?>"><?php echo $cat["cat_name"];?></option>
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
        <div class="col-xs-12 col-md-6 input-container">
            <br>
            <label for="in_cat_description">Business description <sup>(Optional)</sup> </label>
            <textarea class="form-control" type="text" placeholder="Business description" name="business_description" id="in_business_description" title="Business description. Brief description of what the business does"></textarea>
        </div>


        <div class="col-xs-12">
            <br>
            <a class="btn btn-info pull-right" title="Create a new admin account" href="javascript:void(0)" id="createAdminAccount">CREATE ACCOUNT</a>
        </div>
    </form>
<?php
    else:#Manage tab active
        $admin_accounts = Dbinfo::GetAllAdminAccounts();
        if($admin_accounts && $admin_accounts->num_rows>0):
?>
    <!--Category list-->
    <div class="container">
        <!--Category list-->
        <div class="col-xs-12 col-sm-6">
            <p>Manage admin accounts here.</p>
        </div>
        <div class="col-xs-12 col-sm-6 pull-right row clearfix">
            <div class="col-xs-10">
                <input class="form-control" type="search" id="search_manage_acccounts" placeholder="Search Accounts">
            </div>
            <div class="col-xs-2">
                <button class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </div>
    </div><hr>
        
    <!--Accordion-->
    <div class="panel-group" id="manage_accounts_group">
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
            <?php echo $acc_name.", ".$business_name;?> <span class="caret"></span></a>
            <div class="pull-right action-buttons">
                <a class="btn btn-info editable-trigger-btn" data-edit-type="<?php echo $current_page;?>" data-state-toggle="save"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                <a class="btn btn-info manage-reset-btn"><span class="glyphicon glyphicon-refresh"></span> Reset</a>
                <a class="btn btn-warning manage-ban-btn"><span class="glyphicon glyphicon-ban-circle"></span> Ban</a>
                <a class="btn btn-warning manage-delete-btn"><span class="glyphicon glyphicon-trash"></span> Delete</a>
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
                    <input class="editable form-control" required disabled type="text" placeholder="First name" name="admin_first_name" id="<?php echo $first_name_id;?>" title="First name of the business owner" value="<?php echo $acc["first_name"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $last_name_id;?>" >Last name <sup>(Required)</sup> </label>
                    <input class="editable form-control" required disabled type="text" placeholder="Last name" name="admin_last_name" id="<?php echo $last_name_id;?>" title="Last name of the business owner" value="<?php echo $acc["last_name"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $email_id;?>" >Email address <sup>(Required)</sup></label>
                    <input class="editable form-control" required disabled type="email" placeholder="Email address" name="admin_email" id="<?php echo $email_id;?>" title="Email of the business/business owner. Used to login to the account." value="<?php echo $acc["email"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="admin_phone_<?php echo $acc_id;?>">Phone number <sup>(Required)</sup></label>
                    <input class="editable form-control" required disabled type="text" placeholder="Phone number" id="admin_phone_<?php echo $acc_id;?>" title="Phone number of the business/business owner. Used to login to the account." value="<?php echo $acc["phone"];?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $bus_name_id;?>">Business name <sup>(Required)</sup> </label>
                    <input class="editable form-control" required disabled type="text" placeholder="Business name" name="admin_business_name" id="<?php echo $bus_name_id;?>" title="Name of the business/company that owns this account" value="<?php echo $business_name;?>">
                </div>
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $cat_dom_id;?>" >Category <sup>(Required)</sup> </label>
                    <select id="<?php echo $cat_dom_id;?>" required title="Category the business belongs to" class="editable form-control disabled" disabled>
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
                <div class="col-xs-12 col-md-6 input-container">
                    <br>
                    <label for="<?php echo $bus_descr_id;?>">Business description <sup>(Optional)</sup> </label>
                    <textarea class="editable form-control" disabled placeholder="No business description set" name="business_description" id="<?php echo $bus_descr_id;?>" title="Business description. Brief description of what the business does"><?php echo $business_descr;?></textarea>
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
        else:#No categories were found
?>
    <div>
        <?php
            MessageDisplay::PrintInfo("No admin accounts were found. Once you create admin accounts, they will appear here");
        ?> 
    </div>
<?php
        endif;
    endif;
?>
    </div>