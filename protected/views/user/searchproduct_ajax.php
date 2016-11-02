<script type="text/javascript">
 $j("#viewMore").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });
	  
	$j("#viewProduct").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });	
</script>

<script type="text/javascript">
	
	
	function getSearch(test)
	{
		var keyword = $j("#keyword").val();
		
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>user/SearchProductAjax/invoiceId/<?php echo $invoiceId; ?>',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
			{
				$j(".browsebox").html('');
				$j(".browsebox").html(data);
				
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
		});
	}
	
	 
</script>

<div class="browsebox" style="min-height:0px !important;">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" id="browsedata" class="browsedata">
                                <?php if(!empty($res['product'])) { ?>
								<?php $ids = array() ;  
                                	foreach($productIds as $row ){ ?>
                                <?php $ids[] = $row['product_id'] ; ?>
                                <?php } ?>
								<?php foreach($res['product'] as $row ){ ?>
 <tr id="demo" style="cursor:pointer;">
        <td width="5%">&nbsp;</td>
        <td  onclick="getProductDetail(<?php echo $row['product_id'] ; ?>);" width="65%"><?php echo $row['product_name'] ; ?></td>
        <?php /*?><td width="10%"><?php echo $row['product_discount'] ; ?></td><?php */?>
        <td width="25%"  colspan="2" align="right";>
        <select id="productprice<?php echo $row['product_id'] ?>" style="width:100px;">
        <option <?php if (isset($rating) && $rating == 1 ) { ?> selected="selected" <?php } ?> value="<?php echo $row['product_price'] ; ?>"><?php echo $row['product_price'] ; ?></option>
        <option <?php if (isset($rating) && $rating == 2 ) { ?> selected="selected" <?php } ?> value="<?php echo $row['product_price2'] ; ?>"><?php echo $row['product_price2'] ; ?></option>	
        <option <?php if (isset($rating) && $rating == 3 ) { ?> selected="selected" <?php } ?> value="<?php echo $row['product_price3'] ; ?>"><?php echo $row['product_price3'] ; ?></option></select></td>
        <input id="product_id" type="hidden" value="<?php echo $row['product_id'] ?>" />
  <?php if(!in_array($row['product_id'],$ids)) {  ?>
        <td width="10%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" onclick="checkStockDetailFromStock('<?php echo trim(htmlspecialchars($row['product_name'])) ; ?>','<?php echo $row['product_id'] ?>','<?php echo $row['product_image'] ?>');"><img src="images/mark-true1.gif"/></td>
        <?php } else { ?>
        <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" style="background-color:gray;" ><img src="images/mark-true1.gif"/></td>
        <?php } ?>
    </tr>
<?php } ?>
   <?php } else { ?>
    <tr>
    <td colspan="4">##_BROWSE_PRODUCT_NO_PRODUCT_AVAILABLE_##</td>
    </tr>
    <?php } ?>
                                 <?php
            if(!empty($res['pagination']) && $res['pagination']->getItemCount()  > $res['pagination']->getLimit()){?>
                 <div class="pagination"  style="margin-right:0px;">
                    <?php
                    
                    $this->widget('application.extensions.WebPager', 
                                    array('cssFile'=>true,
                                             'pages' => $res['pagination'],
                                             'id'=>'link_pager',
                    )); ?>
                </div>
                <?php
            } ?>
          <script type="text/javascript">
        $j(document).ready(function(){
            $j('#link_pager a').each(function(){
                $j(this).click(function(ev){
                    ev.preventDefault();
                    $j.get(this.href,{ajax:true},function(html){
                        $j('.browsebox').html(html);
                    });
                });
            });
        });
    </script>
    </table>
</div>
