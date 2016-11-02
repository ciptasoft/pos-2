<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" type="text/css" />

<div class="browseCalc" style="height:100%; background-color:white;" >

    <h1 class="popupTitle" style="background-color:#6AA566;"><?php echo $data['product_name']; ?></h1>
    <ul class="titleList popupTitleList" >
    	<?php /*?><li>
        	<label>Product Name:</label>
        	<span  style="width:230px;"><?php echo $data['product_name']; ?></span><p class="clear"></p>
        </li><?php */?>
		<li>
        	<label>##_PRODUCT_DESC_PAGE_DESCRIPTION_##:</label>
        	<span  style="width:300px;"><?php echo strip_tags($data['product_desc']); ?></span><p class="clear"></p>
        </li> 
		<li >
        	<label>##_BROWSE_PRODUCT_PRICE_##:</label>
        	<span  style="width:230px;"><?php echo $data['product_price']; ?></span><p class="clear"></p>
        </li> 
		
        <li>
        	<label>##_BTN_UPC_CODE_##:</label>
        	<span style="width:170px;"><?php echo $data['upc_code']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_PRODUCT_DESC_PAGE_MANUFACTURE_DATE_##:</label>
        	<span  style="width:230px;"><?php echo $data['manufacturing_date']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_PRODUCT_DESC_PAGE_EXPIRY_DATE_##:</label>
        	<span style="width:230px;"><?php echo $data['expiry_date']; ?></span><p class="clear"></p>
        </li>
        <li>
        	<label>##_PRODUCT_DESC_PAGE_PRODUCT_PICTURE_##:</label>
        	<span style="width:230px;"><img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $data['product_image']; ?>" width="200px" height="200px;" style="margin-right:30px;"/></span><p class="clear"></p>
        </li> 
    </ul>  
</div>
