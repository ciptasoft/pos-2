<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
	
	$j('.various4').click(function(){
		var url	=	$j(this).attr('lang');
		jConfirm('Are you sure want delete this reminder ?', 'Confirmation dialog', function(res){
			if( res == true ) {
				$j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').show();
				$j.ajax({
					url: '<?php echo Yii::app()->params->base_path;?>user/'+url,
					cache: false,
					success: function(data)
					{
						var obj	=	$j.parseJSON(data);
						if( obj.status == 0 ){
							$j('#mainContainer')
							.load('<?php echo Yii::app()->params->base_path;?>user/messages', function() {
								$j("#update-message").hide().removeClass().addClass('msg_success');
								$j("#update-message").html('Reminder deleted successfully');
								$j("#update-message").fadeIn();
								setTimeout(function() {
									$j('#update-message').fadeOut();
								}, 10000 );
							});
						}
					}
				});
			}
		});
	});
	
	$j('.remindMe').click(function() {
		var url	=	$j(this).attr('lang');
		jConfirm('Send reminder again?', 'Confirmation dialog', function(res){
		if(res == true){
		$j.ajax({
			url: url,
			success: function(response) {
				var obj	=	$j.parseJSON(response);
				if( obj.status == 0 ) {
					$j("#update-message").removeClass().addClass('msg_success');
					$j("#update-message").html('Reminder sent successfully');
					$j("#update-message").fadeIn();
				}
				setTimeout(function() {
					$j('#update-message').fadeOut();
				}, 10000 );
			}
		});
	    }
	  });
});

function editRemider(id){
	$j('#update-message').removeClass().html('');
	$j('#mainContainer')
		.html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
		.show()
		.load('<?php echo Yii::app()->params->base_path;?>user/addReminder/id/'+id);
	}
	
</script>
<script type="text/javascript">
var base_path = "<?php echo Yii::app()->params->base_path;?>";
$j(document).ready(function(){
	
});

function deleteMessages(id)
{
	//var id	=	$j(this).attr('lang');
	 jConfirm('Do you want to delete this message?', 'Confirmation dialog', function(res){
		   if(res == true){
				$j.ajax({
				url: base_path+"user/deleteMessage/id/"+id,
				success: function(response) {
					
					
					if(response == 1 ) {
						$j("#messageBox").load(base_path+"user/messages");
						$j("#update-message-chat").removeClass().addClass('msg_success');
						$j("#update-message-chat").html('Message delete successfully');
						$j("#update-message-chat").fadeIn();
					}
					setTimeout(function() {
						$j('#update-message-chat').fadeOut();
					}, 10000 );
				}
				});
			}
		   });
	
}
function readMessage(id)
{
				$j.ajax({
				url: base_path+"user/readMessage/id/"+id,
				success: function(response) {
					if(response == 1 ) {
						$j("#messageBox").load(base_path+"user/messages");
					}
				}
				});
	
}
</script>
 <div id="eventLoader"></div>
<div class="mainContainer" id="messageBox">
<div class="secondcont" id="mainContainer" >
	<div class="RightSide">  
     <div class="clear"></div>
          <div class="heading"><?php echo Yii::app()->session['fullname']; ?> 's ##_HOME_PAGE_WORKSPACE_##</div>
          
 <div id="update-message-chat"></div>
    <div align="center">
    <?php if(Yii::app()->user->hasFlash('success')): ?>                                
        <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    </div>
    
    <div class="productboxgreen" > 
        <h1 style="color:#333333;margin-left:10px;">##_MESSAGE_PAGE_INBOX_##</h1>
        <div style="border-bottom:1px solid #006;height:10px;"></div>
        	<?php 
			if(count($data['lists']) > 0)
			{
		   $generalObj = new General();
		   foreach($data['lists'] as $row) { ?>
            <div style="border-bottom:1px solid #006;" >
            <table width="91%" cellpadding="15" cellspacing="5" height="15%" border="0">
            	<tr>
                <td width="13%"><img src="<?php echo Yii::app()->params->base_url;?>images/avatar.png" width="60" height="45" /></td>
                <td width="51%"><b><?php echo $row['firstName'] ; echo "&nbsp;"; echo $row['lastName']; ?></b><br /><p>&nbsp;</p> <p><?php echo $row['message'] ; ?></p></td>
                <td align="center" width="19%"><?php echo  $generalObj->ago($row['created']);?></td>
                <td align="center" width="17%"> 
				<?php if ($row['status'] == 0 ) { ?>
               <a class="" onclick="readMessage('<?php echo $row['id'] ; ?>');" href="javascript:;"  lang="<?php echo $row['id'] ; ?>" title="Mark as read"><img src="<?php echo Yii::app()->params->base_url;?>images/mark-true1.gif" alt="Delete" border="0"/></a>
				<?php  } else { ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php  } ?>
                 <a class="" onclick="deleteMessages('<?php echo $row['id'] ; ?>');" href="javascript:;"  lang="<?php echo $row['id'] ; ?>" title="Delete Message"><img src="<?php echo Yii::app()->params->base_url;?>images/false.png" alt="Delete" border="0"/></a>
                 </td>
                </tr>
                 </table> 
           
		</div>
        <?php } ?>
            <?php } else { ?>
        <table border="0">
        <tr>
            <td colspan="3" class="lastrow lastcolumn">
              <h2 style="color:white;margin-left:10px;">##_MESSAGE_PAGE_INBOX_EMPTY_##</h2>
            </td>
        </tr> 
        </table>
         <?php } ?>   
          <?php
		
        if(!empty($data['pagination']) && $data['pagination']->getItemCount()  > $data['pagination']->getLimit()){?>
 	 <div class="pagination">
    <?php
            $this->widget('application.extensions.WebPager', 
                            array('cssFile'=>true,
                                     'pages' => $data['pagination'],
                                     'id'=>'link_pager',
            ));
            ?>
  </div>
  <?php
		}
        ?>
         
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
<script type="text/javascript">
	$j(document).ready(function(){
		$j('table tr td').each(function(){
			if($j(this).html() == ''){
				$j(this).html('&nbsp;');
			}
		});	
	});
</script>