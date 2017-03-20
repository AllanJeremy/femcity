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
    public static function CreateUserAcc($details); #Create a new category
    public static function UpdateUserAcc($id,$details); #Update category based on primary key
    public static function DeleteUserAcc($id); #Delete category based on primary key
    
    //Featured products
    public static function CreateFeaturedItem($details); #Create a new category
    public static function UpdateFeaturedItem($id,$details); #Update category based on primary key
    public static function DeleteFeaturedItem($id); #Delete category based on primary key
    
    //Offers
    public static function CreateOffer($details); #Create a new category
    public static function UpdateOffer($id,$details); #Update category based on primary key
    public static function DeleteOffer($id); #Delete category based on primary key
    
    //Account requests
    public static function AcceptAccRequest($details); #Accept account request ~ delete the account request from account requests table and move it to the admin_accounts table
    public static function DenyAccountRequest($id); #Deny an account request, delete the account request

/*ADMIN FUNCTIONS*/
    //Account information
    
    //Products/services ~ add and remove services/products
    
    
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