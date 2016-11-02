<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['currentSortType'].'&sortBy='.$ext['sortBy'].'&startdate='.$ext['startdate'].'&enddate='.$ext['enddate'];
?>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />
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
		var dates = $j("#startdate, #enddate").datepicker({
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
	
	$j(function() {
		var dates = $j( "#searchReportDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "searchReportDate" ? "minDate" : "maxDate",
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
	if ( id == 2)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/getDailyProductReport';
	}
	else if( id == 7)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/getDailySalesPersonReport';
	} 
	else if( id == 4)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/getDailyCustomerSalesReport';
	}
	else if( id == 5)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/getDailyStoreSalesReport';
	}
	else if( id == 0)
	{
		window.location.href='<?php echo Yii::app()->params->base_path;?>admin/dailySalesReport';
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
		$j('#searchDate').css( "display","none");
	}
	});	
}
$j("#viewMore").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	 
	  
	  });
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
		<h1>##_SHIFT_REPORTS_##</h1>
        <div id="searchDate" style="display:block;">
        	<table width="100%" border="0" class="search-table" cellpadding="2" cellspacing="2">
                	<?php
                    echo CHtml::beginForm(Yii::app()->params->base_path.'admin/shiftlisting/','post',array('id' => 'searchForm','name' => 'searchForm')) ?>
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
                        	<input type="button"  name="" value="##_ADMIN_SHOWALL_##"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/shiftlisting'"  class="btn"  />
                        </td>
                    </tr>
                    <?php echo CHtml::endForm();?>
                </table>
        </div>
		
        
      <?php 
        echo CHtml::beginForm(Yii::app()->params->base_path.'admin/shiftlisting/type/All','post',array('id' => 'deleteRecordForm','name' => 'deleteRecordForm','onsubmit' => 'return validateForm();')) ?>
    <div id="product">
            <div class="content-box">
            
   		  <table cellpadding="0" cellspacing="0" border="0" class="listing" width="960">
                	<tr>
                    	
                        <th width="5%">##_ADMIN_NO_##</th>
                        <th width="10%"><a href="<?php echo Yii::app()->params->base_path;?>admin/shiftlisting/sortType/<?php echo $ext['sortType'];?>/sortBy/firstName" class="sort"> ##_CASHIER_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'firstName'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                          </a></th>
                      <th width="10%"><a href="<?php echo Yii::app()->params->base_path;?>admin/shiftlisting/sortType/<?php echo $ext['sortType'];?>/sortBy/store_name" class="sort"> ##_STORE_NAME_##<?php 
                        if($ext['img_name'] != '' && $ext['sortBy'] == 'store_name'){ ?>
                            <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                            <?php
                        } ?>
                      </a></th>
                        <th width="10%"><a href="#" class="sort"> ##_TOTAL_SALES_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'totalsales'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                          </a></th>    
                        <th width="15%"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/shiftlisting/sortType/<?php echo $ext['sortType'];?>/sortBy/time_in' >##_TIME_IN_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'time_in'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="15%" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/shiftlisting/sortType/<?php echo $ext['sortType'];?>/sortBy/time_out' >##_TIME_OUT_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'time_out'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                      	<th width="20%" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/shiftlisting/sortType/<?php echo $ext['sortType'];?>/sortBy/fileName' >##_FILENAME_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'fileName'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <?php /*?><th width="10%" class="alignCenter">##_TICKET_LIST_ACTION_##</th><?php */?>
                      </tr>
                    
                    <?php $j=1; if(count($data) > 0){ $i=0;
						foreach($data as $row){ ?> 
                    <tr>
                        <td class="alignCenter">
                           <?php echo $j; ?>
                        </td>
                        <td style="text-align:left;"><?php echo $row['firstName']; ?></td>
                        <td style="text-align:left;"><?php echo $row['store_name']; ?></td>
                        <td style="text-align:right;"><?php echo $row['totalsales']; ?></td>
                        <td style="text-align:right;"><?php echo $row['time_in'];?></td>
                        <td style="text-align:right;"><?php echo $row['time_out'];?></td>
                        <td style="text-align:right;"><a href="<?php echo Yii::app()->params->base_url; ?>assets/upload/pdf/<?php echo $row['fileName'];?>.pdf" target="_blank"><?php echo $row['fileName'];?></a></td>
                      
                     </tr>
					<?php
                       $i++; $j++; }
                    } else { ?>
                    <tr>
                        <td colspan="7" class="lastcolumn alignLeft">
                            ##_TICKET_LIST_NOT_FOUND_##
                        </td>
                    </tr>
                         <?php } ?>
                    </table>
                    
	      <div>
                <div>
                	 <?php 
					 if($j > 0 && $pagination->getItemCount()  > $pagination->getLimit()){?>
                    	 <div class="pagination">
                         <?php 
						 $extraPaginationPara='&keyword='.$ext['keyword'].'&sortBy='.$ext['sortBy'].'&startdate='.$ext['startdate'].'&enddate='.$ext['enddate'];
						 $this->widget('application.extensions.WebPager',
										 array('cssFile'=>Yii::app()->params->base_url.'css/style.css',
												 'extraPara'=>$extraPaginationPara,
												'pages' => $pagination,
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
