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
		if(confirm("##_ADMIN_DELET_CONFIRM_##")){
			window.location=base_path+"admin/deleteProduct/id/"+id;
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

function getReports(value)
{
	var id = value; 
	if ( id == 1)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/getStoresPurchaseReport';
	}
	else if( id == 2)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/getProductPurchaseReport';
	} 
	else if( id == 0)
	{
		window.location.href='<?php echo Yii::app()->params->base_path;?>admin/purchaseReport';
		return true;
	}
	else
	{
		return false;	
	}
	$j.ajax({			
	type: 'POST',
	url:  urlData ,
	data:'',
	cache: true,
	success: function(data)
	{
		$j(".content-box").html(data);
		$j("#searchDate").css('display','none');
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
		<h1>##_ADMIN_PURCHASE_REPORT_##</h1>
        <div id="searchDate" style="display:block;">
        	<table width="100%" style="min-width:920px;" border="0" class="search-table" cellpadding="2" cellspacing="2">
                	<?php
                    echo CHtml::beginForm(Yii::app()->params->base_path.'admin/purchaseReport/','post',array('id' => 'searchForm','name' => 'searchForm')) ?>
                    <tr><td colspan="8" class="height10"></td></tr>
                    <tr>
                        <td width="8%" align="left">##_ADMIN_SEARCH_##:</td>
                        <td width="20%" align="left">
                        	<input name="keyword" id="keyword" class="textbox2" type="text" value="<?php echo $ext['keyword'];?>"/>
                        </td>
                   		<td width="14%" align="right">##_ADMIN_START_DATE_##:</td>
                      	<td width="14%">
                        	<input name="startdate" id="startdate" class="textbox2 datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/>
                        </td>
                        <td width="12%" align="right">##_ADMIN_END_DATE_##:</td>
						<td width="14%" align="left">
                        	<input name="enddate" width="20" id="enddate" class="textbox2 datebox" type="text" value="<?php if(isset($ext['enddate'])){echo $ext['enddate'];}?>"/>
                        </td>
                        <td width="9%" align="right">
                        	<input type="submit"  name="Search" value="##_ADMIN_SEARCH_##"  class="btn" />
                        </td>
                        <td width="9%" align="right">
                        	<input type="button"  name="" value="##_ADMIN_SHOWALL_##"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/purchaseReport'"  class="btn"  />
                        </td>
                    </tr>
                    <?php echo CHtml::endForm();?>
                </table>
        </div>
		<table width="100%" border="0" class="search-table" cellpadding="2" cellspacing="2">
                	<tr>
                        <td colspan="8">
                            <select name="list" style="width:170px;" onchange="getReports(this.value);">
                            <option value="0">##_HOME_ALL_##</option>
                            <option value="1">##_STORE_WISE_##</option>
                            <option value="2">##_PRODUCT_WISE_##</option>
							</select> 
                		</td>
                   </tr>     
                   <tr><td colspan="8" class="height10"></td></tr>
      </table>
        
      <?php 
        echo CHtml::beginForm(Yii::app()->params->base_path.'admin/deleteRecord/type/All','post',array('id' => 'deleteRecordForm','name' => 'deleteRecordForm','onsubmit' => 'return validateForm();')) ?>
    <div id="product">
            <div class="content-box">
   		  <table cellpadding="0" cellspacing="0" border="0" class="listing" width="960">
                	<tr>
                        <th width="2%">##_BTN_NO_##</th>
                        <th width="16%"><a href="<?php echo Yii::app()->params->base_path;?>admin/purchaseReport/sortType/<?php echo $ext['sortType'];?>/sortBy/store_name" class="sort"> ##_STORE_NAME_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'store_name'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                          </a></th>    
                        <th width="21%"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/purchaseReport/sortType/<?php echo $ext['sortType'];?>/sortBy/supplier_name' >##_SUPPLIER_NAME_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'supplier_name'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="13%"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/purchaseReport/sortType/<?php echo $ext['sortType'];?>/sortBy/purchase_order_id' >##_ORDER_ID_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'purchase_order_id'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="15%" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/purchaseReport/sortType/<?php echo $ext['sortType'];?>/sortBy/total_product' >##_Ticket_DESC_PAGE_TOTAL_PRODUCT_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'total_product'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                            <th width="15%" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/purchaseReport/sortType/<?php echo $ext['sortType'];?>/sortBy/total_amount' >##_Ticket_DESC_PAGE_TOTAL_AMOUNT_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'total_amount'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="33%" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/purchaseReport/sortType/<?php echo $ext['sortType'];?>/sortBy/created' >##_TICKET_LIST_CREATED_DATE_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'created'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                  </tr>
                    <?php 
					$j=1; if(count($data['pagination']) > 0){ $i=0;
						foreach($data['purchase'] as $row){ ?> 
                    <tr>
                        <td class="alignCenter">
                           <?php echo $j; ?>
                        </td>
                        <td style="text-align:left;"><?php echo $row['store_name']; ?></td>
                        <td style="text-align:left;"><?php echo $row['supplier_name']; ?></td>
                        <td style="text-align:right;"><?php echo $row['purchase_order_id']; ?></td>
                        <td style="text-align:right;"><?php echo $row['total_product'];?></td>
                        <td style="text-align:right;"><?php echo $row['total_amount'];?></td>
                        <td  class="alignCenter"><?php if(isset($row['created']) && $row['created'] != ""  && $row['created'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y", strtotime($row['created']));} else  { echo "-NULL-"; }?></td>
                   </tr>
					<?php
                       $i++; $j++; }
                    } else { ?>
                    <tr>
                        <td colspan="6" class="lastcolumn alignLeft">
                            ##_PURCHASE_LIST_NOT_FOUND_##
                        </td>
                    </tr>
                         <?php } ?>
                    </table>
                    <div>
                
                <div>
                	 <?php 
					 if($data['pagination']->getItemCount()  > $data['pagination']->getLimit()){?>
                    	
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
            </div>
            
            <div class="clear"></div>
      </div>
  	<?php echo CHtml::endForm();?>
</div>
</div>
