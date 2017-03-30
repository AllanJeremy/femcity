<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Femcity | Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="css/fileinput.min.css" media="all" rel="stylesheet">
    <link href="../css/toastr.min.css" rel="stylesheet">
</head>

<body>
    <?php
        require_once("../handlers/session_handler.php");
    
        /*//If the admin is not logged in ~ redirect them to the login page
        if(!MySessionHandler::AdminIsLoggedIn())
        {
            header("Location:login.php");
            exit(); #Stop execution of this script
        }
        */
        $snippets_dir ="snippets/"; #Snippets folder
        $display_tab = ""; #Tab that should be displayed
        
        $action = @$_GET["action"]; #True if the state is the logout state
        if(isset($action))
        {
            //Handle the different actions
            switch($action)
            {
                case "logout":
                    MySessionHandler::AdminLogout();#Log the admin out
                    header("Location:login.php");#redirect the admin to the login page
                break;
            }
        }
        
        $current_page = htmlspecialchars(@$_GET["p"]); #Get the page get variable
    
        //Check for current active tab
        if(isset($current_page))
        {
            switch($current_page)
            {
                case "create":
                    $display_tab = $snippets_dir."post_items_tab.php";
                break;
                case "manage":
                    $display_tab = $snippets_dir."manage_items_tab.php";
                break;                
                case "profile":
                    $display_tab = $snippets_dir."profile_tab.php";
                break;
                default:
                    $display_tab = $snippets_dir."post_items_tab.php";
            }
        }
        else
        {
            $display_tab = $snippets_dir."categories_tab.php";
        }
    ?>
    <header>
        <?php
            include_once("snippets/navigation.php");
            $nav = new AdminNavigation($current_page);
        ?>
    </header>
    <main>
        <div class="container">
        <?php
            @include_once($display_tab);
        ?>
        </div>
    </main>
    <footer>
        
    </footer>
    <!--Javascript files-->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/toastr.min.js"></script>
    
    <!-- canvas-to-blob.min.js is only needed if you wish to resize images before upload.
         This must be loaded before fileinput.min.js -->
    <script src="js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
         This must be loaded before fileinput.min.js -->
    <script src="js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
         This must be loaded before fileinput.min.js -->
    <script src="js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <script src="js/fileinput.min.js"></script>
    
    <script type="text/javascript" src="js/event_handler.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
