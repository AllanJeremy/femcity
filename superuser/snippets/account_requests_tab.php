<?php
    //Get the active tab
    require_once("tab_manager.php");#Variables ~ $is_create, $create_tab_class, $manage_tab_class
    //Display the tab headers below
?>
    <!--Tab headers-->
    <div>
		<ul class="nav nav-tabs nav-justified">
            <li style=$tabStyle class='active'><a href="javascript:void(0)">Create</a></li>
            <li style=$tabStyle class=''><a href="javascript:void(0)">Manage</a></li>
		</ul>
    </div>
<?php
    //If the active tab is the create tab ~ Display the create tab only
    if($is_create):#Create tab active
?>

<?php
    else:#Manage tab active
?>

<?php
    endif;
?>