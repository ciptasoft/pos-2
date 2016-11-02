
<!-- Remove select and replace --><script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.8.2.min.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />



<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />

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
		
		$j('#purchaseTable > tbody > tr:last').after("<tr style='background-color:#EDEAEA;'><td><select style='width:100%; height:30px;'name='product"+newCount+"' id='product"+newCount+"' class='validate[required]'><option selected='selected' value=''>Please select your product</option><?php foreach($products as $product){?><option value='<?php echo $product['product_id'] ?>'><?php echo htmlspecialchars($product['product_name']); ?></option><?php } ?></select></td><td>pieces</td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' class='textbox validate[required,custom[number]] text-input' id='quantity"+newCount+"' onkeyup='calculateTotal("+newCount+");' name='quantity"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text' class='textbox validate[required,custom[number]] text-input' id='rate"+newCount+"'  value='' onkeyup='calculateTotal("+newCount+");' name='rate"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' id='amount"+newCount+"' readonly='readonly' class='textbox validate[required,custom[number]] text-input' name='amount"+newCount+"' onkeypress='return isNumberKey(event);'></td></tr>");
		
		
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
<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<!-- Middle Part -->
<div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="error-msg-area">								   
           <div id="update-message" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="error-msg-area">
            <div id="update-message1"  class="clearmsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
         </div>
    <?php endif; ?>
</div>
<div class="clear"></div>
                                                 
<div class="mainContainer" style="margin:0px;">
    <div class="content" id="mainContainer" style="width:100%; padding:0px; margin:0px;">
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="">	
            <div class="clear"></div>
       <div class="middlediv">
      <div class="container" style="width:100%; min-height:150%; float:left;">
              <div style="width:100%; float:left;">
					<form name="purchaseForm" id="purchaseForm" method="post" action="<?php echo Yii::app()->params->base_path ; ?>user/InsertPurchase">
                        <div class="firstcont" style="min-height:100%">
                        
                          <a href="<?php echo Yii::app()->params->base_path ; ?>user" style="color:white; cursor:pointer;"> <div class="heading" style="cursor:pointer;">##_HOME_HOME_##</div></a>
                              <div class="clear"></div>
                            <div class="productgreen" style="width:390%; height:auto; margin-left:5px; ">
                              <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                              <h2>Raise P.O.</h2>
  <div align="center" style=" margin-left:-160px;">   
                                  <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                              <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                      <table width="71%" border="0" cellspacing="5" cellpadding="5">
                            <tr>
                              <td align="left" width="13%" scope="col"><h4 style="color:white;">P.O. No.</h4></td>
                              <td width="26%">
                                <input style="width:100%; height:30px;" type="text" class="textbox" name="quantity<?php echo $i;?>" id="quantity<?php echo $i;?>" value="0" size="8" disabled="disabled"/>
                              </td>
                              <td width="21%" align="right" ><h4 style="color:white;">Supplier :</h4></td>
                              <td width="40%"><select style="width:210px; height:30px;" name="supplier" id="supplier"  class="validate[required]">                                                        <option selected="selected" value="">Please Select Your Supplier</option>
                                          <?php foreach($suppliers as $supplier)
                                                    {
                                                    ?>                                                    
                                              <option value="<?php echo $supplier['supplier_id'] ?>"><?php echo $supplier['supplier_name'] ?></option>
                                          <?php
                                                        
                                                    }?>
                                      </select>
                              </td>
                                   
                            </tr>
                            <tr>
                               <td align="left"><h4 style="color:white;">Date :</h4></td>
                              <td width="26%">
                                <input style="width:100%; height:30px;" type="text" class="textbox" name="quantity<?php echo $i;?>" id="quantity<?php echo $i;?>" value="<?php echo date('d-m-Y') ; ?>" size="8" disabled="disabled"/>
                              </td>
                              <td align="right" ><h4 style="color:white;">Receiving Store :</h4></td> 
                              <td>  	<select style="width:210px; height:30px;"  class="validate[required]"  name="store" id="store">                                                        <option selected="selected" value="">Please Select Your Store</option>
                                        <?php foreach($stores as $store)
                                                    {
                                                    ?>                                                    
                                            <option value="<?php echo $store['store_id'] ?>"><?php echo $store['store_name'] ?></option>
                                        <?php
                                                        
                                                    }?>
                                    </select>
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
                                    <p>&nbsp;</p>
                                      <p>&nbsp;</p>
                                       
                                        
                                    
                                    
                                 <div align="center" style=""> 
                                
                                  <table style="border-color:#000099;" width="90%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000099" name="purchaseTable" id="purchaseTable">
                                        <tr style="background-color:#EDEAEA;">
                                          <td width="24%" align="center" valign="middle" scope="col"><h2>Product</h2></td>
                                          <td width="13%" align="center" valign="middle" scope="col"><h2>Unit</h2></td>
                                          <td width="20%" align="center" valign="middle" scope="col"><h2>Quantity</h2></td>
                                          <td width="13%" align="center" valign="middle" scope="col"><h2>Rate</h2></td>
                                          <td width="30%" align="center" valign="middle" scope="col"><h2>Amount</h2></td>
                                        </tr>
                                        <tr style="background-color:#EDEAEA;">
                                           <td>
                                           <select style="width:100%; height:30px;"   class="validate[required]" name="product1" id="product1">
                                                        <option selected="selected" value="">Please select your product</option>
                                                        <?php foreach($products as $product)
                                                        {
                                                        ?>                                                    
                                                            <option value="<?php echo $product['product_id'] ?>"><?php echo $product['product_name'] ?></option>
                                                        <?php
                                                            
                                                     }?>
                                           </select>
                                       </td>
                                                <td>pieces</td>
                                                <td>
                                                    <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value="" name="quantity1" onkeyup="calculateTotal(1);" id="quantity1" size="8"/>
                                                </td>
                                                <td>
                                                    <input style="width:100%; height:30px; text-align:right;" type="text"  value="" class="textbox validate[required,custom[number]] text-input" name="rate1" onkeyup="calculateTotal(1);"  id="rate1" size="12"/>
                                                </td>
                                                <td>
                                                    <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value=""  name="amount1" onkeypress="return isNumberKey(event);" id="amount1" readonly="readonly" />
                                                </td>
                                            </tr>
                                  </table>          
                                 <table style="border-color:#000099;" width="90%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000099">                                           
                                        <tr style="background-color:#EDEAEA;">
                                         <td  colspan="3"> <img src="<?php echo Yii::app()->params->base_url ; ?>images/plus.png" style="margin-left:5px; width:20px; height:20px; cursor:pointer;" onclick="addTablerow();" /><b style="color:#666666;">&nbsp;&nbsp;Click here to add more products </b> </td>
                                          <td width="13%" align="right" valign="middle"><h2 style="margin-right:30px;" >Total</h2></td>
                                          <td width="30%" align="center" valign="middle"><input style="width:100%; height:40px; text-align:right;" class="textbox" id="totalPurchase" name="totalPurchase" onkeypress="return isNumberKey(event);"  type="text"  value="0" readonly="readonly" /></td>
                                        </tr>
                                  </table>
                                  </div>
                                    <p>&nbsp;</p>
                                    <div class="btnleft1" style="margin-right:65px;">
                                      <p>
                                      <input type="hidden" name="count" id="count" value="1" />
                                        <input type="submit" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" name="submit" id="submit" value="Save" />
                                        <input type="reset" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn"  name="cancel" id="cancel" value="cancel" />
                                      </p>
                                    </div>
                                      <p>&nbsp;</p>
                                </div>
                        </div>
                        <div class="secondcont">
                            <div class="heading"><?php echo Yii::app()->session['fullname']; ?> 's ##_HOME_PAGE_WORKSPACE_##</div>
                        </div>
                  	</form>
                <div class="thiredcont">
                    <div class="topbutton">
                        <a href="#" onclick="javascript:submitPendingTicket();" class="first"><img src="images/file_icon.png" width="20" height="20" title="Hold Ticket" /></a> 
                        <a href="#" id="browseBtn" onClick="javascript:loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/BrowseProduct','mainContainer');">Browse</a> 
                        <a href="#" id="searchBtn" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/SearchProductAjax','browsedata');">Search</a> 
                        <a href="#">Scan</a> 
                        <a href="<?php echo Yii::app()->params->base_path ; ?>user/logout">Logout</a>
                    </div>
                  <?php /*?>  <div class="browsebox">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="browsedata" class="browsedata">
                        	<tr style="background-color:#6AA566;">
                            	<td width="5%">&nbsp;</td>
                                <td width="65%">Product Name</td>
                                <td width="10%">Discount(%)</td>
                                <td width="10%">Price</td>
                                <td width="10%" style="background-color:#808080; border-left: 6px solid #333333;">&nbsp;</td>
                            </tr>
							<?php if(!empty($res['product'])) { ?>
							<?php foreach($res['product'] as $row ){  ?>
                          
                            <tr onclick="getProductDetail(<?php echo $row['product_id'] ; ?>)" style="cursor:pointer;">
                                <td width="5%">&nbsp;</td>
                               <td width="65%"> <?php echo $row['product_name'] ; ?></td> 
                                <td width="10%"><?php echo $row['product_discount'] ; ?></td>
                                <td width="10%"><?php echo $row['product_price'] ; ?></td>
                                <input id="product_id" type="hidden" value="<?php echo $row['product_id'] ?>" />
                                <?php if($data['product_id'] != $row['product_id']) {  ?>
                                <td width="10%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" onclick="javascript:addrow('<?php echo $row['product_name'] ; ?>','<?php echo $row['product_price'] ; ?>','<?php echo $row['product_id'] ?>','<?php echo $row['product_image'] ?>');"><img src="images/mark-true1.gif" /></td>
                                <?php } else { ?>
                                <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" style="background-color:gray;" ><img src="images/mark-true1.gif"/></td>
                                <?php } ?>
                            </tr>
                           
                            <?php } ?>
                             <?php } else { ?>
                            <tr>
                            <td colspan="4">No Products Available.</td>
                            </tr>
							<?php } ?>
                        </table>
                    </div><?php */?>
                </div>
        </div>
        
        <div class="clear"></div>
      </div>
    </div>
        </div>
       <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    
</div>
<div class="clear"></div>
