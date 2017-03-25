    <!--Tab body-->
    <div class="container well">

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

    <?php
        $items = DbInfo::GetAllItems(); #Get all the items
        if($items && $items->num_rows>0):    
    ?>
    <!--Accordion-->
    <div class="panel-group" id="manage_featured_group">
    <?php
            $item_description = "";
        
            //Loop through each category creating a dropdown item
            foreach($items as $item):
                $item_id = $item["item_id"];
                $collapse_id = "item_".$item_id;
                $item_name = $item["item_name"];
                $poster_name = $item["acc_id"];//TODO : perform inner join
                echo "Item name";
                //Setting the item description
                $item_description = "No description available";
                if($descr = $item["description"])
                {
                    $item_description = $descr;
                }
    ?>
      <div class="panel panel-default manage-cat-item" data-item-id="<?php echo $items;?>">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#manage_featured_group" href="#<?php echo $collapse_id;?>">
            <?php echo $item_name." - posted by ".ucfirst($poster_name);?> <span class="caret"></span></a>
            <span class="pull-right action-buttons">
                <a class="btn btn-info manage-edit-btn"><span class="glyphicon glyphicon-edit"></span> Make Featured</a>
            </span>
          </h4><br>
        </div>
          
        <div id="<?php echo $collapse_id;?>" class="panel-collapse collapse">
          <div class="panel-body"><?php echo $item_description;?></div>
        </div>
      </div>
    <?php
            $count++;
            endforeach;   
    ?>
    </div>
    <?php
        else:
    ?>
    <div>
        <p class="text-center">No items were found in the database. <br>Once business owners post items, they will appear here and you can set the featured items.</p>    
    </div>
    <?php
        endif;
    ?>

    </div>