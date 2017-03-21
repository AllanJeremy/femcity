<?php

//Handles the superuser's navigation
class SuperuserNavigation
{
    //Navigation section classes
    public $categories_class;
    public $users_class;
    public $featured_class;
    public $offers_class;
    public $requests_class;
    
    function __construct($active_tab)
    {   
        $this->categories_class="";
        $this->users_class="";
        $this->featured_class="";
        $this->offers_class="";
        $this->requests_class="";
        
        //Setting the active classes
        switch($active_tab)
        {
            case "categories":
                $this->categories_class="active";
            break;
            case "accounts":
                $this->users_class="active";
            break;
            case "featured":
                $this->featured_class="active";
            break;
            case "offers":
                $this->offers_class="active";
            break;
            case "requests":
                $this->requests_class="active";
            break;
            default:
                $this->categories_class="active";
        }
?>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">Femcity</a>
            </div>
            <ul class="nav navbar-nav">
              <li class="<?php echo $this->categories_class;?>"><a href="?p=categories">Categories</a></li>
              <li class="<?php echo $this->users_class;?>"><a href="?p=accounts">Accounts</a></li>
              <li class="<?php echo $this->featured_class;?>"><a href="?p=featured">Featured</a></li>
              <li class="<?php echo $this->offers_class;?>"><a href="?p=offers">Offers</a></li>
              <li class="<?php echo $this->requests_class;?>"><a href="?p=requests">Requests</a></li>
            </ul>
          </div>
        </nav>
<?php
    }

}