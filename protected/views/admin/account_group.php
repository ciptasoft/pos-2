<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.cleditor.min.js"></script>
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="application/javascript"> 
   	function addGroup() {
	   	
		 var group_name = $j("#group_name").val();
		 if(group_name == "")
		 {
		 	jAlert(msg['ENTER_ACC_TYPE']);
			//jAlert(msg['INSERT_ONE_VALUE']);
			return false;
		 }
		 
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/addAccountGroup',
		  data: 'group_name='+group_name,
		  cache: false,
		  success: function(data)
		  {
			   $j(".mainDiv").html(data);
			   setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
			   setTimeout(function() { $j("#msgbox1").fadeOut();},2000 ); 
			   //window.location.reload(true);
		  }
		 });
   }
   
</script>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>   
<div class="mainDiv" >
<h1><a href="<?php echo Yii::app()->params->base_path;?>admin/category">##_ADMIN_ACCOUNTS_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />##_ADD_GROUP_##</h1>        
        <div class="content-box">
             <div style="margin-left:10px;">
             <table width="500" border="1" style="background-color:#cccccc;">
                 	<tr>
                 	    <td align="center"><h2>##_GROUP_NAME_##</h2></td>
                        <td align="center"><input type="text" class="textbox" name="group_name" id="group_name" style="width:200px;" /></td>
                        <td align="center"><input type="submit" name="submit" value="##_BTN_SUBMIT_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" onclick="addGroup();" />  </td>
                    </tr>
             </table>
                   
<div class="btnfield">   
</div>
</div>
        </div>
</div>

