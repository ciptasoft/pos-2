<script type="text/javascript">
var bas_path = "<?php echo Yii::app()->params->base_path;?>";
var BASHPATH = "<?php echo Yii::app()->params->base_path;?>";
var imgPath = "<?php echo Yii::app()->params->base_url;?>images";
</script>
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url;?>images/favicon.ico" />
<script type="text/javascript">
var $j = jQuery.noConflict();
function validateAll()
{
	
	$j("#submitFormLoader").html('<img src="<?php echo Yii::app()->params->base_url;?>images/progress_indicator_16_gray_transparent.gif" alt="">');
	
	var flag=0;
	if(!validatefName())
	{
		return false;
	}
	//saveProfile();
	return true;
}
function validatefName()
{
	$j('#firstnameerror').removeClass();
	$j('#firstnameerror').html('');
	var fName=document.getElementById('FirstName').value;
	var reg = /^[A-Za-z ]*$/;
	if(fName=='' || fName=="First Name"){
		$j('#firstnameerror').addClass('false');
		$j('#firstnameerror').html('Full name Required.');
		return false;
	}
	else if(!reg.test(fName)){
		$j('#firstnameerror').removeClass();
		$j('#firstnameerror').addClass('false');
		$j('#firstnameerror').html('No special charaters');
		return false;
	}
	else{
		$j('#firstnameerror').removeClass();
		$j('#firstnameerror').addClass('true');
		$j('#firstnameerror').html('Ok');
		return true;
	}
}
function validatelName()
{
	$j('#lastnameerror').removeClass();
	$j('#lastnameerror').html('');
	var fName=document.getElementById('FirstName').value;
	var reg = /^[A-Za-z ]*$/;
	if(fName=='' || fName=="First Name"){
		$j('#lastnameerror').addClass('false');
		$j('#lastnameerror').html('Full name Required.');
		return false;
	}
	else if(!reg.test(fName)){
		$j('#lastnameerror').removeClass();
		$j('#lastnameerror').addClass('false');
		$j('#lastnameerror').html('No special charaters');
		return false;
	}
	else{
		$j('#lastnameerror').removeClass();
		$j('#lastnameerror').addClass('true');
		$j('#lastnameerror').html('Ok');
		return true;
	}
}

function saveProfile()
{
	var fName=document.getElementById('FirstName').value;
	//Yii::app()->params->base_path.'admin/saveAuthor
	var postData	=	$j('#adminProfileform').serialize();
	$j.ajax ({
		url:'<?php echo Yii::app()->params->base_path;?>admin/saveprofile',
		type:'POST',
		data: postData,
		success: function(response)
		{
			
			if(trim(response)=='LOGOUT' || trim(response)=='logout')
			{
				window.location=BASHPATH;
				return false;
			}
				//var obj = $j.parseJSON(response);
				$j(".username").html('<b>Hi '+fName+'</b>');
						$j('#update-message').removeClass();
						$j('#update-message').addClass('msg_success');
						$j('#update-message').html("Successfully Updated");
						setTimeout(function() {
							$j('#update-message').fadeOut();
							$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>admin/myprofile&ajax=true');	
						}, 10000 );	
			//inner tab menu
			//close inner tab menu
			return false;
		}
	//	});
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
<div class="pageNav">
     
  
</div>

<div id="update-message"></div>
<h1>##_ADMIN_PROFILE_##</h1>
<form name="adminProfileform" id="adminProfileform" action="<?php echo Yii::app()->params->base_path; ?>admin/saveProfile" method="post" enctype="multipart/form-data">
	
    <div class="content-box func-para">
		<input type="hidden" name="AdminID" id="AdminID" value="<?php echo $data['adminDetails']['id'];?>" >
		<div class="field-area">
			<div><label>##_ADMIN_FULL_NAME_##<span class="star">*</span></label></div> 
			<div>
				<div class="name">
					<div>
						<input type="text" name="FirstName" id="FirstName" class="textbox" value="<?php echo $data['adminDetails']['first_name'];?>"  />
					</div>
					<div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
				</div>
			</div>
            <div>
				<div class="name">
					<div>
						<input type="text" name="LastName" id="LastName" class="textbox" value="<?php echo $data['adminDetails']['last_name'];?>" />
					</div>
					<div class="info"><div class="nameerror"><span id="lastnameerror"></span></div></div>
				</div>
			
				
			</div>
			<div class="clear"></div>
		</div>
        
        <div class="field-area">
                <div><label>##_COMPANY_NAME_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                            <input type="text" name="company_name" id="company_name" class="textbox" value="<?php echo $data['adminDetails']['company_name'];?>" />
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
            
                <div class="clear"></div>
        </div>
        
        <div class="field-area">
            <div><label>##_COMPANY_LOGO_##<span class="star">*</span></label></div> 
            <div>
                <div class="name">
                    <div>
                   <?php if(isset($data['adminDetails']['company_logo']) && $data['adminDetails']['company_logo'] != "" ) { ?>
                    <img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/clientLogo/<?php echo $data['adminDetails']['company_logo']; ?>" width="200px" height="200px;" style="margin-right:30px;"/>
                      
                        <input type="file" name="logo" class="text-input" id="file" /> 
                        <?php } else {  ?>
                        <input type="file" name="logo" class="text-input" id="file" /> 
                        <?php } ?>
                    </div>
                    <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="field-area">
                <div><label>##_COMPANY_ADDRESS_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                            <input type="text" name="company_address" id="company_address" class="textbox" value="<?php echo $data['adminDetails']['company_address']; ?>" style="width:508px;"/>
                            <div id="browseProduct" class="browseProduct"></div>
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
            
                <div class="clear"></div>
        </div>
        
        <div class="field-area">
			<label>##_CURR_##<span class="star">*</span></label>
        </div>
        <div class="field-area">
			<select id="currency" name="currency" style=" width:100px" >
                      <?php foreach($currencyList as $row){ ?>
               <option value="<?php echo  $row['curr'] ; ?>"  <?php if(isset($data['adminDetails']['currency']) && $data['adminDetails']['currency']==$row['curr']){ ?> selected <?php } ?> ><?php echo $row['curr'];?></option>
               <?php } ?>
                	</select>
			<span id="emailerror" ></span>
		</div>
		<div class="field-area">
			<label>##_ADMIN_EMAIL_##<span class="star">*</span></label>
        </div>
        <div class="field-area">
			<input type="text" value="<?php echo $data['adminDetails']['email'];?>" class="textbox" name="Email" id="Email" readonly="1" />
			<span id="emailerror" ></span>
		</div>
		<div style="display:none" id="eml"></div>
		<div class="field-area btnfield">
			<input type="submit"   name="FormSubmit" id="FormSubmit" class="btn"  value="##_ADMIN_SUBMIT_##" />
			<input name="cancel" type="reset" class="btn" value="##_ADMIN_CANCEL_##" onclick="window.location.href='<?php echo Yii::app()->params->base_path; ?>admin/myprofile'" />
			<span id="submitFormLoader"></span>
		</div>
	</div>
	<div class="clear"></div>
</form>