<?php
    require_once("handlers/global_init.php");#contains all global variables
    require_once("handlers/session_handler.php");#Accessing information from the database

    const ACTIVE_CLASS = 'class="active"';
    function ShowNav($active_tab="")
    {
        $home_class = $shop_class = $about_class = $contact_class = "";

        switch($active_tab)
        {
            case "index":
                $home_class = ACTIVE_CLASS;
                break;
            case "shop":
                $shop_class = ACTIVE_CLASS;
                break;
            case "products":
                $shop_class = ACTIVE_CLASS;
                break;
            case "product_details":
                $shop_class = ACTIVE_CLASS;
                break;
            case "contact":
                $contact_class = ACTIVE_CLASS;
                break;
            case "about":
                $about_class = ACTIVE_CLASS;
                break;
        }
?>
<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/home/femcity.jpg" alt="" width="144" height="153" /></a>
						</div>
					</div>
          <div class="col-sm-8">

              <form method="GET" action="search_results.php">

            <div class="form-group">
                <?php
                    $countries = DbInfo::GetAllCountries();
                ?>
							<div class="form-group col-sm-3 small-margin location_control">
                  <select id="country_container" title="Country" class="country_list root_file">
                      <?php
                          if($countries):
                              foreach($countries as $country):
                      ?>
                          <option value="<?php echo $country['country_id'];?>"><?php echo strtoupper($country['country_name']);?></option>
                      <?php
                              endforeach;
                          else:
                      ?>
                          <option value="none" disabled selected>No countries found</option>
                      <?php
                          endif;
                      ?>

                      <!-- <option value="">ANY</option> -->
                  </select>
							</div>

							<div class="form-group col-sm-3 small-margin location_control">
                  <select id="region_container" name="r" title="Specific region in country" class="region_list">
                      <?php
                          #If any countries were found
                          if($countries):
                              foreach($countries as $country):
                                  $country_id = $country["country_id"];

                                  $regions = DbInfo::GetRegionsInCountry($country_id);

                                  #If there were any regions found for the given country
                                  if($regions):
                                      foreach($regions as $region):
                                          $region_id = $region["region_id"];
                      ?>
                          <option value="<?php echo $region_id;?>"><?php echo strtoupper($region["region_name"]);?></option>
                      <?php
                                      endforeach;
                                  else:#No regions found
                      ?>
                          <option value="none" disabled selected>No regions found</option>
                      <?php
                                  endif;
                              break;
                              endforeach;
                          else:
                      ?>
                          <option value="none" disabled selected>No regions found</option>
                      <?php
                          endif;
                      ?>
                      <!-- <option value="">ANY</option> -->
                  </select>
							</div>

                            <div class="form-group col-sm-3 location_box small-margin">
                                <input type="text" name="loc" placeholder="Specific location" title="Specific location to find the item you are looking for">
                            </div>

<!--                            <div class="form-group   small-margin pull-right">-->
                                <div class="input-group col-sm-3">
                                    <input type="text" class="form-control" name="q" placeholder="Search..." value="<?php echo @$_GET["q"];?>"/>
                                    <span class="input-group-addon">
                                        <button class="fa fa-search btn_search"></button>
                                    </span>
                                </div>
<!--                            </div>-->
						</div>

                        </form>
                    </div>

				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" <?php echo $home_class;?>>Home</a></li>
								<li><a href="products.php" <?php echo $shop_class;?>>Products</a></li>
								<li><a href="about.php" <?php echo $about_class;?>>About</a></li>
								<li><a href="contact.php" <?php echo $contact_class;?>>Contact</a></li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
<?php
}
?>
