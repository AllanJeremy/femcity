<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
    <?php
        include_once("templates/header.php");
        ShowNav("index");
	?>
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>

						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free E-Commerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="images/home/girl1.jpg" class="girl img-responsive" alt="" />
									<img src="images/home/pricing.png"  class="pricing" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>100% Responsive Design</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="images/home/girl2.jpg" class="girl img-responsive" alt="" />
									<img src="images/home/pricing.png"  class="pricing" alt="" />
								</div>
							</div>

							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free Ecommerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="images/home/girl3.jpg" class="girl img-responsive" alt="" />
									<img src="images/home/pricing.png" class="pricing" alt="" />
								</div>
							</div>

						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/slider-->

	<section>
		<div class="container">
			<div class="row">
				<?php
                    include_once("templates/category_list.php");
                ?>

				<div class="col-sm-9 padding-right">

                    <div class="featured-items"><!--featured_items-->
                    <?php
                        $featured_items = DbInfo::GetAllFeaturedItems();

                        if($featured_items && $featured_items->num_rows>0):
                    ?>
                        <h2 class="title text-center">Femcity Features</h2>
                    <?php
                            foreach($featured_items as $item):
                                $item_id = $item["item_id"];
                                $item_name = $item["item_name"];
                                $price = $item["price"];

                                $img = DbInfo::GetSingleItemImage($item_id);
                                
                                $img_path = $img_name = null;
                                if($img->num_rows>0)
                                {
                                    $img_path = @$img["img_path"];
                                    $img_name = @$img["img_name"];                             
                                }
                                else
                                {
                                    $img_path = GlobalInit::PLACEHOLDER_ITEM_IMG;
                                    $img_name = "No item image";
                                }

                                $product_link = "product-details.php?id=".$item_id;

                                if(!isset($img_name))
                                {
                                    $img_name = "No item image";
                                }
                    ?>
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?php echo $img_path; ?>" alt="" />
                                        <h2><small>Ksh </small><?php echo $price;?></h2>
                                        <p><?php echo ucwords($item_name);?></p>
                                        <a href="<?php echo $product_link?>" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</a>
                                    </div>
                                    <div class="product-overlay">
                                        <div class="overlay-content">
                                            <h2><small>Ksh </small><?php echo $price;?></h2>
                                            <p><?php echo ucwords($item_name);?></p>
                                            <a href="<?php echo $product_link?>" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</a>
                                        </div>
                                    </div>
								</div>
                            </div>
                        </div>
					<?php
                            endforeach;
                        endif;
                    ?>

                    </div><!--/featured_items-->

                    <div class="latest-items-tab col-sm-12"><!--latest-items-->
				        <h2 class="title text-center">Latest Items</h2>
                        <?php
                            $other_items = DbInfo::GetAllOtherItems();
                            if($other_items && $other_items->num_rows>0):

                                foreach($other_items as $item):
                                    $item_id = $item["item_id"];
                                    $item_name = $item["item_name"];
                                    $price = $item["price"];

                                    $img = DbInfo::GetSingleItemImage($item_id);

                                    $img_path = $img_name = null;
                                    if($img && $img->num_rows>0)
                                    {
                                        $img_path = @$img["img_path"];
                                        $img_name = @$img["img_name"];

                                        if(!isset($img_name))
                                        {
                                            $img_name = "No item image";
                                        }
                                    }
                                    else
                                    {
                                        $img_path = "images/placeholder_logo.png";
                                        $img_name = "No image found";
                                    }

                        ?>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?php echo $img_path?>" alt="<?php echo $img_name?>" />
                                        <h2><small>Ksh</small> <?php echo $price;?></h2>
                                        <p><?php echo ucwords($item_name);?></p>
                                        <a href="product-details.php?id=<?php echo $item_id;?>" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                endforeach;
                            else:#No items found
                        ?>
                            <p>No items were recently added</p>
                        <?php
                            endif;
                        ?>
				</div><!--/latest-items-->
            </div>

            </div>

		</div>
	</section>

	<?php
        include_once("templates/footer.php")
    ?>

    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
  <script src="js/jquery.prettyPhoto.js"></script>
  <script src="js/main.js"></script>
  <script src="js/location_handler.js"></script>
</body>
</html>
