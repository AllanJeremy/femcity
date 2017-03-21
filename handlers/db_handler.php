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
    public static function CreateUserAcc($details); #Create a new user account
    public static function UpdateUserAcc($id,$details); #Update user account based on primary key
    public static function DeleteUserAcc($id); #Delete user account based on primary key
    
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
            
            //Try to execute the delete statement, if it executes means the delete was successful, return true.
            if($delete_stmt->execute())
            {
                return true;
            }
            else #failed to execute the query
            {
                return false;
            }
        }
        else #failed to prepare the query to delete the message
        {
            return null;
        }
    }
    
    /*SUPERUSER ACCOUNT FUNCTIONS*/
    
    /*ADMIN ACCOUNT FUNCTIONS*/
    
}