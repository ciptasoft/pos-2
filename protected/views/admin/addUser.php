<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-ui-1.8.13.custom.min.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url;?>css/custom-theme/jquery-ui-1.8.13.custom.css" />
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
	<a href="<?php echo Yii::app()->params->base_path;?>admin/client">##_ADMIN_USER_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?>
</h1>
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/saveClient','post',array('id' => 'functionForm','name' => 'functionForm','enctype' => 'multipart/form-data' )) ?>
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
                <div><label>##_COMPANY_NAME_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                            <input type="text" name="company_name" id="company_name" class="textbox validate[required] text-input" />
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
                       		<input type="file" name="logo"  class="validate[required] text-input" id="file" /> 
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
                                <input type="text" name="company_address" id="company_address" class="textbox validate[required]" style="width:508px;"/>
                                <div id="browseProduct" class="browseProduct"></div>
                            </div>
                            <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                        </div>
                    </div>
                
                    <div class="clear"></div>
            </div>
            
            <div class="field-area">     
                <div class="select">
                    <div><label>##_CLIENT_NO_USER_##<span class="star">*</span></label></div>
                    <div>
                        <select id="users" class="validate[required]" name="users" >
                        <option value="" selected>##_SELECE_NO_USERS_##&nbsp;</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        </select>
                    </div>
                </div>
            </div> 
             
            <div class="field-area">       
                <div class="select">
                    <div><label>##_CURR_##<span class="star">*</span></label></div>
                    <div>
                        <select id="currency" class="validate[required]" name="currency" style=" width:100px" >
                          <?php foreach($currencyList as $row){ ?>
                   <option value="<?php echo  $row['curr'] ; ?>" ><?php echo $row['curr'];?></option>
                   <?php } ?>
                        </select>
                    </div>
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