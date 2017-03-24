<?php
    /*THIS FILE HANDLES THE DETERMINING OF WHICH TAB IS ACTIVE FOR CREATE | MANAGE TAB BASED PAGES
        ~ $is_create can be used to check if the create tab is currently active, if it is not, then the manage tab is active
        ~ Note : this manager only works for pages that only have 2 tabs, CREATE and MANAGE
    */
    require_once("../handlers/db_handler.php");

    $active_tab = htmlspecialchars(@$_GET["tab"]);
    $is_create = false; #if this is true, then the active tab is create, if it is false, then the active tab is false
    
    const ACTIVE_CLASS = "active";
    $create_tab_class = "";
    $manage_tab_class = "";

    if(isset($active_tab))
    {
        switch($active_tab)
        {
            case "create":
                //Display create tab  
                $create_tab_class = ACTIVE_CLASS;
                $is_create = true;
            break;
            case "manage":
                //Display manage tab
                $manage_tab_class = ACTIVE_CLASS;
                $is_create = false;
            break;
            default:
                $create_tab_class = ACTIVE_CLASS;
                $is_create = true;
        }
    }
    else #Active tab not set
    {
        $create_tab_class = ACTIVE_CLASS;
        $is_create = true;
    }
?>