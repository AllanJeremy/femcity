<?php
    //Displays the login form
    function DisplayLoginForm()
    {
?>
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Superuser Login</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="forgot.php">Forgot password?</a></div>
                </div>     

                <div style="padding-top:30px" class="panel-body" >

                    <div id="login-alert" class="alert alert-danger col-sm-12 hidden">Email or password provided is incorrect. Try again</div>

                    <form id="loginform" class="form-horizontal" role="form">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-email" type="email" class="form-control" name="email" value="" placeholder="Email address">                                        
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="Password">
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                              <a id="btn-login" href="javascript:void(0)" class="btn btn-success pull-right">Login</a>
                            </div>
                        </div>

                    </form>     
                </div>                     
            </div>  
    </div>
<?php
    } #End of displayLoginForm function
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
<?php
    require_once("../handlers/db_handler.php");
    
    $superusers_found = DbInfo::GetAllSuperuserAccounts();#Returns super user accounts if they were found
    
    //If superuser accounts were found ~ redirect to login page.
    if($superusers_found && $superusers_found->num_rows>0):
        require_once("../handlers/session_handler.php");#session handler
        
        //If superuser is logged in ~ redirect to index.php
        if(MySessionHandler::SuperuserIsLoggedIn()):
            echo "<p>Logged in.<br>Redirecting you to superuser panel...</p>";
            header("Location:index.php");
        else: #Super user is not logged in, display login form
?>
        <div class="container">
            <?php 
                DisplayLoginForm();
            ?>
        </div>  
<?php
        endif;
    else: #No superuser accounts found
        echo "<div class='alert alert-info container' style='margin-top:50px;'>No superusers found. Redirecting you to the signup page...</div>";
        header("Location:signup.php");
    
    endif; #endif for checking if superuser account exists
?>
    </main>
    <footer>
        
    </footer>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/toastr.min.js"></script>
    
    <script src="../js/bootstrap.min.js"></script>
    
</body>
</html>


