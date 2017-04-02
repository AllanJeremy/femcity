<?php

    //Adds items to the DOM ~ must be inside a panel-group, since the items are panels used as accordions
    function AddItemsToDOM($items_to_add,$is_featured=false)
    {   
        //Appropriate classes for the buttons
        $state_toggle = $btn_glyph_class = $btn_class = $btn_text = "";
        
        $item_type="";#This represents the item type ~ either featured_item or other_item
        
        //If the button for the items is the add button ~ set the glyphicon class and button text + class
        if($is_featured)
        {
            $item_type="featured";
            $btn_class = "btn-warning";
            $btn_glyph_class = "glyphicon-minus removeFeaturedItem";
            $btn_text = "Remove";      
            $state_toggle = "add";#state toggle is remove because remove toggles to add
        }
        else
        {
            $item_type="other";
            $btn_class = "btn-info addFeaturedItem";
            $btn_glyph_class = "glyphicon-plus";
            $btn_text = "Add";
            $state_toggle = "remove";#state toggle is remove because add toggles to remove
        }
        
        //If the items to add were found
        if($items_to_add && $items_to_add->num_rows>0):
    
            //Loop through each category creating a dropdown item
            foreach($items_to_add as $item):
                $item_id = $item["item_id"];
                $collapse_id = "item_".$item_id;
                $item_name = $item["item_name"];
                $item_descr = $item["description"];
        
                //Admin vavriables
                $admin = MySessionHandler::GetAdminById($item["acc_id"]);
                $admin_bus_name = "Unknown Admin";#Admin business name
                $admin_full_name = "Uknown";
                if($admin)
                {
                    $admin_full_name = $admin["first_name"]." ".$admin["last_name"];
                    $admin_bus_name = $admin["business_name"];
                }
        
            //DOM ids
            $item_name_id = $collapse_id."_name";
            $item_descr_id = $collapse_id."_descr";
?>
    <div class="panel panel-default manage-items" data-item-id="<?php echo $item_id;?>">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#manage_cat_group" href="#<?php echo $collapse_id;?>">
            <?php echo $item_name." - by ".$admin_full_name." ($admin_bus_name)";?> <span class="caret"></span></a>
            <span class="pull-right action-buttons">
                <a class="btn <?php echo $btn_class;?> add-trigger-btn" data-state-toggle="<?php echo $state_toggle;?>"><span class="glyphicon <?php echo $btn_glyph_class;?>"></span> <?php echo $btn_text;?></a>
                <a class="btn btn-warning manage-delete-btn delete-item"><span class="glyphicon glyphicon-trash"></span> Delete</a>
            </span>
          </h4><br>
        </div>
          
        <div id="<?php echo $collapse_id;?>" class="panel-collapse collapse">
          <div class="panel-body">
              <form class="row editable-list" method="post">  
                <div class="col-xs-12 col-md-6">
                    <br>
                    <label for="<?php echo $item_name_id;?>" >Item Name </label>
                    <input class="editable form-control" disabled type="text" placeholder="Category name" id="<?php echo $item_name_id;?>" title="Item name" value="<?php echo $item_name;?>">
                </div>

                <div class="col-xs-12 col-md-6">
                    <br>
                    <label for="<?php echo $item_descr_id;?>">Item Description </label>
                    <textarea class="editable form-control" disabled type="text" placeholder="No description available for this item. Click edit to add one." id="<?php echo $item_descr_id;?>" title="Item Description"><?php echo $item_descr;?></textarea>
                </div>
            </form>
          </div>
        </div>
    </div>
<?php
            endforeach;
            return true;
        else:
            return false;
        endif;
    } #End of function
?>

    <!--Tab body-->
    <div class="container well">

    <?php
        $items = DbInfo::GetAllItems(); #Get all the items
        if($items && $items->num_rows>0):    
    ?>
    <!--Manage featured items header-->
    <div class="container">
            <div class="col-xs-12 col-sm-6">
                <p>Manage featured items here.</p>
            </div>
            <div class="col-xs-12 col-sm-6 pull-right row clearfix">
                <div class="col-xs-10">
                    <input class="form-control" type="search" id="search_manage_featured" placeholder="Search Items">
                </div>
                <div class="col-xs-2">
                    <button class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </div><hr> 

    <!--Accordion-->
    <div class="panel-group" id="manage_featured_group">
        <h4>FEATURED ITEMS</h4><hr>
    <?php
            $item_description = "";

            $featured_items = DbInfo::GetAllFeaturedItems(); #Get all the featured items

            //Message shown when no items are found and the id of the message box the message is displayed in
            $no_featured_msg = "No featured items found in the database.";
            $no_featured_id="no_featured_msg";

            //If featured items were found
            if($featured_items && $featured_items->num_rows>0)
            {
                MessageDisplay::PrintHiddenInfo($no_featured_msg,$no_featured_id); 
                AddItemsToDOM($featured_items,true); #Add the featured items to the DOM
            }
            else #No featured items found
            {
                MessageDisplay::PrintInfo($no_featured_msg,$no_featured_id); 
            }        
        
    ?>
        <br><hr><h4>OTHER ITEMS</h4><hr>
    </div>
    <?php
            //Other items
            $other_items = DbInfo::GetAllOtherItems();
        
            //Message shown when no items are found and the id of the message box the message is displayed in
            $no_other_msg = "No other items found in the database.";
            $no_other_id = "no_other_msg";
            
            //If other items were found
            if($other_items && $other_items->num_rows>0)
            {
                MessageDisplay::PrintHiddenInfo($no_other_msg,$no_other_id);    
                AddItemsToDOM($other_items,false); #Add the featured items to the DOM
            }
            else #No other items were found
            {
                MessageDisplay::PrintInfo($no_other_msg,$no_other_id);
            }

        else:
    ?>
    <div class="container">
        <?php MessageDisplay::PrintInfo("No items were found in the database. <br>Once business owners post items, they will appear here and you can set the featured items.");?>    
    </div>
    <?php
        endif;
    ?>

    </div>