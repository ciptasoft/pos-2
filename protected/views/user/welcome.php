 <!-- Remove select and replace -->
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

<div class="mainContainer" style="height:100%; background-color:#222222;">

    <!-- LeftSide Slide Bar -->    
    <div class="leftSlidebar" style="background-color:#6AA566; width:235px; height:150px; margin-top:100px; margin-left:40px;">	
        <!-- Slidebar -->
        <div class="sidebar" align="center"  style="background-color:#6AA566;">
                    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/logout','post',array('id' => 'logout','name' => 'logout')) ?>
                    <div style="background-color:#6AA566;">
                        <h1><label class="username">##_HOME_HEADER_HI_## <b><?php echo Yii::app()->session['fullname']; ?></b></label></h1>
                    </div>
                  <a href="<?php echo Yii::app()->params->base_path;?>user/index" id="logoImage"><img src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo.png" alt="" border="0"  style="background-color:#6AA566;"/></a>
            <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>
            
            <div class="clear"></div>
        </div>
    </div>
    <!-- End LeftSide Slide Bar -->   
    
    <!-- RightSide Slide Bar -->    
    <div class="content">
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="RightSide">	
            <div class="clear"></div>
        <div> 
        <h1 style="color:white; margin-top:100px;">Shift Details</h1>
          	 <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/Welcome','post',array('id' => 'functionForm','name' => 'functionForm')) ?>
           
            	
           			 <div style="padding:10px; height:300px;width:100%">
                <table style="color:#02356E;" width="100%" cellpadding="0" cellspacing="0" height="15%" border="1">
                    <tr>
                        <td width="100%">
                            <table style="background-color:#6AA566; padding:10px;" width="100%" cellspacing="1" height="50%">
                                <tr>
                                    <td align="right" width="150px"><b style="color:black;">Shift Id:</b></td>
                                    <td align="left">
                                        <input style="width:240px;" class="textbox" type="text" id="userId" name="userId" value="<?php echo Yii::app()->session['userId'];?>" disabled="disabled" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" width="150px"><b style="color:black;">Cash Float:</b></td>
                                    <td  align="left"><input style="width:240px;" class="textbox" type="text" id="cash_in" name="cash_in" value="0" /></td>
                                    <input type="hidden" name="cash_out" value="0" />
                                    <input type="hidden" name="cashier_id" value="<?php echo Yii::app()->session['userId'];?>" />
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <br/>
             <input type="submit" name="submit" value="Submit" style=" background-color:#02356E; color:#FFF; width:100px; height:30px; cursor:pointer;" />  
   			</div>
				
           
			<?php echo CHtml::endForm();?>
        </div>
        </div>
    </div>
    
</div>