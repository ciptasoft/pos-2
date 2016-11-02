<script type="text/javascript">
var $ = jQuery.noConflict();

	$(document).ready(function(){
	   // binds form submission and fields to the validation engine
	   $("#functionForm").validationEngine();
	  });
	  
</script>
<div style="width:200px !important;">
<h1>
	<a href="#">##_ADMIN_CUSTOMERS_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?>
</h1>
    
	
<form name="functionForm" id="functionForm" action="<?php echo Yii::app()->params->base_path; ?>user/addCustomer" method="post" enctype="multipart/form-data">

        <div class="content-box func-para">
            
            <div class="field-area">
                <div><label>##_CUSTOMER_NAME_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                            <input type="text" name="customer_name" id="customer_name" class="textbox  validate[required] text-input" value="<?php echo $result['customer_name'];?>" />
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
            </div>
			 <div class="clear"></div> 
            <div class="field-area">
                <div><label>##_CUSTOMER_ADD_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                        <textarea style="width:250px; height:110px;"  name="cust_address" id="cust_address"><?php echo $result['cust_address'];?></textarea>
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
            </div>  
            <div class="clear"></div>
            <div class="field-area">
                <div><label>##_ADMIN_EMAIL_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['cust_email'];?>" class="textbox validate[required,custom[email]] text-input" name="cust_email" id="cust_email"  />
                    <span id="emailerror" ></span>
                </div>
            </div> 
            <div class="field-area">
                <div><label>##_CUSTOMER_NO_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['contact_no'];?>" class="textbox validate[required,custom[phone]] text-input" name="contact_no" id="contact_no" />
                </div>
            </div>      
            <div class="field-area">
                <div><label>##_CUST_RATE_##<span class="star">*</span></label></div>
                <div>
                 <select name="rating" id="rating" class="select-box2" style="width:250px;">
               			<option <?php if(isset($result['credit']) && $result['credit'] == "1") { ?> selected="selected" <?php  } ?> value="1" >Rating 1</option>
                        <option <?php if(isset($result['credit']) && $result['credit'] == "2") { ?> selected="selected" <?php  } ?> value="2" >Rating 2</option>
                        <option <?php if(isset($result['credit']) && $result['credit'] == "3") { ?> selected="selected" <?php  } ?> value="3" >Rating 3</option>
                </select>
                
                </div>
            </div>
            <div class="field-area">
                <div><label>##_TOTAL_PURCHASE_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['total_purchase'];?>" class="textbox validate[required,custom[number]] text-input" name="total_purchase" id="total_purchase" />
                </div>
            </div>
            <div class="field-area">
                <div><label>##_CREDIT_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['credit'];?>" class="textbox validate[required,custom[number]] text-input" name="credit" id="credit" />
                </div>
            </div>
            <div class="field-area">
                <div><label>##_DEBIT_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['debit'];?>" class="textbox validate[required,custom[number]] text-input" name="debit" id="debit" />
                </div>
            </div>
            <div class="field-area">
                <div><label>##_ADMIN_STATUS_##<span class="star">*</span></label></div>
                <div>
                    <input type="radio" name="status"  id="status" value="1" <?php if(isset($result['status']) && $result['status']==1){ ?>  checked="checked" <?php }else{ ?>checked="checked" <?php } ?>/>##_ADMIN_ACTICE_##
                    <input type="radio" name="status" <?php if(isset($result['status']) && $result['status']==0){ ?> checked="checked" <?php } ?>  id="status" value="0"/>##_ADMIN_INACTICE_##	
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
	    <input type="hidden" <?php if(isset($result['customer_id'])){ ?> value="<?php echo $result['customer_id']; ?>" <?php } ?> name="customer_id"/>
<?php //echo CHtml::endForm();?>
</form>
</div>