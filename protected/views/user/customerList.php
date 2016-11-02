<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript">
$j(document).ready(function() {
	
	$j(".viewMore").fancybox({
		'width' : 500,
 		'height' : 450,
		'autoScale'		: true,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});
	
	$j(".addCust").fancybox({
		'width' : 'auto',
 		'height' : 'auto',
		'padding'		 : 0,
		'autoScale'		: true,
 		'transitionIn' : 'none',
		'transitionOut' : 'none'
	
		
		
	/*	'width' : 500,
 		'height' : 450,
		'autoScale'		: true,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'*/
	
		/*'padding'		 : 0,
		'autoScale'		: false,
		'width' : 'auto',
 		'height' :200,
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',*/
		
 	});
	
	
	
	  $j('.sort').click(function() {
                var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','secondcont');
	  });
				
				
	$j('.various4').click(function() {
		
		var id	=	$j(this).attr('lang');
		
		jConfirm('Are you sure want delete this TODO list ?', 'Confirmation dialog', function(res){
			if( res == true ) {
				$j('#mainContainer')
					.load('<?php echo Yii::app()->params->base_path;?>user/removeList/id/'+id, function() {
						$j("#update-message").removeClass().addClass('msg_success');
						$j("#update-message").html('List deleted successfully');
						$j("#update-message").fadeIn();
						$j('#listAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/listAjax');
						$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/myLists');
						setTimeout(function() {
							$j('#update-message').fadeOut();
						}, 10000 );
					});
			}
		});
		
	});
	
	
	
});
	
function getSearch()
{
	var keyword = $j("#keyword").val();
	var searchFrom = $j("#searchFrom").val();
	var searchTo = $j("#searchTo").val();
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/customers',
		data: 'keyword='+keyword+'&searchFrom='+searchFrom+'&searchTo='+searchTo+"&",
		cache: false,
		success: function(data)
		{
			$j("#secondcont").html(data);
			$j("#keyword").val(keyword);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}


</script>
<div class="mainContainer">
<div class="content" id="mainContainer" style="margin-left:0px; margin-right:0px;">
<div class="RightSide" style="margin:0 !important;">
	<div class="clear"></div>
          <div class="heading" style="margin-top:5px;"><?php echo Yii::app()->session['fullname']; ?> 's workspace				     </div>
	<span id="loading"></span>
    <div class="productboxgreen">
    <h1 style="color:#333333;">##_CUSTOMER_LIST_PAGE_CUSTOMER_LIST_##</h1><a href="<?php echo Yii::app()->params->base_path;?>user/addCustomerView/" lang="<?php echo $row['customer_id'];?>" id="viewMore_<?php echo $row['customer_id'];?>" class="noMartb addCust floatRight" style="margin-top: -35px !important;margin-right: 20px;font-size: 18px;"  title="##_MY_LISTS_VIEW_##">Add Customer</a>
    <div class="clear"></div>
    <b style="padding-left: 25px;">##_EXPORT_PDF_##</b>&nbsp;
    <input type="button" class="btn" value="Total Payable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/pdfReportForCustomerPayableReport'" />
      <input type="button" class="btn" value="Total Receivable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/pdfReportForCustomerReceivableReport'" /><br/><br/>
      <b>##_EXPORT_EXCEL_##</b>
    <input type="button" class="btn" value="Total Payable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/getTotalPayableReportForCustomer'" />
      <input type="button" class="btn" value="Total Receivable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/getTotalReceivableReportForCustomer'" />
   <div class="searchArea innerSearch" style="padding-right:0%; width:890px;">
        <form id="jobSearch" name="jobSearch" action="#" method="post" onsubmit="return false;">        
        	<label style="float:left;margin-right:5px;margin-top:5px;font-size:12px; padding-left: 70px;"><b>##_GENERAL_AMOUNT_##</b></label>
        	<label class="label floatLeft" style="font-size:12px; ">##_CUSTOMER_LIST_PAGE_FROM_##</label>
    		<select id="searchFrom" style="width:120px;float:left;" name="searchFrom">           	
            	<option value="">##_CUSTOMER_LIST_PAGE_SELECT_##</option>           	            	
            	<option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "100") { ?> selected="selected" <?php  } ?> value="100">100</option>           	
            	<option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "5000") { ?> selected="selected" <?php  } ?>  value="5000">5000</option>
                <option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "10000") { ?> selected="selected" <?php  } ?>  value="1000">10000</option>
            </select>
        	<label class="label floatLeft" style="font-size:12px;">##_CUSTOMER_LIST_PAGE_TO_##</label>
    		<select id="searchTo" style="width:110px;float:left;" name="searchTo">            	
            	<option value="">##_CUSTOMER_LIST_PAGE_SELECT_##</option>           	
            	<option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "5000") { ?> selected="selected" <?php  } ?> value="5000">5000</option>
                <option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "10000") { ?> selected="selected" <?php  } ?> value="10000">10000</option>
                <option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "15000") { ?> selected="selected" <?php  } ?> value="15000">15000</option>
            </select>
             
            <label class="label floatLeft" style="font-size:12px;  padding: 0 5px !important;
}">##_CUSTOMER_LIST_PAGE_CUSTOMERS_##</label>
            <input type="text" class="textbox floatLeft" name="keyword"  onkeypress="if(event.keyCode==13){getSearch();}" id="keyword" value="<?php if(isset($ext['keyword']) && $ext['keyword'] != "" ) { echo $ext['keyword'] ; } ?>" autocomplete="off" style="width:200px !important; " />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="getSearch();" />
        </form>
        <div class="clear"></div>
    </div>
	
    <table cellpadding="0" cellspacing="0" border="0" id="list" class="productdata" style="background-color:#FFF;" width="100%">
    	<tr style="font-size:12px; font-stretch:normal;">
    		<th width="25%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;"> 
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/customer_name' >
                ##_CUSTOMER_LIST_PAGE_CUSTOMER_NAME_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'customer_name'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="15%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/rating' >
                ##_CUST_RATE_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'rating'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <?php /*?><th width="10%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/debit' >
                ##_DEBIT_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'debit'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="15%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customers/sortType/<?php echo $ext['sortType'];?>/sortBy/credit' >
                ##_CREDIT_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'credit'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th><?php */?>
            <th width="21%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	##_AMOUNT_PENDING_##
			</th>
           <th width="20%" class="lastcolumn" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">Action</th>
		</tr>
        <?php  
		if(count($data) > 0){ $i=0;
			foreach($data as $row){ ?> 
            <tr style="font-size:14px; font-stretch:normal;">
            	<td class="" align="left">
                <a href="#" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/ticketListForCustomer/customer_id/<?php echo $row['customer_id'] ?>/customer_name/<?php echo $row['customer_name'] ?>','secondcont')" >
                	 <?php echo $row['customer_name']; ?>
                </a>
				</td>
				<td class="" align="center">
                	 <?php if ($row['rating'] == 1 ) { ?>
                                <img src="<?php echo Yii::app()->params->base_url; ?>images/star1.png" />
								<?php } else if ($row['rating'] == 2 ) { ?>
                                 <img src="<?php echo Yii::app()->params->base_url; ?>images/star2.png" />
								<?php } else {  ?>
                                <img src="<?php echo Yii::app()->params->base_url; ?>images/star3.png" />
                                <?php } ?>
                </td>				
                <?php /*?><td class="" align="right">
                	<?php echo $row['debit'];?>
                </td>				
                				
                <td class="" align="right">
                	<?php echo $row['credit'];?>
                </td><?php */?>
                <td class="" align="right">
                	<?php echo $row['credit'] - $row['debit'];?>
                </td>
               <td  class="" align="center">
                	<a href="<?php echo Yii::app()->params->base_path;?>user/customerDescription/id/<?php echo $row['customer_id'];?>" lang="<?php echo $row['customer_id'];?>" id="viewMore_<?php echo $row['customer_id'];?>" class="viewIcon noMartb viewMore" title="##_MY_LISTS_VIEW_##" style="margin-right:30px;">
                    </a>
                   <img src="<?php echo Yii::app()->params->base_url;?>images/account-icon.png" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/generalEntryCustomerList/customer_id/<?php echo $row['customer_id'];?>/customer_name/<?php echo $row['customer_name'];?>','secondcont')" style="cursor:pointer;cursor: pointer;margin-top: -20px;margin-left: 30px; "  title="Account Entries" />
                    <?php /*?> <a style="cursor:pointer;" onclick="inviteFromLists('<?php echo $row['id'];?>');" class="floatLeft" title="##_REM_INVITES_LOGO_##"><img src="<?php echo Yii::app()->params->base_url;?>images/invite.png" /></a><?php */?>
                   <?php /*?> <a href="javascript:;" lang="<?php echo $row['id'];?>" id="remove_<?php echo $row['id'];?>" class="various4 deleteIcon noMartb floatLeft" title="##_MY_LISTS_DELETE_##"><?php */?>
                    
				</td>
			</tr>
			<?php
           $i++; }
		} else { ?>
			<tr>
            	<td colspan="8" class="lastcolumn alignLeft">
                	##_CUSTOMER_LIST_PAGE_NO_FOUND_##
				</td>
			</tr>
		<?php
		}?>
        </table>
         <?php
        if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
      <div class="pagination"  style="margin-right:65px;">
                <?php
				$extraPaginationPara='&keyword='.$ext['keyword'];
                $this->widget('application.extensions.WebPager', 
                                array('cssFile'=>true,
                                        'extraPara'=>$extraPaginationPara,
										 'pages' => $pagination,
                                         'id'=>'link_pager',
                )); ?>
            </div>
			<?php
		} ?>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
	$j(document).ready(function(){
		$j('#link_pager a').each(function(){
			$j(this).click(function(ev){
				ev.preventDefault();
				$j.get(this.href,{ajax:true},function(html){
					$j('#secondcont').html(html);
				});
			});
		});
	});
</script>