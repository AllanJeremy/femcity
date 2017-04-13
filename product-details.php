<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Product Details | E-Shopper</title>
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
        //Minimum number of item images to have before a carousel can be shown should be >1
        const MIN_CAROUSEL_COUNT = 2;
        const MIN_OTHER_ITEM_COUNT = 1;
    
        include_once("templates/header.php");
        showNav("shop");
    ?>
	
	<section>
		<div class="container">
			<div class="row">
                <?php
                    include_once("templates/category_list.php");
                
                    $item_id = @$_GET["id"];
                    
                    if(isset($item_id)):
                        $item_id = htmlspecialchars($item_id);
                        $item = DbInfo::GetItemById($item_id);
                        if($item):
                            $item_name = $item["item_name"];
                            $price = $item["price"];
                            
                            $images = DbInfo::GetItemImagesByItem($item_id);
                
                            $img = DbInfo::GetSingleItemImage($item_id);
                            $img_path = @$img["img_path"];
                            $img_name = @$img["img_name"];
                            $product_link = "product-details.php?id=".$item_id;
                            
                            //Account related functionality
                            $acc_id = $item["acc_id"];
                
                            $admin_acc = MySessionHandler::GetAdminById($acc_id);
                            $company_name = null;
                
                            if(isset($admin_acc) && $admin_acc)
                            {
                                $company_name = $admin_acc["business_name"];
                            }
                
                            
                ?>
				
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="<?php echo $img_path;?>" alt="<?php echo $img_name;?>" />
								<h3>ZOOM</h3>
							</div>
                            
                            <?php
                                if($images && $images->num_rows>=MIN_CAROUSEL_COUNT):
                            ?>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
                                        
                                        <?php
                                            $count=0;
                                            //For each product image found,
                                            foreach($images as $image):
                                                $img_id = $image["img_id"];
                                                $path = $image["img_path"];
                                                $name = $image["img_name"];
                                                $active_class ="";
                                                
                                                if($count===0)
                                                {
                                                    $active_class="active";
                                                }
                                        

                                        ?>
										<div class="item <?php echo $active_class;?>">
                                            <div class="col-sm-8">
			     							  <a href=""><img class="img-responsive" src="<?php echo $path;?>" alt="<?php echo $name;?>"></a>
                                            </div>
										</div>		
                                        
                                        <?php
                                            $count++;
								            endforeach;
                                        ?>
                                        
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>
                            <?php
                                endif;
                            ?>
						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<h2><?php echo ucwords($item_name);?></h2>
								<p>Web ID: <?php echo md5($item_id);?></p>
								<span>
									<span><small>Ksh</small> <?php echo $price;?></span>
								</span>
						        <p><a class="btn btn-default view-phone" data-item-id="<?php echo $item_id;?>">
										<i class="glyphicon glyphicon-eye-open"></i>
										View Phone
									</a>
                                </p>
								<br>
                                <p><b>Company :</b> 
                                    <?php 
                                        $company_link = "";
                                        if(isset($company_name))
                                        {
                                            $company_link = "<a href='company.php?id=".$acc_id."'>".$company_name."</a>";
                                        }
                                        else
                                        {
                                            $company_link = "<a href='javascript:void(0)' disabled title='The item selected was posted by a business we could not identify, please inform the admin of this finding'>Unknown account <i class='glyphicon glyphicon-info-sign'></i></a>";
                                        }
                                        
                                        echo $company_link;
                                    ?>
                                </p>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#details" data-toggle="tab">Details</a></li>
								<li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li>
<!--								<li><a href="#tag" data-toggle="tab">Tag</a></li>-->
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade in active" id="details" >
								<h2 class="title"><?php echo $item_name?> <small> By </small> <?php echo $company_link;?></h2>
                                <div class="container">
                                    <h4>Description</h4>
                                    <p><?php echo ucfirst($item["description"]);?></p><hr>
                                    <h4>Date Added : <?php echo $item["date_added"];?></h4>
                                </div>
							</div>
							
							<div class="tab-pane fade" id="companyprofile" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery1.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery3.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery2.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery4.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							
<!--
							<div class="tab-pane fade" id="tag" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery1.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery2.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery3.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery4.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</button>
											</div>
										</div>
									</div>
								</div>
							</div>
-->
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended-items"><!--recommended_items-->
                        <h2 class="title text-center">Other items by this service provider</h2>
                                
                    <?php
                        $recommended_items = DbInfo::GetItemsByAccId($acc_id,$item_id);

                        if($recommended_items && $recommended_items->num_rows>0):
                    ?>
      
                    <?php
                            foreach($recommended_items as $item):
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
                                 <div class="product-image-wrapper item <?php //echo $active_class;?> col-sm-4">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="<?php echo $img_path?>" alt="<?php echo $img_name?>" />
                                            <h2><small>Ksh</small> <?php echo $price;?></h2>
                                            <p><?php echo ucwords($item_name);?></p>
                                            <a href="product-details.php?id=<?php echo $item_id;?>" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Item</a>
                                        </div>
                                    </div>
                                </div>
					<?php
                            endforeach;
                        else:
                    ?>
                        <p>No other items by this service provider were found</p>
                        <br><br>
                    <?php
                        endif;
                    ?>
                        
                    </div><!--/recommended_items-->
                
                <?php
                        else:
                ?>
                <script> location.replace("404.php"); </script>
                <?php
                        endif;
                    else:
                ?>
                 <script> location.replace("404.php"); </script>
                <?php
                    endif;
                ?>  
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