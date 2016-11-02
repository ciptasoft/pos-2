<!-- Remove select and replace --><script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.8.2.min.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />



<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	
	function calculateTotal(productId) {
		
		var quantity = $("#recquantity"+productId).val();
		var remainQuantity = $("#remainQuantity"+productId).val();
		var rate = $("#rate"+productId).val();

		if(Number(quantity) > Number(remainQuantity))
		{
			alert("You can not receive quantity more than remaining quantity.");
			$("#recquantity"+productId).val(0);
			var quantity = 0 ;
		}
		

		if(rate == " ")
		{
			return false;	
		}

		totalAmount = Number(quantity) * Number(rate) ;

		$("#amount"+productId).val(totalAmount);
		calculateTotalPurchase();

	}
	
	function calculateTotalPurchase()
	{
		var count = $("#count").val();
		var total=0;
		for( i=1 ; i<=count ; i++)
		{
			var amount = $("#amount"+i).val();

			total = total + Number(amount);
		}
		$("#totalPurchase").val(total);
	}
	
   
	function addTablerow()
	{  
		var $j = jQuery.noConflict();
		
		var count = $j("#count").val();
		var newCount = Number(count) + 1 ;
		
		$j('#purchaseTable > tbody > tr:last').after("<tr style='background-color:#EDEAEA;'><td><select style='width:100%; height:30px;'name='product"+newCount+"' id='product"+newCount+"'><option value='0'>Please select your product</option><?php foreach($products as $product){?><option value='<?php echo $product['product_id'] ?>'><?php echo $product['product_name'] ?></option><?php } ?></select></td><td>pieces</td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='0' class='textbox' id='quantity"+newCount+"' onkeyup='calculateTotal("+newCount+");' name='quantity"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text' class='textbox' id='rate"+newCount+"'  value='0' onkeyup='calculateTotal("+newCount+");' name='rate"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='0' id='amount"+newCount+"' readonly='readonly' class='textbox' name='amount"+newCount+"' onkeypress='return isNumberKey(event);'></td></tr>");
		
		
		$j('#count').attr( "value",newCount);
	}
	
	function addProduct(productId,productPrice,quntity,total1,quntityOld)
	{
		//var quntity = 1;
		if(quntityOld == "null" || quntityOld == "" || quntityOld == "undefined")
		{
			quntityOld = 0 ;	
		}
		
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/submitProductdesc',
		  data: 'productId='+productId+'&productPrice='+productPrice+'&quntity='+quntity+'&total1='+total1+'&invoiceId='+invoiceId+'&quntityOld='+quntityOld,
		  cache: false,
		  success: function(data)
		  {
		   	if( data == 0) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				$("#quantityold"+productId).val(quntityOld);
				$("#quantity"+productId).val(quntityOld);
				multiply_product(productId);
				//return false;
			}
		  }
		 });	
	}
	
	
	  
	function removeTableRow(productId){
		var quntity = $("#quantity"+productId).val();
		var totalPayable = $j("#totalPayable").text();
		var total = $("#total1"+productId).text();
		var remainingTotal = Number(totalPayable) - Number(total);
		$j("#totalPayable").text(remainingTotal);
		$j("#pay").text(remainingTotal + " /-   Pay");
	
	 $j("#my_table tbody #tabletr"+productId+"").remove();
	 deleteProduct(productId,quntity);
	}
	
	function deleteProduct(productId,quntity)
	{
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/deleteProductdesc',
		  data: 'productId='+productId+'&invoiceId='+invoiceId+'&quntity='+quntity,
		  cache: false,
		  success: function(data)
		  {
			  $j("#searchBtn").trigger('click');
		   // $j('#selectbtn'+productId).css( "background-color","#CCCCCC");
		  }
		 });	
	}
	
	function getProductDetail(product_id)
	{
	// var upc_code = $j("#upc_code").val();
	 $j.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/getProductDetail',
	  data: 'product_id='+product_id,
	  cache: false,
	  success: function(data)
	  {
	   $j(".calc").html(data);
	  }
	 });
	}
	
	function getSearch(test)
	{
		
		<!--$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();-->
	
		var keyword = $j("#keyword").val();
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>admin/SearchProductAjax/invoiceId/<?php echo $invoiceId; ?>',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
	
			{
				$j("#browsedata").html('');
				$j("#browsedata").html(data);
	
				$j("#keyword").val(keyword);
				//$('#keyword').focus();
				setTimeout(function() { $j("#update-message").fadeOut();},  10000 );
				setTimeout(function() { $j("#update-message1").fadeOut();},  10000 );
	
			}
	
		});
	
	}
	
function isNumberKey(evt)
{
 if(evt.keyCode == 9)
 {
  
 }
 else
 {
  var charCode = (evt.which) ? evt.which : event.keyCode 
  if (charCode > 31 && (charCode < 48 || charCode > 57))
  return false;
 }
 return true;
}

function validateDetails()
{
	
	var totalPurchase = $("#totalPurchase").val();
	if(totalPurchase == 0)
	{
		jAlert("Purchase Return is Empty.");
		return false;	
	}
	else
	{
	  var postData = $('#purchaseForm').serialize();
	  $.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/submitPurchaseReturn',
	  data: postData,
	  cache: false,
	  success: function(data)
	  {
	  	window.location.href="<?php echo Yii::app()->params->base_path;?>admin/raisePurchaseReturnOrder/id/"+data;
	  }
	  });	
	}
}
</script>
<script type="text/javascript">
var $ = jQuery.noConflict();

	$(document).ready(function(){
	   // binds form submission and fields to the validation engine
	   $("#purchaseForm").validationEngine();
	  });
	  
</script>
<style>
h2 { background:none !important;
border:none !important;
}
</style>
<!-- End Mouse Scroll Finction -->
<!-- Middle Part -->
<!-- Login -->
  <div class="clear"></div>
 
  <div align="center">
      <h5>##_HEADER_GOODS_RECEIPT_##</h5>
      <div class="mojone-loginbox">
      <form name="purchaseForm" id="purchaseForm" method="post" action="<?php echo Yii::app()->params->base_path ; ?>admin/confirmPurchaseOrder">
         <div class="login-box" style="width:100% !important">
         <div class="productgreen" style="width:100%; height:auto; margin-left:5px; ">
                      <table width="71%" border="0" cellspacing="5" cellpadding="5">
                            <tr>
                              <td align="right" width="13%" scope="col"><h2 style="color:#826E89;">P.O. ##_NO_##:</h2></td>
                              <td width="26%">
                                <input style="width:100%; height:30px;" type="text" class="textbox" name="purchase_order_id" id="purchase_order_id" value="<?php echo $purchaseOrderData['purchase_order_id'] ; ?>" size="8" disabled="disabled"/>
                        <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="<?php echo $purchaseOrderData['purchase_order_id'] ; ?>" />         
                              </td>
                              <td width="21%" align="right" ><h2 style="color:#826E89;">##_SUPPLIER_## :</h2></td>
                              <td width="40%"><input style="width:280px; height:30px;" type="text" class="textbox" name="supplier" id="supplier" value="<?php echo $purchaseOrderData['supplier_name'] ; ?>" size="8" disabled="disabled"/></td>
                             <input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $purchaseOrderData['supplier_id'] ; ?>" />      
                            </tr>
                            <tr>
                               <td align="right"><h2 style="color:#826E89;">P.O. ##_DATE_## :</h2></td>
                              <td width="26%">
                                <input style="width:100%; height:30px;" type="text" class="textbox" name="quantity<?php echo $i;?>" id="quantity<?php echo $i;?>" value="<?php echo date('d-m-Y') ; ?>" size="8" disabled="disabled"/>
                              </td>
                              <td align="right" ><h2 style="color:#826E89;">##_RECEIVING_STORE_## :</h2></td> 
                              <td><input style="width:280px; height:30px;" type="text" class="textbox" name="store" id="store" value="<?php echo $purchaseOrderData['store_name'] ; ?>" size="8" disabled="disabled"/>
                              <input type="hidden" name="store_id" id="store_id" value="<?php echo $purchaseOrderData['store_id'] ; ?>" />  
                              </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
</table>
                              </div>
                                  <table style="border-color:#000099;" width="90%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000099" name="purchaseTable" id="purchaseTable">
                                        <tr style="background-color:#EDEAEA;">
                                          <td width="24%" align="center" valign="middle" scope="col"><h2>##_PRODUCT_##</h2></td>
                                          <td width="13%" align="center" valign="middle" scope="col"><h2>##_UNIT_##</h2></td>
                                          <td width="20%" align="center" valign="middle" scope="col"><h2>P.O. ##_BROWSE_PRODUCT_QUANTITY_##</h2></td>
                                          <td width="20%" align="center" valign="middle" scope="col"><h2>##_REMAINING_## ##_BROWSE_PRODUCT_QUANTITY_##</h2></td>
                                          <td width="20%" align="center" valign="middle" scope="col"><h2>##_RECEIVE_## ##_BROWSE_PRODUCT_QUANTITY_##</h2></td>
                                          <td width="13%" align="center" valign="middle" scope="col"><h2>##_RATE_##</h2></td>
                                          <td width="30%" align="center" valign="middle" scope="col"><h2>##_GENERAL_AMOUNT_##</h2></td>
                                        </tr>
                                    <?php $i = 1 ; foreach($purchaseData as $row) { ?>
                                        <tr style="background-color:#EDEAEA;">
                                           <td><input style="width:100%; height:30px; text-align:left; color:#666666; font-weight:bold;" type="text" class="textbox" value="<?php echo $row['product_name']; ?>" name="product<?php echo $i; ?>" id="product<?php echo $i ; ?>" size="8" readonly="readonly">
                                               <input type="hidden" name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>" value="<?php echo $row['product_id']; ?>" />
                                               <input type="hidden" name="id<?php echo $i; ?>" id="id<?php echo $i; ?>" value="<?php echo $row['id']; ?>" />
                                               <input type="hidden" name="oldRecQuantity<?php echo $i; ?>" id="oldRecQuantity<?php echo $i; ?>" value="<?php echo $row['receive_qnt']; ?>" />
                                           </td>
                                            <td>##_PIECES_##</td>
                                            <td>
                                                <input style="width:100%; height:30px; text-align:right;" type="text"  class="textbox validate[required,custom[number]] text-input" value="<?php echo $row['quantity']; ?>" name="quantity<?php echo $i; ?>" readonly="readonly" id="quantity<?php echo $i; ?>" size="8"/>
                                            </td>
                                            <td>
                                                <input style="width:100%; height:30px; text-align:right;" type="text"  class="textbox validate[required,custom[number]] text-input" value="<?php echo $row['quantity'] - $row['receive_qnt']; ?>" name="remainQuantity<?php echo $i; ?>" readonly="readonly" id="remainQuantity<?php echo $i; ?>" size="8"/>
                                            </td>
                                            <td>
                                                <input style="width:100%; height:30px; text-align:right;" type="text"  class="textbox validate[required,custom[number]] text-input" value="0" name="recquantity<?php echo $i; ?>" onkeypress="return isNumberKey(event);"  onkeyup="calculateTotal('<?php echo $i; ?>');" id="recquantity<?php echo $i; ?>" size="8"/>
                                            </td>
                                            <td>
                                                <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox" value="<?php echo $row['price']; ?>"  name="rate<?php echo $i; ?>" id="rate<?php echo $i; ?>" size="12" readonly="readonly"/>
                                            </td>
                                            <td>
                                                <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox" value="0"  name="amount<?php echo $i; ?>" id="amount<?php echo $i; ?>" readonly="readonly" />
                                            </td>
                                        </tr>
                                 <?php $i++ ; } ?>
                                <input type="hidden" name="count" id="count" value="<?php echo $i-1; ?>" />
                                  </table>          
                                 <table style="border-color:#000099;" width="90%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000099">                                           
                                        <tr style="background-color:#EDEAEA;">
                                         <td  colspan="5">&nbsp;&nbsp </td>
                                          <td width="18%" align="center" valign="middle"><h2>##_Ticket_DESC_PAGE_TOTAL_##</h2></td>
                                          <td width="13%" align="center" valign="middle"><input style="width:100%; height:40px; text-align:right;" class="textbox" id="totalPurchase" name="totalPurchase" type="text"  value="0" readonly="readonly" /></td>
                                        </tr>
                                  </table>
                                    <p>&nbsp;</p>
                                    <div class="btnleft1" style="margin-right:45px; float:right;">
                                      <p>
                                      
                                        <input type="submit" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" name="submit" id="submit" value="##_ADMIN_SUBMIT_##" />
                                        <input type="reset" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn"  name="cancel" id="cancel" value="##_ADMIN_CANCEL_##" />
                                      </p>
                                    </div>
                                      <p>&nbsp;</p>
                                </div>  
      </form>      
            
         
      </div>
  </div>
<div class="clear"></div>