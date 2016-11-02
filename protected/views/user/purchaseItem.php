<!-- Remove select and replace -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.7.2.min.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
 $j(document).ready(function() {
	 $j.ajax({ url:'<?php echo Yii::app()->params->base_path ; ?>user/recentTicket',
         type: 'post',
         success: function(data) {
			 $j(".offer").replaceWith(data);
        }
		
	});
	
});
</script>

<script type="text/javascript">
	function multiply() {
		quantity = document.getElementById('quantity').value;
		price = document.getElementById('price').value;
		document.getElementById('total').value = quantity * price;
		
		$("#total1").html(quantity * price);
		document.getElementById('total1').text = quantity * price;
		$("#totalPayable").html(quantity * price);
	}
	
	function multiply_product(productId) {
		
		var quntityOld = $("#quantityold"+productId).val();
		var total1 = $("#totalPayable").text();
		quantity = document.getElementById('quantity'+productId).value;
		$("#quantityold"+productId).val(quantity);
		price = $("#price"+productId).text();
		total = $("#total1"+productId).text();
		
		$("#total1"+productId).text(quantity * price);
		if(quantity==1 || quantity==0)
		{
			
			var sum = 0;
			if(quantity==0)
			{
				
				if(total1==0)
				{
					total1 = 0;
				}
				total1 = Number(total1);
				total1 = Number(total1) - Number(price * (quntityOld));
			}
			else
			{
				
				
				if(total1==0)
				{
					total1 = 0;
				}
				total1 = Number(total1) - Number(price * (quntityOld-1));
			}
			$("#totalPayable").text(Number(total1) + Number(sum));
			$j("#pay").text(Number(total1) + Number(sum) + " /-   Pay");
			
			var productPrice = Number(price) ;
			var quntity = document.getElementById('quantity'+productId).value;
			var total1 = $("#total1"+productId).text(); 
			addProduct(productId,productPrice,quntity,total1,quntityOld);
			
		}
		else
		{
			//alert("quntity OLD : "+quntityOld);
			//alert("quntity NEW : "+quantity);
			if(quntityOld > 0)
			{
				quantity = Number(quantity) - quntityOld ;
			}
			
			
			var sum = quantity * price;
			//alert('total1 :'+total1);
			//alert(sum);
			$("#totalPayable").text(Number(total1) + Number(sum));
			$j("#pay").text(Number(total1) + Number(sum) + " /-   Pay");
			
			
			var productPrice = Number(price) ;
			var quntity = document.getElementById('quantity'+productId).value;
			var total1 = $("#total1"+productId).text(); 
			addProduct(productId,productPrice,quntity,total1,quntityOld);
			
		}
		
	}
	
  	/*function submitTicket(invoiceId) {
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			alert('Ticket is Empty.');
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php// echo Yii::app()->params->base_path;?>user/submitTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	  	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
		  }
		 });
   }*/
   
    function submitTicket(invoiceId) {
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			alert('Ticket is Empty.');
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/paymentTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".secondcont").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	  	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
		  }
		 });
   }
   
   function discardTicket(invoiceId) {
	   	//alert('invoiceId :'+invoiceId);
		//return false;
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			alert('Ticket is Empty.');
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/discardTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();},  10000 );
		   setTimeout(function() { $j("#update-message1").fadeOut();},  10000 );
		   
		  }
		 });
   }
   
    function submitPendingTicket(invoiceId) {
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			alert('Ticket is Empty.');
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitPendingTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();},  10000);
		   setTimeout(function() { $j("#update-message1").fadeOut();},  10000 );
		  }
		 });
   }
   
	function addrow(productName,productPrice,productId,productImg)
	{  
		if(productImg!='')
		{
			$j('#productImg').html('');
			$j('#productImg').html('<img src="assets/upload/product/'+productImg+'" width="100%" height="200" />');
		}
		var i = 0;
		var sum = $j("#totalPayable").text();
		$j('#my_table > tbody > tr:last').after("<tr id='tabletr"+productId+"'><td id='productName"+productId+"' onclick='getProductDetail("+productId+");' style='cursor:pointer;color:#FC5716;'>"+productName+"</td><td><input type='text' id='quantity"+productId+"' onkeyup='multiply_product("+productId+")' name='quantity' size='5px;' value='1'><input type='hidden' id='quantityold"+productId+"' name='quantityold' size='5px;' value='1'></td><td id='price"+productId+"' align='right'>"+productPrice+"</td><td id='total1"+productId+"' align='right'>"+productPrice+"</td><td style='cursor:pointer' onClick='removeTableRow("+productId+");' id='delete"+productId+"'><img src='images/false.png'/></td></tr>");
		$j('#selectbtn'+productId).attr( "onClick", "" ).css( "background-color","gray");
		
		var firstItem = 0;
		var price = 0;
		var quntity = 0;
		price = $("#price").val();
		quntity = $("#quantity").val();
		var total1 = $("#total1"+productId).text();
		
		total = Number(total1) + Number(sum);
		$j("#totalPayable").text(total);
		$j("#pay").text(total + " /-   Pay");
		var quntity = 1;
		addProduct(productId,productPrice,quntity,total1);
	}
	
	function addProduct(productId,productPrice,quntity,total1,quntityOld)
	{
		//var quntity = 1;
		var invoiceId = <?php echo $invoiceId ;  ?>;
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
	
	
	$j("#viewMore").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });
	  
	$j("#viewProduct").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });	
	  
	  
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
		var invoiceId = <?php echo $invoiceId ;  ?>;
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
	
	function getProductData()
	{
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
	 var upc_code = $j("#upc_code").val();
	 if(upc_code == null || upc_code == 'undefined' || upc_code == '')
	 {
		jAlert(msg['ENTER_UPC_CODE']);
		$j("#loading").hide();
		return false;	 
	 }
	 var invoiceId = <?php echo $invoiceId ; ?>;
	 $j.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>user/submitTicketbyUPCcode',
	  data: 'upc_code='+upc_code+'&invoiceId='+invoiceId,
	  cache: false,
	  success: function(data)
	  {
	   if(data == 0)
	   {
	   		jAlert(msg['PLEASE_ENTER_CORRECT_UPC_CODE']);
			return false;
	   }
	   if(data == -1)
	   {
	   		jAlert(msg['PRODUCT_ALREADY_ADDED']);
			return false;
	   }
	   //$j(".mainContainer").html(data);
	   $j("#browseBtn").trigger('click');
	   setTimeout(function() { $j("#update-message").fadeOut();},  10000 );
	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
	  }
	 });
	  $j("#loading").hide();	
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
      <div class="container">
              <div style="width:100%; float:left;">
                <div class="firstcont">
            <div class="heading">F&B </div>
            
            
            <div class="productgreen">
			  <p>Goods Received </p>
				  <p>
				    <label for="select">Supplier :</label>
				    <select name="select" id="select">
				      <option>Please Select</option>
			        </select>
			  </p>
				  <table width="40%" border="1" cellspacing="0" cellpadding="5">
				    <tr>
				      <td scope="col">P.O. No.</td>
				      <td scope="col">P.O. Date</td>
				      <td scope="col">Select</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td align="center" valign="middle">
				        <input type="checkbox" name="checkbox" id="checkbox" />

					  </td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td align="center" valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td align="center" valign="middle"><input type="checkbox" name="checkbox3" id="checkbox3" /></td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td align="center" valign="middle"><input type="checkbox" name="checkbox4" id="checkbox4" /></td>
			        </tr>
		      </table>
				  <p>&nbsp;</p>
				  <p>Received Date : ____________</p>
				  <p>&nbsp;</p>
				  <table width="100%" border="1" cellpadding="5" cellspacing="0">
				    <tr>
				      <td rowspan="2" align="center" valign="middle" scope="col">P.O. No.</td>
				      <td rowspan="2" align="center" valign="middle" scope="col">Product</td>
				      <td colspan="3" align="center" valign="middle" scope="col">P.O.</td>
				      <td colspan="3" align="center" valign="middle" scope="col">Invoice</td>
				      <td colspan="3" align="center" valign="middle" scope="col">Accepted</td>
			        </tr>
				    <tr>
				      <td align="center" valign="middle" scope="col">Qty.</td>
				      <td align="center" valign="middle" scope="col">Rate</td>
				      <td align="center" valign="middle" scope="col">Amt</td>
				      <td align="center" valign="middle" scope="col">Qty.</td>
				      <td align="center" valign="middle" scope="col">Rate</td>
				      <td align="center" valign="middle" scope="col">Amt</td>
				      <td align="center" valign="middle" scope="col">Qty.</td>
				      <td align="center" valign="middle" scope="col">Rate</td>
				      <td align="center" valign="middle" scope="col">Amt</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
			        </tr>
		      </table>
			  <p>&nbsp;</p>
				<div class="btnleft">
				  <p>
				    <input type="submit" name="button" id="button" value="Save" />
				    <input type="submit" name="button2" id="button2" value="cancel" />
				  </p>
				</div>
				  <p>&nbsp;</p>
            </div>
            
          </div>
                  <div class="secondcont">
                    <div class="topbutton"><a href="#">Butt</a> <a href="#">Browse</a> <a href="#">Scan</a> <a href="#" class="last">20,000 Pay</a></div>
                    <div class="producttable">
                    
                    </div>
                  </div>
                <div class="thiredcont">
                    <div class="topbutton">
                        <a href="#" onclick="javascript:submitPendingTicket();" class="first"><img src="images/file_icon.png" width="20" height="20" /></a> 
                        <a href="#" id="browseBtn" onClick="javascript:loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/BrowseProduct','mainContainer');">Browse</a> 
                        <a href="#" id="searchBtn" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/SearchProductAjax','browsedata');">Search</a> 
                        <a href="#">Scan</a> 
                        <a href="<?php echo Yii::app()->params->base_path ; ?>user/logout">Logout</a>
                    </div>
                    <?php /*?><div class="browsebox">
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
                          
                            <tr onclick="getProductDetail('<?php echo $row['product_id'] ; ?>')" style="cursor:pointer;">
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
