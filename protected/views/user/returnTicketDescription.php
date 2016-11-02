<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>


<div>
<?php // echo "<pre>"; print_r($data); print_r($productData); ?>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
	<h1 class="popupTitle" style="background-color:#6AA566;">##_RETURN_TICKET_DESC_PAGE_TICKET_DETAILS_##</h1>
    <ul class="titleList popupTitleList">
    	<li>
        	<label>##_RETURN_TICKET_DESC_PAGE_INVOICE_ID_##:</label>
        	<span><?php echo $data['sales_return_invoiceId']; ?></span><p class="clear"></p>
        </li>
        <li>
        	<label>##_RETURN_TICKET_DESC_PAGE_CUSTOMER_NAME_##:</label>
        	<span><?php echo $data['firstName'];echo " ";echo $data['lastName']; ?></span><p class="clear"></p>
        </li>
		<li>
        	<label>##_RETURN_TICKET_DESC_PAGE_CASHIER_##:</label>
        	<span><?php echo $data['return_casher']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_RETURN_TICKET_DESC_PAGE_TOTAL_RETURN_ITEM_##:</label>
        	<span><?php echo $data['return_total_item']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_RETURN_TICKET_DESC_PAGE_TOTAL_RETURN_AMOUNT_##:</label>
        	<span><?php echo $data['return_total_amount']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_RETURN_TICKET_DESC_PAGE_CREATED_DATE_##:</label>
        	<span><?php echo $data['return_createdAt']; ?></span><p class="clear"></p>
        </li> 
	</ul>  
    <table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr height="30" align="center" valign="middle">
			<td width="10%"><strong style="color:#666666;">##_RETURN_TICKET_DESC_PAGE_QUANTITY_##</strong></td>
			<td width="55%"><strong style="color:#666666;">##_BROWSE_PRODUCT_PRODUCT_NAME_##</strong></td>
			<td width="20%"><strong style="color:#666666;">##_RETURN_TICKET_DESC_PAGE_UNIT_PRICE_##</strong></td>
			<td width="15%"><strong style="color:#666666;">##_RETURN_TICKET_DESC_PAGE_TOTAL_##</strong></td>
		  </tr>
         <?php foreach($productData as $row) { ?>
		  <tr style="color:#666666;">
			<td align="right"><?php echo $row['return_quantity'] ?></td>
			<td align="left"><?php echo  $row['product_name'] ;?></td>
			<td align="right"><?php echo $row['return_price'] ?></td>
			<td align="right"><?php echo $row['return_product_total'] ?></td>
		  </tr>
        <?php } ?>
	</table> 
</div>