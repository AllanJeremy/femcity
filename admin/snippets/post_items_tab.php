<div class="container well">
    <form class="row" method="post">
        <h4>Create a post here</h4><hr>
        <div class="col-xs-12 col-sm-6">
            <br>
            <label for="item_name">Item Name</label>
            <input type="text" class="form-control" placeholder="Name of the product/service" id="item_name">
        </div>
        <div class="col-xs-12 col-sm-6">
            <br>
            <label for="item_descr">Item Description</label>
            <textarea  class="form-control" placeholder="Product/Service Description" id="item_descr"></textarea>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <br>
            <label for="item_price">Price</label>
            <div class="input-group">
                <span class="input-group-addon">Ksh</span>
                <input type="number" min="10" max="100000" value="100" class="form-control validate-number" id="item_price">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <br>
            <label for="item_discount">Discount</label>
            <div class="input-group">
                <span class="input-group-addon">Ksh</span>
                <input type="number" min="0" max="100000" value="0" class="form-control validate-number" id="item_discount">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <br>
            <label for="item_type">Item type</label>
            <select class="form-control" id="item_type">
                <option value="product" selected>Product</option>
                <option value="service">Service</option>
            </select>
        </div>
<!--
        <div class="col-xs-12 col-sm-6 col-md-3">
            <br>
            <h5>Discount Percentage </h5>
            <p><span class="discount_perc">0</span>%</p>
            <br><br>
        </div>
-->
        
        <div class="col-xs-12">
        <br><br>
            <h4>Item Images : <small>Add images that represent the product or services you are providing here.</small></h4><hr>
        </div>
        
        <div class="col-xs-12">
        <?php
            MessageDisplay::PrintInfo("File must be a valid image type (png,jpg,gif) and must be less than 2MB per file.");
        ?>
        </div>
        <div class="col-xs-12">
            <label for="item_files">Image Files</label>
            <input id="item_files" class="file" type="file" name="item_files[]" data-url="server/php/" multiple placeholder="Drag and drop files here or select files to upload.">
        </div>
        
        <div class="col-xs-12">
            <br>
            <button class="btn btn-info pull-right">POST ITEM</button>
            <br><br>
        </div>
    </form>
</div>