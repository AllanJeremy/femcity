<?php

require_once("db_connect.php");

//Class used to handle file uploads
class FileUploader
{
    //Constants
    const BASE_DIRECTORY = "uploads/";
    
    //Variables
    public $file_found;#File
    public $file_name;#Name of the file
    public $upload_path;#Path the file is uploaded to
    public $file_type;#MIME type of the file
    public $item_id;
    
    //Constructor
    function __construct($file_name,$item_id)
    {
        $this->item_id = $item_id;#Item id
        
        $this->file_found = $_FILES[$file_name];#File found
        $file = $this->file_found;
        
        $this->file_name = $file["name"];#File name        
        $this->upload_path = self::BASE_DIRECTORY."/".$file_name;#Upload path
        $this->file_type = $file["type"];#MIME type of the file
    }
    
    //Adds the file information to the database
    public function AddFileToDb()
    {
        global $dbCon;
        $insert_query = "INSERT INTO item_images (img_path,img_name,img_type,item_id) VALUES(?,?,?,?)";
        
        //Attempt to prepare the query
        if($insert_stmt = $dbCon->prepare($insert_query))
        {
            $insert-stmt->bind_param("sssi",$this->upload_path,$this->file_name,$this->file_type,$this->item_id);
            return($insert_stmt->execute());
        }
        else
        {
            return null;
        }
    }
    
    //Validating file size
    private static function FileSizeValid()
    {
        
    }
    
    //Validating file type
    private static function FileTypeValid()
    {
        
    }
    //Uploading files
    public function UploadFile($file_name)
    {
        
    }
    
    //
}