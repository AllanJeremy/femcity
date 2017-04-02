<?php
    //Get the active tab
    require_once("tab_manager.php");#Variables ~ $is_create, $create_tab_class, $manage_tab_class

    //Current page
    $current_page = "categories";

    //Variables for the different urls
    $create_url = "index.php?p=".$current_page."&tab=create";
    $manage_url = "index.php?p=".$current_page."&tab=manage";

    //Display the tab headers below
?>
    <!--Tab headers-->
    <div class="container row">
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
        <p>Create a new category here</p>    
    </div><hr>
        
    <form class="row input-list" method="post">  
        <div class="form-group col-xs-12 col-md-6 input-container has-feedback">
<!--            <br>-->
            <label for="in_cat_name" >Category Name <sup>(Required)</sup></label>
            <input class="form-control" type="text" placeholder="Category name" required name="cat_name" id="in_cat_name" title="Category Name. This field is required">
        </div>
        
        <div class="form-group col-xs-12 col-md-6 input-container has-feedback">
<!--            <br>-->
            <label for="in_cat_description">Category Description <sup>(Optional)</sup></label>
            <textarea class="form-control" type="text" placeholder="Category Description" name="cat_description" id="in_cat_description" title="Category Description"></textarea>
        </div>
        <div class="form-group col-xs-12">
<!--            <br>-->
            <a class="btn btn-info pull-right" title="Create a new category" href="javascript:void(0)" id="createCategory">CREATE CATEGORY</a>
        </div>
    </form>
<?php
    else:#Manage tab active
        $categories = DbInfo::GetAllCategories();
        if($categories && $categories->num_rows>0):
?>
    <!--Category list-->
    <div class="container">
        <div class="col-xs-12 col-sm-6">
            <p>Manage categories here.</p>
        </div>
        <div class="col-xs-12 col-sm-6 pull-right row clearfix">
            <div class="col-xs-10">
                <input class="form-control" type="search" id="search_manage_cat" placeholder="Search Categories">
            </div>
            <div class="col-xs-2">
                <button class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </div>
    </div><hr> 
        
    <!--Accordion-->
    <div class="panel-group" id="manage_cat_group">
    <?php
        $cat_id="";
        $count = 0;#iterator
        $open_state = "";
        
        //Loop through each category creating a dropdown item
        foreach($categories as $cat):
            $cat_id = $cat["cat_id"];
            $cat_name = $cat["cat_name"];
            $cat_description = $cat["cat_description"];
        
            $collapse_id = "cat_".$cat_id; #Collapse trigger id
        
            //If it is the first category, make the collapsible open by default
            if($count==0)
            {   $open_state="in";}
            else
            {   $open_state="";}
    ?>
      <div class="panel panel-default manage-items" data-cat-id="<?php echo $cat_id;?>">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#manage_cat_group" href="#<?php echo $collapse_id;?>">
            <?php echo $cat_name;?> <span class="caret"></span></a>
            <span class="pull-right action-buttons">
                <a class="btn btn-info editable-trigger-btn" data-edit-type="<?php echo $current_page?>" data-state-toggle="save"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                <a class="btn btn-warning manage-delete-btn"><span class="glyphicon glyphicon-trash"></span> Delete</a>
            </span>
          </h4><br>
        </div>
          
        <div id="<?php echo $collapse_id;?>" class="panel-collapse collapse <?php echo $open_state;?>">
          <div class="panel-body">
              <form class="row editable-list" method="post">  
                <div class="col-xs-12 col-md-6 input-container">
                    <br>
                    <label for="cat_name_<?php echo $cat_id;?>" >Category Name </label>
                    <input class="editable form-control cat_name" required disabled type="text" placeholder="Category name" id="cat_name_<?php echo $cat_id;?>" title="Category name" value="<?php echo $cat_name;?>">
                </div>

                <div class="col-xs-12 col-md-6 input-container">
                    <br>
                    <label for="cat_descr_<?php echo $cat_id;?>">Category Description </label>
                    <textarea class="editable form-control cat_description" disabled type="text" placeholder="No description available for this category. Click edit to add one." id="cat_descr_<?php echo $cat_id;?>" title="Category Description"><?php echo $cat_description;?></textarea>
                </div>
            </form>
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
    <div class="container">
        <?php MessageDisplay::PrintInfo("No categories were found. Once you create categories, they will appear here");?>  
    </div>
<?php
        endif;
    endif;
?>
    </div>