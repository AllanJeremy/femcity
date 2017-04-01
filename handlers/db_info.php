<?php
@session_start();
require_once("db_connect.php");#Database connection file

//This interface determines what public functions need to be implemented in this class
interface DbInfoInterface
{
    //Get all records from a table  
    public static function GetAllCategories();
    public static function GetAllFeaturedItems();
    public static function GetAllOtherItems();
    public static function GetAllItems();
    public static function GetAllOffers();
       
    public static function GetAllAdminAccounts();
    public static function GetAllSuperuserAccounts();
    public static function GetAllAccountRequests();
    
    //Get records based on primary keys
    public static function GetCategoryById($cat_id);
    public static function GetFeaturedById($f_item_id);
    public static function GetItemById($item_id);
    public static function GetOfferById($promo_id);
    
    //Get records based on foreign keys
    public static function GetFeaturedByItemId($item_id);
    public static function GetOfferByItemId($item_id);
    public static function GetItemsByAccId($acc_id);        
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
    //Get all featured items
    public static function GetAllFeaturedItems()
    {
        global $dbCon;
        $select_query="SELECT * FROM featured_items INNER JOIN items ON featured_items.item_id = items.item_id";
        $result = $dbCon->query($select_query);
        return $result;
    }
    
    //Get all other items ~ items that are not featured
    public static function GetAllOtherItems()
    {
        global $dbCon;
        $featured_items = self::GetAllFeaturedItems();
        $featured_ids = array(); # Array containing featured item ids
        
        //If any featured items were found
        if($featured_items && $featured_items->num_rows>0)
        {
            //Add the featured item ids to the featured ids
            foreach($featured_items as $item)
            {
                array_push($featured_ids,$item["item_id"]);
            }
        }
        
        $all_items = self::GetAllItems();
        $other_items = array();
        
        //If there are featured items, filter them off the other items list
        if(!empty($featured_ids) && $all_items && $all_items->num_rows>0)
        {
            foreach($all_items as $item)
            {
                #If the item is in the featured item_ids variable, it is considered a featured item
                $is_featured = in_array($featured_ids,$item["item_id"]);
                
                #If the item is not a featured item ~ it is considered to be "other item"
                if(!$is_featured)
                {
                    array_push($other_items,$item);
                }
            }
            
            return $other_items;
        }
        else #No featured items, return all items
        {
            return $all_items;
        }

    }
    
    //Get all items
    public static function GetAllItems()
    {
        return self::GetAllRecordsFromTable("items");
    }
    public static function GetAllOffers()
    {
        return self::GetAllRecordsFromTable("offers");
    }
    
    //Get all admin accounts ~ select everything except the password
    public static function GetAllAdminAccounts()
    {
        global $dbCon;
        $select_query = "SELECT acc_id,first_name,last_name,business_name,business_description,cat_id,email,phone,subbed,date_created,date_activated,date_expires FROM admin_accounts";
        
        return ($dbCon->query($select_query));
    }
    public static function GetAllSuperuserAccounts()
    {
        global $dbCon;
        $select_query = "SELECT acc_id,first_name,last_name,username,email,subbed,date_created FROM admin_accounts";
        
        return ($dbCon->query($select_query));
    }
    
    public static function GetAllAccountRequests()
    {
        return self::GetAllRecordsFromTable("account_requests");
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
    public static function GetOfferById($offer_id)
    {
        return (self::GetSingleRecordUsingProperty("offers","offer_id",$offer_id));
    }
    
    /*GET RECORDS BASED ON FOREIGN KEYS*/
    //Get Featured item by item_id
    public static function GetFeaturedByItemId($item_id)
    {
        return self::SinglePropertyExists("featured_items","item_id",$item_id);
    }
    
    //Get Promotion item by item_id
    public static function GetOfferByItemId($item_id)
    {
        return self::SinglePropertyExists("offers","item_id",$item_id);
    }
    
    //Get item by acc_id ~ the id of the account that added it
    public static function GetItemsByAccId($acc_id)
    {
        return self::SinglePropertyExists("items","acc_id",$acc_id);
    }
    
}