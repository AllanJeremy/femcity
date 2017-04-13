<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Company Profile</title>
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
        showNav("shop");
    ?>
	
	<section>
		<div class="container">
			<div class="row">
                <?php
                    include_once("templates/category_list.php");
                ?>
				
				<div class="col-sm-9 padding-right">
					<div class="items_available"><!--items_available-->
						<h2 class="title text-center">Items Available</h2>
                    <?php
                        $items_found = DbInfo::GetAllFeaturedItems();
                    
                        if($items_found && $items_found->num_rows>0):
                            foreach($items_found as $item):
                                $item_id = $item["item_id"];
                                $item_name = $item["item_name"];
                                $price = $item["price"];

                                $img = DbInfo::GetSingleItemImage($item_id);
                                $img_path = @$img["img_path"];
                                $img_name = @$img["img_name"];
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
                                        <img src="<?php echo $img_path;?>" alt="" />
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
						
<!--
						<div class="col-sm-12">
                            <ul class="pagination">
                                <li class="active"><a href="">1</a></li>
                                <li><a href="">2</a></li>
                                <li><a href="">3</a></li>
                                <li><a href="">&raquo;</a></li>
                            </ul>                        
                        </div>
-->

					</div><!--/items_available-->
				</div>
			</div>
		</div>
	</section>
	
    <?php
        include_once("templates/footer.php");
    ?>
  
    <script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>