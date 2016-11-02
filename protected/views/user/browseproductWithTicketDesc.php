<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language'] ; ?>/global.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	function multiply() {
		quantity = document.getElementById('quantity').value;
		price = document.getElementById('price').value;
		document.getElementById('total').value = quantity * price;
		
		$("#total1").html(quantity * price);
		document.getElementById('total1').text = quantity * price;
		$("#totalPayable").html(quantity * price);
	}
	
	function checkStockDetail(productId)
	{
		quntityOld = $("#quantityold"+productId).val();
		quantity = document.getElementById('quantity'+productId).value;
		
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/CheckStockDetail',
		  data: 'quantity='+quantity+'&quntityOld='+quntityOld+'&productId='+productId,
		  cache: false,
		  success: function(data)
		  {
		  	if( data == 0 || data < 0) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				multiply_product(productId);
			}
			else
			{
				multiply_product(productId);
			}
		  }
		 });
   }
	
	function multiply_product(productId) {
		
		var quntityOld = $("#quantityold"+productId).val();
		var total1 = $("#totalPayable").text();
		quantity = document.getElementById('quantity'+productId).value;
		$("#quantityold"+productId).val(quantity);
		price = $("#price"+productId).text();
		total = $("#total1"+productId).text();
		
		/*checkStockDetail(quantity,quntityOld,productId);
		alert('test');
		return false;*/
		
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
	
   	function submitTicket(invoiceId) {
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			jAlert(msg['TICKET_EMPTY']);
			$j("#loading").hide();	
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/paymentTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		  $j("#loading").hide();
		   $j(".thiredcont").html(data);
		    $j('.browseCalc').css( "display","none");
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	  	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
		  }
		 });
		  	
   }
   
   	function discardTicket(invoiceId) {
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
	   	//alert('invoiceId :'+invoiceId);
		//return false;
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			jAlert(msg['TICKET_EMPTY']);
			$j("#loading").hide();	
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/discardTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   //$j(".mainContainer").html(data);
		   $j("#browseBtn").trigger('click');
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	  	   setTimeout(function() { $j("#update-message1").fadeOut();},10000 ); 
		  }
		 });
		  $j("#loading").hide();	
   }
   
    function submitPendingTicket(invoiceId) {
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			jAlert(msg['TICKET_EMPTY']);
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitPendingTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   
		   //$j(".mainContainer").html(data);
		   $j("#browseBtn").trigger('click');
		   setTimeout(function() { $j("#update-message").fadeOut();},10000);
	  	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
		  }
		 });
		  $j("#loading").hide();	
   }
   
   function checkStockDetailFromStock(productName,productId,productImg)
	{
		$j('#selectbtn'+productId).attr( "onClick", "" ).css( "background-color","gray");
		
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/getStockDetail',
		  data: '&productId='+productId,
		  cache: false,
		  success: function(data)
		  {
		  	if( data == 0 || data < 0) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				addrow(productName,productId,productImg);
			}
			else
			{
				addrow(productName,productId,productImg);
			}
		  }
		 });
   }
   
	function addrow(productName,productId,productImg)
	{  
		/*if(productImg!='')
		{
			$j('#productImg').html('');
			$j('#productImg').html('<img src="assets/upload/product/'+productImg+'" width="100%" height="200" />');
		}*/
		var productPrice = $j("#productprice"+productId).val();
		//alert(productPrice);
		//return false;
		
		var i = 0;
		var sum = $j("#totalPayable").text();
		$j('#my_table > tbody > tr:last').after("<tr id='tabletr"+productId+"'><td id='productName"+productId+"' onclick='getProductDetail("+productId+");' style='cursor:pointer;color:#666666;'><b>"+productName+"</b></td><td><input type='text' id='quantity"+productId+"' onkeyup='checkStockDetail("+productId+")' onkeypress='return isNumberKey(event);' name='quantity' size='5px;' value='1'><input type='hidden' id='quantityold"+productId+"' name='quantityold' size='5px;' value='1'></td><td id='price"+productId+"' align='right'>"+productPrice+"</td><td id='total1"+productId+"' align='right'>"+productPrice+"</td><td style='cursor:pointer' id='delete"+productId+"'><img src='images/false.png'/></td></tr>");
		
		$j("#delete"+productId).attr("onClick","removeTableRow('"+productId+"','"+productName+"','"+productImg+"');");
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
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
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
		   /*if( data == 0) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				$("#quantityold"+productId).val(quntityOld);
				$("#quantity"+productId).val(quntityOld);
				checkStockDetail(productId);
				return false;
			}*/
		  }
		 });	
		  $j("#loading").hide();	
	}
	
	function removeTableRow(productId,productName,productImage){
		
		var quntity = $("#quantity"+productId).val();
		var totalPayable = $j("#totalPayable").text();
		var total = $("#total1"+productId).text();selectbtn15
		var remainingTotal = Number(totalPayable) - Number(total);
		$j("#totalPayable").text(remainingTotal);
		$j("#pay").text(remainingTotal + " /-   Pay");
	
	 $j("#my_table tbody #tabletr"+productId+"").remove();
	 $j("#selectbtn"+productId).attr("onClick","checkStockDetailFromStock('"+productName+"','"+productId+"','"+productImage+"');");
	 $j("#selectbtn"+productId).css( "background-color","");
	 deleteProduct(productId,quntity);
	}
	
	function deleteProduct(productId,quntity)
	{
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
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
		  $j("#loading").hide();		
	}
	
	$j("#viewMore").fancybox({
	  'width' : 750,
	   'height' : 960,
	   'transitionIn' : 'none',
	   'transitionOut' : 'none',
	   'type':'iframe'
	  /*'padding'		 : 0,
		'autoScale'		: true,
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',*/
	  
	  });
	
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
	   setTimeout(function() { $j("#update-message").fadeOut();},10000 );
	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
	  }
	 });
	  $j("#loading").hide();	
	}
	
	function getProductDetail(product_id)
	{
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
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
	  $j("#loading").hide();	
	}
	
	function getSearch(test)
	{
		
	$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		var keyword = $j("#keyword").val();
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>user/SearchProductAjax/invoiceId/<?php echo $invoiceId; ?>',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
	
			{
				$j(".browsebox").html('');
				$j(".browsebox").html(data);
	
				//$('#keyword').focus();
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
				setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
	
			}
	
		});
		 $j("#loading").hide();	
	
	}
	
function searchInvoice()
	{
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		var invoiceId = $j("#upc_code").val();
		if(invoiceId == null || invoiceId == 'undefined' || invoiceId == '')
		{
		jAlert(msg['ENTER_INVOICE_ID']);
		return false;	 
		}
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/ticketDescriptionForSalesReturn',
		  data:'&invoiceId='+invoiceId,
		  cache: false,
		  success: function(data)
		  {
		 if(data == 0)
		   {
			  jAlert(msg['ENTERED_WRONG_INVOICE_ID']);  
			  return false; 
		   }
     	   $j(".mainContainer").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
		  }
		 });	
		  $j("#loading").hide();		
	}
	
function upcCode()
	{
		$j('#goBtn').css( "display","block");
		$j('#goBtn').attr("onClick","getProductData();");
		$j('#upc_code').removeAttr( "disabled","disabled");
		$j("#firstColumn").text('##_HOME_PAGE_UPC_CODE_##');
		$j('#firstColumn').css( "background-color","red");
		$j('#upc_code').attr( "value","");
	}
	
function calculator()
	{
		$j('#goBtn').css( "display","none");
		$j('#upc_code').attr( "value","");
		$j('#upc_code').removeAttr( "disabled","disabled");
		$j("#firstColumn").text('##_HOME_PAGE_CALCULATOR_##');
		$j('#firstColumn').css( "background-color","red");
	}
	
function enableSearch()
	{
		$j('#goBtn').css( "display","block");
		$j('#goBtn').attr("onClick","searchInvoice();");
		$j('#upc_code').attr( "value","");
		$j('#upc_code').removeAttr( "disabled","disabled");
		$j("#firstColumn").text('##_HOME_PAGE_SALES_RETURN_##');
		$j('#firstColumn').css( "background-color","red");
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
var n;
function eval1(Calculate)
{
    try{
	n=eval(Calculate.upc_code.value);
    Calculate.upc_code.value=n;
	}
	catch(err)
	{
		Calculate.upc_code.value=" ";
		jAlert(err);
		return false;
	}
}

function f1(Calculate)
{
    Calculate.upc_code.value=" ";
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
          <div class="secondcont" id="secondcont">
          	<div id="secondDiv" >
         		 <div class="topbutton">
                 <a href="<?php echo Yii::app()->params->base_path;?>site/prefferedLanguage&lang=eng">English</a> 					                  <a href="<?php echo Yii::app()->params->base_path;?>site/prefferedLanguage&lang=ar">##_ARABIC_##</a> 
                  <a href="#" title="Hold Ticket" onclick="submitPendingTicket('<?php echo $invoiceId ; ?>');" class="first">##_PENDING_##</a>
                 <a onclick="discardTicket(<?php echo $invoiceId ; ?>);" href="#" style="background-color:#CC0000;">##_BROWSE_PRODUCT_DISCARD_##</a>
                 <a href="#" onclick="submitTicket(<?php echo $invoiceId ; ?>);" class="last" id="pay" style="background-color:#FC5716;"><?php  echo $totalAmount."/-";  ?>
##_BROWSE_PRODUCT_PAY_##</a>
			</div>
                 <div class="productbox">
                  <div class="head">
                  <?php //echo "<pre>"; print_r($result); exit; ?>
                    <div class="floatLeft width40p" style="margin-left:4px !important;" >##_BROWSE_PRODUCT_INVOICE_NO_## : <?php echo $invoiceId ; ?></div>
                    <a href="<?php echo Yii::app()->params->base_path;?>user/customerList/invoiceId/<?php echo $invoiceId; ?>" id="viewMore" class="viewIcon noMartb viewMore floatLeft"></a>
                    <div id="customer_name1" style="float:left;  margin-left:10px;"><?php if(isset($result[0]['customer_name']) && $result[0]['customer_name'] != "" ) { echo $result[0]['customer_name'] ; } else { echo "##_BROWSE_PRODUCT_CUSTOMER_##" ; } ?></div>
                    <input type="hidden" id="customer_name" name="customer_name" value="<?php if(isset($result[0]['customer_name']) && $result[0]['customer_name'] != "" ) { echo $result[0]['customer_name'] ; } ?>">
                    <?php /*?><div id="customer_id1"><?php if(isset($result[0]['customer_id']) && $result[0]['customer_id'] != "" ) { echo $result[0]['customer_id'] ; } ?></div><?php */?>
                     <input type="hidden" id="customer_id" name="customer_id" value="<?php if(isset($result[0]['customer_id']) && $result[0]['customer_id'] != "" ) { echo $result[0]['customer_id'] ; } ?>">
                      </div>
                  <div style="clear:both">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="productdata" id="my_table">
                    <tr style="background-color:#DFE6EE;">
                                        <td>##_BROWSE_PRODUCT_PRODUCT_NAME_##</td>
                                        <td>##_BROWSE_PRODUCT_QUANTITY_##</td>
                                        <td align="right">##_BROWSE_PRODUCT_PRICE_##</td>
                                        <td align="right">##_BROWSE_PRODUCT_TOTAL_##</td>
                                        <td>&nbsp;</td>
                    </tr>
                    <?php $productIds = array();foreach ($ticket as $data)  { $productIds[] = $data['product_id'];  ?>
                    <?php if(isset($data['product_name']) && $data['product_name']!= '' && isset($data['product_price']) && $data['product_price'] != ''){ ?>
                      <tr id="tabletr<?php echo $data['product_id'];?>">
                        <td onclick='getProductDetail("<?php echo $data['product_id'];?>");' style='cursor:pointer;color:#666666;'><b><?php if(isset($data['product_name'])) { echo $data['product_name'] ;} ?></b></td>
                        <input type="hidden" id="product_name" name="product_name"  value="<?php if(isset($data['product_name'])) { echo $data['product_name'] ;} ?>" size="30px;" height="50px;">
                        <td><input type="text" id="quantity<?php echo $data['product_id'];?>" onkeyup="checkStockDetail(<?php echo $data['product_id'];?>)" onkeypress="return isNumberKey(event);" name="quantity" size="5px;" value="<?php echo $data['quantity'] ; ?>"><input type="hidden" id="quantityold<?php echo $data['product_id'];?>" name="quantityold" size="5px;" value="<?php echo $data['quantity'] ; ?>"></td>
                    <td id="price<?php echo $data['product_id'];?>" align="right"><?php if(isset($data['price'])) { echo $data['price'] ;} ?></td>
                        <input type="hidden" id="price" onblur="checkStockDetail(<?php echo $data['product_id'];?>)" name="price" value="<?php echo $data['price'] ; ?>" size="15px;">
                        <td id="total1<?php echo $data['product_id'];?>" align="right"><?php echo $data['product_total'] ; ?></td>
                        <input type="hidden" id="total" name="total" value="" size="10px;">
                         <td style="cursor:pointer" onClick="removeTableRow('<?php echo $data['product_id'];?>','<?php echo  trim(htmlspecialchars($data['product_name'])) ;?>','<?php echo $data['product_image'];?>');" id="delete<?php echo $data['product_id'];?>"><img src="images/false.png"/></td>
                       </tr>
                     <?php } ?>
                     <tr>
                     </tr>
                    <?php } ?>
                     </table>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                     <!-- <tr>
                        <td>##_BROWSE_PRODUCT_TAX_## 0% * 0 = 0.00</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>-->
              
                  <tr style="background-color:#DFE6EE; font-size:20px !important;">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="50%">&nbsp;</td>
                    <td align="right">##_Ticket_DESC_PAGE_TOTAL_AMOUNT_##&nbsp;</td>
                    <td align="right" id="totalPayable" style="padding-right:10px;"><?php  echo $totalAmount;  ?></td>
                  </tr>
                    </table>
                  </div>
                </div>
            </div>
            <div class="browseCalc">
                   <div class="calc">
        <form name="Calculate">
              <table width="100%" border="0" cellpadding="0" cellspacing="1" style="font-size:14px;">
                <tr>
                  <td id="firstColumn">&nbsp;</td>
                  <td colspan="3" align="center"><input style=" width:230px; height:43px; font-size:18px;"  value="<?php if(isset($_POST['upc_code'])) { echo $_POST['upc_code']; }?>" type="text" id="upc_code" name="upc_code" disabled/></td>
                  <td colspan="2" align="center"><input style=" width:120px; height:43px; display:none;" id="goBtn"  value="GO" type="button" class="btn"/></td>
                </tr>
                <tr>
                  <td width="25%" onClick="enableSearch();"><b style="color:#333333;">##_BTN_SALES_RETURN_##</b></td>
                   <td width="15%" class="dark" name="DIV" OnClick="Calculate.upc_code.value += '/'"><b style="color:#333333;">/</b><input type="hidden" name="DIV" value="/"/></td>
                   <td width="15%" class="dark" name="minus" OnClick="Calculate.upc_code.value += '*'"><b style="color:#333333;">*</b><input type="hidden" name="minus" value="X"/></td>
                 <td width="15%" class="dark" name="point" OnClick="Calculate.upc_code.value += '%'"><b style="color:#333333;">%</b><input type="hidden" name="point" value="%"/></td>
                 <td width="15%" class="dark" name="times" OnClick="Calculate.upc_code.value += '-'"><b style="color:#333333;">-</b><input type="hidden" name="times" value="-"/></td>
                 <td width="15%" class="dark" name="plus" OnClick="Calculate.upc_code.value += '+'"><b style="color:#333333;">+</b><input type="hidden" name="plus" value="+"/></td>
                </tr>
                <tr>
                  <td class="last" onClick="upcCode();"><b style="color:#333333;">##_BTN_UPC_CODE_##</b></td>
                  <td name="seven" OnClick="Calculate.upc_code.value += '7'"><b style="color:#333333;">7</b><input type="hidden" name="seven" value="7"/></td>
                  <td name="eight" OnClick="Calculate.upc_code.value += '8'"><b style="color:#333333;">8</b><input type="hidden" name="seven" value="8"/></td>
                  <td name="nine" OnClick="Calculate.upc_code.value += '9'"><b style="color:#333333;">9</b><input type="hidden" name="seven" value="9"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr> 
                <tr>
                  <td onClick="calculator();"><b style="color:#333333;">##_BTN_CALCULATOR_##</b></td>
                  <td name="four" OnClick="Calculate.upc_code.value += '4'"><b style="color:#333333;">4</b><input type="hidden" name="seven" value="4"/></td>
                  <td name="five" OnClick="Calculate.upc_code.value += '5'"><b style="color:#333333;">5</b><input type="hidden" name="seven" value="5"/></td>
                  <td name="six" OnClick="Calculate.upc_code.value += '6'"><b style="color:#333333;">6</b><input type="hidden" name="seven" value="6"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr>
                <tr>
                  <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/ticketList','secondDiv')"><b style="color:#333333;">##_BTN_TICKETS_##</b></td>
                  <td name="one" OnClick="Calculate.upc_code.value += '1'"><b style="color:#333333;">1</b><input type="hidden" name="seven" value="1"/></td>
                  <td name="two" OnClick="Calculate.upc_code.value += '2'"><b style="color:#333333;">2</b><input type="hidden" name="seven" value="2"/></td>
                  <td name="three" OnClick="Calculate.upc_code.value += '3'"><b style="color:#333333;">3</b><input type="hidden" name="seven" value="3"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr>
                <tr>
                  <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/Messages','secondDiv')"><b style="color:#333333;">##_BTN_MESSAGES_##</b></td>
                  <td OnClick="Calculate.upc_code.value += '.'"><b style="color:#333333;">.</b><input type="hidden" value="."/></td>
                  <td name="zero" OnClick="Calculate.upc_code.value += '0'"><b style="color:#333333;">0</b><input type="hidden" name="zero" value="0"/></td>
                  <td><input type="button" class="" style="width:100% ; height:100%;background-color:#CCCCCC; border:none; cursor:pointer;" OnClick="f1(this.form)" name="point" value="C"/></td>
                  <td colspan="2" class="dark" align="center"><input class="" id="DIV" style="width:100% ; height:100%; background-color:#666666; border:none; cursor:pointer;" type="button" name="DIV" value="##_BTN_ENTER_##" OnClick="eval1(this.form)"/></td>
                </tr>
                <tr>
                 <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/vault','secondDiv')"><b style="color:#333333;">##_BTN_VAULT_##</b></td>
                  <td name="bracket" OnClick="Calculate.upc_code.value += '('" ><b style="color:#333333;">(</b><input type="hidden" name="bracket" value="("/></td>
                  <td name="zero" value=")"  OnClick="Calculate.upc_code.value += ')'"><b style="color:#333333;">)</b><input type="hidden" name="zero" value=")" /></td>
                  <td colspan="2" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/customers','secondDiv')"><b style="color:#333333;">##_BROWSE_PRODUCT_CUSTOMER_##</b></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td id="aboutmeTd" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/aboutme','secondDiv')"><b style="color:#333333;">##_BROWSE_PRODUCT_ABOUT_ME_##</b></td>
                  <td colspan="2" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/changePassword','secondDiv')"><b style="color:#333333;">##_BROWSE_PRODUCT_CHANGE_PASSWORD_##</b></td>
                  <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/productList','secondDiv')"><b style="color:#333333;">##_BROWSE_PRODUCT_PRODUCTS_##</b></td>
                   <td colspan="2" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/returnTicketList','secondDiv')"><b style="color:#333333;">##_BROWSE_PRODUCT_RETURN_TICKETS_##</b></td>
                </tr>
              </table>
        </form>
        </div>
            	</div>
          </div>
          <div class="thiredcont">
            <div class="topbutton">
            <!--<a href="#" class="first"><img src="images/file_icon.png" width="20" height="20" /></a>--> 
            <a style="font-size:14px; width:60px;" href="<?php echo Yii::app()->params->base_path;?>user/home">##_HOME_HOME_##</a>
            <a style="font-size:14px; width:60px;" href="#" id="browseBtn" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/BrowseProduct','mainContainer');">##_BTN_BROWSE_##</a> 
            <a style="font-size:14px; width:60px;" href="#" id="categoryBtn" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/categoryListing','browsedata');">##_ADMIN_CATEGORY_##</a> 
            <a style="font-size:14px; width:60px;" href="<?php echo Yii::app()->params->base_path ; ?>user/logout">##_BTN_LOGOUT_##</a>
            </div>
            <div id="browsedata" class="browsedata"  style="margin-top:50px !important;">
                        <table width="114%" border="0" cellspacing="0" cellpadding="0">   
                        <tr style="background-color:#6AA566;">
                          <td align="center" colspan="4">                  	
                            <form id="search" name="search" method="post" action="" onsubmit="return false;">
                                ##_LBL_SEARCH_## : <input type="text" style=" width:305px; height:40px;font-size:16px;font-weight:bold" name="keyword" id="keyword" onkeyup="getSearch();" />
                            </form>
                          </td>
                          
                          <td width="10%" style="background-color:#222222; border-left: 6px solid #333333;">&nbsp;</td>
                        </tr>
                        <tr style="background-color:#6AA566;">
                                    <td width="5%">&nbsp;</td>
                                    <td width="40%">##_BROWSE_PRODUCT_PRODUCT_NAME_##</td>
                                    <!--<td width="15%" align="right">##_BROWSE_PRODUCT_DISCOUNT_##(%)</td>-->
                                    <td width="25%"  colspan="2" align="left">##_BROWSE_PRODUCT_PRICE_##</td>
                                    <td width="10%" style="background-color:#222222; border-left: 6px solid #333333;">&nbsp;</td>
                                </tr>
                     </table>
            <div id="browsedata" class="browsedata" style="padding-top:0 !important;">
                        <table width="95.5%" border="0" cellspacing="0" cellpadding="0">   
                        
                     </table>
                   <div class="browsebox" style="max-height:490px; overflow-y:scroll; min-height:0px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="browsedata" class="browsedata">
                                
                               <?php if(!empty($res['product'])) { ?>
    <?php foreach($res['product'] as $row ){ ?>
                <tr style="cursor:pointer;">
                  <td width="5%">&nbsp;</td>
                  <td onclick="getProductDetail(<?php echo $row['product_id'] ; ?>);" width="65%"><?php echo trim($row['product_name']) ; ?></td>
                 <?php /*?> <td width="10%"><?php echo $row['product_discount'] ; ?></td><?php */?>
       			<td width="25%"  colspan="2" align="right";>
                <select id="productprice<?php echo $row['product_id'] ?>" style="width:100px;">
                <option <?php if (isset($rating) && $rating == 1 ) { ?> selected="selected" <?php } ?> value="<?php echo $row['product_price'] ; ?>"><?php echo $row['product_price'] ; ?></option>
        <option <?php if (isset($rating) && $rating == 2 ) { ?> selected="selected" <?php } ?> value="<?php echo $row['product_price2'] ; ?>"><?php echo $row['product_price2'] ; ?></option>	
        <option <?php if (isset($rating) && $rating == 3 ) { ?> selected="selected" <?php } ?> value="<?php echo $row['product_price3'] ; ?>"><?php echo $row['product_price3'] ; ?></option>
        		</select>
                </td>
                  <input id="product_id" type="hidden" value="<?php echo $row['product_id'] ?>" />
                 <?php if(!in_array($row['product_id'],$productIds)) {  ?>
                  <td width="10%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" onclick="checkStockDetailFromStock('<?php echo trim(htmlspecialchars($row['product_name'])); ?>','<?php echo $row['product_id'] ?>','<?php echo $row['product_image'] ?>');"><img src="images/mark-true1.gif"/></td>
                 <?php } else { ?>
                 <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" style="background-color:gray;" ><img src="images/mark-true1.gif"/></td>
                 <?php } ?>
                </tr>
               <?php }   ?>
                  <?php } else { ?>
                <tr>
                <td colspan="4">##_BROWSE_PRODUCT_NO_PRODUCT_AVAILABLE_##</td>
                </tr>
                <?php } ?>
                                 <?php
            if(!empty($res['pagination']) && $res['pagination']->getItemCount()  > $res['pagination']->getLimit()){?>
                 <div class="pagination"  style="margin-right:0px;">
                    <?php
                    
                    $this->widget('application.extensions.WebPager', 
                                    array('cssFile'=>true,
                                             'pages' => $res['pagination'],
                                             'id'=>'link_pager',
                    )); ?>
                </div>
                <?php
            } ?>
          <script type="text/javascript">
        $j(document).ready(function(){
            $j('#link_pager a').each(function(){
                $j(this).click(function(ev){
                    ev.preventDefault();
                    $j.get(this.href,{ajax:true},function(html){
                        $j('.mainContainer').html(html);
                    });
                });
            });
        });
    </script>
                            </table>
                        </div>
                  </div>
                  </div>
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
