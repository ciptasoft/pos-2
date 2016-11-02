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
            <div class="content-box">
            <h2>##_STORE_PUR_REPORT_##</h2>
   		  <table cellpadding="0" cellspacing="0" border="0" class="listing" width="960">
                	<tr>
                        <th width="5%">##_BTN_NO_##</th>
                        <th width="10%">##_STORE_NAME_##</th>
                        <th width="10%">##_SUPPLIER_NAME_##</th>
                        <th width="10%">##_TOTAL_ORDER_##</th>    
                        <th width="20%">##_Ticket_DESC_PAGE_TOTAL_PRODUCT_##</th>
                        <th width="20%">##_Ticket_DESC_PAGE_TOTAL_AMOUNT_##</th>
                       </tr>
                    
                    <?php $j=1; if(count($data) > 0){ $i=0;
						foreach($data as $row){ ?> 
                    <tr>
                        <td class="alignCenter">
                           <?php echo $j; ?>
                        </td>
                        <td style="text-align:left;"><?php echo $row['store_name']; ?></td>
                        <td style="text-align:left;"><?php echo $row['supplier_name']; ?></td>
                        <td style="text-align:right;"><?php echo $row['totalOrder']; ?></td>
                        <td style="text-align:right;"><?php echo $row['totalProduct']; ?></td>
                         <td style="text-align:right;"><?php echo $row['totalAmount']; ?></td>
                   </tr>
                   <?php
                       $i++; $j++; } ?>
                   <tr style=" background-color:#cccccc;">
                   		<td colspan="2">&nbsp;</td>
                        <td class="alignCenter"><b>##_TOTAL_##</b></td>
                        <td style="text-align:right;">
                        <?php foreach ( $data as $row ) { 
							$totalOrder += $row['totalOrder'];?>
						<?php } ?>
						<b><?php echo $totalOrder ; ?></b>
                        </td>
                        <td style="text-align:right;"><?php  foreach ( $data as $row ) { 
							$totalProduct +=  $row['totalProduct']; ?>
						<?php } ?>
                       <b> <?php echo $totalProduct ; ?></b>
                        </td>
                         <td style="text-align:right;"><?php  foreach ( $data as $row ) { 
							$totalAmount +=  $row['totalAmount']; ?>
						<?php } ?>
                       <b> <?php echo $totalAmount ; ?></b>
                        </td>
                   </tr>
					<?php 
                    } else { ?>
                    <tr>
                        <td colspan="7" class="lastcolumn alignLeft">
                            ##_TICKET_LIST_NOT_FOUND_##
                        </td>
                    </tr>
                         <?php } ?>
                    </table>
            </div>
            <div>
                
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
         