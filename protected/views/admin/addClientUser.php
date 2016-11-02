<script type="text/javascript">
var $ = jQuery.noConflict();

	$(document).ready(function(){
	   // binds form submission and fields to the validation engine
	   $("#functionForm").validationEngine();
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

<h1>
	<a href="<?php echo Yii::app()->params->base_path;?>admin/product">##_ADMIN_USER_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?>
</h1>
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/saveClientUser','post',array('id' => 'functionForm','name' => 'functionForm')) ?>
        <div class="content-box func-para">
            
            <div class="field-area">
                <div><label>##_ADMIN_FULL_NAME_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                            <input type="text" name="firstName" id="firstName" class="textbox validate[required] text-input" value="<?php echo $result['firstName'];?>" />
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                    
                    <div class="name">
                        <div>
                            <input type="text" name="lastName" id="lastName" class="textbox validate[required] text-input" value="<?php echo $result['lastName'];?>" />
                        </div>
                        <div class="info"><div class="nameerror"><span id="lastnameerror"></span></div></div>
                    </div>
                </div>
                <div>
                    
                <div class="clear"></div>
            </div>    
            <div class="field-area">
                <div><label>##_ADMIN_EMAIL_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['Email'];?>" class="textbox validate[required,custom[email]] text-input" name="Email" id="Email"  />
                    <span id="emailerror" ></span>
                </div>
            </div>    
            <div class="field-area">
               <div><label>Password<span class="star">*</span></label></div>
                <div>
                    <input type="password" value="<?php echo $result['password'];?>" class="textbox validate[required] text-input" name="password" id="password"  />
                    <span id="emailerror" ></span>
                </div>
            </div>       
            <div class="select">
                <div><label>Store<span class="star">*</span></label></div>
                <div>
                	<select id="store" name="store" class="validate[required]" >
                    <option value="">##_SELECE_STORE_##&nbsp;</option>
                    <option value="0">ALL</option>
                   	<?php foreach($storeList as $row) {  ?>
                    <option value="<?php echo $row['store_id'];?>"><?php echo $row['store_name'];?></option> 
                    <?php } ?>
                	</select>
                </div>
            </div>   
            
            <div class="field-area">
                <div class="terms">
                    <div>
                        <input type="submit" name="FormSubmit" id="FormSubmit" class="btn"  value="##_ADMIN_SUBMIT_##" />
                        <input name="cancel" type="reset" class="btn" value="##_ADMIN_CANCEL_##" onclick="javascript:history.go(-1)" />
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
	    <input type="hidden" <?php if(isset($result['product_id'])){ ?> value="<?php echo $result['product_id']; ?>" <?php } ?> name="product_id"/>
<?php echo CHtml::endForm();?>