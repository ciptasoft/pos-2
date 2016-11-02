<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.cleditor.min.js"></script>
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="application/javascript"> 
   	function generalEntryforCustomer() {
	   	 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/generalEntryforCustomer',
		  data: '',
		  cache: false,
		  success: function(data)
		  {
			   $j(".mainDiv").html(data);
		  }
		 });
   }
   
   function generalEntryforSupplier() {
	   	 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/generalEntryforSupplier',
		  data: '',
		  cache: false,
		  success: function(data)
		  {
			   $j(".mainDiv").html(data);
		  }
		 });
   }
   
   function generalEntryforOther() {
	   	 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/generalEntryforOther',
		  data: '',
		  cache: false,
		  success: function(data)
		  {
			   $j(".mainDiv").html(data);
		  }
		 });
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
<h1><a href="<?php echo Yii::app()->params->base_path;?>admin/generalEntryforAdmin">##_MONEY_TRANSACTION_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />##_GENERAL_ACCOUNT_ENTRY_##</h1>        
        <div class="content-box">
             <div style="margin-left:10px;">
             <div class="RightSide">	
             <div class="productboxgreen">
             
            	
              <div style="margin-left:10px;">
                 <div class="btnfield">   
               		<input type="button" name="submit" value="##_BROWSE_PRODUCT_CUSTOMER_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn"  onClick="generalEntryforCustomer();" />  
                    <input id="button" type="button" onClick="generalEntryforSupplier();" value="##_SUPPLIER_##" class="btn" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"   />
                     <input id="button" type="button" onClick="generalEntryforOther();" value="##_OTHER_##" class="btn" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"   />
                </div>
            </div>
       </div>
    </div>
</div>
        </div>
</div>

