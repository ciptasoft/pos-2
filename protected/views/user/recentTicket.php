<script type="text/javascript">
	function openTicket(invoiceId)
	{	
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/ticketDescription',
		  data:'&invoiceId='+invoiceId,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		  }
		 });	
	}
</script>

<!-- End Mouse Scroll Finction -->
<div id="update-message"></div>
<!-- Middle Part -->
<div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="error-msg-area">								   
           <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="error-msg-area">
            <div class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
         </div>
    <?php endif; ?>
</div>
<div class="clear"></div>
			<div class="offer">
              <h2>##_PENDING_TICKETS_##</h2>
               <?php 
				if(count($result) > 0)
				{
				foreach($result as $row){ ?>
              <div class="itemname">Ticket <?php echo $row['invoiceId']; ?></div>
              <div class="price"><a style="color:white; text-decoration:underline;" href="#" onclick="openTicket(<?php echo $row['invoiceId']; ?>);"><?php echo $row['total_amount']; ?></a></div>
              <?php } ?> <?php } else { ?>
             <span><h2 style="color:black;">##_NO_PENDING_TICKET_##</h2></span>
             <?php } ?> 
                
           	</div>
             