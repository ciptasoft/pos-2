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
			window.location=base_path+"admin/deleteCustomer/id/"+id;
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
		<h1>##_CUSTOMER_LIST_##</h1>
        
		
        <table width="100%" border="0" class="search-table" cellpadding="2" cellspacing="2">
                	<tr>
                        <td align="right" colspan="8">
                        	<a href="<?php echo Yii::app()->params->base_path;?>admin/addCustomer" class="btn">##_ADD_CUSTOMER_##</a> 
                		</td>
                    </tr>
                    <?php
                    echo CHtml::beginForm(Yii::app()->params->base_path.'admin/customers/','post',array('id' => 'searchForm','name' => 'searchForm')) ?>
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
                        	<input type="button"  name="" value="##_ADMIN_SHOWALL_##"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/customers'"  class="btn"  />
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
                    	<?php /*?><th width="20">
                        	<input name="checkboxAll" type="checkbox" id="checkboxAll" value="1" onclick="checkAll();">
                        </th><?php */?>
                        <th width="20" align="center">##_ADMIN_NO_##</th>
                        <th width="20" align="center"><a href="<?php echo Yii::app()->params->base_path;?>admin/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/customer_name" class="sort">##_CUSTOMER_NAME_##
						<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'customer_name'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="20" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/cust_email' >##_ADMIN_EMAIL_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'cust_email'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                             <th width="10" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/credit' >##_CREDIT_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'credit'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                             <th width="20"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/debit' >##_DEBIT_##</a>
                            <?php  if($ext['img_name'] != '' && $ext['sortBy'] == 'debit'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                             </th>
                         <th width="35" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/rating' >##_CUST_RATE_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'rating'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                            <th width="35" align="center"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/total_purchase' >##_TOTAL_PURCHASE_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'total_purchase'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="35" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/createdAt' >##_ADMIN_CREATE_DATE_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'createdAt'){ ?>
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
						
						foreach($data['customers']  as $row){ ?>
                            <tr>
                               <?php /*?> <td class="alignCenter">
                                    <input name="checkbox[]" type="checkbox" onclick="dSelectCheckAll()" id="checkbox<?php echo $row['product_id'];?>" value="<?php echo $row['id'];?>">
                                </td><?php */?>
                                <td class="alignCenter">
                                    <?php 
                                    echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
                                    ?>
                                </td>
                                <td style="text-align:left;"><?php echo $row['customer_name'];?></td>
                                <td style="text-align:left;"><?php echo $row['cust_email'];?></td>
                             <td style="text-align:right;"><?php echo $row['credit'] ;?></td>
                                <td style="text-align:right;"><?php echo $row['debit'];?></td>
                                <td class="alignCenter">
                                <?php if ($row['rating'] == 1 ) { ?>
                                <img src="<?php echo Yii::app()->params->base_url; ?>images/star1.png" />
								<?php } else if ($row['rating'] == 2 ) { ?>
                                 <img src="<?php echo Yii::app()->params->base_url; ?>images/star2.png" />
								<?php } else {  ?>
                                <img src="<?php echo Yii::app()->params->base_url; ?>images/star3.png" />
                                <?php } ?>
                                </td>
                                <td style="text-align:right;"><?php echo $row['total_purchase'];?></td>
                                <td class="alignCenter"><?php if(isset($row['createdAt']) && $row['createdAt'] != ""  && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y", strtotime($row['createdAt']));} else  { echo "-NULL-"; }?></td>
                                
                               
                                <td class="alignCenter" width="15">
                                    <a href="<?php echo Yii::app()->params->base_path;?>admin/addCustomer/customer_id/<?php echo $row['customer_id'];?>" title="Edit"><img src="<?php echo Yii::app()->params->base_url; ?>images/edit_pencil.png" /> </a>
                                </td>
                                 
                                <td class="alignCenter" width="15">
                                    <a class="delete_this" href="javascript:;"  lang="<?php echo $row['customer_id'];?>" title="Delete Seeker">
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
