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
        <div class="productboxgreen">
             <h1 style="color:#333333; margin-left:10px;">##_QUANTITY_DETAILS_##<span style="color:#053F81;"> <?php echo $product_name; ?></span></h1>
              <div style="margin-left:10px;">
                 <table width="90%" border="1" style="background-color:white;">
                    <tr>
                        <td align="left"><b>##_TOTAL_SALES_##</b></td>
                        <td width="100" align="right">
							<?php if(isset($totalQuantityForSales)) { echo $totalQuantityForSales; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"><b>##_TOTAL_SALES_RETURN_##</b></td>
                        <td width="100"  align="right">
                       		<?php if(isset($totalQuantityForSalesReturn)) { echo $totalQuantityForSalesReturn; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"><b>##_TOTAL_PURCHASE_##</b></td>
                       	<td width="100" align="right">
							<?php if(isset($totalQuantityForPurchase)) { echo $totalQuantityForPurchase; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"><b>##_TOTAL_PURCHASE_RETURN_##</b></td>
                        <td width="100" align="right">
							<?php if(isset($totalQuantityForPurchaseReturn)) { echo $totalQuantityForPurchaseReturn; } ?>
                        </td>
                    </tr>
               </table> 
               <div style="height:30px !important;">&nbsp;</div>  
            </div>
        </div>
    </div>
    
</div>