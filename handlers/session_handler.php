<?php
@session_start();#start session

require_once("password_handler.php");#Encrypting and validating passwords
require_once("db_info.php");#Database information file

interface MySessionHandlerInterface
{
    //Admin functions
    public static function AdminIsLoggedIn();
    public static function AdminLogin($email,$password);
    public static function AdminLogout();
    
    //Superuser functions
    public static function SuperuserIsLoggedIn();
    public static function SuperuserLogin($email,$password);
    public static function SuperuserLogout();
    
    //Getting logged user info ~ returns an  associative array

    
}

//This class deals with the session related functionality ~ logging in and out
class MySessionHandler extends DbInfo implements MySessionHandlerInterface
{
    //Get admin account by acc_id
    public static function GetAdminById($acc_id)
    {
        //todo: Get everything except the password
        global $dbCon;
        
        $select_query = "SELECT first_name,last_name,business_name,business_description,region_id,specific_location,admin_accounts.cat_id,email,phone,subbed,date_created,date_activated,date_expires 
        FROM admin_accounts INNER JOIN categories ON admin_accounts.cat_id=categories.cat_id WHERE admin_accounts.acc_id=?";
        
        //Attempt to prepare the query
        if($select_stmt = $dbCon->prepare($select_query))
        {
            $select_stmt->bind_param("i",$acc_id);
            
            //If query ran successfully
            if($select_stmt->execute())
            {
               $results = $select_stmt->get_result();
               foreach($results as $result)
               {
                   return $result;
               }
            }
            else #failed to execute query
            {
                return false;
            }
        }
        else #failed to prepare query
        {
            return null;
        }
    }
    
    //Get admin account by email
    public static function GetAdminByEmail($email)
    {
        return DbInfo::GetSingleRecordUsingProperty("admin_accounts","email",$email,"s");
    }
    
    //Get superuser account by acc_id
    public static function GetSuperuserById($acc_id)
    {
        //todo: Get everything except the password
        global $dbCon;
        
        $select_query = "SELECT first_name,last_name,username,email,date_created FROM superuser_accounts WHERE acc_id=?";
        
        //Attempt to prepare the query
        if($select_stmt = $dbCon->prepare($select_query))
        {
            $select_stmt->bind_param("i",$acc_id);
            
            //If query ran successfully
            if($select_stmt->execute())
            {
               $results = $select_stmt->get_result();
               foreach($results as $result)
               {
                   return $result;
               }
            }
            else #failed to execute query
            {
                return false;
            }
        }
        else #failed to prepare query
        {
            return null;
        }
    }
    
    //Get admin account by email
    public static function GetSuperuserByEmail($email)
    {
        return DbInfo::GetSingleRecordUsingProperty("superuser_accounts","email",$email,"s");
    }
    /*SESSION VARIABLES*/
    //Initialize the admin session variables ~ used to store admin information on login [param is an admin account]
    protected static function InitAdminSessionVars($admin_acc)
    {
        try
        {
            $_SESSION["acc_id"] = $admin_acc["acc_id"];
            $_SESSION["first_name"] = $admin_acc["first_name"];
            $_SESSION["last_name"] = $admin_acc["last_name"];
            $_SESSION["username"] = $admin_acc["username"];
            $_SESSION["email"] = $admin_acc["email"];
            $_SESSION["business_name"] = $admin_acc["business_name"];
            $_SESSION["business_description"] = $admin_acc["business_description"];
            $_SESSION["cat_id"] = $admin_acc["cat_id"];
            $_SESSION["cat_name"] = $admin_acc["cat_name"];
            $_SESSION["cat_description"] = $admin_acc["cat_description"];
            $_SESSION["subbed"] = $admin_acc["subbed"];
            $_SESSION["date_created"] = $admin_acc["date_created"];
            $_SESSION["date_activated"] = $admin_acc["date_activated"];
            $_SESSION["date_expires"] = $admin_acc["date_expires"];   
            
            return true;
        }
        
        catch(Exception $e) #Exception occcured while trying to set the admin session variables
        {
            echo "<p>Error! Exception occurred while trying to set the superuser session data<br><b>Error info:</b>$e</p>";
            return false;
        }
    }
    
    //Unset the admin session variables ~ used when logging out ~ return true on success and false on failure
    protected static function UnsetAdminSessionVars()
    {
        //Try unsetting the session variables
        try
        {
            unset(
                $_SESSION["acc_id"],
                $_SESSION["first_name"],
                $_SESSION["last_name"],
                $_SESSION["username"],
                $_SESSION["email"],
                $_SESSION["business_name"],
                $_SESSION["business_description"],
                $_SESSION["cat_id"],
                $_SESSION["cat_name"],
                $_SESSION["cat_description"],
                $_SESSION["subbed"],
                $_SESSION["date_created"],
                $_SESSION["date_activated"],
                $_SESSION["date_expires"]
            );
            return true;
        }
        catch (Exception $e)#if an exception occurs
        {
            echo "<p>Error! Exception occurred while trying to unset the admin session data<br><b>Error info:</b>$e</p>";
            return false;
        }
    }
    
    //Initialize the superuser session variables ~ used to store admin information on login
    protected static function InitSuperuserSessionVars($superuser_acc)
    {
        try
        {
            $_SESSION["acc_id"] = $superuser_acc["acc_id"];
            $_SESSION["first_name"] = $superuser_acc["first_name"];
            $_SESSION["last_name"] = $superuser_acc["last_name"];
            $_SESSION["username"] = $superuser_acc["username"];
            $_SESSION["email"] = $superuser_acc["email"];
            $_SESSION["subbed"] = $superuser_acc["subbed"];
            $_SESSION["date_created"] = $superuser_acc["date_created"];
            
            return true;
        }
        catch(Exception $e)
        {
            echo "<p>Error! Exception occurred while trying to set the superuser session data<br><b>Error info:</b>$e</p>";
            return false;
        }
    }
    
    //Unset the superuser session variables ~ used when logging out ~ return true on success and false on failure
    protected static function UnsetSuperuserSessionVars()
    {
        try
        {
            unset(
                $_SESSION["acc_id"],
                $_SESSION["first_name"],
                $_SESSION["last_name"],
                $_SESSION["username"],
                $_SESSION["email"],
                $_SESSION["subbed"],
                $_SESSION["date_created"]
            );
            return true;
        }
        catch (Exception $e)#if an exception occurs
        {
            echo "<p>Error! Exception occurred while trying to unset the superuser session data<br><b>Error info:</b>$e</p>";
            return false;
        }
    }
    
    /*ADMIN FUNCTIONS*/
    //Check if superuser is logged in ~ returns true if superuser is logged in and false if not
    public static function AdminIsLoggedIn()
    {
        //Checks if admin session variables are set, if they are; means the admin is logged in
        return
        (
            isset
            (
                $_SESSION["acc_id"],
                $_SESSION["first_name"],
                $_SESSION["last_name"],
                $_SESSION["username"],
                $_SESSION["email"],
                $_SESSION["business_name"],
                $_SESSION["business_description"],
                $_SESSION["cat_id"],
                $_SESSION["cat_name"],
                $_SESSION["cat_description"],
                $_SESSION["subbed"],
                $_SESSION["date_created"],
                $_SESSION["date_activated"],
                $_SESSION["date_expires"]
            )
        );
    }
    
    //Logs the superuser in, if the email and password provided are correct. Returns true on success and false on failure
    public static function AdminLogin($email,$password)
    {   

        $admin_acc = self::GetAdminByEmail($email); #Returns the account if it was found in the database, otherwise returns false | null
        
        //If the account exists, check if the password combination is valid or not
        if($admin_acc)
        {   
            //if the account exists and the password is valid, log them in ~ set session variables
            $password_valid = PasswordHandler::Verify($password,$admin_acc["password"]);
                
            //If the password is valid
            if($password_valid)
            {
                self::LogAllUsersOut();#Log all users out
                return self::InitAdminSessionVars($admin_acc); #Initialize the admin session variables ~ returns true on success and false on failure
            }
            else #password provided was invalid
            {
                return $password_valid;
            }
        }
        else #Admin account requested could not be found
        {
            return $admin_acc;        
        }
    }
    
    //Logs out the superuser ~ unsets all admin session variables
    public static function AdminLogout()
    {
        //If the admin is logged in
        if(self::AdminIsLoggedIn())
        {
           //Unset the admin session variables
           return self::UnsetAdminSessionVars(); 
        }
        else #No admin logged in
        {
            return false;
        }
    }
    
    /*SUPERUSER FUNCTIONS*/
    //Check if superuser is logged in ~ returns true if superuser is logged in and false if not
    public static function SuperuserIsLoggedIn()
    {
        //Checks if superuser session variables are set, if they are; means the superuser is logged in
        return
        (
            isset
            (
                $_SESSION["acc_id"],
                $_SESSION["first_name"],
                $_SESSION["last_name"],
                $_SESSION["username"],
                $_SESSION["email"],
                $_SESSION["subbed"],
                $_SESSION["date_created"]
            )
        );
    }
    
    //Logs the superuser in, if the email and password provided are correct. Returns true on success and false on failure
    public static function SuperuserLogin($email,$password)
    {
        $superuser_acc = self::GetSuperuserByEmail($email); #Returns the account if it was found in the database, otherwise returns false | null
        
        //If the account exists, check if the password combination is valid or not
        if($superuser_acc)
        {
            //if the account exists and the password is valid, log them in ~ set session variables
            $password_valid = PasswordHandler::Verify($password,$superuser_acc["password"]);
            //If the password is valid
            if($password_valid)
            {
                self::LogAllUsersOut();#Log all users out ~ OPTIONAL [REMOVE THIS IF MULTIPLE ACCOUNT TYPES CAN LOG AT THE SAME TIME]
                return self::InitSuperuserSessionVars($superuser_acc); #Initialize the admin session variables ~ returns true on success and false on failure
            }
            else #password provided was invalid
            {
                return $password_valid;
            }
        }
        else #Admin account requested could not be found
        {
            return $superuser_acc;        
        }     
    }
    
    //Logs out the superuser ~ unsets all superuser session variables
    public static function SuperuserLogout()
    {
        //If the superuser is logged in
        if(self::SuperuserIsLoggedIn())
        {
           //Unset the superuser session variables
           return self::UnsetSuperuserSessionVars(); 
        }
        else #No superuser logged in
        {
            return false;
        }
    }
    
    //Log all users out
    public static function LogAllUsersOut()
    {
        try
        {
            self::AdminLogout();
            self::SuperuserLogout();     
            return true;
        }
        catch (Exception $e)#if an exception occurs
        {
            echo "<p>Error! Exception occurred while trying to log all users out<br><b>Error info:</b>$e</p>";
            return false;
        }

    }
    /*GETTING LOGGED IN USER INFORMATION*/
    //Helper : Get Logged in admin's info ~ returns an associative array
    private static function GetLoggedAdminInfo()
    {
        
    }
    
    //Helper : Get Logged in superuser's info ~ returns an associative array
    private static function GetLoggedSuperuserInfo()
    {
        
    }   
    
    //Get the information of the logged user
    public static function GetLoggedUserInfo()
    {
        $user_info = array();
        if(self::AdminIsLoggedIn()) #if admin is logged in
        {
            $user_info = self::GetLoggedAdminInfo();
        }
        elseif(self::SuperuserIsLoggedIn()) #if superuser is logged in
        {
            $user_info = self::GetLoggedSuperuserInfo();
        }
        else
        {
            $user_info = false;
        }
        
        return $user_info;
    }
}