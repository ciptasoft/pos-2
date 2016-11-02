 <!-- Remove select and replace -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.jeditable.js" ></script>
<!-- Dialog Popup Js -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/j.min.Dialog.js" ></script>		
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jDialog.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/smoothscroll.js"></script>

<a href="#verifycodePopup" id="verifycode"></a>
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

<div class="mainContainer">

    <!-- LeftSide Slide Bar -->
    
    <div class="leftSlidebar">	
        <!-- Slidebar -->
        <div class="sidebar">
            <div class="logo-bg">
                <div class="logo"> 
                    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/logout','post',array('id' => 'logout','name' => 'logout')) ?>
                    <div>
                        <label class="username">##_HOME_HEADER_HI_## <b><?php echo Yii::app()->session['fullname']; ?></b></label>
                        <label class="logout"><a href="javascript:;" onClick="document.logout.submit();">##_BTN_LOGOUT_##</a></label>
                    </div>
                  <a href="<?php echo Yii::app()->params->base_path;?>user/index" id="logoImage"><img src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo.png" alt="" border="0" /></a>
            <?php echo CHtml::endForm(); ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="rightBorder">
              
                <div class="box">
                    <div id="leftview"></div>
                </div>
                <div class="clear"></div>
                
               
                <div class="box">
                    <div id="inviteAjaxBox"></div>
                </div>
             
                <div class="box">
                    <div id="listAjaxBox"></div>
                </div>
                <div class="clear"></div>
                
               
                <div class="clear"></div>
                
                <div class="box">
                    <div id="reminderAjaxBox"></div>
                </div>
                <div class="clear"></div>
             
                
                <div class="box">
                    <div id="inviteAjaxBox"></div>
                </div>
             
                <div class="clear"></div>
                <div class="box">
                    <div id="itemAjaxBox"></div>
                </div>
                <div class="clear"></div>
                
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="content" id="mainContainer">
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="RightSide">	
            <div class="clear"></div>
        <div> 
        <h1>Create Ticket</h1>
        	<div style="border-bottom:0px solid #006;height:30px;">
            	 <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/submitTicketbyUPCcode','post',array('id' => 'form','name' => 'form')) ?>
                 <input class="textbox" style=" margin-left:350px;" value="<?php if(isset($_POST['upc_code'])) { echo $_POST['upc_code']; }?>" type="text" id="upc_code" name="upc_code"/>
                  <input type="button" name="submitUpcCode" value="Add By UPC Code" onclick="getProductData();" style=" margin-top:-5px; float:right; background-color:#02356E; color:#FFF; width:150px; height:30px;" />
                <?php /*?> <input type="submit" name="submitUpcCode" value="Add By UPC Code" style=" margin-top:-5px; float:right; background-color:#02356E; color:#FFF; width:150px; height:30px;" /><?php */?>  
   			<?php echo CHtml::endForm();?>
            </div>
          	 <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/submitTicket','post',array('id' => 'functionForm','name' => 'functionForm')) ?>
            <div style="padding:5px; height:730px;width:90%">
            <table style="color:#02356E;" width="90%" cellpadding="10" cellspacing="0" height="15%" border="1">
            	<tr>
                <td width="60%">
                	<table width="100%" cellspacing="7" height="50%">
                    	<tr>
                        <td align="center" width="110px"><b>Invoice No:</b></td>
                        <td align="left"><input style="width:240px;" class="textbox" type="text" id="invoiceId" name="invoiceId" value="<?php echo $invoiceId;?>" disabled="disabled" /></td>
                        <input style="width:240px;" class="textbox" type="hidden" id="invoiceId" name="invoiceId" value="<?php echo $invoiceId;?>" />
                        </tr>
                        <tr>
                        <td align="center" width="110px"><b>Customer:</b></td>
                        <td  align="left"><input style="width:59px;" class="textbox" type="text" readonly="readonly" id="customer_id" name="customer_id" value="" /> <input  class="textbox" type="text" id="customer_name" name="customer_name" style="width:154px;"/> <a href="<?php echo Yii::app()->params->base_path;?>user/customerList" id="viewMore" class="viewIcon noMartb viewMore floatLeft"></a>
                        </td>
                        </tr>
                        <tr>
                        <td align="center" width="110px"><b>Discount:</b></td>
                       <td  align="left"><input style="width:241px;" class="textbox" onkeyup="discount();" type="number" id="discount" name="discount" value="0" min="0" max="100"/></td>
                       </tr>
                    </table>
                </td>
                <td width="40%">
                <table width="100%" height="100%">
                    	<tr>
                        <td align="center" width="110px"><b>Date:</b></td>
                        <td align="left"><input style="width:100px;" disabled="disabled" class="textbox" type="text" id="createdAt" name="createdAt" value="<?php echo date("Y-m-d");?>"/>&nbsp;<input style="width:50px;" class="textbox" type="text" id="" name="time" value="<?php echo date("H:i:s");?>" disabled="disabled"/></td>
                        </tr>
                        <tr>
                        <td align="center" width="110px"><b>Casher:</b></td>
                        <td  align="left"><input style="width:162px;" class="textbox" type="text" id="casher" name="casher" value="<?php echo Yii::app()->session['fullname']; ?>" disabled="disabled" /> </td>
                        <input style="width:162px;" class="textbox" type="hidden" id="casher" name="casher" value="<?php echo Yii::app()->session['fullname']; ?>" />
                        </tr>
                        <tr>
                        <td align="center" width="110px"><b>Reg No:</b></td>
                       <td  align="left"><input style="width:100px;" class="textbox" type="text" id="reg_no" name="reg_no" value="<?php echo Yii::app()->session['userId']; ?>" disabled="disabled" /></td>
                       <input style="width:100px;" class="textbox" type="hidden" id="reg_no" name="reg_no" value="<?php echo Yii::app()->session['userId']; ?>" />
                       </tr>
                    </table>
                </td>
               
                </tr>
            </table>
            <br/>
            <table width="95%">
            <tr><td width="95%">
             <table width="95%" cellpadding="10" cellspacing="0" border="1">
            	<tr style="color:#02356E;" height="22px">
                	<th>Sr.</th>
                    <th>Itemno</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Shd</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Disc%</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td align="justify"><input size="5" class="" value="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" value="<?php if(isset($data['product_id'])) { echo $data['product_id']; }?>" type="text" id="product_id" name="product_id"/></td>
                    <td align="justify"><input size="30" class="" value="<?php if(isset($data['product_desc'])) { echo $data['product_desc']; }?>" type="text" id="product_desc" name="product_desc"/></td>
                    <td align="justify"><input size="10" class="" value="<?php if(isset($data['unit'])) { echo $data['unit']; }?>" type="text" id="unit" name="unit"/></td>
                    <td align="justify"><input size="5" class="" value="<?php if(isset($data['shd'])) { echo $data['shd']; }?>" type="text" id="shd" name="shd"/></td>
                    <td align="justify"><input size="5" class="" value="<?php if(isset($data['product_quantity'])) { echo $data['product_quantity']; }?>" type="text" id="product_quantity" name="product_quantity"/></td>
                    <td align="justify"><input size="10" class="" type="text" value="<?php if(isset($data['product_price'])) { echo $data['product_price']; } ?>" id="product_price" name="product_price"/></td>
                    <td align="justify"><input size="5"  class="" type="text" id="discount1" name="discount1" /></td>
                    <td align="justify"><input size="10" class="" value="<?php if(isset($data['product_total'])) { echo $data['product_total']; }else{ echo "30";}?>" type="text" onkeyup="sumTotal();" id="product_total1" name="product_total1"/></td>
                    
              <?php //} ?>      
               
                </tr>
                <tr>
                	<td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="30" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" onkeyup="sumTotal();" value="20" id="product_total2" name="product_total2"/></td>
                </tr>
                <tr>
                	<td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="30" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" onkeyup="sumTotal();" value="20" id="product_total3" name="product_total3"/></td>
                </tr>
                <tr>
                	<td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="30" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" onkeyup="sumTotal();" value="20" id="product_total4" name="product_total4"/></td>
                </tr>
                <tr>
                	<td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="30" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" onkeyup="sumTotal();" value="20" id="product_total5" name="product_total5"/></td>
                </tr>
                <tr>
                	<td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="30" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" onkeyup="sumTotal();" value="20" id="product_total6" name="product_total6"/></td>
                </tr>
                <tr>
                	<td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="30" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="5" class="" type="text" id="" name=""/></td>
                    <td align="justify"><input size="10" class="" type="text" onkeyup="sumTotal();" value="20" id="product_total7" name="product_total7"/></td>
                </tr>
               </table>
               </td>
               
               </tr>
               <tr>
          
               </tr>
                </table>
               </td>
               </tr>
               </table>
               <br/>
               <table width="90%" cellpadding="10" cellspacing="0" border="0" style="color:#02356E;">
               <tr height="40px">
               <td><b>Quantity :</b></td>
               <td><b>Items: </b></td>
               </tr>
               <tr height="50px">
               <td align="justify"><input class="textbox" value="<?php if(isset($_POST['total_quantity'])) { echo $_POST['total_quantity']; }?>" type="text" id="total_quantity" name="total_quantity"  disabled="disabled"/></td>
               <input class="textbox" type="hidden" value="<?php if(isset($_POST['total_quantity'])) { echo $_POST['total_quantity']; }?>" id="total_quantity" name="total_quantity"/>
               <td align="justify"><input class="textbox" type="text" value="<?php if(isset($_POST['total_item'])) { echo $_POST['total_item']; }?>" id="total_item" name="total_item" disabled="disabled"/></td>
               <input class="textbox" type="hidden" value="<?php if(isset($_POST['total_item'])) { echo $_POST['total_item']; }?>" id="total_item" name="total_item"/>
               </tr>
               
               <tr height="40px">
               <td><b>Payment Type: </b></td>
               <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total :</b></td>
               </tr>
               <tr height="50px">
               <td align="justify"><input style="width:40px;" class="textbox" type="text" id="" name=""/>&nbsp;<input style="width:250px;" size="10" class="textbox"type="text" id="" name=""/></td>
               <td align="justify"><input style="width:40px;" size="5" class="textbox" type="text" id="" name=""/>&nbsp;<input style="width:50px;" size="5" class="textbox" type="text" id="product_total" name="product_total"/></td>
               </tr>
               <tr height="40px">
               <td><b>Credit Payment</b></td>
               <td><b>Total Amount</b></td>
               </tr>
               <tr height="50px">
               <td align="justify"><input style="" class="textbox" type="text" id="creditPayment" name="creditPayment"/></td>
               <td align="justify"><input style="" class="textbox" type="text" id="total_amount" name="total_amount"/></td>
               </tr>
               <tr height="40px">
               <td><b>Cash Payment</b></td>
               <td><b>Remianing Payment</b></td>
               </tr>
               <tr height="50px">
               <td align="left"><input style="" class="textbox" type="text" id="cashPayment" name="cashPayment"/></td>
               <td align="left"><input style="" class="textbox" type="text" id="remainingPayment" name="remainingPayment"/></td>
               </tr>
               </table>
             <input type="submit" name="submit" value="Submit" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;" />  
   			</div>
			
			<?php echo CHtml::endForm();?>
        </div>
        </div>
       <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    
</div>
<div class="clear"></div>
