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
	if ( id == 0)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/accountsReport';
	}
	else if( id == 1)
	{
		urlData =  '<?php echo Yii::app()->params->base_path;?>admin/getStoresAccountReport';
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
		<h1>##_ADMIN_ACCOUNTS_REPORT_##</h1>
        
		<table width="100%" border="0" class="search-table" cellpadding="2" cellspacing="2">
                	<tr>
                        <td colspan="8">
                            <select name="list" style="width:170px;" onchange="getReports(this.value);">
                            <option value="0">##_HOME_ALL_##</option>
                            <option value="1">##_STORE_WISE_##</option>
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
                        <th width="16%"><a href="<?php echo Yii::app()->params->base_path;?>admin/accountsReport/sortType/<?php echo $ext['sortType'];?>/sortBy/store_name" class="sort"> ##_STORE_NAME_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'store_name'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                          </a></th>    
                        <th width="21%"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/accountsReport/sortType/<?php echo $ext['sortType'];?>/sortBy/account' >##_ADMIN_ACCOUNTS_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'account'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="13%"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/accountsReport/sortType/<?php echo $ext['sortType'];?>/sortBy/credit' >##_CREDIT_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'credit'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="15%" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/accountsReport/sortType/<?php echo $ext['sortType'];?>/sortBy/debit' >##_DEBIT_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'debit'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                        <th width="33%" class="alignCenter"><a class="sort" href='<?php echo Yii::app()->params->base_path;?>admin/accountsReport/sortType/<?php echo $ext['sortType'];?>/sortBy/created' >##_TICKET_LIST_CREATED_DATE_##<?php 
                            if($ext['img_name'] != '' && $ext['sortBy'] == 'created'){ ?>
                                <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
                                <?php
                            } ?>
                            </a></th>
                  </tr>
                    <?php 
					$j=1; if(count($data['pagination']) > 0){ $i=0;
						foreach($data['lists'] as $row){ ?> 
                    <tr>
                        <td class="alignCenter">
                           <?php echo $j; ?>
                        </td>
                        <td style="text-align:left;"><?php echo $row['store_name']; ?></td>
                        <td style="text-align:left;"><?php echo $row['account']; ?></td>
                        <td style="text-align:right;"><?php echo $row['credit']; ?></td>
                        <td style="text-align:right;"><?php echo $row['debit'];?></td>
                        <td class="alignCenter"><?php if(isset($row['created']) && $row['created'] != ""  && $row['created'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y", strtotime($row['created']));} else  { echo "-NULL-"; }?></td>
                   </tr>
					<?php
                       $i++; $j++; }
                    } else { ?>
                    <tr>
                        <td colspan="6" class="lastcolumn alignLeft">
                            ##_TICKET_LIST_NOT_FOUND_##
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
