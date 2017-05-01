<?php
require_once("db_info.php");
require_once("password_handler.php");

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
    public static function AddFeaturedItem($details); #Create a new featured product
    public static function UpdateFeaturedItem($id,$details); #Update featured product based on primary key
    public static function RemoveFeaturedItem($id); #Delete featured product based on primary key
    
    //Offers
    public static function CreateOffer($details); #Create a new offer
    public static function UpdateOffer($id,$details); #Update offer based on primary key
    public static function DeleteOffer($id); #Delete offer based on primary key
    
    //Account requests
    public static function AcceptAccRequest($id,$details); #Accept account request ~ delete the account request from account requests table and move it to the admin_accounts table
    public static function DenyAccRequest($id); #Deny an account request, delete the account request
    
    //Personal account ~ Create, update and delete superuser account
    public static function CreateSuperuserAccount($details); #Create a new featured product
    public static function UpdateSuperuserAccount($id,$details); #Update a superuser account based on primary key
    public static function DeleteSuperuserAccount($id); #Delete a superuser account based on primary key
    
    //Item images
    public static function DeleteItemImages($id);
    
    //Locations
    #Countries
    public static function AddCountry($data);
    public static function UpdateCountry($id,$data);
    public static function DeleteCountry($id);
    
    #Regions
    public static function AddRegion($data);
    public static function UpdateRegion($id,$data);
    public static function DeleteRegion($id);
    
/*ADMIN FUNCTIONS*/
   //Account requests
    public static function RequestAdminAccount($details); #Create an admin account request

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
            
            $del_status = $del_stmt->execute();
            
            //Try to execute the delete statement, returns true on succes and false on failure
            return($del_status);
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
            $update_stmt->bind_param("ssi",$details["cat_name"],$details["cat_description"],$id);
            
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
        $insert_query = "INSERT INTO admin_accounts(first_name,last_name,business_name,business_description,cat_id,email,phone,password,subbed) VALUES(?,?,?,?,?,?,?,?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {   
            $insert_stmt->bind_param("ssssisssi",$details["first_name"],$details["last_name"],$details["business_name"],$details["business_description"],$details["cat_id"],$details["email"],$details["phone"],$details["password"],$details["subbed"]);
            

            //Try executing the query ~ returns true on success and false on failure
            return($insert_stmt->execute());
            //var_dump($inser_stmt->error);
        }
        else #Failed to prepare query
        {
            
            return null;
        }        
    }
    
    #Update user account based on primary key
    public static function UpdateAdminAcc($id,$details)#TODO: Update this
    {
        global $dbCon;
        $update_query = "UPDATE admin_accounts SET first_name=?,last_name=?,business_name=?,business_description=?,cat_id=?,email=?,phone=? WHERE acc_id=?";

        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {
            $update_stmt->bind_param("ssssissi",$details["first_name"],$details["last_name"],$details["business_name"],$details["business_description"],$details["cat_id"],$details["email"],$details["phone"],$id);
            
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
            $select_result = $select_result->fetch_array();#Get the mysqli result as an associative array
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
        
        $update_query = "UPDATE admin_accounts SET is_banned=? WHERE acc_id=?";
       
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
    
    //Delete an admin account request based on primary key
    public static function DeleteAdminAccountRequest($id)
    {
        return self::DeleteBasedOnSingleProperty("account_requests","request_id",$id);
    }
    //Featured products
    #Create a new featured product
    public static function AddFeaturedItem($details)
    {
        global $dbCon;
        $insert_query = "INSERT INTO featured_items(item_id,description) VALUES (?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {
            $insert_stmt->bind_param("is",$details["item_id"],$details["description"]);
            return ($insert_stmt->execute());
        }
        else #failed to prepare query
        {
            return null;
        }
    }
    
    #Update featured product based on primary key
    public static function UpdateFeaturedItem($id,$details)
    {
        $update_query = "UPDATE featured_items SET item_id=?,description=? WHERE feature_id=?";
        
        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {
            $update_stmt->bind_param("is",$details["item_id"],$details["description"],$id);
            return ($update_stmt->execute());
        }
        else #failed to prepare query
        {
            return null;
        }
    }
    
    #Delete featured product based on item_id (foreign key)
    public static function RemoveFeaturedItem($id)
    {
        return self::DeleteBasedOnSingleProperty("featured_items","item_id",$id);
    }
    
    //Offers
    #Create a new offer
    public static function CreateOffer($details)
    {
        global $dbCon;
        $insert_query = "INSERT INTO offers(offer_text,description,cat_id) VALUES (?,?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {
            $insert_stmt->bind_param("ssi",$details["offer_text"],$details["description"],$details["cat_id"]);
            
            return ($insert_stmt->execute());
        }
        else #failed to prepare query
        {
            return null;
        }    
    }
    
    #Update offer based on primary key
    public static function UpdateOffer($id,$details)
    {
        global $dbCon;
        $update_query = "UPDATE offers SET offer_text=?,description=?,cat_id=? WHERE offer_id=?";
        
        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {
            $update_stmt->bind_param("ssii",$details["offer_text"],$details["description"],$details["cat_id"],$id);
            return ($update_stmt->execute());
        }
        else #failed to prepare query
        {
            return null;
        }
    }
    
    #Delete offer based on primary key
    public static function DeleteOffer($id)
    {
        return self::DeleteBasedOnSingleProperty("offers","offer_id",$id);
    }
    
    //Account requests
    #Helper function: Delete account request
    private static function DeleteAccountRequest($id)
    {
        return self::DeleteBasedOnSingleProperty("account_requests","request_id",$id);
    }
    
    #Accept account request ~ NOTE: $details MUST be an associative array containing columns in admin_accounts
    public static function AcceptAccRequest($id,$details)
    {   
        $admin_acc_created = self::CreateAdminAcc($details);
        
        //If the admin acc was created successfully ~ delete the account request
        if($admin_acc_created)
        {
            #delete the account request if the corresponsing admin account is created
            $acc_request_deleted = self::DeleteAccountRequest($id); 
            
            return ($acc_request_deleted && $admin_acc_created);#return the status of the execution
        }
        else
        {
            return $admin_acc_created;
        }
    }
    
    #Deny an account request, delete the account request
    public static function DenyAccRequest($id)
    {
        return self::DeleteAccountRequest($id);
    }
    
    //Superuser Personal account ~ Create, update and delete superuser account
    #Create a new superuser account
    public static function CreateSuperuserAccount($details)
    {
        global $dbCon;
        $insert_query = "INSERT INTO superuser_accounts(first_name,last_name,username,email,password) VALUES(?,?,?,?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {   
            $password = PasswordHandler::Encrypt($details["password"]);
            $insert_stmt->bind_param("sssss",$details["first_name"],$details["last_name"],$details["username"],$details["email"],$password);
            
            //Try executing the query ~ returns true on success and false on failure
            return($insert_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }   
    }
    
    #Update a superuser account based on primary key
    public static function UpdateSuperuserAccount($id,$details)
    {
        global $dbCon;
        $update_query = "UPDATE superuser_accounts SET first_name=?,last_name=?,username=?,email=?,password=?,subbed=? WHERE acc_id=?";
        
        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {   
            $update_stmt->bind_param("sssssii",$details["first_name"],$details["last_name"],$details["username"],$details["email"],$details["password"],$details["subbed"],$id);
            
            //Try executing the query ~ returns true on success and false on failure
            return($update_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }  
    }
    
    #Delete a superuser account based on primary key
    public static function DeleteSuperuserAccount($id)
    {
        return self::DeleteBasedOnSingleProperty("superuser_accounts","acc_id",$id);
    }
    
    
    /*ADMIN ACCOUNT FUNCTIONS*/
    
    //Account requests
    #Create an admin account request
    public static function RequestAdminAccount($details)
    {
        global $dbCon;
        $insert_query = "INSERT INTO account_requests(first_name,last_name,business_name,business_description,cat_id,email,password,subbed) VALUES(?,?,?,?,?,?,?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {   
            $insert_stmt->bind_param("ssssissi",$details["first_name"],$details["last_name"],$details["business_name"],$details["business_description"],$details["cat_id"],$details["email"],$details["password"],$details["subbed"]);
            
            //Try executing the query ~ returns true on success and false on failure
            return($insert_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }   
    }
    
    //Products/services ~ add and remove services/products
    #Create a new product or service
    public static function CreateItem($details)
    {
        global $dbCon;
        $insert_query = "INSERT INTO items(item_name,type,description,images,price,quantity,discount,acc_id) VALUES(?,?,?,?,?,?,?,?)";
        
        //Attempt to prepare query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {   
            $insert_stmt->bind_param("ssssiiii",$details["item_name"],$details["type"],$details["description"],$details["images"],$details["price"],$details["quantity"],$details["discount"],$details["acc_id"]);
            
            //Try executing the query ~ returns true on success and false on failure
            return($insert_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }  
    }
    
    #Update product/service based on primary key
    public static function UpdateItem($id,$details)
    {
        global $dbCon;
        $update_query = "UPDATE items SET item_name=?,type=?,description=?,images=?,price=?,quantity=?,discount=?,acc_id=? WHERE item_id=?";
        
        //Attempt to prepare query
        if($update_stmt = $dbCon->prepare($update_query))
        {   
            $update_stmt->bind_param("ssssiiiii",$details["item_name"],$details["type"],$details["description"],$details["images"],$details["price"],$details["quantity"],$details["discount"],$details["acc_id"],$id);
            
            //Try executing the query ~ returns true on success and false on failure
            return($update_stmt->execute());
        }
        else #Failed to prepare query
        {
            return null;
        }  
    }
        
    #Delete item images from the database and server
    public static function DeleteItemImages($id)
    {
        global $dbCon;
        
        $select_query = "SELECT * FROM item_images WHERE item_id=?";
        
        if($select_stmt = $dbCon->prepare($select_query))
        {
            $select_stmt->bind_param("i",$id);
            $select_status = $select_stmt->execute();
            
            //If the selection was successful
            if($select_status)
            {
                $files = $select_stmt->get_result();
                
                $file_del_status = true;#File delete status ~ true if succesful deletion
                
                if($files && @$files->num_rows>0)
                {
                    $file_path = "";
                    
                    //Loop through each file and attempt to delete it from the server if it exists
                    foreach($files as $file)
                    {
                        $file_path = $file["img_path"];
                        
                        //If the file exists delete it from the server
                        if(file_exists($file_path))
                        {
                            $file_del_status = $file_del_status && (unlink($file_path));    
                        }
                    }
                    
                    //Delete the files from the database
                    $file_db_del_status = self::DeleteBasedOnSingleProperty("item_images","item_id",$id);
                    return ($file_db_del_status && $file_del_status);
                }
                else #Files were not found in the database
                {
                    return true;
                }
            }
            else #Failed to execute query to select files
            {
                return $select_status;
            }
        }
        else #Failed to prepare query to select files from the database
        {
            return null;
        }
    }
    
    /*LOCATIONS*/
    #Add a new country
    public static function AddCountry($data)
    {
        global $dbCon;
        
        $insert_query = "INSERT INTO countries(country_name) VALUES(?)";
        
        if($insert_stmt = $dbCon->prepare($insert_query))
        {
            $insert_stmt->bind_param("s",$data["country_name"]);
            
            $create_status = ($insert_stmt->execute());
            echo $dbCon->error;
            return $create_status;
        }
        else
        {
            return null;
        }
    }
    
    #Update country
    public static function UpdateCountry($id,$data)
    {
        global $dbCon;
        
        $update_query = "UPDATE countries SET country_name=? WHERE countries.country_id=?";
        
        if($update_stmt = $dbCon->prepare($insert_query))
        {
            $update_stmt->bind_param("si",$data["country_name"],$id);
            
            return($update_stmt->execute());
        }
        else
        {
            return null;
        }
    }
    
    #Delete country
    public static function DeleteCountry($id)
    {
        $del_status = self::DeleteBasedOnSingleProperty("countries","country_id",$id);
        return $del_status;
    }
    
    #Add a new region
    public static function AddRegion($data)
    {
        global $dbCon;
        
        //Set foreign key checks to 0
        $dbCon->query("SET foreign_key_checks=0");
        
        $insert_query = "INSERT INTO regions(region_name,country_id) VALUES(?,?)";
        
        if($insert_stmt = $dbCon->prepare($insert_query))
        {
            $insert_stmt->bind_param("si",$data["region_name"],$data["country_id"]);
            
            $create_status = ($insert_stmt->execute());
            echo $dbCon->error;
            return $create_status;
        }
        else
        {
            return null;
        }
    }
    
    #Update a region
    public static function UpdateRegion($id,$data)
    {
        global $dbCon;
        
        $update_query = "UPDATE regions SET region_name=? country_id=? WHERE regions.region_id=?";
        
        if($update_stmt = $dbCon->prepare($insert_query))
        {
            $update_stmt->bind_param("sii",$data["region_name"],$data["country_id"],$id);
            
            return($update_stmt->execute());
        }
        else
        {
            return null;
        }
    }
    
    #Delete a region
    public static function DeleteRegion($id)
    {
        $del_status = self::DeleteBasedOnSingleProperty("regions","region_id",$id);
        return $del_status;
    }
    
    #Delete product/service based on primary key
    public static function DeleteItem($id)
    {
        $del_item_images_status = self::DeleteItemImages($id);
        $del_items_status = self::DeleteBasedOnSingleProperty("items","item_id",$id);
        return ($del_item_images_status && $del_items_status);
    }
}