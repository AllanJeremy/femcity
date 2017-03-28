<div class="container" id="profile_info">
<?php
    require_once("../handlers/session_handler.php"); #Session handler
    
    $user_info = MySessionHandler::GetLoggedUserInfo(); #User info ~ information on the logged in user
    
    #If user is logged in and we could retrieve the user information
    //if($user_info):
?>
    <div class="col-xs-12" id="profile_basic_info">
        <h4>BASIC INFORMATION</h4><hr>
        <form class="row">
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_first_name">First Name</label>
                <input id="p_first_name" type="text" class="form-control" placeholder="First Name">
            </div>
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_last_name">Last Name</label>
                <input id="p_last_name" type="text" class="form-control" placeholder="Last Name">
            </div>
            <div class="col-xs-12 pull-right">
                <br>
                <a class="btn btn-info pull-right" id="update_basic_info" href="javascript:void(0)">UPDATE BASIC INFO</a>  
            </div>
        </form>
    </div>
    
    <div class="col-xs-12" id="profile_basic_info">
        <br><br><h4>CHANGE PASSWORD</h4><hr>
        <?php
            $password_message = "<b>Note :</b> Passwords must be at least 8 characters long <br><b>Tip :</b> Choose a strong password to protect your account. Strong passwords include a mix of uppercase and lowercase letters, numbers and symbols";
            
            MessageDisplay::PrintInfo($password_message);
        ?>
        <form class="row">
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_old_password">Old Password</label>
                <input id="p_old_password" type="password" class="form-control" placeholder="Old password">
            </div>
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_new_password">New password</label>
                <input id="p_new_password" type="password" class="form-control" placeholder="New password">
            </div>
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_confirm_password">Confirm password</label>
                <input id="p_confirm_password" type="password" class="form-control" placeholder="Confirm new password">
            </div>
            <div class="col-xs-12 pull-right">
                <br>
                <a class="btn btn-info pull-right" id="update_password" href="javascript:void(0)">CHANGE PASSWORD</a>  
            </div>
        </form>
    </div>
    
    <div class="col-xs-12" id="profile_basic_info">
        <br><br><h4>EMAIL ADDRESSES</h4><hr>
        <?php
            $email_message = "<b>Note :</b> To change your email, we will send you a confirmation code to the email you have requested.<br> You can then enter the confirmation code in your browser to confirm the change.";
            
            MessageDisplay::PrintInfo($email_message);
        ?>
        <form class="row">
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_current_email">Current Email</label>
                <input id="p_current_email" type="email" class="form-control" disabled placeholder="Current email">
            </div>
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_new_email">New Email</label>
                <input id="p_new_email" type="email" class="form-control" placeholder="New email">
            </div>
            <div class="col-xs-12 col-sm-6">
                <br>
                <label for="p_confirm_email">Confirm Email</label>
                <input id="p_confirm_email" type="email" class="form-control" placeholder="Confirm new email">
            </div>
            <div class="col-xs-12 pull-right">
                <br>
                <a class="btn btn-info pull-right" id="update_email" href="javascript:void(0)">CHANGE EMAIL</a>  
            </div>
        </form>
        <br><br><br>
    </div>
    
<!--
    <div class="col-xs-12" id="profile_update_all">
        <br><br><h4>UPDATE ALL INFO</h4><hr>
        <?php
            $update_message = "<b>Note :</b> If you would like to update all your profile information with the click of one button, you can do so by clicking on update profile below";
            
            MessageDisplay::PrintInfo($update_message);
        ?>
            <div class="col-xs-12 pull-right">
                <br>
                <a class="btn btn-info pull-right" id="update_full_profile" href="javascript:void(0)">UPDATE PROFILE</a>  
            </div>
        <br><br><br>
    </div>
-->

<?php
    //endif;#End check for user info
?>
</div>
