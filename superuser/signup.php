<?php
    
    require_once("../handlers/message_display.php");#Controls displaying of message boxes

    function DisplaySignupBox()
    {
?>
                <div id="signupbox" style="margin-top:25px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Superuser Sign Up</div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form">
                                <div id="signupalert" class="alert alert-danger hidden">
                                    <p>Error:</p>
                                    <span></span>
                                </div>


                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="firstname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="lastname" placeholder="Last Name">
                                    </div>
                                </div>                               
                                <div class="form-group">
                                    <label for="username" class="col-md-3 control-label">Username</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="username" placeholder="Username">
                                    </div>
                                </div>
             
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="email" placeholder="Email Address">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" id="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="col-md-3 control-label">Confirm</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" id="confirm_pass" placeholder="Confirm password">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-xs-12">
                                        <a id="btn-signup" class="btn btn-info pull-right">Sign Up</a>
                                    </div>
                                </div>
                            </form>
                         </div>
                    </div>
                </div> 
<?php
    }

    //Require db handler for entering records into the database
    require_once("../handlers/db_handler.php");
    
    $superusers_found = DbInfo::GetAllSuperuserAccounts();#Returns super user accounts if they were found
    
    //If superuser accounts were found ~ redirect to login page.
    if($superusers_found && $superusers_found->num_rows>0)
    {
        echo "<p>Redirecting you to another page...</p>";
        require_once("../handlers/session_handler.php");#session handler
        
        $redirect_page = "";
        //If superuser is logged in ~ redirect to index.php
        if(MySessionHandler::SuperuserIsLoggedIn())
        {
            $redirect_page = "index.php";
        }
        else
        {
            $redirect_page = "login.php";
        }
        header("Location:$redirect_page");
        exit();
    }
    
    //No superuser accounts were found if we get to this point ~ display the signup form
    echo "<div class='container'><br>";
        MessageDisplay::PrintInfo("No superuser accounts were found in the database. Create one here");
    echo "</div>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Femcity | Superuser Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/toastr.min.css" rel="stylesheet">
</head>
    <body>
        <main>
            <div class="container">
                <?php
                    DisplaySignupBox();
                ?>
            </div>
        </main>
        
        <script src="../js/jquery.min.js"></script>
        <script src="../js/toastr.min.js"></script>
        
        <script src="../js/bootstrap.min.js"></script>
        <script src="js/login.js"></script>
    </body>
</html>