<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
var $ = jQuery.noConflict();

	$(document).ready(function(){
	   // binds form submission and fields to the validation engine
	   $("#functionForm").validationEngine();
	  });
	  
</script>
<script type="text/javascript">
	
	function getSearch()
	{
		var keyword = $j("#product_name").val();
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>admin/searchProduct',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
			{
				$j("#browseProduct").html(data);
				$j("#product_name").val(keyword);
				$j('#product_name').focus().val(keyword);
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
		});
	}
	
	function getProductDetail(product_id)
	{
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>admin/getProduct',
	
			data: 'product_id='+product_id,
	
			cache: false,
	
			success: function(data)
			{
				$j("#MainDiv").html(data);
			}
		});
	}
	 
</script>
<div id="MainDiv" class="MainDiv">
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>   

<h1>
	<a href="<?php echo Yii::app()->params->base_path;?>admin/product">##_PRODUCT_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?>
</h1>
    
	
<form name="functionForm" id="functionForm" action="<?php echo Yii::app()->params->base_path; ?>admin/addProduct" method="post" enctype="multipart/form-data">

        <div class="content-box func-para">
            
            <div class="field-area">
                <div><label>##_PRODUCT_NAME_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                            <input type="text" name="product_name" id="product_name" class="textbox validate[required] text-input" value="<?php echo $result['product_name'];?>"  onkeyup="getSearch();" autocomplete="off"/>
                            <div id="browseProduct" class="browseProduct"></div>
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
                <div>
                    
                <div class="clear"></div>
            </div>  
			<div class="field-area">
                <div><label>##_PRODUCT_IMAGE_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                       <?php if(isset($result['product_image']) && $result['product_image'] != "" ) { ?>
                        <img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $result['product_image']; ?>" width="200px" height="200px;" style="margin-right:30px;"/>
                          <?php } ?>
                            <input type="file" name="product_image" class="validate[required] text-input" id="file" /> 
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
                <div>
                    
                <div class="clear"></div>
            </div>  
            
            <div class="field-area">
                <div><label>##_PRODUCT_DESC_##<span class="star">*</span></label></div> 
                <div>
                    <div class="name">
                        <div>
                        <textarea style="width:250px; height:110px;" class="validate[required] text-input"  name="product_desc" id="product_desc"><?php echo $result['product_desc'];?></textarea>
                        </div>
                        <div class="info"><div class="nameerror"><span id="firstnameerror"></span></div></div>
                    </div>
                </div>
                <div>
                    
                <div class="clear"></div>
            </div>  
          
            
            <div class="field-area">
                <div><label>##_PRODUCT_PRICE_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['product_price'];?>" class="textbox validate[required,custom[number]] text-input" name="product_price" id="product_price"  />
                    <span id="emailerror" ></span>
                </div>
            </div>
            <div class="field-area">
                <div><label>##_PRODUCT_PRICE_##2<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['product_price2'];?>" class="textbox validate[required,custom[number]] text-input" name="product_price2" id="product_price2"  />
                    <span id="emailerror" ></span>
                </div>
            </div>
            <div class="field-area">
                <div><label>##_PRODUCT_PRICE_##3<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['product_price3'];?>" class="textbox validate[required,custom[number]] text-input" name="product_price3" id="product_price3"  />
                    <span id="emailerror" ></span>
                </div>
            </div>        
            <div class="field-area">
                <div><label>##_PRODUCT_UPC_CODE_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['upc_code'];?>" class="textbox validate[required,custom[number]] text-input" name="upc_code" id="upc_code" />
                </div>
            </div>      
            <div class="field-area">
                <div><label>##_PRODUCT_QUANTITY_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['quantity'];?>" class="textbox validate[required,custom[number]] text-input" name="quantity" id="quantity" />
                </div>
            </div>
            <div class="field-area">
                <div><label>##_ADMIN_DISCOUNT_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['product_discount'];?>" class="textbox validate[required,custom[number]] text-input" name="product_discount" id="product_discount" />
                </div>
            </div>
            <div class="field-area">
                <div><label>##_ADMIN_EXPIRY_DATE_##<span class="star">*</span></label></div>
                <div>
                    <input type="text" value="<?php echo $result['expiry_date'];?>" class="textbox2 datebox validate[required] text-input" name="expiry_date" id="expiry_date" />
                </div>
            </div>
            <div class="field-area">
                <div><label>##_CATEGORY_NAME_##<span class="star">*</span></label></div>
                <div>
                    <select name="cat_id" id="cat_id" class="validate[required]" style="width:250px;">
                               <option value="" selected>##_SELECT_CATEGORY_NAME_##</option>
                <?php foreach($categoryList as $row){ ?>
               <option value="<?php echo  $row['cat_id'] ; ?>" <?php if(isset($result['category_name']) && $result['category_name']==$row['category_name']){ ?> selected <?php } ?> ><?php echo $row['category_name'];?>
               </option>
               <?php } ?>
                </select>
                </div>
            </div>
            <div class="field-area">
                <div><label>##_STORE_NAME_##<span class="star">*</span></label></div>
                <div>
                    <select name="store_id" id="store_id" class="validate[required]" style="width:250px;">
                               <option value="" selected>##_SELECT_YOUR_STORE_##</option>
                <?php foreach($storeList as $row){ ?>
               <option value="<?php echo  $row['store_id'] ; ?>" <?php if(isset($result['store_name']) && $result['store_name']==$row['store_name']){ ?> selected <?php } ?> ><?php echo $row['store_name'];?>
               </option>
               <?php } ?>
                </select>
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
                    <input type="hidden" value="<?php echo $result['store_id'];?>" class="textbox" name="Oldstore_id" id="Oldstore_id" />
                        <input type="submit" name="FormSubmit" id="FormSubmit" class="btn"  value="##_ADMIN_SUBMIT_##" />
                        <input name="cancel" type="reset" class="btn" value="##_ADMIN_CANCEL_##" onclick="javascript:history.go(-1)" />
                    </div>
                    
				</div>
            </div>
            <div class="clear"></div>
        </div>
	    <input type="hidden" <?php if(isset($result['product_id'])){ ?> value="<?php echo $result['product_id']; ?>" <?php } ?> name="product_id"/>
<?php //echo CHtml::endForm();?>
</form>
</div>