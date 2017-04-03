<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Femcity | Superuser Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/toastr.min.css" rel="stylesheet">
</head>

<body>
    <?php
        require_once("../handlers/message_display.php");
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
        
        $action = htmlspecialchars(@$_GET["action"]); #True if the state is the logout state
        if(isset($action))
        {
            //Handle the different actions
            switch($action)
            {
                case "logout":
                    MySessionHandler::SuperuserLogout();#Log the superuser out
                    header("Location:login.php");#redirect the superuser to the login page
                break;
            }
        }
        
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
                case "profile":
                    $display_tab = $snippets_dir."profile_tab.php";
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
        <!-- Confirm delete modal -->
        <div class="modal fade confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" id="confirmDeleteModal">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <h5>
                        Are you sure you want to delete the selected <span id="confirmDeleteType">item</span>?
                        <br><br><small><b>Note:</b> This process is irreversible</small>
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn_confirm_delete"><span class="glyphicon glyphicon-ok"></span> Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
          </div>
        </div>
        <div class="container">
        <?php
            include_once($display_tab);
        ?>
        </div>
    </main>
    <footer>
        
    </footer>
    <!--Javascript files-->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/toastr.min.js"></script>
    
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/event_handler.js"></script>
    
</body>
</html>
