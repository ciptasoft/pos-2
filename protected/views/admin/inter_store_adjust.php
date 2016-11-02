<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.cleditor.min.js"></script>
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="application/javascript"> 
   	function interChangeProduct() {
	   	
		 var product_id = $j("#product").val();
		 var fromStore = $j("#fromStore").val();
		 var toStore = $j("#toStore").val();
		 var availableQuantity = $j("#availableQuantity").val();
		 var quantity = $j("#quantity").val();
		 
		 if(product_id == "0")
		 {
			jAlert(msg['SELECT_PRODUCT']);
			return false;
		 }
		 
		 if(fromStore == "0" || toStore == "0")
		 {
			jAlert(msg['SELECT_STORE']);
			return false;
		 }
		 
		 if(quantity == "0" || quantity == "")
		 {
			jAlert(msg['ADD_QUANTITY']);
			return false;
		 }
		 
		if(Number(quantity) > Number(availableQuantity) || availableQuantity == "Not Available")
		 {
			jAlert(msg['NOT_AVAILABLE']);
			return false;
		 }
		 
		 
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/interChangeProduct',
		  data: 'product_id='+product_id+'&fromStore='+fromStore+'&toStore='+toStore+'&quantity='+quantity,
		  cache: false,
		  success: function(data)
		  {
			   $j(".mainDiv").html(data);
			   setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
			   setTimeout(function() { $j("#msgbox1").fadeOut();},2000 ); 
			   //window.location.reload(true);
		  }
		 });
   }
   
   	function checkStock() {
	   	
		 var product_id = $j("#product").val();
		 var fromStore = $j("#fromStore").val();
		 
		 if(product_id == 0 || fromStore == 0)
		 {
			return false;	 
		 }
		 
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/CheckStockDetail',
		  data: 'product_id='+product_id+'&store_id='+fromStore,
		  cache: false,
		  success: function(data)
		  {
			  // alert(data);
			  if(data == 0 || data == "")
			  {
				  $j("#availableQuantity").val("Not Available");
			  }
			  else 
			  {
			   $j("#availableQuantity").val(data);
			  }
		  }
		 });
   }
   
   function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode 
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	  
function emptyValue(boxid)
{
	$j("#"+boxid+"").attr("value"," ");
}	

</script>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>   
<div class="mainDiv" >
<h1><a href="<?php echo Yii::app()->params->base_path;?>admin/generalEntryforAdmin">##_ADMIN_ACCOUNTS_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />##_INTER_STORE_ADJUST_##</h1>        
        <div class="content-box">
             <div style="margin-left:10px;">
             <table width="600" border="1" style="background-color:#cccccc;">
             		<tr>
                    	<td align="center" style=" width:200px;"><h2>##_PRODUCT_NAME_##</h2></td>
                        <td align="center" style=" width:400px;"><select name="product" id="product" class="select-box2" style="width:250px;" onclick="checkStock();" >
                               <option value="0" selected>##_SELECT_PRODUCT_NAME_##</option>
                <?php foreach($products as $row){ ?>
               <option value="<?php echo  $row['product_id'] ; ?>"><?php echo $row['product_name'];?>
               </option>
               <?php } ?>
                </select></td>
                    </tr>
                 	<tr>
                    	<td align="center" style=" width:200px;"><h2>##_CUSTOMER_LIST_PAGE_FROM_##</h2></td>
                        <td align="center" style=" width:400px;"><select name="fromStore" id="fromStore" class="select-box2" style="width:250px;" onclick="checkStock();">
                               <option value="0"  selected>##_SELECT_YOUR_STORE_##</option>
                <?php foreach($storeList as $row){ ?>
               <option value="<?php echo  $row['store_id'] ; ?>" <?php if(isset($result['store_name']) && $result['store_name']==$row['store_name']){ ?> selected <?php } ?> ><?php echo $row['store_name'];?>
               </option>
               <?php } ?>
                </select></td>
                    </tr>
                    <tr>
                 	    <td align="center" style=" width:200px;"><h2>##_CUSTOMER_LIST_PAGE_TO_##</h2></td>
                        <td align="center" style=" width:400px;"><select name="toStore" id="toStore" class="select-box2" style="width:250px;">
                               <option value="0" selected>##_SELECT_YOUR_STORE_##</option>
                <?php foreach($storeList as $row){ ?>
               <option value="<?php echo  $row['store_id'] ; ?>" <?php if(isset($result['store_name']) && $result['store_name']==$row['store_name']){ ?> selected <?php } ?> ><?php echo $row['store_name'];?>
               </option>
               <?php } ?>
                </select></td>
                    </tr>
                    <tr>
                    	<td align="center" style=" width:200px;"><h2>##_AVAILABLE_QUANTITY_##</h2></td>
                        <td align="center" style=" width:200px;"><input style="text-align:right;" class="textbox" type="text" id="availableQuantity" name="availableQuantity" value="0"  disabled="disabled" /></td>
                    </tr>
                    <tr>
                    	<td align="center" style=" width:200px;"><h2>##_Ticket_DESC_PAGE_QUANTITY_##</h2></td>
                        <td align="center" style=" width:200px;"><input style="text-align:right;" class="textbox" type="text" id="quantity" name="quantity" value="" onkeypress="return isNumberKey(event);"  /></td>
                    </tr>
            </table>
                   
<div class="btnfield">   
<input type="submit" name="submit" value="##_BTN_SUBMIT_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" onclick="interChangeProduct();" />  
  <input id="btn_cancel_password" type="button" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>admin'" value="##_BTN_CANCEL_##" class="btn" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"   />
</div>
</div>
        </div>
</div>

