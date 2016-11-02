<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.cleditor.min.js"></script>
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>

<!-- Remove select and replace --><script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.8.2.min.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />



<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine.js" type="text/javascript"></script>
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
<script type="text/javascript">
var $ = jQuery.noConflict();

	$(document).ready(function(){
	   // binds form submission and fields to the validation engine
	   $("#purchaseReturn").validationEngine();
	  });
	  
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
<h1><a href="#">##_MODULE_PURCHASE_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp; ##_HEADER_GOODS_RECEIPT_##</h1>        
        <div class="content-box">
             <div style="margin-left:10px;">
             <div class="RightSide">	
             <div class="productboxgreen">
              <div style="margin-left:10px;">
                 <div class="btnfield"> 
                     <form method="post" action="<?php echo Yii::app()->params->base_path;?>admin/confirmPurchaseView" name="purchaseReturn" id="purchaseReturn" >
                         <span>##_INSERT_PURCHASE_ID_## :</span>
                         <input type="text" class="textbox validate[required,custom[number]] text-input" id="id" name="id" />
                         <input type="submit" name="submit" value="##_ADMIN_SUBMIT_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn"/>
                     </form>  
               </div>
            </div>
       </div>
    </div>
</div>
        </div>
</div>

