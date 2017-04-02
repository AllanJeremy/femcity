<?php
//Add the session handler for getting session information
require_once("session_handler.php"); #This adds the dbInfo class for getting database records too

//Get the logged in user info
$user_info = MySessionHandler::GetLoggedUserInfo();

/*AJAX POST REQUESTS*/
if(isset($_POST["action"]))
{
    //If it is a post request, we will need the functions in db handler
    require_once("db_handler.php"); #Contains functions for manipulating database records
    
    switch($_POST["action"])
    {
        //CATEGORY FUNCTIONS
        case "CreateCategory": #Superuser ~ Create a category
            $data = $_POST["data"];
            $create_status = DbHandler::CreateCategory($data);
            echo $create_status;
        break;
            
        case "UpdateCategory": #Superuser ~ Update a category
            echo "<p>Updating category</p>";
        break;
        
        case "DeleteCategory": #Superuser ~ Delete a category
            echo "<p>Deleting category</p>";
        break;
            
        //ADMIN ACCOUNT FUNCTIONS
        case "CreateAdminAccount": #Superuser ~ Create an admin account
            $data = $_POST["data"];
            $data["password"] = PasswordHandler::Encrypt($data["password"]);#Encrypt the password
            $data["subbed"] = (int)$data["subbed"];
            $create_status = DbHandler::CreateAdminAcc($data);
            
            echo $create_status;
        break;
        
        case "UpdateAdminAccount": #Superuser ~ Update an admin account
            echo "<p>Updating admin account</p>";
        break;

        case "DeleteAdminAccount": #Superuser ~ Delete an admin account
            echo "<p>Deleting admin account</p>";
        break;
            
        //FEATURED ITEM FUNCTIONS
        case "CreateFeaturedItem": #Superuser ~ Create a featured item
            echo "<p>Creating featured item</p>";
        break;   
     
        case "UpdateFeaturedItem": #Superuser ~ Update a featured item
            echo "<p>Updating featured item</p>";
        break;   
     
        case "DeleteFeaturedItem": #Superuser ~ Delete a featured item
            echo "<p>Deleting featured item</p>";
        break;   
     
        //OFFER FUNCTIONS
        case "CreateOffer": #Superuser ~ Create an offer
            echo "<p>Creating offer</p>";
        break;
        
        case "UpdateOffer": #Superuser ~ Update an offer
            echo "<p>Updating offer</p>";
        break;
        
        case "DeleteOffer": #Superuser ~ Delete an offer
            echo "<p>Deleting offer</p>";
        break;
        
        //ACCOUNT REQUEST FUNCTIONS
        case "AcceptAccountRequest": #Superuser ~ Accept account request
            echo "<p>Accepting account request</p>";
        break;
            
        case "DenyAccountRequest": #Superuser ~ Deny account request
            echo "<p>Denying account request</p>";
        break;
            
        default:
            echo "Invalid action";
    }
}

/*AJAX GET REQUESTS*/
if(isset($_GET["action"]))
{
    switch($_GET["action"])
    {
        
    }
}