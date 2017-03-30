<?php
    
    require_once("../handlers/message_display.php");#Controls displaying of message boxes

    function DisplayAccountRequestBox()
    {
?>
                <div id="signupbox" style="margin-top:25px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Admin Request account
                                <small><a class="pull-right" href="login.php">Login</a></small>
                            </div>
                            
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
                                        <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>                               
                                <div class="form-group">
                                    <label for="username" class="col-md-3 control-label">Username</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="username" placeholder="Username">
                                    </div>
                                </div>
             
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="col-md-3 control-label">Confirm</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="confirm_pass" placeholder="Confirm password">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-xs-12">
                                        <button id="btn-signup" type="button" class="btn btn-info pull-right">Request Account</button>
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
    require_once("../handlers/session_handler.php");#session handler
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
                    //If admin is logged in ~ redirect to index.php
                    if(MySessionHandler::AdminIsLoggedIn())
                    {
                        echo "<p>Logged in. Redirecting you to the admin panel...</p>";
                        header("Location:index.php");
                    }
                    else
                    {
                        //Display informative message
                        echo "<div class='container'><br>";
                        MessageDisplay::PrintInfo("<b>Thank you for expressing interest in Femcity.</b> You can request an account for your business here and we'll get back to you as soon as possible.");
                        echo "</div>";
                        DisplayAccountRequestBox();
                    }
                    
                ?>
            </div>
        </main>
        
        <script src="../js/jquery.min.js"></script>
        <script src="../js/toastr.min.js"></script>
        
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>