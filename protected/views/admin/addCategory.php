<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.cleditor.min.js"></script>
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

<h1><a href="<?php echo Yii::app()->params->base_path;?>admin/category">##_CATEGORY_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?></h1>        
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/addCategory','post',array('id' => 'functionForm','name' => 'functionForm')) ?>
             <div class="content-box">
            <div class="field-area">
                <div><label>##_CATEGORY_NAME_##<span class="star">*</span></label></div>
                <div>
                    <input  type="text" name="category_name" id="category_name" <?php if(isset($result['category_name'])){ ?> value="<?php echo $result['category_name']; ?>" <?php } ?> class="textbox width validate[required] text-input" />							
                    <span id="fullnameerror"></span>
                </div>
            </div>
               <div class="field-area">
                <div><label>##_CATEGORY_DESC_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                        <textarea  name="cat_description" class="validate[required] text-input" id="cat_description"><?php echo $result['cat_description'];?></textarea>
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
                </div>
                <div class="clear"></div>
            <div class="field-area">
                    <div>
                        <p>
                          <input type="submit" name="FormSubmit" id="FormSubmit" class="btn"  value="##_ADMIN_SUBMIT_##" />
                          <input name="cancel" type="reset" class="btn" value="##_ADMIN_CANCEL_##" onclick="javascript:history.go(-1)" />
                        </p>
</div>
            </div>
            <div class="clear"></div>
        </div>
	    <input type="hidden" <?php if(isset($result['cat_id'])){ ?> value="<?php echo $result['cat_id']; ?>" <?php } ?> name="cat_id"/>
<?php echo CHtml::endForm();?>