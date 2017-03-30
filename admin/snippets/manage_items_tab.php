<?php
    $items_posted = DbInfo::GetAllItems();

    //$items_posted = DbInfo::GetItemsByAccId($acc_id);
?>
    <div class="container">
        <div class="col-xs-12 col-sm-6">
            <p>Manage item posts here.</p>
        </div>
        <div class="col-xs-12 col-sm-6 pull-right row clearfix">
            <div class="input-group">
                <input class="form-control" type="search" id="search_manage_offers" placeholder="Search here...">
                <div class="input-group-btn">
                    <button class="btn btn-default" title="Search here...">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div><hr> 
        
    <!--Accordion-->
    <div class="panel-group" id="manage_items_group">
    <?php
        $cat_id="";
        $count = 0;#iterator
        $open_state = "";
        
        //Loop through each category creating a dropdown item
        foreach($items_posted as $item):
            $item_id = $item["item_id"];
            $item_name = $item["item_name"];
            $item_type = $item["type"];
            $item_descr = $item["description"];
            $item_images = $item["images"];
            $item_price = $item["price"];
            $item_quantity = $item["quantity"];
            $item_discount = $item["discount"];
            //$item_acc_id = $item["acc_id"];
            $item_date_added = $item["date_added"];
            
            //DOM ids
            $collapse_id = "item_".$item_id; #Collapse trigger id
            $item_name_id = $collapse_id."_name"; #Item name id
            $item_descr_id = $collapse_id."_descr"; #Item description id
            $item_type_id = $collapse_id."_type"; #Item type id
            //If it is the first category, make the collapsible open by default
            if($count==0)
            {   $open_state="in";}
            else
            {   $open_state="";}
    ?>
      <div class="panel panel-default manage-items" data-item-id="<?php echo $item_id;?>">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#manage_items_group" href="#<?php echo $collapse_id;?>">
            <?php echo $item_name;?> <span class="caret"></span></a>
            <span class="pull-right action-buttons">
                <a class="btn btn-info editable-trigger-btn" data-edit-type="<?php echo $current_page;?>" data-state-toggle="save"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                <a class="btn btn-warning manage-delete-btn"><span class="glyphicon glyphicon-trash"></span> Delete</a>
            </span>
          </h4><br>
        </div>
          
        <div id="<?php echo $collapse_id;?>" class="panel-collapse collapse <?php echo $open_state;?>">
          <div class="panel-body">
              <form class="row editable-list" method="post">  
                <div class="col-xs-12 col-sm-6">
                    <br>
                    <label for="item_name_<?php echo $item_id;?>">Item Name</label>
                    <input type="text" disabled class="editable form-control" placeholder="Name of the product/service" id="item_name_<?php echo $item_id;?>" value="<?php echo $item_name;?>">
                </div>
                <div class="col-xs-12 col-sm-6">
                    <br>
                    <label for="item_descr_<?php echo $item_id;?>">Item Description</label>
                    <textarea  disabled class="editable form-control" placeholder="Product/Service Description" id="item_descr_<?php echo $item_id;?>"><?php echo $item_descr;?></textarea>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <br>
                    <label for="item_price_<?php echo $item_id;?>">Price</label>
                    <div class="input-group">
                        <span class="input-group-addon">Ksh</span>
                        <input type="number" min="10" max="100000" value="<?php echo $item_price;?>" disabled class="editable form-control validate-number" id="item_price_<?php echo $item_id;?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <br>
                    <label for="item_discount_<?php echo $item_id;?>">Discount</label>
                    <div class="input-group">
                        <span class="input-group-addon">Ksh</span>
                        <input type="number" min="0" max="100000" value="<?php echo $item_discount;?>" disabled class="editable form-control validate-number" id="item_discount_<?php echo $item_id;?>"  value="<?php echo $item_name;?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <br>
                    <label for="item_type_<?php echo $item_id;?>">Item type</label>
                    <select disabled class="editable form-control" id="item_type_<?php echo $item_id;?>">
                        <option value="product" selected>Product</option>
                        <option value="service">Service</option>
                    </select>
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