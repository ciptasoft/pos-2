<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript">
$j(document).ready(function() {
	
	$j(".viewMore").fancybox({
		'width' : 500,
 		'height' : 450,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});
	
	$j(".addCust").fancybox({
		'width' : 500,
 		'height' : 650,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
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
		url: '<?php echo Yii::app()->params->base_path;?>user/suppliers',
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
          <div class="heading" style="margin-top:5px;" ><?php echo Yii::app()->session['fullname']; ?> 's workspace	</div>
	<span id="loading"></span>
    <div class="productboxgreen">
    <h1 style="color:#333333;">##_SUPPLIER_LIST_##</h1>
    <div class="clear"></div>
    <b style="padding-left: 25px;">##_EXPORT_PDF_##</b>&nbsp;
     <input type="button" class="btn" value="Total Payable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/pdfReportForSupplierPayableReport'" />
      <input type="button" class="btn" value="Total Receivable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/pdfReportForSupplierReceivableReport'" /><br/><br/>
       <b>##_EXPORT_EXCEL_##</b>
        <input type="button" class="btn" value="Total Payable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/getTotalPayableReportForSupplier'" />
      <input type="button" class="btn" value="Total Receivable Report" onclick="window.location.href='<?php echo Yii::app()->params->base_path ; ?>user/getTotalReceivableReportForSupplier'" />
   <div class="searchArea innerSearch" style="padding-right:50px;">
        <form id="jobSearch" name="jobSearch" action="#" method="post" onsubmit="return false;">        
        	<label style="float:left;margin-right:5px;margin-top:5px;font-size:12px; padding-left: 70px;"><b>##_GENERAL_AMOUNT_##</b></label>
        	<label class="label floatLeft" style="font-size:12px;">##_CUSTOMER_LIST_PAGE_FROM_##</label>
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
            
            <label class="label floatLeft" style="font-size:12px; padding: 0 5px !important;
}">##_ADMIN_SUPPLIERS_##</label>
            <input type="text" class="textbox floatLeft" name="keyword"  onkeypress="if(event.keyCode==13){getSearch();}" id="keyword" autocomplete="off" style="width: 200px;" />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="getSearch();" />
        </form>
        <div class="clear"></div>
    </div>
	
    <table cellpadding="0" cellspacing="0" border="0" id="list" class="productdata" style="background-color:#FFF;" width="100%">
    	<tr style="font-size:12px; font-stretch:normal;">
    		<th width="22%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;"> 
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/suppliers/sortType/<?php echo $ext['sortType'];?>/sortBy/supplier_name' >
                ##_SUPPLIER_NAME_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'supplier_name'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="20%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/suppliers/sortType/<?php echo $ext['sortType'];?>/sortBy/email' >
                ##_ACTIVATE_EMAIL_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'email'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <?php /*?><th width="10%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/suppliers/sortType/<?php echo $ext['sortType'];?>/sortBy/debit' >
                ##_DEBIT_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'debit'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="15%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/suppliers/sortType/<?php echo $ext['sortType'];?>/sortBy/credit' >
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
           <th width="15%" class="lastcolumn" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">Action</th>
		</tr>
        <?php  
		if(count($data) > 0){ $i=0;
			foreach($data as $row){ ?> 
            <tr style="font-size:14px; font-stretch:normal;">
            	<td class="" align="left">
                <a href="#" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/purchaseOrderListForSupplier/supplier_id/<?php echo $row['supplier_id'] ?>/supplier_name/<?php echo $row['supplier_name'] ?>','secondcont')" >
                	 <?php echo $row['supplier_name']; ?>
                </a>
				</td>
				<td class="" align="right">
                	 <?php echo $row['email']; ?>
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
               <td class="lastcolumn">
                	<a href="<?php echo Yii::app()->params->base_path;?>user/supplierDescription/id/<?php echo $row['supplier_id'];?>" lang="<?php echo $row['supplier_id'];?>" id="viewMore_<?php echo $row['supplier_id'];?>" class="viewIcon noMartb viewMore " title="##_MY_LISTS_VIEW_##">
                    </a>
                   <img src="<?php echo Yii::app()->params->base_url;?>images/account-icon.png" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/generalEntrySupplierList/supplier_id/<?php echo $row['supplier_id'];?>/supplier_name/<?php echo $row['supplier_name'];?>','secondcont')" style="cursor:pointer;cursor: pointer;margin-top: -20px;margin-left: 30px; "  title="Account Entries" />
                    <?php /*?> <a style="cursor:pointer;" onclick="inviteFromLists('<?php echo $row['id'];?>');" class="floatLeft" title="##_REM_INVITES_LOGO_##"><img src="<?php echo Yii::app()->params->base_url;?>images/invite.png" /></a><?php */?>
                   <?php /*?> <a href="javascript:;" lang="<?php echo $row['id'];?>" id="remove_<?php echo $row['id'];?>" class="various4 deleteIcon noMartb floatLeft" title="##_MY_LISTS_DELETE_##"><?php */?>
                    
				</td>
			</tr>
			<?php
           $i++; }
		} else { ?>
			<tr>
            	<td colspan="8" class="lastcolumn alignLeft">
                	##_SUPP_LIST_PAGE_NO_FOUND_##
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