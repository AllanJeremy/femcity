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
            <select id="in_business_category" title="Category the business belongs to">
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
        if($admin_accounts):
?>
    <!--Category list-->
    <div>
        <p>Manage admin accounts here</p>    
    </div><hr> 
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