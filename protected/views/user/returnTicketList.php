<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$j(document).ready(function() {
	
	$j(".viewMore").fancybox({
		'width' : 500,
 		'height' : 450,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
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
	
	  $j('.sort').click(function() {
                var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','secondcont');
	  });
				
});
	
function getSearch()
{
	var keyword = $j("#keyword").val();
	var searchFrom = $j("#searchFrom").val();
	var searchTo = $j("#searchTo").val();
	var startdate = $j("#startdate").val();
	var enddate = $j("#enddate").val();
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/returnTicketList',
		data: 'keyword='+keyword+'&searchFrom='+searchFrom+'&searchTo='+searchTo+'&startdate='+startdate+'&enddate='+enddate,
		cache: false,
		success: function(data)
		{
			$j("#secondcont").html(data);
			$j("#keyword").val(keyword);
		}
	});
}

function getAllSearch()
{
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/returnTicketList',
		data: '',
		cache: false,
		success: function(data)
		{
			$j("#secondcont").html(data);
		}
	});
}

function getTodayRecord()
{
	if ($j('#todayCheckbox').is(":checked"))
	{
		todayDate = '<?php echo date("d-m-Y"); ?>';
		$j.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>user/returnTicketList',
			data: 'todayDate='+todayDate,
			cache: false,
			success: function(data)
			{
				$j("#secondcont").html(data);
				$j('#todayCheckbox').prop('checked', true);
			}
		});
	}
	else
	{
		$j.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>user/returnTicketList',
			data: '',
			cache: false,
			success: function(data)
			{
				$j("#secondcont").html(data);
			}
		});
	}
}

</script>
<div class="mainContainer">
<div class="secondcont" id="mainContainer" style="margin-left:0px; margin-right:0px;">
<div class="RightSide" style="margin:0 !important;">
	 <div class="clear"></div>
          <div class="heading"><?php echo Yii::app()->session['fullname']; ?> 's ##_HOME_PAGE_WORKSPACE_##				     </div>
    <span id="loading"></span>
    <div class="productboxgreen">
		<h1 style="color:#333333;">##_RETURN_TICKET_PAGE_LIST_##</h1>
        <div class="clear"></div>
   	 <div class="searchArea innerSearch" style="padding-right:50px;">
        <form id="jobSearch" name="jobSearch" action="#" method="post" onsubmit="return false;">        
        	<label style="float:left;margin-right:5px;margin-top:5px;font-size:12px; padding-left: 25px;"><b>##_TICKET_LIST_AMOUNT_##</b></label>  	<label class="label floatLeft" style="font-size:12px;">##_TICKET_LIST_FROM_##</label>
    		<select id="searchFrom" style="width:150px;float:left;" name="searchFrom">           	
            	<option value="">##_TICKET_LIST_SELECT_##</option>           	            	
            	<option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "100"){ ?> selected="selected" <?php } ?> value="100">100</option>           	
            	<option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "5000"){ ?> selected="selected" <?php } ?> value="5000">5000</option>
                <option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "10000"){ ?> selected="selected" <?php } ?> value="10000">10000</option>
            </select>
        	<label class="label floatLeft" style="font-size:12px;">##_TICKET_LIST_TO_##</label>
    		<select id="searchTo" style="width:150px;float:left;" name="searchTo">            	
            	<option value="">##_TICKET_LIST_SELECT_##</option>           	
            	<option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "100"){ ?> selected="selected" <?php } ?> value="100">100</option>           	
            	<option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "5000"){ ?> selected="selected" <?php } ?> value="5000">5000</option>
                <option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "10000"){ ?> selected="selected" <?php } ?> value="10000">10000</option>
            </select>
           <label class="label floatLeft" style="font-size:12px; padding: 0 5px !important;
}">##_TICKET_LIST_SEARCH_##</label>
            <input type="text" class="textbox floatLeft" name="keyword"  onkeypress="if(event.keyCode==13){getSearch();}" id="keyword" autocomplete="off" style="width:150px !important;" />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="getSearch();" />
            
        </form>
        
        <div class="clear"></div>
        
    </div>
   
	<table style="margin-left:74px;" border="0" class="search-table searchArea innerSearch" cellpadding="0" cellspacing="0">
                	
                    <tr>
                        <td align="left">
                        <label class="label floatLeft" style="font-size:12px; padding: 0 5px !important;
}">##_ADMIN_START_DATE_##</label>
</td>
                      	<td>
                        	<input name="startdate" width="10" id="startdate" style="width:142px !important; height:25px;"  class="datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/>
                        </td>
                        <td align="left">
                        <label class="label floatLeft" style="font-size:12px; margin-left:5px; padding: 0 5px !important;
}">##_ADMIN_END_DATE_##</label>
                        </td>
						<td align="left">
                        	<input name="enddate" width="10" id="enddate" style="width:132px !important; height:25px;" class="datebox" type="text" value="<?php if(isset($ext['enddate'])){echo $ext['enddate'];}?>"/>
                        </td>
                        <td align="left">
                        	&nbsp;<input type="button"  name="Search" onclick="getSearch();" value="##_ADMIN_SEARCH_##"  class="btn" />
                        </td>
                        <td align="right">&nbsp;<input type="button"  name="" value="##_ADMIN_SHOWALL_##"  onclick="getAllSearch();"  class="btn"  />
                        </td>
                    </tr>
					
                    <tr>
                      	
                        <td align="left" colspan="6">&nbsp;
                        
                        </td>
                      	
                    </tr>

                    
                    <tr>
                      	
                        <td align="left" colspan="6">
                        <b style="color:#FFF;"> For Today's Ticket :</b> &nbsp;&nbsp;<input type="checkbox" name="todayCheckbox" id="todayCheckbox" value="1" onclick="getTodayRecord()" ></td>
                      	
                    </tr>
                    
                </table>
     
     <table cellpadding="0" cellspacing="0" border="0" class="productdata"  id="list" style="background-color:#FFF;" width="100%">
    	<tr style="font-size:12px; font-stretch:normal;">
    		<th width="15%"  style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;"> 
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/returnTicketList/sortType/<?php echo $ext['sortType'];?>/sortBy/sales_return_invoiceId' >
                ##_TICKET_LIST_INVOICE_ID_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'sales_return_invoiceId'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="27%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/returnTicketList/sortType/<?php echo $ext['sortType'];?>/sortBy/return_casher' >
                ##_TICKET_LIST_CASHIER_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'return_casher'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="16%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/returnTicketList/sortType/<?php echo $ext['sortType'];?>/sortBy/return_total_amount' >
                 ##_TICKET_LIST_AMOUNT_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'return_total_amount'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="19%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/returnTicketList/sortType/<?php echo $ext['sortType'];?>/sortBy/return_createdAt' >
                ##_TICKET_LIST_CREATED_DATE_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'return_createdAt'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
           <?php /*?> <th width="12%" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/returnTicketList/sortType/<?php echo $ext['sortType'];?>/sortBy/status' >
                Status
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'status'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th><?php */?>
            <th width="11%" class="lastcolumn" style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">##_RETURN_TICKET_PAGE_ACTION_##</th>
		</tr>
        <?php  
		if(count($data) > 0){ $i=0;
			foreach($data as $row){ ?> 
            <tr style="font-size:14px; font-stretch:normal;">
            	<td class="" align="right">
                	 <?php echo $row['sales_return_invoiceId']; ?>
				</td>
				<td class="" align="left">
                	<span><?php echo $row['return_casher']; ?></span>
				</td>				
                <td class="" align="right">
                	<?php echo $row['return_total_amount'];?>
                </td>				
                <td class="" align="right">
                	<?php echo date("d-m-Y",strtotime($row['return_createdAt'])) ;?>
                </td>				
                <?php /*?><td class="" align="left">
                	<?php echo $row['status'];?>
                </td><?php */?>
                <td width="11%" class="lastcolumn">
                	<a href="<?php echo Yii::app()->params->base_path;?>user/returnTicketDetail/id/<?php echo $row['sales_return_invoiceId'];?>" lang="<?php echo $row['sales_return_invoiceId'];?>" id="viewMore_<?php echo $row['sales_return_invoiceId'];?>" class="viewIcon noMartb viewMore floatLeft" title="##_MY_LISTS_VIEW_##">
                    </a>
                    <a style="cursor:pointer;" target="_blank" href="<?php echo Yii::app()->params->base_url;?>assets/upload/srinvoice/srinvoice<?php echo $row['sales_return_invoiceId'];?>.pdf" lang="<?php echo $row['sales_return_invoiceId'];?>"><img src="<?php echo Yii::app()->params->base_url;?>images/print.png" /></a>
                 
                  <?php /*?>  <a style="cursor:pointer;" onclick="inviteFromLists('<?php echo $row['product_id'];?>');" class="floatLeft" title="##_REM_INVITES_LOGO_##"><img src="<?php echo Yii::app()->params->base_url;?>images/invite.png" /></a>
                    <a href="javascript:;" lang="<?php echo $row['product_id'];?>" id="remove_<?php echo $row['product_id'];?>" class="various4 deleteIcon noMartb floatLeft" title="##_MY_LISTS_DELETE_##">
                    </a><?php */?>
				</td>
			</tr>
			<?php
           $i++; }
		} else { ?>
			<tr>
            	<td colspan="8" class="lastcolumn alignLeft">
                	##_TICKET_LIST_NOT_FOUND_##
				</td>
			</tr>
		<?php
		}?>
        </table>
         <?php
        if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
            <div class="pagination"  style="margin-right:65px;">
                <?php
				$extraPaginationPara='&keyword='.$ext['keyword'].'&startdate='.$ext['startdate'].'&enddate='.$ext['enddate'].'&searchFrom='.$ext['searchFrom'].'&searchTo='.$ext['searchTo'];
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