<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Categories | Femcity</title>
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
        $cat_id = @$_GET["id"];
        
        //If the category id is not set, redirect to 404
        if(!isset($cat_id)):
    ?>
         <script> location.replace("404.php"); </script>
     <?php
        endif; 
   
        include_once("templates/header.php");
        ShowNav();
    
        $offer = DbInfo::GetOfferByCategory($cat_id);
        
        //If there is a valid offer 
        if($offer):
	?>
	<section id="advertisement">
		<div class="container ad-container">
			<h1 class="text-center"><?php echo ucwords($offer["offer_text"]);?></h1>
            <p class="text-center"><?php echo $offer["description"];?></p>
		</div>
	</section>
	<?php
        endif;
    ?>
	<section>
		<div class="container">
			<div class="row">
                <?php
                    include_once("templates/category_list.php");
                    
                    $cat = DbInfo::GetCategoryById($cat_id);
                    if(!isset($cat) || !$cat):
                ?>
                    <script> location.replace("404.php"); </script>
                <?php
                    endif;       
                ?>
				<div class="col-sm-9 padding-right">
                    <?php
                        $accounts_found = DbInfo::GetAdminByCategory($cat_id);
                    
                        if($accounts_found):
                    ?>
					<div class="company-list"><!--company-list-->
						<h2 class="title text-center"><?php echo @$cat["cat_name"]." available"?> </h2>
                        <?php
                            foreach($accounts_found as $acc):
                                $company_link = "company.php?id=".$acc["acc_id"];
                        ?>
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">
										<img src="images/placeholder_logo.png" alt="Business logo" />
										<h2><?php echo ucwords($acc["business_name"])." <br><small>(".$cat['cat_name'].")</small>";?></h2>
										<p>Location : <?php echo "Sample location";?></p>
										<a href="<?php echo $company_link?>" class="btn btn-default view-item"><i class="glyphicon glyphicon-eye-open"></i>View Business</a>
									</div>
                                </div>
                            </div>
						</div>
                        
                        <?php
                            endforeach;
                        ?>
<!--
                        <div class="col-xs-12">
                            <ul class="pagination">
                                <li class="active"><a href="">1</a></li>
                                <li><a href="">2</a></li>
                                <li><a href="">3</a></li>
                                <li><a href="">&raquo;</a></li>
                            </ul>
                        </div>
-->
					</div><!--/company-list-->
                <?php
                    else:#No companies in this category were found
                ?>
                    <div class="container">
                        <h4>No <?php echo $cat["cat_name"]?> businesses found</h4>
                    </div>    
                <?php
                    endif;#End if companies in this category were found
                ?>
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