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
		var dates = $j( "#searchInDate" ).datepicker({
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
	}
	});	
}
function getSalesPersonByDate()
{
	var date = $j("#searchInDate").val();
	
	$j.ajax({			
	type: 'POST',
	url:  '<?php echo Yii::app()->params->base_path;?>admin/getDailySalesPersonReport',
	data:'date='+date,
	cache: true,
	success: function(data)
	{
		$j(".content-box").html(data);
	}
	});	
}
</script>
            <div class="content-box">
            
            <div id="searchByDate">
                      <table class="search-table" >
                       <tr>
                       <td width="18%" align="left">Search ByDate :</td>
                       <td width="15%" align="left" >
                        	<input name="searchInDate" id="searchInDate" class="textbox2 datebox" type="text" value="<?php if(isset($date) && $date != date('Y-m-d')){echo $date ;} ?>"/>
                       </td> 
                       <td colspan="6" align="left">
                       <input type="button" onclick="getSalesPersonByDate();" value="##_ADMIN_SEARCH_##"  class="btn" style="margin-left:40px;" />
                       </td>
                       </tr>
                       </table>
                      
                       </div>
                       
                       <h2><?php if(isset($date) && $date != date('Y-m-d')){echo $date ;} else { echo "Today's" ; }?>  Sales Person's Report</h2>
   		  <table cellpadding="0" cellspacing="0" border="0" class="listing" width="960">
                	<tr>
                        <th width="5%">No</th>
                        <th width="10%">Casher Id</th>
                        <th width="10%">##_STORE_##</th>
                        <th width="10%">Sales Person</th>
                        <th width="10%">Total Product(sales)</th>    
                        <th width="20%">Total Amount</th>
                       </tr>
                    
                    <?php $j=1; if(count($data) > 0){ $i=0;
						foreach($data as $row){ ?> 
                    <tr>
                        <td class="alignCenter">
                           <?php echo $j; ?>
                        </td>
                        <td style="text-align:right;"><?php echo $row['userId']; ?></td>
                        <td style="text-align:left;"><?php echo $row['store_name']; ?></td>
                        <td style="text-align:left;"><?php echo $row['casher']; ?></td>
                        <td style="text-align:right;"><?php echo $row['Product']; ?></td>
                        <td style="text-align:right;"><?php echo $row['Amount']; ?></td>
                   </tr>
                   <?php
                       $i++; $j++; } ?>
                   <tr style=" background-color:#cccccc;">
                   		<td colspan="3">&nbsp;</td>
                        <td class="alignCenter"><b>TOTAL</b></td>
                        <td style="text-align:right;">
                        <?php foreach ( $data as $row ) { 
							$totalQuantity += $row['Product'];?>
						<?php } ?>
						<b><?php echo $totalQuantity ; ?></b>
                        </td>
                        <td style="text-align:right;"><?php  foreach ( $data as $row ) { 
							$totalAmount +=  $row['Amount']; ?>
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
         