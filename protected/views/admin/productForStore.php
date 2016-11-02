<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['currentSortType'].'&sortBy='.$ext['sortBy'].'&startdate='.$ext['startdate'].'&enddate='.$ext['enddate'];
?>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url;?>css/custom-theme/jquery-ui-1.8.13.custom.css" />
<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path;?>";
var $j = jQuery.noConflict();
$j(document).ready(function(){
	$j('.delete_this').click(function(){
		var id	=	$j(this).attr('lang');
		var store_id = <?php echo $store_id; ?> ;
		if(confirm("Do you want to delete this record")){
			window.location=base_path+"admin/deleteProductFromStore/id/"+id+"/store_id/"+store_id;
		}
	});
	
	$j(function() {
		var dates = $j( "#startdate, #enddate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $j( this ).data( "datepicker" ),
					date = $j.datepicker.parseDate(
						instance.settings.dateFormat ||
						$j.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
});
function checkAll(){
	for (var i=0;i<document.forms[2].elements.length;i++)
	{
		var e=document.forms[2].elements[i];
		if ((e.name != 'checkboxAll') && (e.type=='checkbox'))
		{
			e.checked=document.forms[2].checkboxAll.checked;
		}
	}
}

function dSelectCheckAll()
{
	document.getElementById('checkboxAll').checked="";
}

function validateForm(){
	var checked	=	$j("input[name=checkbox[]]:checked").map(
    function () {return this.value;}).get().join(",");
	
	if(!checked){
		alert('Please select at least one record.');
		return false;
	}
	
	if(confirm("Do you want to delete this record")){
		return true;
	}
	return false;
}

function validateAll()
{
	var flag=0;
	
	return true;
	
}
function popitup(url) {
	newwindow=window.open(url,'name','height=400,width=780,scrollbars=yes,screenX=250,screenY=200,top=150');
	if (window.focus) {newwindow.focus()}
	return false;
}

function addTextField(id)
{
	//alert(id);
	$j("#qnt"+id).html('<input type="textbox" id="shrinkQnt'+id+'" style="width:70%; height:27px;" /><span id="img'+id+'" ><img onclick="submitShrinkQnt('+id+')" style="float:left; cursor:pointer; margin-left:-5px; margin-top:5px;" src="<?php echo Yii::app()->params->base_url;?>images/success-icon.png" alt="Save" border="0"/></span>');
	return true;
		
}

function submitShrinkQnt(id)
{
	$j('#img'+id).html('<img style="float:left; cursor:pointer; margin-left:0px; margin-top:5px;" src="<?php echo Yii::app()->params->base_url;?>images/spinner-mini.gif" border="0"/>');
	realQnt = $j("#shrinkQnt"+id).val();
	systemQnt = $j("#quantityForStore"+id).text();
	store_id = $j("#store_id").val();
	product_id = id ;
	
	var numberRegex = /^[+-]?\d+(\d+)?([eE][+-]?\d+)?$/;
	var str = $j("#shrinkQnt"+id).val();
	if(!numberRegex.test(str)) {
	   alert('Please enter numeric value.');
	   $j("#qnt"+id).html('<img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField('+id+')" style="cursor:pointer;" />');	
	   return false;
	  
	}
	if(realQnt=='' || realQnt=='undefined')
	{
		$j("#qnt"+id).html('<img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField('+id+')" style="cursor:pointer;" />');	
		return false;
	}
	
	$j.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/shrinkStockQuantity',
	  data: 'realQnt='+realQnt+'&systemQnt='+systemQnt+'&store_id='+store_id+'&product_id='+product_id,
	  cache: false,
	  success: function(data)
	  {
		$j("#qnt"+id).html('<img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField('+id+')" style="cursor:pointer;" />');
		$j("#quantityForStore"+id).text(realQnt);
		return true;	
	  }
	 });
}
</script>
<div align="center">
	<?php if(Yii::app()->user->hasFlash('success')): ?>                                
        <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
</div>
<div class="clear"></div>
<div id="content">
	<div>
		<h1>##_PRODUCT_LIST_FOR_## <b><?php echo $store_name; ?></b></h1>
        
		
        <table width="100%" border="0" class="search-table" cellpadding="2" cellspacing="2">
                	<tr>
                        <td align="right" colspan="8">
                        	<a href="<?php echo Yii::app()->params->base_path;?>admin/addProduct" class="btn">##_ADD_PRODUCT_##</a> 
                			
                		</td>
                    </tr>
                    <?php
          echo CHtml::beginForm(Yii::app()->params->base_path.'admin/prouductForStore/store_id/'.$store_id.'/store_name/'.$store_name.'' ,'post',array('id' => 'searchForm','name' => 'searchForm')) ?>
                    <tr><td colspan="8" class="height10"></td></tr>
                    <tr>
                        <td width="8%" align="left">##_ADMIN_SEARCH_## :</td>
                        <td width="20%" align="left">
                        	<input name="keyword" id="keyword" class="textbox2" type="text" value="<?php echo $ext['keyword'];?>"/>
                        </td>
                   		<td width="14%" align="right">##_ADMIN_START_DATE_## :</td>
                      	<td width="14%">
                        	<input name="startdate" id="startdate" class="textbox2 datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/>
                        </td>
                        <td width="12%" align="right">##_ADMIN_END_DATE_## :</td>
						<td width="14%" align="left">
                        	<input name="enddate" width="20" id="enddate" class="textbox2 datebox" type="text" value="<?php if(isset($ext['enddate'])){echo $ext['enddate'];}?>"/>
                        </td>
                        <td width="9%" align="right">
                        	<input type="submit"  name="Search" value="##_ADMIN_SEARCH_##"  class="btn" />
                        </td>
                        <td width="9%" align="right">
                        	<input type="button"  name="" value="##_ADMIN_SHOWALL_##"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/prouductForStore/store_id/<?php echo $store_id ; ?>/store_name/<?php echo $store_name ; ?>'"  class="btn"  />
                        </td>
                    </tr>
                    <?php echo CHtml::endForm();?>
                </table>
      <?php 
        echo CHtml::beginForm(Yii::app()->params->base_path.'admin/deleteRecord/type/All','post',array('id' => 'deleteRecordForm','name' => 'deleteRecordForm','onsubmit' => 'return validateForm();')) ?>
<div id="product">
        <div class="content-box">
        
            <table cellpadding="0" cellspacing="0" border="0" class="listing" width="960">
                <tr>
                    <th width="20" align="center">##_ADMIN_NO_##</th>
                    <th width="20" align="center"><a href="<?php echo Yii::app()->params->base_path;?>admin/prouductForStore/store_id/<?php echo $store_id ; ?>/store_name/<?php echo $store_name ; ?>/sortType/<?php echo $ext['sortType'];?>/sortBy/product_name" class="sort">##_PRODUCT_NAME_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'product_name'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
                    <th width="20" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/prouductForStore/store_id/<?php echo $store_id ; ?>/store_name/<?php echo $store_name ; ?>/sortType/<?php echo $ext['sortType'];?>/sortBy/product_price' >##_PRODUCT_PRICE_##1<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'product_price'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
                        <th width="20" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/prouductForStore/store_id/<?php echo $store_id ; ?>/store_name/<?php echo $store_name ; ?>/sortType/<?php echo $ext['sortType'];?>/sortBy/product_price2' >##_PRODUCT_PRICE_##2<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'product_price2'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
                        <th width="20" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/prouductForStore/store_id/<?php echo $store_id ; ?>/store_name/<?php echo $store_name ; ?>/sortType/<?php echo $ext['sortType'];?>/sortBy/product_price3' >##_PRODUCT_PRICE_##3<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'product_price3'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
                         <th width="10" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/prouductForStore/store_id/<?php echo $store_id ; ?>/store_name/<?php echo $store_name ; ?>/sortType/<?php echo $ext['sortType'];?>/sortBy/upc_code' >##_PRODUCT_UPC_CODE_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'upc_code'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
                         <th width="20"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/prouductForStore/store_id/<?php echo $store_id ; ?>/store_name/<?php echo $store_name ; ?>/sortType/<?php echo $ext['sortType'];?>/sortBy/quantity' >##_PRODUCT_QUANTITY_##</a>
                        <?php  if($ext['img_name'] != '' && $ext['sortBy'] == 'quantity'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                         </th>
                    <th width="35" style="max-width:80px !important; width:80px !important;" class="alignCenter"><a class="sort" href='#' >##_ACTUAL_QUANTITY_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'created_date'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                        </a></th>
                    
                    <th width="15" align="center">##_ADMIN_EDIT_##</th>
                    <th width="5" align="center">##_ADMIN_DELETE_##</th>
                </tr>
                
                <?php
                $i=1;
                $cnt = $data['pagination']->itemCount;
                if($cnt>0){
                    
                    foreach($data['product']  as $row){ ?>
                        <tr>
                            <td class="alignCenter">
                                <?php 
                                echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
                                ?>
                            </td>
                            <td class="alignCenter"><?php echo $row['product_name'];?></td>
                            <td class="alignCenter"><?php echo $row['product_price'];?></td>
                            <td class="alignCenter"><?php echo $row['product_price2'];?></td>
                            <td class="alignCenter"><?php echo $row['product_price3'];?></td>
                            <td class="alignCenter"><?php echo $row['upc_code'];?></td>
                            <td class="alignCenter" id="quantityForStore<?php echo $row['product_id'];?>">
                                <?php echo $row['quantityForStore'];?>
                            </td>
                            <td class="alignCenter" style="max-width:80px !important; width:80px !important;">
                                <div style="margin:0px !important; padding:0px !important;"  id="qnt<?php echo $row['product_id'];?>">
                                    <img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField(<?php echo $row['product_id'];?>)" title="Add Actual Quantity" style="cursor:pointer;" />
                                </div>
                            </td>
                            <td class="alignCenter" width="15">
                                <a href="<?php echo Yii::app()->params->base_path;?>admin/addProduct/product_id/<?php echo $row['product_id'];?>" title="Edit">
                                    <img src="<?php echo Yii::app()->params->base_url; ?>images/edit_pencil.png" />
                                </a>
                            </td>
                             
                            <td class="alignCenter" width="15">
                                <a class="delete_this" href="javascript:;"  lang="<?php echo $row['product_id'];?>" title="Delete Seeker">
                                    <img src="<?php echo Yii::app()->params->base_url;?>images/false.png" alt="Delete" border="0"/>
                                </a>
                            </td>
                            
                        </tr>
                        <?php
                        $i++;
                    }
                }else{?>
                <tr>
                    <td colspan="10">##_ADMIN_NO_RECORD_FOUND_##</td>
                </tr>
                <?php
                }?>
                <input type="hidden" name="total_acc" id="total_acc" value="<?php echo $i;?>" />
                <input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id;?>" />
            </table>
        </div>
        <div>
            <div class="floatLeft">
                <?php
                if($cnt == '1'){?>
                    &nbsp;
                <?php 
                }else{?>
                    <?php /*?><span>
                     <input type="submit" name="delete_record" id="delete_record" value="##_ADMIN_DELETE_##" class="btn"/>
                    </span><?php */?>
                <?php
                }?>
            </div>
            <div>
                 <?php
                 if($cnt > 0 && $data['pagination']->getItemCount()  > $data['pagination']->getLimit()){?>
                     <div class="pagination">
                     <?php 
                     $extraPaginationPara='&keyword='.$ext['keyword'].'&sortBy='.$ext['sortBy'].'&startdate='.$ext['startdate'].'&enddate='.$ext['enddate'];
                     $this->widget('application.extensions.WebPager',
                                     array('cssFile'=>Yii::app()->params->base_url.'css/style.css',
                                             'extraPara'=>$extraPaginationPara,
                                            'pages' => $data['pagination'],
                                            'id'=>'link_pager',
                    ));
                 ?>	
                 </div>
                 <?php  
                 }?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
  	<?php echo CHtml::endForm();?>
</div>
</div>
