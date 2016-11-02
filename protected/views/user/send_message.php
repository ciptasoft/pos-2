<?php
$extraPaginationPara='';
//$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script>
function setMessage(message)
{
	$j("#messageText").val(message);
}

function sendMessage()
{
		var postData	=	$j('#sendMessageToCollegues').serialize();
		var messageText = $j("#messageText").val();
		var id = $j("#id").val();
		
			$j.ajax({
				type: 'POST',
				url: '<?php echo Yii::app()->params->base_path;?>user/sendMessageToCollegues',
				data: 'id='+id+'&messageText='+messageText,
				cache: false,
				success: function(data)
				{
					$j(".secondcont").html(data);
					setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
					setTimeout(function() { $j("#msgbox1").fadeOut();},2000 );		
				}
			});
	
}
</script>
<div class="mainContainer">
<div class="secondcont" id="mainContainer">
<div class="RightSide">
 		<div class="clear"></div>
    <div class="heading" ><?php echo Yii::app()->session['fullname']; ?> 's workspace</div>
    
    <div class="clear"></div>
<div>
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="error-msg-area">								   
   <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="error-msg-area">
    <div id="msgbox1" class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
</div>
        <?php endif; ?>
        </div>
<div class="clear"></div>
   <div class="productboxgreen-small">           
   		<h1 style="color:#333333;margin-left:300px;">Send Message To <?php echo $name;?></h1>
   
     
      <img style="display:none; float:right;" id="loader_pagination" src="<?php echo Yii::app()->params->base_url;?>/images/spinner-small.gif" border="0">
   	 <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/sendMessageToCollegues','post',array('id' => 'sendMessageToCollegues','name' => 'sendMessageToCollegues')) ?>
    	<div id="messagePart" style="margin-left:300px;">
        	<ul style="padding-top:0; list-style:none;">
				<li>
                <select name="messageList" class="select-box" onchange="setMessage(this.value);">
                	 <option value="NONE">-Select Message-</option>
					<?php foreach($messageList as $row){ ?>
                    <option value="<?php echo $row['message'];?>"><?php echo $row['message'];?></option>
                    <?php } ?>
                </select>
                </li>
                <li>&nbsp;</li>
                <li>
                <textarea name="messageText" id="messageText" style="width:350px; height:100px;"></textarea>
                </li>
                <li>&nbsp;</li>
                <li class="btnfield">
                 <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                <input type="button" class="btn" name="send" value="send" onclick="sendMessage();" />
                 <input type="button" class="btn" name="cancel" onclick="$j('#secondcont').load('<?php echo Yii::app()->params->base_path;?>user/collegues');" value="Cancel" />
                </li>
           </ul>
    </div>
    <?php echo CHtml::endForm(); ?>      
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