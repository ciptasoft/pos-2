<!-- Remove select and replace -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.jeditable.js" ></script>
<!-- Dialog Popup Js -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/j.min.Dialog.js" ></script>		
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jDialog.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/smoothscroll.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />
<?php /*?><script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jcarousellite_1.0.1.pack.js"></script><?php */?>

<script type="text/javascript">
		/*$(function() {
    		$(".anyClass").jCarouselLite({
        		btnNext: ".next",
        		btnPrev: ".prev"
    		});
		});*/
	
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
			addProduct(productId,productPrice,quntity,total1);
			
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
			addProduct(productId,productPrice,quntity,total1);
			
		}
		
	}
	
   function submitTicket() {
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitTicket',
		  data: 'totalPayable='+totalPayable+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		  }
		 });
   }
   
    function submitPendingTicket() {
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitPendingTicket',
		  data: 'totalPayable='+totalPayable+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		  }
		 });
   }
   /*
   	$j("#viewMore").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });*/
	
 function addrow(productName=null,productPrice=null,productId=null,productImg=null)
	 {  
		
		if(productImg!='')
		{
			$j('#productImg').html('');
			$j('#productImg').html('<img src="assets/upload/product/'+productImg+'" width="333" height="200" />');
		}
		var i = 0;
		var sum = $j("#totalPayable").text();
		$j('#my_table > tbody > tr:last').after("<tr><td id='productName"+productId+"'>"+productName+"</td><td><input type='text' id='quantity"+productId+"' onkeyup='multiply_product("+productId+")' name='quantity' size='5px;' value='1'><input type='hidden' id='quantityold"+productId+"' name='quantityold' size='5px;' value='1'></td><td  id='price"+productId+"'>"+productPrice+"</td><td id='total1"+productId+"'>"+productPrice+"</td></tr>");
		$j('#selectbtn'+productId).attr( "onClick", "" ).css( "background-color","gray");
		
		var firstItem = 0;
		var price = 0;
		var quntity = 0;
		price = $("#price").val();
		quntity = $("#quantity").val();
		var total1 = $("#total1"+productId).text();
		/*firstItem = 0;
		if(price > 0)
		{
			firstItem = Number(quntity) * Number(price);
		}
		else
		{
			firstItem = 0;	
		}*/
		//alert('Total1 : ' +total1);
		//alert('Sum : ' + sum);
		
		total = Number(total1) + Number(sum);
		$j("#totalPayable").text(total);
	    $j("#pay").text(total + " /-   Pay");
		var quntity = 1;
		addProduct(productId,productPrice,quntity,total1);
	 }	
	 
	function addProduct(productId=null,productPrice=null,quntity=1,total1=null)
	{
		var invoiceId = <?php echo $invoiceId ;  ?>;
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitProductdesc',
		  data: 'productId='+productId+'&productPrice='+productPrice+'&quntity='+quntity+'&total1='+total1+'&invoiceId='+invoiceId,
		  cache: false,
		  success: function(data)
		  {
		   {
		   if( data == 0) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				$("#quantityold"+productId).val(quntityOld);
				$("#quantity"+productId).val(quntityOld);
				multiply_product(productId);
			}
		  }
		  }
		 });	
	}

	function getSearch(test)
	{
		
		$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	
		var keyword = $j("#keyword").val();
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>user/SearchProductAjax',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
	
			{
				$j("#demo").html('');
				$j("#demo").html(data);
	
				$j("#keyword").val(keyword);
				//$('#keyword').focus();
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
	
		});
	
	}
	


</script>
<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<div id="update-message"></div>
<!-- Middle Part -->
<div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="error-msg-area">								   
           <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="error-msg-area">
            <div class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
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
            <div style="margin:5px 0px; width:100%; float:left;"><span id="productImg"><img src="images/img.png" width="333" height="200" /></span></div>
            <div class="about">
              <h2>Wine Academy</h2>
              <div class="cont">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived only five centuries.</div>
            </div>
            <div class="offer">
              <h2> Today's Offers</h2>
              <div class="itemname">Item 1</div>
              <div class="price">10.50</div>
              <div class="itemname">Item 2</div>
              <div class="price">15.50</div>
              <div class="itemname">Item 3</div>
              <div class="price">20.50</div>
              <div class="itemname">Item 4</div>
              <div class="price">15.50</div>
            </div>
          </div>
          <div class="secondcont">
            <div class="topbutton"><a href="#">Butt</a> <a href="#">Browse</a> <a href="#">Scan</a> <a href="#" onclick="submitTicket();" class="last" id="pay">Pay</a></div>
            <div class="productbox">
              <div class="head">
                <div class="floatLeft width40p" ><?php echo $invoiceId ; ?></div>
                <a href="<?php echo Yii::app()->params->base_path;?>user/customerList" id="viewMore" class="viewIcon noMartb viewMore floatLeft"></a>
                <div id="customer_name1" style="float:left">Customer </div>
                <input type="hidden" id="customer_name" name="customer_name" value="">
                <div id="customer_id1"></div>
                 <input type="hidden" id="customer_id" name="customer_id" value="">
                </div>
              <div style="clear:both">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="productdata" id="my_table">
                  <?php if(isset($data['product_name']) && $data['product_name']!= '' && isset($data['product_price']) && $data['product_price'] != ''){ ?>
                  <tr>
                    <td><?php if(isset($data['product_name'])) { echo $data['product_name'] ;} ?></td>
                    <input type="hidden" id="product_name" name="product_name"  value="<?php if(isset($data['product_name'])) { echo $data['product_name'] ;} ?>" size="30px;" height="50px;">
                    <td><input type="text" id="quantity<?php echo $data['product_id'];?>" onblur="multiply_product(<?php echo $data['product_id'];?>)" name="quantity" size="5px;" value="1"><input type="hidden" id="quantityold<?php echo $data['product_id'];?>" name="quantityold" size="5px;" value="1"></td>
                    <td id="price<?php echo $data['product_id'];?>"><?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?></td>
                    <input type="hidden" id="price" onblur="multiply_product(<?php echo $data['product_id'];?>)" name="price" value="<?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?>" size="15px;">
                    <td id="total1<?php echo $data['product_id'];?>"><?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?></td>
                    <input type="hidden" id="total" name="total" value="" size="10px;">
                  </tr>
                 <?php } ?>
                 <tr>
                 </tr>
                 </table>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td>Tax 0% * 0 = 0.00</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>TOTAL</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td id="totalPayable"><?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="thiredcont">
            <div class="topbutton">
            <a href="#" onclick="submitPendingTicket();" class="first"><img src="images/file_icon.png" title="Hold Ticket" width="20" height="20" /></a> 
            <a href="#" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/BrowseProduct','mainContainer');">Browse</a> 
            <a href="#">Search</a> 
            <a href="#">Scan</a> 
            <a href="<?php echo Yii::app()->params->base_path ; ?>user/logout">Logout</a></div>
            <div class="browsebox" id="demo">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="browsedata">
              	<tr>
                  <td>&nbsp;</td>
                  <td>                  	
                	<form id="search" name="search" method="post" action="" onsubmit="return false;">
                		<input type="text" style=" width:200px; height:43px;" name="keyword" id="keyword" onkeyup="getSearch();" />
                    </form>
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <?php foreach($res['product'] as $row ){ ?>
                <tr>
                  <td width="5%">&nbsp;</td>
                  <td width="60%"><?php echo $row['product_name'] ; ?></td>
                  <td width="10%"><?php echo $row['product_price'] ; ?></td>
                  <input id="product_id" type="hidden" value="<?php echo $row['product_id'] ?>" />
                 <?php if($data['product_id'] != $row['product_id']) {  ?>
                  <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" onclick="addrow('<?php echo $row['product_name'] ; ?>','<?php echo $row['product_price'] ; ?>','<?php echo $row['product_id'] ?>','<?php echo $row['product_image'] ?>');">select</td>
                 <?php } else { ?>
                 <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" style="background-color:gray;" >select</td>
                 <?php } ?>
                </tr>
               <?php } ?>
              </table>
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
