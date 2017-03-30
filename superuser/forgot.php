<?php
function DisplayForgotBox()
{
?>
    <div id="forgotbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Forgot password. </div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="login.php">Login</a></div>
                </div>     

                <div style="padding-top:30px" class="panel-body" >

                    <div id="login-alert" class="alert alert-success col-sm-12 hidden">The email has been sent. Check your inbox to reset your account</div>
                    
                    <form id="loginform" class="form-horizontal" role="form">
                        <h4 class="text-center">Enter your email to reset the account</h4>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input id="login-email" type="email" class="form-control" name="email" value="" placeholder="Email address">                                        
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                              <a id="btn-reset" href="javascript:void(0)" class="btn btn-default pull-right">Reset Account</a>
                            </div>
                        </div>

                    </form>     
                </div>                     
            </div>  
    </div>
<?php
} #End of DisplayForgotBox()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Femcity | Superuser Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
</head>

<body>
    <main>
<?php
    require_once("../handlers/db_handler.php");
    
    $superusers_found = DbInfo::GetAllSuperuserAccounts();#Returns super user accounts if they were found
        
        require_once("../handlers/session_handler.php");
        //If superuser is logged in ~ redirect to index.php
        if(MySessionHandler::SuperuserIsLoggedIn()):
            echo "<p>Logged in.<br>Redirecting you to superuser panel...</p>";
            header("Location:index.php");
        else: #Super user is not logged in, display login form
?>
        <div class="container">
            <?php 
                DisplayForgotBox();
            ?>
        </div>  
<?php
        endif;
?>
    </main>
    <footer>
        
    </footer>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>