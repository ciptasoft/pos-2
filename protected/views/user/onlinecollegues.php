 <!-- Remove select and replace -->
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

            <div class="usercont" style="height:192px; cursor:pointer;" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/collegues','secondcont')">
            <?php 
			if(count($res) > 0)
			{
			foreach($res as $row){?>
              <div class="userbox" style="width:80px;"><img src="images/avatar.png" width="80" height="60" /><br />
                <span><img src="images/online.png" width="12" height="12" />&nbsp;<b><?php echo $row['firstName']; ?></b></span></span></div>
			 <?php } ?> <?php } else { ?>
             <span><h2>No Collegues Online.</h2></span>
             <?php } ?>    
              <div style="clear:both"></div>
            </div>