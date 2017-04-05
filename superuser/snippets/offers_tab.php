<?php
    //Get the active tab
    require_once("tab_manager.php");#Variables ~ $is_create, $create_tab_class, $manage_tab_class

    //Current page
    $current_page = "offers";

    //Variables for the different urls
    $create_url = "index.php?p=".$current_page."&tab=create";
    $manage_url = "index.php?p=".$current_page."&tab=manage";

//Message shown when categories cannot be found and the id for the message box(used as selector in js)
    $missing_offer_msg = "No offers were found. Once you create offers, they will appear here";
    $missing_offer_id = "missing_cat_msg";

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
        <p>Create an offer/promotion here</p>    
    </div><hr>
        
    <form class="row input-list" method="post">  
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_offer_name" >Offer Title <sup>(Required)</sup></label>
            <input class="form-control" required type="text" placeholder="Offer Title" id="in_offer_text" title="Offer Title">
        </div>
        
        <div class="col-xs-12 col-sm-6 input-container">
            <br>
            <label for="in_category">Category <sup>(Required)</sup></label>  
            <select id="in_category" required title="Category the business belongs to" class="form-control">
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
            <label for="in_offer_description">Offer Description <sup>(Optional)</sup></label>
            <textarea class="form-control" type="text" placeholder="Offer Description" id="in_offer_description" title="Offer Description"></textarea>
        </div>
        <div class="col-xs-12">
            <br>
            <a class="btn btn-info pull-right" title="Create a new offer" href="javascript:void(0)" id="createOffer">CREATE AN OFFER</a>
        </div>
    </form>
<?php
    else:#Manage tab active
        $offers = DbInfo::GetAllOffers();
        
        //If offers were found
        if($offers && $offers->num_rows>0):
            //Print hidden message for display when items run out
            MessageDisplay::PrintHiddenInfo($missing_offer_msg,$missing_offer_id);
?>
    <!--Offer list-->
    <div class="container manage-content">
        <div class="col-xs-12 col-sm-6">
            <p>Manage offers here.</p>
        </div>
        <div class="col-xs-12 col-sm-6 pull-right row clearfix">
            <div class="col-xs-10">
                <input class="form-control" type="search" id="search_manage_offers" placeholder="Search Offers">
            </div>
            <div class="col-xs-2">
                <button class="btn btn-default" title="Search offers">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </div>
    </div><hr> 
        
    <!--Accordion-->
    <div class="panel-group manage-content" id="manage_offers_group">
    <?php
        $cat_id="";
        $count = 0;#iterator
        $open_state = "";
        
        //Loop through each category creating a dropdown item
        foreach($offers as $offer):
            $offer_id = $offer["offer_id"];
            $offer_title = $offer["offer_text"];
            $offer_description = $offer["description"];
            $offer_cat_id = $offer["cat_id"];
                
            $collapse_id = "offer_".$offer_id; #Collapse trigger id
            $offer_name_id = $collapse_id."_name"; #Category name id
            $offer_descr_id = $collapse_id."_descr"; #Category description id
        
            //If it is the first category, make the collapsible open by default
            if($count==0)
            {   $open_state="in";}
            else
            {   $open_state="";}
    ?>
      <div class="panel panel-default manage-items" data-offer-id="<?php echo $offer_id;?>">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#manage_offers_group" href="#<?php echo $collapse_id;?>">
            <span class="accordion-title"><?php echo $offer_title;?></span> <span class="caret"></span></a>
            <span class="pull-right action-buttons">
                <a class="btn btn-info editable-trigger-btn" data-edit-type="<?php echo $current_page;?>" data-state-toggle="save"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                <a class="btn btn-warning manage-delete-btn delete_offer" data-toggle="modal" data-target=".confirm-delete-modal"><span class="glyphicon glyphicon-trash"></span> Delete</a>
            </span>
          </h4><br>
        </div>
          
        <div id="<?php echo $collapse_id;?>" class="panel-collapse collapse <?php echo $open_state;?>">
          <div class="panel-body">
              <form class="row editable-list" method="post">  
                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="<?php echo $offer_name_id;?>" >Offer title <sup>(Required)</sup></label>
                    <input class="editable form-control offer_text" required disabled type="text" placeholder="Offer title" id="<?php echo $offer_name_id;?>" title="Offer title" value="<?php echo $offer_title;?>">
                </div>

                <div class="col-xs-12 col-sm-6 input-container">
                    <br>
                    <label for="in_cat<?php echo $offer_id?>">Category <sup>(Required)</sup></label>  
                    <select id="in_cat<?php echo $offer_id?>" required title="Category the business belongs to" disabled class="editable form-control offer_category">
                        <?php
                            $categories = DbInfo::GetAllCategories();

                            //If there are any categories
                            if($categories):
                                
                                foreach($categories as $cat):
                                    $is_selected = "";#if the category is selected in the dropdown
                                    //Change the active selection
                                    if($cat["cat_id"]==$offer_cat_id)
                                    {
                                        $is_selected="selected";
                                    }
                                    
                        ?>
                            <option value="<?php echo $cat["cat_id"];?>" <?php echo $is_selected?>><?php echo $cat["cat_name"];?></option>
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
                    <label for="<?php echo $offer_descr_id;?>">Offer Description <sup>(Optional)</sup></label>
                    <textarea class="editable form-control offer_description" disabled type="text" placeholder="No description available for this offer. Click edit to add one." id="<?php echo $offer_descr_id;?>" title="Category Description"><?php echo $offer_description;?></textarea>
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
        else:#No offers were found
?>
    <div class="container">
        <?php MessageDisplay::PrintInfo($missing_offer_msg,$missing_offer_id);?>    
    </div>
<?php
        endif;
    endif;
?>
    </div>