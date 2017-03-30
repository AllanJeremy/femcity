<?php

//Handles the superuser's navigation
class AdminNavigation
{
    //Navigation section classes
    public $post_items_class;
    public $manage_items_class;
    public $settings_class;
    public $profile_class;
    
    function __construct($active_tab)
    {   
        $this->post_items_class="";
        $this->manage_items_class="";
        $this->settings_class="";
        $this->profile_class="";
        
        //Setting the active classes
        switch($active_tab)
        {
            case "create":
                $this->post_items_class="active";
            break;
            case "manage":
                $this->manage_items_class="active";
            break;
            case "profile":
                $this->settings_class = "active";
                $this->profile_class="active";
            default:
                //No tab is active it wasn't specified above as a case
        }
        
?>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#adminNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
              </button>
              <a class="navbar-brand" href="?p=create">Femcity Admin Panel </a>
            </div>
              
          <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="nav navbar-nav">
              <li class="<?php echo $this->post_items_class;?>"><a href="?p=create">Create Post</a></li>
              <li class="<?php echo $this->manage_items_class;?>"><a href="?p=manage">Manage Posts</a></li>
            </ul>
            
              <div class="container">
               <ul class="nav navbar-nav navbar-right">
                  <li class="<?php echo $this->settings_class;?>">
                      <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                          <span class="glyphicon glyphicon-cog"></span> Settings 
                          <span class="caret"></span>
                      </a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo $this->profile_class;?>" title="Personal profile. You can change your account information here.">
                            <a href="?p=profile">
                                <span class="glyphicon glyphicon-user"></span> Profile
                            </a>
                        </li>                
                        <li title="Logout of your account">
                            <a href="?action=logout">
                                <span class="glyphicon glyphicon-off"></span> Logout
                            </a>
                        </li>
                    </ul>
                      
                   </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
<?php
    }
    
}

require_once("../handlers/message_display.php");#Controls displaying of message boxes