<div class="mainContainer" id="mainContainer">
<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>

<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/style.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/registration.css" />
<script type="text/javascript">
var $j = jQuery.noConflict();
var imgPath = "<?php echo Yii::app()->params->base_url;?>images/";
function sortData(sortBy,sortType)
{
	 //var url	=	$j(this).attr('lang');
     loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/customerList/sortType/'+sortBy+'/sortBy/'+sortType+'<?php echo  $extraPaginationPara;?>','mainContainer');
}
function loadBoxContent(urlData,boxid)
{
	mylist=0;
	mytodoStatus=0;
	
	var $j = jQuery.noConflict();
		$j.ajax({			
		type: 'POST',
		url: urlData,
		data: '',
		cache: true,
		success: function(data)
		{
			//alert(urlData);
			//alert(boxid);
			//alert(data);
			if(data=="logout")
			{
				window.location.href = '<?php echo Yii::app()->params->base_path;?>';
				return false;	
			}
			$j("#"+boxid).html(data);
			$j('#update-message').removeClass().html('').hide();
		}
		});	
} 
$j(document).ready(function() {
	
	$j(".viewMore").fancybox({
		'width' : 800,
 		'height' : 500,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});
	
	  $j('.sort').click(function() {
                var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','mainContainer');
	  });
				
				
	$j('.various4').click(function() {
		
		var id	=	$j(this).attr('lang');
		
		jConfirm('Are you sure want delete this TODO list ?', 'Confirmation dialog', function(res){
			if( res == true ) {
				$j('#update-message').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
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
	$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	var keyword = $j("#keyword").val();
	
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/customerList',
		data: 'keyword='+keyword,
		cache: false,
		success: function(data)
		{
			$j("#mainContainer").html(data);
			$j("#keyword").val(keyword);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}

function getAll()
{
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>user/customerList',
		data: '',
		cache: false,
		success: function(data)
		{
			$j("#mainContainer").html(data);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}


function inviteFromLists(id)
{
	setUrl('<?php echo Yii::app()->params->base_path; ?>user/addinvite/id/'+id+'/from/myLists');
}

function selectNetworkUser(id,name,rating)
{
	parent.loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/ticketDescriptionNew/invoiceId/<?php echo $invoiceId; ?>/rating/'+rating+'/customer_id/'+id,'mainContainer');
	parent.$j.fancybox.close();	
		
}
</script>

<div class="RightSide">
	
    <h1>##_CUSTOMER_LIST_PAGE_CUSTOMER_LIST_##</h1>
    
    <div class="searchArea innerSearch">
        <form id="jobSearch" name="jobSearch" action="#" method="post" onsubmit="return false;">        
        	<label class="label floatLeft">##_CUSTOMER_LIST_PAGE_CUSTOMERS_##</label>
            <input type="text" class="textbox floatleft" style="width:300px;" name="keyword"  onkeypress="if(event.keyCode==13){getSearch();}" id="keyword" autocomplete="off" />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="getSearch();" />
            <input type="button" name="searchBtn" class="btn" value="ShowAll" onclick="getAll();" />
        </form>
        <div class="clear"></div>
    </div>
	
	
        <div class="clear"></div>
 
	
    <table cellpadding="0" cellspacing="0" border="0" class="listing width700" id="list">
    	<tr>
    		<th width="15%"> 
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customerList/invoiceId/<?php echo $invoiceId;?>/sortType/<?php echo $ext['sortType'];?>/sortBy/customer_name' >
                ##_CUSTOMER_LIST_PAGE_CUSTOMER_NAME_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'customer_name'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="7%">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customerList/invoiceId/<?php echo $invoiceId;?>/sortType/<?php echo $ext['sortType'];?>/sortBy/rating' >
                ##_CUST_RATE_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'rating'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="10%">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customerList/invoiceId/<?php echo $invoiceId;?>/sortType/<?php echo $ext['sortType'];?>/sortBy/credit' >
                ##_CREDIT_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'credit'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            
            <th width="10%">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>user/customerList/invoiceId/<?php echo $invoiceId;?>/sortType/<?php echo $ext['sortType'];?>/sortBy/debit' >
                ##_DEBIT_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'debit'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            
            <th width="10%">
                ##_BALANCE_##
			</th>
            
            <th width="10%" class="lastcolumn">##_TICKET_LIST_ACTION_##</th>
		</tr>
        <?php  
		if(count($data) > 0){ $i=0;
			foreach($data as $row){ ?> 
            <tr>
            	<td class="alignCenter">
                	 <?php echo $row['customer_name']; ?>
                </td>
                <td class="alignCenter">
                	 <?php if ($row['rating'] == 1 ) { ?>
                    <img src="<?php echo Yii::app()->params->base_url; ?>images/star1.png" />
                    <?php } else if ($row['rating'] == 2 ) { ?>
                     <img src="<?php echo Yii::app()->params->base_url; ?>images/star2.png" />
                    <?php } else if ($row['rating'] == 3 ){  ?>
                    <img src="<?php echo Yii::app()->params->base_url; ?>images/star3.png" />
                    <?php } ?>
                </td>
                
                <td class="alignCenter">
                	<?php echo $row['credit'];?>
                </td>				
                				
                <td class="alignCenter">
                	<?php echo $row['debit'];?>
                </td>
                
                <td class="alignCenter">
                	<?php echo $row['debit'] - $row['credit'] ;?>
                </td>
                
                <td style=" text-align:center;" class="lastcolumn">
                	<a href="#" lang="<?php echo $row['id']; ?>" id="myNetwork_<?php echo $row['customer_id']; ?>" onclick="selectNetworkUser('<?php echo $row['customer_id']; ?>','<?php echo $row['customer_name'];?>','<?php echo $row['rating'];?>')" >##_TICKET_LIST_SELECT_##</a>
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
            <div class="pagination" style="width:70% !important;">
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
<script type="text/javascript">
	$j(document).ready(function(){
		$j('#link_pager a').each(function(){
			$j(this).click(function(ev){
				ev.preventDefault();
				$j.get(this.href,{ajax:true},function(html){
					$j('#mainContainer').html(html);
				});
			});
		});
	});
</script>
</div>