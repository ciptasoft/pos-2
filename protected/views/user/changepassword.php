<div class="clear"></div>
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path; ?>";	

$j(document).ready(function(){
	
	$j("#btn_change_password_menu").click(function(){
		if($j('#old_password_menu').val() == "")
		{	
			$j('#passwordreseterror_menu').removeClass().addClass('false');
			$j('#passwordreseterror_menu').html(msg['PASSWORD_VALIDATE']);
			$j('#old_password_menu').focus();
			return false;
		}
		
		if($j('#new_password_menu').val() == "" || $j('#new_password_menu').val().length < 6)
		{	
			$j('#passwordreseterror_menu').removeClass().addClass('false');
			$j('#passwordreseterror_menu').html(msg['VPASSWORD_VALIDATE']);
			$j('#new_password_menu').focus();
			return false;
		}
		
		if($j('#new_password_menu').val() != $j('#c_password_menu').val())
		{	
			$j('#passwordreseterror_menu').removeClass().addClass('false');
			$j('#passwordreseterror_menu').html(msg['MPASSWORD_VALIDATE']);
			$j('#c_password_menu').focus();
			return false;
		}
		$j('#passwordreseterror_menu').removeClass();
		$j('#passwordreseterror_menu').html('');
	
		var post_data = $j("#frm_change_password_menu").serialize();
		$j("#btn_change_password_menu").attr("disabled","disabled");
		$j("#loader_change_password").css('display','block');
		$j.ajax({			
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path; ?>'+'user/changePassword',
			data: post_data,
			cache: false,
			success: function(data)
			{
				$j("#secondcont").html(data);
		   		setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
	  	   		setTimeout(function() { $j("#msgbox1").fadeOut();},2000 );		
			}
		});
	});
});
</script>



<div class="mainContainer">
<div class="secondcont" id="mainContainer">
 <div class="RightSide">
 
            <div class="clear"></div>
                <div class="heading" style="margin-top:2px;" ><?php echo Yii::app()->session['fullname']; ?> 's workspace</div>
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
                    <h1 style="color:#333333; margin-left:300px;">##_PROFILE_CHANGE_MY_PASSWORD_##</h1>
                    <div style="margin-left:300px;">
                    <?php echo CHtml::beginForm('','post',array('id'=>'frm_change_password_menu','name'=>'frm_change_password_menu')) ?>
                        <input type="hidden" id="user_id" name="userId" value="<?php echo Yii::app()->session['userId']; ?>" />
                        
                        <div class="field">
                            <span id="passwordreseterror_menu"></span>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="field">
                            <label>##_PROFILE_OLD_PASSWORD_##</label>
                            <input type="password"  name="oldpassword" class="textbox width300" id="old_password_menu"/>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="field">
                            <label>##_PROFILE_NEW_PASSWORD_##</label>
                            <input type="password"  name="newpassword" class="textbox width300" id="new_password_menu"/>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="field">
                            <label>##_PROFILE_CONFIRM_PASSWORD_##</label>
                            <input type="password"  name="confirmpassword" class="textbox width300" id="c_password_menu"/>
                        </div>
                        <div class="clear"></div>
                            
                        <div class="btnfield">
                            <input type="button" id="btn_change_password_menu"  name="btn_change_password_menu" value="##_BTN_SUBMIT_##" class="btn" />
                            <input id="btn_cancel_password" type="button" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>user'" value="##_BTN_CANCEL_##" class="btn" />
                            <span><img style="display:none; margin-left:20px; position:absolute;" id="loader_change_password" src="<?php echo Yii::app()->params->base_url; ?>images/spinner-small.gif" border="0" /></span>
                            <div class="clear"></div>
                        </div>
                            
                    <?php echo CHtml::endForm();?>
                    </div>
   			 	</div>
</div>
</div>
</div>