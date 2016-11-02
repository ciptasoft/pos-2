<!-- Login -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url;?>css/custom-theme/jquery-ui-1.8.13.custom.css" />
<script type="text/javascript">
	var base_path = "<?php echo Yii::app()->params->base_path;?>";
	var $j = jQuery.noConflict();
	
	$j(function() {
		var dates = $j( "#date1, #date2, #date3, #date4" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $j( this ).data( "datepicker" ),
					date = $j.datepicker.parseDate(
						instance.settings.dateFormat ||
						$j.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
</script>
  <div class="clear"></div>
 
  <div align="center">
      <h5>##_EXP_DATA_##</h5>
      <?php if(isset($link)) { ?><span> To Download xls file click this link : </span><a style="color:#F00;" href="<?php echo $link ; ?>"><?php echo $link ; ?>  </a>  <?php   }  ?>
      <div class="mojone-loginbox">
          <div class="login-box">
         
                <?php /*?><table cellpadding="1" cellspacing="1" border="0" class="login-table">
                <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportProductFile" method="post">
                    <tr>
                        <td><label>##_EXP_PRODUCT_FILE_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="1" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                </form>
                <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportCustomerFile" method="post">
                    <tr>
                        <td><label>##_EXP_CUSTOMER_FILE_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="2" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                  </form>
                </table><?php */?>
                <table cellpadding="1" cellspacing="1" border="0" class="login-table">
               <?php /*?> <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportPdfTransactionReport" method="post">
                    <tr>
                        <td><label>##_EXPORT_PDF_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="1" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                </form><?php */?>
                <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportExcellTransactionReport" method="post">
                	<tr>
                   		<td>&nbsp;</td>
                        <td><label>ON DATE :</label></td>
                        <td><input name="date1" style="width:90px !important;" id="date1" class="textbox2 datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/></td>
                    </tr>
                    <tr>
                   		<td><b>##_TODAY_TRANSACTION_REPORTS_## :</b></td>
                        <td><label>##_EXPORT_EXCEL_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="2" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                    </form>
                   <form name="importForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/pdfReportForAccountTransactionReport" method="post">
                   <tr>
                   		<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                   <tr>
                   		<td>&nbsp;</td>
                        <td><label>ON DATE :</label></td>
                        <td><input name="date2" style="width:90px !important;"  id="date2" class="textbox2 datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/></td>
                    </tr>
                    <tr>
                   		<td>&nbsp;</b></td>
                        <td><label>##_EXPORT_PDF_## :</label></td>
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                  </form>
                    <tr>
                    	<td colspan="3">&nbsp;</td>
                    </tr>
                  <br/><br/>
                  <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportExcellJournalReport" method="post">
                  <tr>
                   		<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                   		<td>&nbsp;</td>
                        <td><label>ON DATE :</label></td>
                        <td><input name="date3" style="width:90px !important;"  id="date3" class="textbox2 datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/></td>
                    </tr>
                    <tr>
                   		<td><b>##_TODAY_JOURNAL_REPORTS_## :</b></td>
                        <td><label>##_EXPORT_EXCEL_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="2" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                   </form>
                   <form name="importForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/pdfReportForJournalTransactionReport" method="post">
                   <tr>
                   		<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                   <tr>
                   		<td>&nbsp;</td>
                        <td><label>ON DATE :</label></td>
                        <td><input name="date4" style="width:90px !important;"  id="date4" class="textbox2 datebox" type="text" value="<?php if(isset($ext['startdate'])){echo $ext['startdate'];}?>"/></td>
                    </tr>
                    <tr>
                   		<td>&nbsp;</b></td>
                        <td><label>##_EXPORT_PDF_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="2" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                  </form>
                  <tr>
                    	<td colspan="3">&nbsp;</td>
                    </tr>
                   <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportProductFile" method="post">
                    <tr>
                    	<td><b>##_EXP_PRODUCT_FILE_## :</b></td>
                        <td><label>##_EXPORT_EXCEL_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="1" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                </form>
                 <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportCustomerFile" method="post">
                    <tr>
                    	<td><b>##_EXP_CUSTOMER_FILE_## :</b></td>
                        <td><label>##_EXPORT_EXCEL_## :</label></td>
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                  </form>
                   <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportSupplierFile" method="post">
                    <tr>
                    	<td><b>##_EXP_SUPPLIER_FILE_## :</b></td>
                        <td><label>##_EXPORT_EXCEL_## :</label></td>
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                  </form>
                </table>
           </div>
      </div>
  </div>