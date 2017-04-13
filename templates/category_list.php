<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordion"><!--category-products-->

            <?php
                require_once("handlers/db_info.php");
                $categories = DbInfo::GetAllCategories();
                foreach($categories as $cat):
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="categories.php?id=<?php echo $cat["cat_id"]?>"><?php echo $cat["cat_name"];?></a></h4>
                </div>
                <div id="sportswear" class="panel-collapse collapse">
                    <div class="panel-body">

                    </div>
                </div>
            </div>
            <?php
                endforeach;
            ?>

        </div><!--/category-products-->

        <!-- price-range
        <div class="price-range">
            <h2>Price Range</h2>
            <div class="well text-center">
                 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div>
        -->
    </div>
</div>