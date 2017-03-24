<?php

//This classs allows for displaying of different message boxes
class MessageBox
{
    //Generic display message ~ this message will be unhidden based on the $hidden parameter
    private static function DisplayGenericMessage($message,$msg_class="",$id="",$hidden=false)
    {
        $display_id="";
        $hide_class="";#Class that determines if the message is hidden or not
        
        //If the id is set, set the display id equal to it
        if(isset($id)&&(!empty($id)))
        {
            $display_id = 'id="'.$id.'"';
        }
        
        //If the message is hidden, add the hidden class
        if($hidden)
        {$hide_class="hidden";}
?>
    <div class="alert <?php echo $hide_class.' alert-'.$msg_class;;?>" <?php echo $display_id;?>>
        <p><?php echo $message;?></p>
    </div>
<?php
    }
    
    //Print hidden messages ~ hidden in DOM by default
    public static function PrintHiddenSuccess($message,$id="")
    {
        self::DisplayGenericMessage($message,"success",$id,true);
    }
    public static function PrintHiddenError($message,$id="")
    {
        self::DisplayGenericMessage($message,"warning",$id,true);
    }
    public static function PrintHiddenInfo($message,$id="")
    {
        self::DisplayGenericMessage($message,"info",$id,true);
    }

    public static function PrintHiddenImportant($message,$id="")
    {
        self::DisplayGenericMessage($message,"primary",$id,true);
    }

    //Print visible messages ~ visible in DOM by default
    public static function PrintSuccess($message,$id="")
    {
        self::DisplayGenericMessage($message,"success",$id);
    }
    public static function PrintError($message,$id="")
    {
        self::DisplayGenericMessage($message,"warning",$id);
    }
    public static function PrintInfo($message,$id="")
    {
        self::DisplayGenericMessage($message,"info",$id);
    }

    public static function PrintImportant($message,$id="")
    {
        self::DisplayGenericMessage($message,"primary",$id);
    }
    
}//End of class
?>