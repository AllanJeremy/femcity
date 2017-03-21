<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Femcity | Superuser Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
    <?php
        require_once("../handlers/session_handler.php");
    
        /*//If the superuser is not logged in ~ redirect them to the login page
        if(!MySessionHandler::SuperuserIsLoggedIn())
        {
            header("Location:login.php");
            exit(); #Stop execution of this script
        }
        */
        $snippets_dir ="snippets/"; #Snippets folder
        $display_tab = ""; #Tab that should be displayed
        
        $current_page = htmlspecialchars(@$_GET["p"]); #Get the page get variable
    
        //Check for current active tab
        if(isset($current_page))
        {
            switch($current_page)
            {
                case "categories":
                    $display_tab = $snippets_dir."categories_tab.php";
                break;
                case "accounts":
                    $display_tab = $snippets_dir."accounts_tab.php";
                break;                
                case "featured":
                    $display_tab = $snippets_dir."featured_items_tab.php";
                break;
                case "offers":
                    $display_tab = $snippets_dir."offers_tab.php";
                break;                
                case "requests":
                    $display_tab = $snippets_dir."account_requests_tab.php";
                break;
                default:
                    $display_tab = $snippets_dir."categories_tab.php";
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
            $nav = new SuperuserNavigation($current_page);
        ?>
    </header>
    <main>
        <div class="container">
        <?php
            include_once($display_tab);
        ?>
        </div>
    </main>
    <footer>
        
    </footer>
    <script>
        
    </script>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
