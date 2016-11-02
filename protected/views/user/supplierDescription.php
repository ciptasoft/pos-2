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
	<h1 class="popupTitle" style="background-color:#6AA566;"><?php echo $data['supplier_name']; ?></h1>
    <ul class="titleList popupTitleList">
    	<li>
        	<label>Supplier Name:</label>
        	<span><?php echo $data['supplier_name']; ?></span><p class="clear"></p>
        </li>
		<li>
        	<label>Supplier Address:</label>
        	<span><?php echo $data['address']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Email:</label>
        	<span><?php echo $data['email'];?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Credit:</label>
        	<span><?php echo $data['credit'];?></span><p class="clear"></p>
        </li>
        <li>
        	<label>Debit:</label>
        	<span><?php echo $data['debit'];?></span><p class="clear"></p>
        </li>
        <li>
        	<label>Balance:</label>
        	<span><?php echo $data['debit']-$data['credit'] ;?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Contact No:</label>
        	<span><?php echo $data['contact_no'];?></span><p class="clear"></p>
        </li> 
        <li>
        	<label>Created Date:</label>
        	<span><?php echo $data['created_date'];?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Status:</label>
        	<span><?php if( $data['status'] == 0 ) { echo "Inactive"; } else { echo "Active" ; } ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Modified Date:</label>
        	<span><?php echo $data['modified_date']; ?></span><p class="clear"></p>
        </li> 
	</ul>    
</div>