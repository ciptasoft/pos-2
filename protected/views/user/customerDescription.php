<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>


<div>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
	<h1 class="popupTitle" style="background-color:#6AA566;"><?php echo $data['customer_name']; ?></h1>
    <ul class="titleList popupTitleList">
    	<li>
        	<label>Customer Name:</label>
        	<span><?php echo $data['customer_name']; ?></span><p class="clear"></p>
        </li>
		<li>
        	<label>Customer Address:</label>
        	<span><?php echo $data['cust_address']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Email:</label>
        	<span><?php echo $data['cust_email'];?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Credit:</label>
        	<span><?php echo $data['credit'];?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Contact No:</label>
        	<span><?php echo $data['contact_no'];?></span><p class="clear"></p>
        </li> 
        <li>
        	<label>Total Purchase:</label>
        	<span><?php echo $data['total_purchase'];?></span><p class="clear"></p>
        </li>
        <li>
        	<label>Created Date:</label>
        	<span><?php echo $data['createdAt'];?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Status:</label>
        	<span><?php if( $data['status'] == 0 ) { echo "Inactive"; } else { echo "Active" ; } ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Modified Date:</label>
        	<span><?php echo $data['modifiedAt']; ?></span><p class="clear"></p>
        </li> 
	</ul>    
</div>