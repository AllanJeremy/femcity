<?php
    $search_query = @$_GET["q"];
    $region_id = @$_GET["r"];
    $specific_loc = @$_GET["loc"];
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Search results | Femcity</title>
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
        showNav("");
    ?>
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 padding-right">
					<div class="search_results container"><!--items_available-->
						<h2 class="title text-center">Search Results</h2>
                        
                        <?php
                            //If the search query has been specified
                            if(isset($search_query)&& !empty($search_query)):
                                require_once("handlers/db_info.php");
                                #Sanitize the input to prevent XSS attacks
                                $search_query = htmlspecialchars($search_query);
                                
                                $items_found = DbInfo::GetSearchResults($search_query,$region_id,$specific_loc);
                                var_dump($items_found);
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

                                        if(!isset($img_name))
                                        {
                                            $img_name = "No item image";
                                        }
                        ?>
                        <div class="col-sm-3">
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
                                else:
                        ?>
                        <!--No search results were found-->
                        <div class="well">
                            <h4 class="text-center">No search results were found</h4>
                        </div>
                        <?php
                                endif;
                            else: #If the search query has not been specified   
                        ?>
                        <!--No search results were found ~ no search query was provided-->
                        <div class="well">
                            <h4 class="text-center">No results found | Enter something in the search bar</h4>
                        </div>
                        <?php
                            endif;
                        ?>
					</div><!--/items_available-->
                    <br>
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