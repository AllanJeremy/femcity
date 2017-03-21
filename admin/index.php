<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Femcity | Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
