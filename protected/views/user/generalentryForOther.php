<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="application/javascript"> 
   	function generalEntry() {
	   	
		 var credit = $j("#credit").val();
		 var debit = $j("#debit").val();
		 var account = $j("#account").val();
		 var paymentType = $j("#paymentType option:selected").val();
		 var description = $j("#description").val();
		 
		 if(credit == 0 && debit == 0)
		 {
		 	jAlert(msg['INSERT_ONE_VALUE']);
			return false;
		 }
		 
		 if(account == "")
		 {
		 	jAlert(msg['ENTER_ACC_NAME']);
			return false;
		 }
		 
		 if(paymentType == "0")
		 {
		 	jAlert(msg['SELECT_PAY_TYPE']);
			return false;
		 }
		 
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/addGeneralEntryforOther',
		  data: 'credit='+credit+'&debit='+debit+'&account='+account+'&paymentType='+paymentType+'&description='+description,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		   /*setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
	  	   setTimeout(function() { $j("#msgbox1").fadeOut();},2000 );*/ 
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
	$j("#"+boxid+"").attr("value","");
}	

</script>

<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<div id="update-message"></div>
<!-- Middle Part -->

<div class="clear"></div>

<div class="mainContainer">
    
    <!-- RightSide Slide Bar -->    
    <div class="secondcont" id="mainContainer">
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="RightSide">	
            <div class="clear"></div>
                <div class="heading"><?php echo Yii::app()->session['fullname']; ?> 's ##_HOME_PAGE_WORKSPACE_##</div>
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
             <div class="productboxgreen-small">
             
            	<h1 style="color:#333333; margin-left:300px;">##_GENERAL_ACCOUNT_ENTRY_OTHER_##</h1>
              <div style="margin-left:300px;">
                 <table width="400" border="1" style="background-color:#cccccc;">
                 	<tr>
                    	<td align="center"><h2>##_GENERAL_ACCOUNT_##</h2></td>
                        <td align="center">
                        <input style="width:160px" class="textbox" type="text" id="account" name="account" value="" />
                        </td>
                        
                        
                    </tr>
                    <tr>
                 	    <td align="center"><h2>##_RECEIVE_##</h2></td>
                    	<td align="center"><input style="width:160px; text-align:right;" onclick="emptyValue('debit');" class="textbox" type="text" id="debit" name="debit" value="0" onkeypress="return isNumberKey(event);"/></td>
                    </tr>
                    <tr>
                    	<td align="center"><h2>##_PAY_##</h2></td>
                        <td align="center"><input style="width:160px; text-align:right;" onclick="emptyValue('credit');" class="textbox" type="text" id="credit" name="credit" value="0" onkeypress="return isNumberKey(event);" /></td>
                    </tr>
                    <tr>
                    	<td align="center"><h2>##_PAY_TYPE_##</h2></td>
                        <td align="center">
                        <select id="paymentType" name="paymentType" style="width:160px;"  >
                        	<option value="0" selected="selected">##_SELECT_PAY_TYPE_##</option>
                            <option value="1" >##_CASH_##</option>
                            <option value="2" >##_CARD_##</option>
                            <option value="3" >##_CHEQUE_##</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                    	<td align="center"><h2>##_Ticket_DESC_PAGE_DESCRIPTION_##</h2></td>
                        <td align="center"><input style="width:160px; " class="textbox" type="text" id="description" name="description" value="" /></td>
                    </tr>
                    
                 </table>   
                 <div class="btnfield">   
               		<input type="submit" name="submit" value="##_BTN_SUBMIT_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" onclick="generalEntry();" />  
                    <input id="btn_cancel_password" type="button" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>user'" value="##_BTN_CANCEL_##" class="btn" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"   />
                </div>
            </div>
       </div>
    </div>
    
</div>