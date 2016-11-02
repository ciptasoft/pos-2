<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.cleditor.min.js"></script>
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="application/javascript"> 
   	function addAccountMaster() {
	   	
		 var accountName = $j("#accountName").val();
		 var group_id = $j("#group_id").val();
		 var balance = $j("#balance").val();
		 
		 if(accountName == "")
		 {
		 	jAlert(msg['ENTER_ACC_NAME']);
			//jAlert(msg['INSERT_ONE_VALUE']);
			return false;
		 }
		 
		 if(group_id == 0)
		 {
		 	//jAlert(msg['INSERT_ONE_VALUE']);
			jAlert(msg['ENTER_GROUP']);
			return false;
		 }
		 
		 
		 
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/addAccountMaster',
		  data: 'accountName='+accountName+'&group_id='+group_id+'&balance='+balance,
		  cache: false,
		  success: function(data)
		  {
			   $j(".mainDiv").html(data);
			   setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
			   setTimeout(function() { $j("#msgbox1").fadeOut();},2000 ); 
			   window.location.reload(true);
		  }
		 });
   }
   
   function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode 
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	  
function emptyValue(boxid)
{
	$j("#"+boxid+"").attr("value"," ");
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
<h1><a href="<?php echo Yii::app()->params->base_path;?>admin/category">##_ADMIN_ACCOUNTS_##</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />##_ADD_MASTER_##</h1>        
        <div class="content-box">
             <div style="margin-left:10px;">
             <table width="500" border="1" style="background-color:#cccccc;">
             		<tr>
                    	<td align="center"><h2>##_ACCOUNT_NAME_##</h2></td>
                        <td align="center"><input type="text" class="textbox" name="accountName" id="accountName" style="width:200px;" /></td>
                    </tr>
                 	<tr>
                    	<td align="center"><h2>##_BALANCE_##</h2></td>
                        <td align="center"><input style="width:200px;text-align:right;" class="textbox" type="text" id="balance" name="balance" value="0" onkeypress="return isNumberKey(event);"  onclick="emptyValue('balance');" /></td>
                    </tr>
                    <tr>
                 	    <td align="center"><h2>##_GROUP_NAME_##</h2></td>
                        <td align="center"><select name="group_id" id="group_id" class="select-box2" style="width:200px;">
                               <option value="0" selected>##_SELECT_GROUP_NAME_##</option>
                <?php foreach($groups as $row){ ?>
               <option value="<?php echo  $row['group_id'] ; ?>"><?php echo $row['group_name'];?>
               </option>
               <?php } ?>
                </select></td>
                    </tr>
             </table>
                   
<div class="btnfield">   
<input type="submit" name="submit" value="##_BTN_SUBMIT_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" onclick="addAccountMaster();" />  
  <input id="btn_cancel_password" type="button" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>admin'" value="##_BTN_CANCEL_##" class="btn" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"   />
</div>
</div>
        </div>
</div>

