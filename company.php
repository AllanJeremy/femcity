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
        $acc_id = $_GET["id"];
    
        if(!isset($acc_id)):
    ?>
        <script> location.replace("404.php"); </script>
    <?php
        endif;
        include_once("templates/header.php");
        showNav();
    
        $acc_found = MySessionHandler::GetAdminById($acc_id);
        if(!isset($acc_found) || @$acc_found->num_rows<=0 || !$acc_found):
    ?>
<!--        <script> location.replace("404.php"); </script>-->
    <?php
        else:
        endif;
    ?>
	
	<section>
		<div class="container">
			<div class="row">
                <?php
                    include_once("templates/category_list.php");
                    $business_name = $acc_found["business_name"];
                ?>
				
				<div class="col-sm-9 padding-right">
                    <div class="company-profile container">
                        <h2 class="title text-center">About <?php echo $business_name;?></h2>
                        <div class="col-sm-3">
                            <img class="img-responsive" src="images/placeholder_logo.png" alt="<?php echo $business_name.' logo';?>">
                        </div>
                        <div class="col-sm-9">
                            <br>
                            <?php
                                $descr = $acc_found["business_description"];
                                if(!empty($descr) && isset($descr)):
                            ?>
                                <p><?php echo $descr;?></p>
                            <?php
                                else:
                            ?>
                                <p>No description available for <?php echo $acc_found["business_name"];?></p>
                            <?php
                                endif;
                            ?>
                        </div>
                    </div><br><hr><br>
					<div class="items_available"><!--items_available-->
						<h2 class="title text-center">Items by <?php echo $acc_found["business_name"];?></h2>
                    <?php
                        $items_found = DbInfo::GetItemsByAccId($acc_id);
                    
                        if($items_found && $items_found->num_rows>0):
                            
                            foreach($items_found as $item):
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
                        
                                if(!isset($img_name) || empty($img_name))
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
                        else:
                            echo "<p>This business has not yet posted any items</p><br><hr><br>";
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