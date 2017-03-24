<?php
@session_start();
require_once("db_connect.php");#Database connection file

//This interface determines what public functions need to be implemented in this class
interface DbInfoInterface
{
    //Get all records from a table  
    public static function GetAllCategories();
    public static function GetAllFeaturedItems();
    public static function GetAllItems();
    public static function GetAllPromotions();
    
    public static function GetAllAdminAccounts();
    
    //Get records based on primary keys
    public static function GetCategoryById($cat_id);
    public static function GetFeaturedById($f_item_id);
    public static function GetItemById($item_id);
    public static function GetPromoById($promo_id);
    
    //Get records based on foreign keys
    public static function GetFeaturedByItemId($item_id);
    public static function GetPromoByItemId($item_id);
    public static function GetItemByAccId($acc_id);        
}

//This class deals with retrieval of records from the database
class DbInfo implements DbInfoInterface
{
    /*HELPER FUNCTIONS ~ PRIVATE FUNCTIONS USED INTERNALLY FOR CONVENIENCE*/
    //Checks if a single property exists. Private function - only used as convenience by other functions
    private static function SinglePropertyExists($table_name,$column_name,$prop_name,$prop_type="i",$prepare_error="<p>Error preparing data retrieval query </p>")#prop type is string used for bind_params
    {
        global $dbCon;

        $select_query = "SELECT * FROM $table_name WHERE $column_name=?";
        if ($select_stmt = $dbCon->prepare($select_query))
        {
            $select_stmt->bind_param($prop_type,$prop_name);
            
            if($select_stmt->execute())
            {
                $result = $select_stmt->get_result();
                if($result->num_rows>0)#found records
                {
                    return $result;
                }   
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else #failed to prepare the query for data retrieval
        {
            echo "<p>".($prepare_error)."</p>";
            return null;
        }
    }
    
    //Get a  single record ~ this will be used for getting records using primary keys
    protected static function GetSingleRecordUsingProperty($table_name,$column_name,$prop_name,$prop_type="i")
    {
        $records = self::SinglePropertyExists($table_name,$column_name,$prop_name,$prop_type);
        
        if($records)
        {
            foreach($records as $record_found)
            {
                return $record_found;
            }
        }
        return $records;

    }
    
    //Get all records from a specific table
    private static function GetAllRecordsFromTable($table_name)
    {
        global $dbCon;
        
        $select_query = "SELECT * FROM $table_name";
        if($select_stmt = $dbCon->prepare($select_query))
        {
            //Try executing the query
            if($select_stmt->execute())
            {
                return $select_stmt->get_result();
            }
            else #failed to run the query
            {
                return false;
            }
        }
        else # failed to prepare the query
        {
            return null;
        }
    }
    
    /*GET ALL RECORDS FROM A TABLE*/
    public static function GetAllCategories()
    {
        return self::GetAllRecordsFromTable("categories");
    }
    public static function GetAllFeaturedItems()
    {
        return self::GetAllRecordsFromTable("featured_items");
    }
    public static function GetAllItems()
    {
        return self::GetAllRecordsFromTable("items");
    }
    public static function GetAllPromotions()
    {
        return self::GetAllRecordsFromTable("promotions");
    }
    
    //Get all admin accounts ~ select everything except the password
    public static function GetAllAdminAccounts()
    {
        global $dbCon;
        $select_query = "SELECT first_name,last_name,business_name,business_description,cat_id,email,subbed,date_created,date_activated,date_expires FROM admin_accounts";
        
        return ($dbCon->query($select_query));
    }
    /*GET RECORDS BASED ON PRIMARY KEYS*/
    //Get Category by it's primary key (cat_id)
    public static function GetCategoryById($cat_id)
    {
        return (self::GetSingleRecordUsingProperty("categories","cat_id",$cat_id));
    }
    
    //Get Featured item by it's primary key (feature_id)
    public static function GetFeaturedById($f_item_id)
    {
        return (self::GetSingleRecordUsingProperty("featured_items","feature_id",$f_item_id));
    }
    
    //Get Item by it's primary key (item_id)
    public static function GetItemById($item_id)
    {
        return (self::GetSingleRecordUsingProperty("items","item_id",$item_id));
    }
    
    //Get Promotion by it's primary key (promo_id)
    public static function GetPromoById($promo_id)
    {
        return (self::GetSingleRecordUsingProperty("promotions","promo_id",$promo_id));
    }
    
    /*GET RECORDS BASED ON FOREIGN KEYS*/
    //Get Featured item by item_id
    public static function GetFeaturedByItemId($item_id)
    {
        return self::SinglePropertyExists("featured_items","item_id",$item_id);
    }
    
    //Get Promotion item by item_id
    public static function GetPromoByItemId($item_id)
    {
        return self::SinglePropertyExists("promotions","item_id",$item_id);
    }
    
    //Get item by acc_id ~ the id of the account that added it
    public static function GetItemByAccId($acc_id)
    {
        return self::SinglePropertyExists("items","acc_id",$acc_id);
    }
    
}