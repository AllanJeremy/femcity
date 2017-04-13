<?php
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
							<a href="index.html"><img src="images/home/femcity.jpg" alt="" width="144" height="153" /></a>
						</div>
					</div>
                    <div class="col-sm-8">
                        <div class="pull-right">
                            <div class="search_box pull-right">
                                <input type="text" placeholder="Search"/>
                            </div>
					   </div>
                        <div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									KENYA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">UGANDA</a></li>
									<li><a href="#">TANZANIA</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									NAIROBI
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">MOMBASA</a></li>
									<li><a href="#">KISUMU</a></li>
								</ul>
							</div>
						</div>
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