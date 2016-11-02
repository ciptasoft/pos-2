<?php
$extraPaginationPara='';
//$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript">
$j(document).ready(function(){
	$j('.viewIcon').click(function(){
		$j('#update-message').removeClass().html('');
		var url	=	$j(this).attr('lang');
		$j('#mainContainer').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')			.show().load(url);
	});
	
	
	 $j('.sort').click(function() {
               $j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show();
			    var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','mainContainer');
			 
	  });
				
	
	/******* ACCEPT INVITATION *******/
	$j('.inviteAccept').click(function() {
		  $j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show();
			
		var url	=	$j(this).attr('lang');
		$j.ajax({
			url: '<?php echo Yii::app()->params->base_path;?>user/'+url,
			cache: false,
			success: function(data)
			{
				var obj = $j.parseJSON(data);
				if(obj.status == 0){
					$j('#mainContainer')
						.load('<?php echo Yii::app()->params->base_path;?>user/collegues'+'<?php echo  $extraPaginationPara;?>', function(){
							$j("#update-message").removeClass().addClass('msg_success');
							$j("#update-message").html(obj.message);
							$j("#update-message").fadeIn();
							setTimeout(function() {
								$j('#update-message').fadeOut();
							}, 10000 );
						});
					$j('#inviteAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/inviteAjax');
				} else {
					$j("#update-message").removeClass().addClass('error-msg');
					$j("#update-message").html(obj.message);
					$j("#update-message").fadeIn();
				}
			}
		});
	});
	
	/******* DELETE INVITATION *******/
	$j('.various4').click(function(){
		var url	=	$j(this).attr('lang');
		jConfirm('Are you sure want delete this Invite?', 'Confirmation dialog', function(res){
			if( res == true ) {
				  $j('#eventLoader').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
			.show();
				
				$j.ajax({
					url: url,
					cache: false,
					success: function(data)
					{
						var obj = $j.parseJSON(data);
						if( obj.status == 0 ) {
							$j('#mainContainer')
								.load('<?php echo Yii::app()->params->base_path;?>user/invites'+'<?php echo  $extraPaginationPara;?>', function() {
								
								});
								$j("#update-message").removeClass().addClass('msg_success');
									$j("#update-message").html(msg['INVITE_DELETED_SUCCESS']);
									$j("#update-message").fadeIn();
									setTimeout(function() {
										$j('#update-message').fadeOut();
									}, 10000 );
							$j('#inviteAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/inviteAjax');
						} else {
							$j('#update-message').html('');
						}
					}
				});
			}
		});
	});
});
function addInvite() {
	$j('#update-message').removeClass().html('');
	$j('#mainContainer')
		.html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>')
		.show()
		.load('<?php echo Yii::app()->params->base_path;?>user/AddInvite/from/invites');
}
</script>
<div id="eventLoader"></div>
<div class="mainContainer">
<div class="secondcont" id="mainContainer">
<div class="RightSide">
<div class="clear"></div>
                <div class="heading" ><?php echo Yii::app()->session['fullname']; ?> 's ##_HOME_PAGE_WORKSPACE_##</div>
    <div id="update-message"></div>
    <div>
		<?php if(Yii::app()->user->hasFlash('success')): ?>                                
            <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
            <div class="clear"></div>
        <?php endif; ?>
        <?php if(Yii::app()->user->hasFlash('error')): ?>
            <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
            <div class="clear"></div>
        <?php endif; ?>
    </div>
    
  	<div class="productboxgreen">
    <h1 style="color:#333333;margin-left:10px;">##_COLLEGUES_LIST_PAGE_LIST_##</h1>
    <div style="margin-left:10px;width:500px;">
    <table cellpadding="0" cellspacing="0" border="0" class="listing">
      <div id="occupations_list" style="">
		</span>
        <img style="display:none; float:right;" id="loader_pagination" src="http://jobsmo.com/images/spinner-small.gif" border="0">
   	
        <div>
        	<ul class="occupation" style="padding-top:0; list-style:none;">
        	<?php 
			if(count($res) > 0)
			{
			foreach($res as $row){?>
               <li>
               
            
                <div class="occupation-text" style="margin-top:5px;">
					                       
                                        
                        <img src="<?php echo Yii::app()->params->base_url;?>images/avatar.png" alt="" border="0" height="49" width="49">
                    	<div style="float:right; margin-left:-15px;">
                       	 	<b><?php echo $row['firstName']; echo "&nbsp;"; echo $row['lastName']; ?></b>
                             <img src="<?php echo Yii::app()->params->base_url;?>images/online.png" alt="" border="0" height="16" width="16">
                    	</div>
                    <p></p>
                </div>
                <div class="clear"></div>
                
                <div align="right" style="margin-bottom:10px;">
                <a class="hirenow btn" href="#"  onClick="loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/messageSend/id/<?php echo $row['id'];?>/name/<?php echo $row['firstName'];?>','secondcont')">
                        ##_COLLEGUES_LIST_PAGE_SEND_MSG_##
                    </a>
                                </div>								
            </li>							
            <?php } ?>
        </ul>
        	<div class="clear"></div>                 		
    	</div>
    </div>    
   <?php } else { ?>
        <tr>
            <td colspan="6" class="lastrow lastcolumn">
               ##_COLLEGUES_LIST_PAGE_NO_ONLINE_##
            </td>
        </tr> 
    <?php } ?>    
    </table>
    </div>
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
					$j('#mainContainer').html(html);
				});
			});
		});
	});
</script>