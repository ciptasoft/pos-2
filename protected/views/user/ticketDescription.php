<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>

<script type="text/javascript">
var $j = jQuery.noConflict();
$j(document).ready(function() {
	
	$j("#editToDo").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400
	});
	
	
	$j('#submit').click(function() {
		var postData	=	$j("#comments").serialize();
		$j.ajax({
			type: "POST",
			url: '<?php echo Yii::app()->params->base_path; ?>user/addComments' ,
			data: postData,
			success: function(response) {
				if(response == 'success'){
					$j('#commentDiv').load("<?php echo Yii::app()->params->base_path;?>user/getComments/id/<?php echo $data[0]['invoiceId'];?>");
					document.getElementById("commentText").value = "";
				}
			}
			
		});
	});
});
function updateTodoList(){
	
	var title =  $j("#todoListtitle").val();
	var desc =  $j("#description").val();
	var listId = $("#listId").val();
	if(title=='')
	{
		$j("#todoListtitlemsg").text("Please enter list name");
		return false;
	}
	else
	{
		var postData	=	$j('#editTodoItem_form').serialize();
		$j.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->params->base_path;?>user/updateToDoList',
			data: "title="+title+"&desc="+desc+"&listId="+listId,
			cache: false,
			success: function(data)
			{
				
				if(data == 1){
					$j("#update-message").removeClass().addClass('msg_success');
					$j("#update-message").html('Your To Do List Successfully Updated.');
					$j("#update-message").fadeIn();
					$j.fancybox.close();
					
				} else {
					$j("#update-message").removeClass().addClass('error-msg');
					$j("#update-message").html('Problem With Update.');
					$j("#update-message").fadeIn();
				}
			}
		});
	}
}
</script>
<div>
<?php // echo "<pre>"; print_r($data); print_r($productData); exit; ?>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
	<h1 class="popupTitle" style="background-color:#6AA566;">##_Ticket_DESC_PAGE_TICKET_DETAILS_##</h1>
    <ul class="titleList popupTitleList">
    	<li>
        	<label>##_Ticket_DESC_PAGE_INVOICE_ID_##:</label>
        	<span><?php echo $data['invoiceId']; ?></span><p class="clear"></p>
        </li>
        <li>
        	<label>##_Ticket_DESC_PAGE_CUSTOMER_NAME_##:</label>
        	<span><?php echo $data['customer_name']; ?></span><p class="clear"></p>
        </li>
		<li>
        	<label>##_Ticket_DESC_PAGE_CASHIER_##:</label>
        	<span><?php echo $data['casher']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_Ticket_DESC_PAGE_TOTAL_ITEM_##:</label>
        	<span><?php echo $data['total_item']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_Ticket_DESC_PAGE_TOTAL_AMOUNT_##:</label>
        	<span><?php echo $data['total_amount']; ?></span><p class="clear"></p>
        </li> 
        <li>
        	<label>##_CASH_PAY_##:</label>
        	<span><?php if($data['cashPayment'] == "") { $data['cashPayment'] == 0 ;} echo $data['cashPayment']; ?></span><p class="clear"></p>
        </li>
        <li>
        	<label>##_CARD_PAY_##:</label>
        	<span><?php if($data['cardPayment'] == "") { $data['cardPayment'] == 0 ;} echo $data['cardPayment']; ?></span><p class="clear"></p>
        </li>
        <li>
        	<label>##_CHEQUE_PAY_##:</label>
        	<span><?php if($data['bankPayment'] == "") { $data['bankPayment'] == 0 ;} echo $data['bankPayment']; ?></span><p class="clear"></p>
        </li>
        <li>
        	<label>##_CREDIT_AMOUNT_##:</label>
        	<span><?php if($data['creditPayment'] == "") { $data['creditPayment'] == 0 ;} echo $data['creditPayment']; ?></span><p class="clear"></p>
        </li>
		<li>
        	<label>##_Ticket_DESC_PAGE_CREATED_DATE_##:</label>
        	<span><?php echo $data['createdAt']; ?></span><p class="clear"></p>
        </li> 
	</ul>  
    <table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr height="30" align="center" valign="middle">
			<td width="10%"><strong style="color:#666666;">##_Ticket_DESC_PAGE_QUANTITY_##</strong></td>
			<td width="55%"><strong style="color:#666666;">##_BROWSE_PRODUCT_PRODUCT_NAME_##</strong></td>
			<td width="20%"><strong style="color:#666666;">##_Ticket_DESC_PAGE_UNIT_PRICE_##</strong></td>
			<td width="15%"><strong style="color:#666666;">##_Ticket_DESC_PAGE_TOTAL_##</strong></td>
		  </tr>
         <?php foreach($productData as $row) { ?>
		  <tr style="color:#666666;">
			<td align="right"><?php echo $row['quantity'] ?></td>
			<td align="left"><?php echo $row['product_name'] ;?></td>
			<td align="right"><?php echo $row['price'] ?></td>
			<td align="right"><?php echo $row['product_total'] ?></td>
		  </tr>
        <?php } ?>
	</table> 
</div>