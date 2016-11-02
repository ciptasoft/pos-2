
<!-- Remove select and replace --><script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.8.2.min.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />



<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	
	function calculateTotal(productId) {
		
		var quantity = $("#quantity"+productId).val();
		var rate = $("#rate"+productId).val();

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
		
		$j('#purchaseTable > tbody > tr:last').after("<tr style='background-color:#EDEAEA;'  id='tabletr"+newCount+"' ><td><img id='trImg"+newCount+"' onclick='removeTablerow("+newCount+");' style='float:left; cursor:pointer; margin-right:5px; margin-top:5px;' src='<?php echo Yii::app()->params->base_url;?>images/error-icon.png' alt='Cancel'/><select style='width:88%; height:30px;'name='product"+newCount+"' id='product"+newCount+"' class='validate[required]'><option selected='selected' value=''>##_PLEASE_SELECT_PRODUCT_##</option><?php foreach($products as $product){?><option value='<?php echo $product['product_id'] ?>'><?php echo htmlspecialchars($product['product_name']); ?></option><?php } ?></select></td><td>##_PIECES_##</td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' class='textbox validate[required,custom[number]] text-input' id='quantity"+newCount+"' onkeyup='calculateTotal("+newCount+");' name='quantity"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text' class='textbox validate[required,custom[number]] text-input' id='rate"+newCount+"'  value='' onkeyup='calculateTotal("+newCount+");' name='rate"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' id='amount"+newCount+"' readonly='readonly' class='textbox validate[required,custom[number]] text-input' name='amount"+newCount+"' onkeypress='return isNumberKey(event);'></td></tr>");
		
		
		$j('#count').attr( "value",newCount);
	}
	
	function removeTablerow(id)
	{  
		var $j = jQuery.noConflict();
		
		var count = $j("#count").val();
		var newCount = Number(count) - 1 ;
		
		$j("#purchaseTable tbody #tabletr"+id+"").remove();
		
		$j('#count').attr( "value",newCount);
		
		var newLoopCount = id + 1 ;
		var newId = id  ;
		
		if(count == id)
		{
			calculateTotalPurchase();
			return true;
		}else{
			
			for( i=newLoopCount ; i<=count ; i++)
			{
				$("#tabletr"+i).attr('id', 'tabletr'+newId);
				
				$("#amount"+i).attr('id', 'amount'+newId);
				$("#amount"+newId).attr('name', 'amount'+newId);
				
				$("#trImg"+i).attr('id', 'trImg'+newId);
				$("#trImg"+newId).attr('onclick', 'removeTablerow('+newId+');');
				
				$("#product"+i).attr('id', 'product'+newId);
				$("#product"+newId).attr('name', 'product'+newId);
				
				$("#quantity"+i).attr('id', 'quantity'+newId);
				$("#quantity"+newId).attr('name', 'quantity'+newId);
				$("#quantity"+newId).attr('onkeyup', 'calculateTotal('+newId+');');
				
				$("#rate"+i).attr('id', 'rate'+newId);
				$("#rate"+newId).attr('name', 'rate'+newId);
				$("#rate"+newId).attr('onkeyup', 'calculateTotal('+newId+');');
				
				//newLoopCount++;
				newId++;
			}
		
			calculateTotalPurchase();
			return true;
		}
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
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitProductdesc',
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
				return false;
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
		  url: '<?php echo Yii::app()->params->base_path;?>user/deleteProductdesc',
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
	  url: '<?php echo Yii::app()->params->base_path;?>user/getProductDetail',
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
	
			url: '<?php echo Yii::app()->params->base_path;?>user/SearchProductAjax/invoiceId/<?php echo $invoiceId; ?>',
	
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

<div class="clear"></div>

<!-- Login -->
  <div class="clear"></div>
 
  <div align="center">
      <h5>##_RAISE_PO_##</h5>
      <div class="mojone-loginbox">
      <form name="purchaseForm" id="purchaseForm" method="post" action="<?php echo Yii::app()->params->base_path ; ?>admin/InsertPurchase">     
          <div class="login-box" style="width:100% !important">
                         
      <table width="90%" border="0" cellspacing="5" cellpadding="5" >
            <tr>
               <td width="21%" align="right" ><h2 style="color:#826E89;">##_ADMIN_SUPPLIERS_## :</h2></td>
              <td width="40%">
              <select style="width:210px; height:30px;" name="supplier" id="supplier"  class="validate[required]">                                                       
               <option selected="selected" value="">##_PLEASE_SELECT_SUPPLIER_##</option>
                          <?php foreach($suppliers as $supplier)
                                    {
                                    ?>                                                    
                              <option value="<?php echo $supplier['supplier_id'] ?>"><?php echo $supplier['supplier_name'] ?></option>
                          <?php
                                        
                                    }?>
                      </select>
              </td>
              
              <td align="right"><h2 style="color:#826E89;">##_DATE_## :</h2></td>
              <td width="26%">
               <span> <?php echo  date("d M Y"); ?></span>
              </td>
              
                   
            </tr>
            <tr>
              <td align="right" ><h2 style="color:#826E89;">##_RECEIVING_STORE_## :</h2></td> 
              <td>  	<select style="width:210px; height:30px;"  class="validate[required]"  name="store" id="store">                                                       
              			 <option selected="selected" value="">##_PLEASE_SELECT_STORE_##</option>
                        <?php foreach($stores as $store)
                                    {
                                    ?>                                                    
                            <option value="<?php echo $store['store_id'] ?>"><?php echo $store['store_name'] ?></option>
                        <?php
                                        
                                    }?>
                    </select>
              </td>
              
              <td align="right" >&nbsp;</td> 
              <td>&nbsp;</td>
            </tr>
           
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
</table>

            <p>&nbsp;</p>
              <p>&nbsp;</p>
                 <div align="center" style=""> 
                
                  <table style="border-color: #000099;" width="90%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000099" name="purchaseTable" id="purchaseTable">
                        <tr style="background-color:#EDEAEA;">
                          <td width="24%" align="center" valign="middle" scope="col"><h2>##_PRODUCT_##</h2></td>
                          <td width="10%" align="center" valign="middle" scope="col"><h2>##_UNIT_##</h2></td>
                          <td width="10%" align="center" valign="middle" scope="col"><h2>##_BROWSE_PRODUCT_QUANTITY_##</h2></td>
                          <td width="10%" align="center" valign="middle" scope="col"><h2>##_RATE_##</h2></td>
                          <td width="10%" align="center" valign="middle" scope="col"><h2>##_GENERAL_AMOUNT_##</h2></td>
                          <!--<td width="2%" align="center" valign="middle" scope="col"></td>-->
                        </tr>
                        <tr style="background-color:#EDEAEA;" id="tabletr1">
                           <td>
                           <select style="width:100%; height:30px;"   class="validate[required]" name="product1" id="product1">
                                        <option selected="selected" value="">##_PLEASE_SELECT_PRODUCT_##</option>
                                        <?php foreach($products as $product)
                                        {
                                        ?>                                                    
                                            <option value="<?php echo $product['product_id'] ?>"><?php echo $product['product_name'] ?></option>
                                        <?php
                                            
                                     }?>
                           </select>
                       </td>
                                <td>##_PIECES_##</td>
                                <td>
                                    <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value="" name="quantity1" onkeyup="calculateTotal(1);" id="quantity1" size="8"/>
                                </td>
                                <td>
                                    <input style="width:100%; height:30px; text-align:right;" type="text"  value="" class="textbox validate[required,custom[number]] text-input" name="rate1" onkeyup="calculateTotal(1);"  id="rate1" size="12"/>
                                </td>
                                <td>
                                    <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value=""  name="amount1" onkeypress="return isNumberKey(event);" id="amount1" readonly="readonly" />
                                </td>
                                <!--<td>
                                    <img src="<?php// echo Yii::app()->params->base_url ; ?>images/error.png" />
                                </td>-->
                            </tr>
                  </table>          
                 <table style="border-color:#000099;" width="90%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000099">                                           
                        <tr style="background-color:#EDEAEA;">
                         <td  colspan="3"> <img src="<?php echo Yii::app()->params->base_url ; ?>images/plus.png" style="margin-left:5px; width:20px; height:20px; cursor:pointer;" onclick="addTablerow();" /><b style="color:#666666;">&nbsp;&nbsp;##_ADD_MORE_PRODUCT_## </b> </td>
                          <td width="16%" align="center" valign="middle"><h2 style="margin-right:0px;" >##_Ticket_DESC_PAGE_TOTAL_##</h2></td>
                          <td width="31%" align="center" valign="middle"><input style="width:100%; height:40px; text-align:right;" class="textbox" id="totalPurchase" name="totalPurchase" onkeypress="return isNumberKey(event);"  type="text"  value="0" readonly="readonly" /></td>
                       </tr>
                        
                  </table>
                  </div>
                <p>&nbsp;</p>
                <div class="btnleft1" style="margin-right:45px; float:right;">
                  <p>
                  <input type="hidden" name="count" id="count" value="1" />
                    <input type="submit" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" name="submit" id="submit" value="##_ADMIN_SAVE_##" />
                    <input type="reset" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn"  name="cancel" id="cancel" value="##_ADMIN_CANCEL_##" />
                  </p>
                </div>
                  <p>&nbsp;</p>
      </div>
      </form>
  </div>
                                                 

<div class="clear"></div>
