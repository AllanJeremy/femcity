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
        
    <form class="row" method="post">  
        <div class="col-xs-12 col-sm-6">
            <br>
            <label for="in_admin_first_name" >First name </label>
            <input class="form-control" type="text" placeholder="First name" name="admin_first_name" id="in_admin_first_name" title="First name of the business owner">
        </div>
        <div class="col-xs-12 col-sm-6">
            <br>
            <label for="in_admin_last_name" >Last name </label>
            <input class="form-control" type="text" placeholder="Last name" name="admin_last_name" id="in_admin_last_name" title="Last name of the business owner">
        </div>
        <div class="col-xs-12 col-sm-6">
            <br>
            <label for="in_admin_first_name" >Email address</label>
            <input class="form-control" type="email" placeholder="Email address" name="admin_email" id="in_admin_email" title="Email of the business/business owner. Used to login to the account.">
        </div>
        <div class="col-xs-12 col-md-6">
            <br>
            <label for="in_admin_business_name" >Business name </label>
            <input class="form-control" type="text" placeholder="Business name" name="admin_business_name" id="in_admin_business_name" title="Name of the business/company that owns this account">
        </div>
        <div class="col-xs-12 col-sm-6">
            <br>
            <label for="in_business_category" >Category </label>
            <select id="in_business_category" title="Category the business belongs to" class="form-control">
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
        <div class="col-xs-12 col-sm-6">
            <br>
            <label for="in_cat_description">Business description </label>
            <textarea class="form-control" type="text" placeholder="Business description" name="business_description" id="in_business_description" title="Business description. Brief description of what the business does"></textarea>
        </div>


        <div class="col-xs-12 pull-right">
            <br>
            <button type="submit" class="btn btn-primary" title="Create a new category" href="javascript:void(0)" id="createCategory">CREATE ACCOUNT</button>
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
        $count = 0;#iterator
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
            
            //If it is the first category, make the collapsible open by default
            if($count==0)
            {   $open_state="in";}
            else
            {   $open_state="";}
    ?>
      <div class="panel panel-default manage-admin-account" data-acc-id="<?php echo $acc_id;?>">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#manage_accounts_group" href="#<?php echo $collapse_id;?>">
            <?php echo $acc_name.", ".$business_name;?> <span class="caret"></span></a>
            <div class="pull-right action-buttons">
                <a class="btn btn-info editable-trigger-btn" data-state-toggle="edit"><span class="glyphicon glyphicon-edit"></span> Edit</a>
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
                <div class="col-xs-12 col-sm-6">
                    <br>
                    <label for="in_admin_first_name" >First name </label>
                    <input class="editable form-control" disabled type="text" placeholder="First name" name="admin_first_name" id="in_admin_first_name" title="First name of the business owner" value="<?php echo $acc["first_name"];?>">
                </div>
                <div class="col-xs-12 col-sm-6">
                    <br>
                    <label for="in_admin_last_name" >Last name </label>
                    <input class="editable form-control" disabled type="text" placeholder="Last name" name="admin_last_name" id="in_admin_last_name" title="Last name of the business owner" value="<?php echo $acc["last_name"];?>">
                </div>
                <div class="col-xs-12 col-sm-6">
                    <br>
                    <label for="in_admin_first_name" >Email address</label>
                    <input class="editable form-control" disabled type="email" placeholder="Email address" name="admin_email" id="in_admin_email" title="Email of the business/business owner. Used to login to the account." value="<?php echo $acc["email"];?>">
                </div>
                <div class="col-xs-12 col-md-6">
                    <br>
                    <label for="in_admin_business_name">Business name </label>
                    <input class="editable form-control" disabled type="text" placeholder="Business name" name="admin_business_name" id="in_admin_business_name" title="Name of the business/company that owns this account" value="<?php echo $business_name;?>">
                </div>
                <div class="col-xs-12 col-sm-6">
                    <br>
                    <label for="in_business_category" >Category </label>
                    <select id="in_business_category" title="Category the business belongs to" class="editable form-control disabled" disabled>
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
                <div class="col-xs-12 col-sm-6">
                    <br>
                    <label for="in_cat_description">Business description </label>
                    <textarea class="editable form-control" disabled placeholder="No business description set" name="business_description" id="in_business_description" title="Business description. Brief description of what the business does"><?php echo $business_descr;?></textarea>
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
            $count++;
        endforeach;   
    ?>
    </div>
<?php
        else:#No categories were found
?>
    <div>
        <p>No admin accounts were found. Once you create admin accounts, they will appear here</p>    
    </div>
<?php
        endif;
    endif;
?>
    </div>