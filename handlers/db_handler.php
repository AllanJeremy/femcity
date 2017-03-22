<?php
require_once("db_info.php");

//This interface determines what public functions need to be implemented in this class
interface DbHandlerInterface
{
/*SUPERUSER FUNCTIONS*/
    //Categories
    public static function CreateCategory($details); #Create a new category
    public static function UpdateCategory($id,$details); #Update category based on primary key
    public static function DeleteCategory($id); #Delete category based on primary key
    
    //User accounts
    public static function CreateAdminAcc($details); #Create a new admin user account
    public static function UpdateAdminAcc($id,$details); #Update admin user account based on primary key
    public static function DeleteAdminAcc($id); #Delete admin user account based on primary key
    
    public static function ResetAdminAccountPassword($id); #Reset admin account password
    public static function BanAdminAccount($id); #Ban an admin account
    public static function UnbanAdminAccount($id); #Unban an admin account
    
    //Account requests
    public static function DeleteAdminAccountRequest($id);#Delete an admin account request based on primary key
    
    //Featured products
    public static function CreateFeaturedItem($details); #Create a new featured product
    public static function UpdateFeaturedItem($id,$details); #Update featured product based on primary key
    public static function DeleteFeaturedItem($id); #Delete featured product based on primary key
    
    //Offers
    public static function CreateOffer($details); #Create a new offer
    public static function UpdateOffer($id,$details); #Update offer based on primary key
    public static function DeleteOffer($id); #Delete offer based on primary key
    
    //Account requests
    public static function AcceptAccRequest($details); #Accept account request ~ delete the account request from account requests table and move it to the admin_accounts table
    public static function DenyAccountRequest($id); #Deny an account request, delete the account request
    
    //Personal account ~ Create, update and delete superuser account
    public static function CreateSuperuserAccount($details); #Create a new featured product
    public static function UpdateSuperuserAccount($id,$details); #Update a superuser account based on primary key
    public static function DeleteSuperuserAccount($id); #Delete a superuser account based on primary key

/*ADMIN FUNCTIONS*/
    //Personal account ~ Create update account
    public static function RequestAdminAccount($details); #Create an admin account request
    public static function CreateAdminAccount($details); #Create an admin account
    public static function UpdateAdminAccount($id,$details); #Update an admin account

    public static function DeleteAdminAccount($id);#Delete an admin account based on primary key

    //Products/services ~ add and remove services/products
    public static function CreateItem($details); #Create a new product or service
    public static function UpdateItem($id,$details); #Update product/service based on primary key
    public static function DeleteItem($id); #Delete product/service based on primary key
    
}

//This class deals with manipulation of records in the database
class DbHandler implements DbHandlerInterface
{
    /*HELPER FUNCTIONS*/
    //Delete based on single property ~ Deleting any record/row based on a single property
    private static function DeleteBasedOnSingleProperty($table_name,$col_name,$prop_name,$prop_type="i")
    {
        global $dbCon;
        $del_query = "DELETE FROM $table_name WHERE $col_name=?";
        
        //Prepare delete statement
        if($del_stmt = $dbCon->prepare($del_query))
        {
            $del_stmt->bind_param($prop_type,$prop_name);
            
            //Try to execute the delete statement, returns true on succes and false on failure
            return($delete_stmt->execute());
        }
        else #failed to prepare the query to delete the message
        {
            return null;
        }
    }
    
    /*SUPERUSER ACCOUNT FUNCTIONS*/
    /*
        INSERT INTO table_name (column1, column2, column3, ...)
        VALUES (value1, value2, value3, ...);
        
        UPDATE table_name
        SET column1 = value1, column2 = value2, ...
        WHERE condition;
    */
    //Categories
    #Create a new category
    public static function CreateCategory($details)
    {
        global $dbCon;
        $insert_query = "INSERT INTO categories(cat_name,cat_description) VALUES(?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {   
            $insert_stmt->bind_param("ss",$details["cat_name"],$details["cat_description"]);
            
            //Try executing the query ~ returns true on success and false on failure
            return($insert_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }
    }
    
    #Update category based on primary key
    public static function UpdateCategory($id,$details)
    {
        global $dbCon;
        $update_query = "UPDATE categories SET cat_name=?,cat_description=? WHERE cat_id=?";

        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {
            $update_stmt->bind_param("ssi",$details["cat_name"],$details["cat_description"]);
            
            //Try executing the query ~ returns true on success and false on failure
            return($update_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }
    }
    
    #Delete category based on primary key
    public static function DeleteCategory($id)
    {
        return self::DeleteBasedOnSingleProperty("categories","cat_id",$id);
    }
    
    //User accounts
    #Create a new user account
    public static function CreateAdminAcc($details)
    {
        global $dbCon;
        $insert_query = "INSERT INTO admin_accounts(first_name,last_name,username,business_name,business_description,cat_id,email,password,subbed) VALUES(?,?,?,?,?,?,?,?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {   
            $insert_stmt->bind_param("sssssissi",$details["first_name"],$details["last_name"],$details["username"],$details["business_name"],$details["business_description"],$details["cat_id"],$details["email"],$details["password"],$details["subbed"]);
            
            //Try executing the query ~ returns true on success and false on failure
            return($insert_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }        
    }
    
    #Update user account based on primary key
    public static function UpdateAdminAcc($id,$details)
    {
        global $dbCon;
        $update_query = "UPDATE admin_accounts SET first_name=?,last_name=?,username=?,business_name=?,business_description=?,cat_id=?,email=?,password=?,subbed=? WHERE acc_id=?";

        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {
            $update_stmt->bind_param("sssssissii",$details["first_name"],$details["last_name"],$details["username"],$details["business_name"],$details["business_description"],$details["cat_id"],$details["email"],$details["password"],$details["subbed"],$id);
            
            //Try executing the query ~ returns true on success and false on failure
            return($update_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }  
    }
    
    #Delete user account based on primary key
    public static function DeleteAdminAcc($id)
    {
        return self::DeleteBasedOnSingleProperty("admin_accounts","acc_id",$id);
    }
    
    #Reset admin account password
    public static function ResetAdminAccountPassword($id)
    {
        global $dbCon;
        
        #select the email of the current account ~ used because the function GetAdminByAccId is overkill for only one value
        $select_query = "SELECT email FROM admin_accounts WHERE acc_id=$id";
        $select_result = $dbCon->query($select_query);
        
        $email = "no@email.com";#email address belonging to this account ~ default is no@email.com | this should never be used
        
        //If the select result was valid ~ set an email
        if($select_result)
        {
            $email = $select_result["email"];
        }
        else #Could not find the selected account ~ return false;
        {
            return false;
        }
        
        //Query used for the reset
        $reset_query = "UPDATE admin_accounts SET password=?";
        
        //Attempt to prepare the query
        if($reset_stmt = $dbCon->prepare($reset_query))
        {
            $new_pass = PasswordHandler::Encrypt($email);
            $reset_stmt->bind_param("s",$new_pass);
            
            return ($reset_stmt->execute());
        }
        else
        {
            return null;
        }
    }
    

    //HELPER FUNCTION FOR BANNING
    private static function SetAdminAccBanStatus($ban_status,$id)
    {
        global $dbCon;
        
        $update_query = "UPDATE admin_account SET is_banned=? WHERE acc_id=?";
       
        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {
            $update_stmt->bind_param("ii",$ban_status,$id);
            
            //Try executing the query ~ returns true on success and false on failure
            return($update_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }          
    }

    #Ban an admin account
    public static function BanAdminAccount($id)
    {
        return self::SetAdminAccBanStatus(true,$id);
    }
    
    #Unban an admin account
    public static function UnbanAdminAccount($id)
    {
        return self::SetAdminAccBanStatus(false,$id);
    }
    
    
    /*ADMIN ACCOUNT FUNCTIONS*/
    
}