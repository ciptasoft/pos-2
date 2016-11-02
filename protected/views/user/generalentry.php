<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>

<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<div id="update-message"></div>
<!-- Middle Part -->

<div class="clear"></div>

<div class="mainContainer">
    
    <!-- RightSide Slide Bar -->    
    <div class="secondcont" id="mainContainer" >
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="RightSide">	
            <div class="clear"></div>
                <div class="heading"><?php echo Yii::app()->session['fullname']; ?> 's ##_HOME_PAGE_WORKSPACE_##</div>
<div style="width:620px;">
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="error-msg-area">								   
   <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="error-msg-area">
    <div id="msgbox1" class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
</div>
        <?php endif; ?>
        </div>
             <div class="productboxgreen-small">
             
            	<h1 style="color:#333333; margin-left:300px;">##_GENERAL_ACCOUNT_ENTRY_##</h1>
              <div style="margin-left:300px;">
                 <div class="btnfield">   
               		<input type="button" name="submit" value="##_BROWSE_PRODUCT_CUSTOMER_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn"  onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/generalEntryforCustomer','secondcont')" />  
                    <input id="button" type="button" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/generalEntryforSupplier','secondcont')" value="##_SUPPLIER_##" class="btn" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"   />
                    <input id="button" type="button" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/generalEntryforOther','secondcont')" value="##_OTHER_##" class="btn" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"   />
                </div>
            </div>
       </div>
    </div>
    
</div>