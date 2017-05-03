<?php
    require_once("../handlers/db_info.php");
    require_once("../handlers/message_display.php");#Controls displaying of message boxes

    function DisplayAccountRequestBox()
    {
        $countries = DbInfo::GetAllCountries();
        $regions = null;
?>
                <div id="request_box" style="margin-top:25px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Admin Request account
                                <small class="pull-right">Have an account? <a href="login.php">Login</a></small>
                            </div>

                        </div>
                        <div class="panel-body" >
                            <form id="request_form" class="form-horizontal input-list" role="form">
                                <div id="signupalert" class="alert alert-danger hidden">
                                    <p>Error:</p>
                                    <span></span>
                                </div>

                                <!--First name-->
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <input required type="text" class="form-control" id="first_name" placeholder="First Name (Required)">
                                    </div>
                                </div>

                                <!--Last name-->
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <input required type="text" class="form-control" id="last_name" placeholder="Last Name (Required)">
                                    </div>
                                </div>

                                <!-- Business name-->
                                <div class="form-group">
                                    <label for="businessname" class="col-md-3 control-label">Business <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <input required type="text" class="form-control" id="business_name" placeholder="Business Name (Required)">
                                    </div>
                                </div>

                                <!--Business description-->
                                 <div class="form-group">
                                    <label for="username" class="col-md-3 control-label">Description <sup>(Optional)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <textarea style="resize:vertical;" type="text" class="form-control" id="business_description" placeholder="Business Description (Required)"></textarea>
                                    </div>
                                </div>

                                <!--Business category-->
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Category <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <select required id="business_category" required title="Category the business belongs to" class="form-control">
                                        <?php
                                            $categories = DbInfo::GetAllCategories();

                                            //If there are any categories
                                            if($categories):
                                                foreach($categories as $cat):
                                        ?>
                                            <option value="<?php echo $cat["cat_id"];?>"><?php echo $cat["cat_name"];?></option>
                                        <?php
                                                endforeach;
                                            else:
                                        ?>
                                        <option value="0">No Categories found</option>
                                        <?php
                                            endif;
                                        ?>
                                        </select>
                                    </div>
                                </div>

                                <!--Email address-->
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <input required type="email" class="form-control" id="email" placeholder="Email Address (Required)">
                                    </div>
                                </div>

                                <!--Phone number-->
                                <div class="form-group">
                                    <label for="phone" class="col-md-3 control-label">Phone <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <input required type="text" class="form-control" id="phone" placeholder="Phone Number (Required)">
                                    </div>
                                </div>

                                <div class="form-group location_control">
                                    <label for="country" class="col-md-3 control-label">Country <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <select required class="form-control country_list" id="country" title="Country your business is located in">
                                            <?php
                                                if(@$countries && $countries->num_rows>0):
                                                    $count = 0;
                                                    foreach($countries as $country):
                                                        $country_id = $country["country_id"];
                                                        $country_name = $country["country_name"];

                                                        #If the country is the first country
                                                        if($count==0)
                                                        {
                                                            #get the regions for that country
                                                            $regions = DbInfo::GetRegionsInCountry($country_id);
                                                        }
                                            ?>
                                            <option value="<?php echo $country_id?>"><?php echo strtoupper($country_name)?></option>
                                            <?php
                                                    $count++;
                                                    endforeach;
                                                else:
                                            ?>
                                            <option value="0" selected disabled>No countries found</option>
                                            <?php
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group location_control">
                                    <label for="region" class="col-md-3 control-label">Region <sup>(Required)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <select required class="form-control region_list" id="region" title="Region your business is located in">
                                            <?php
                                                if(@$regions && $regions->num_rows>0):
                                                    foreach($regions as $region):
                                                        $region_id = $region["region_id"];
                                                        $region_name = $region["region_name"];
                                            ?>
                                            <option value="<?php echo $region_id;?>"><?php echo strtoupper($region_name);?></option>
                                            <?php
                                                    endforeach;
                                                else:
                                            ?>
                                            <option value="0" selected disabled>No regions found</option>
                                            <?php
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="location" class="col-md-3 control-label">Location <sup>(Optional)</sup></label>
                                    <div class="col-md-9 input-container">
                                        <input type="text" class="form-control" id="location" placeholder="Specific location (Optional)" title="Specific location for the business. Users can find your business by searching for businesses in this location">
                                    </div>
                                </div>
                                <!--Google maps location -->


                                <div class="form-group">
                                    <!-- Button -->
                                    <div class="col-xs-12">
                                        <a id="btn_request_account" type="submit" class="btn btn-info pull-right" href="javascript:void(0)">Request Account</a>
                                    </div>
                                </div>
                            </form>
                         </div>
                    </div>
                </div>
<?php
    }

    //Require db handler for entering records into the database
    require_once("../handlers/db_handler.php");
    require_once("../handlers/session_handler.php");#session handler
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Femcity | Superuser Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/toastr.min.css" rel="stylesheet">
</head>
    <body>
        <main>
            <div class="container">
                <?php
                    //If admin is logged in ~ redirect to index.php
                    if(MySessionHandler::AdminIsLoggedIn())
                    {
                        echo "<p>Logged in. Redirecting you to the admin panel...</p>";
                        header("Location:index.php");
                    }
                    else
                    {
                        //Display informative message
                        echo "<div class='container'><br>";
                        MessageDisplay::PrintInfo("<b>Thank you for expressing interest in Femcity.</b> You can request an account for your business here and we'll get back to you as soon as possible.");
                        echo "</div>";
                        DisplayAccountRequestBox();
                    }

                ?>
            </div>
        </main>

        <script src="../js/jquery.min.js"></script>
        <script src="../js/toastr.min.js"></script>

        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/location_handler.js"></script>
        <script src="js/event_handler.js"></script>
    </body>
</html>
