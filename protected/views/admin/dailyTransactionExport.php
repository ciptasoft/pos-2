<!-- Login -->
  <div class="clear"></div>
 
  <div align="center">
      <h5>##_ADMIN_DAILY_TRANSACTION_REPORTS_##</h5>
      <?php if(isset($link)) { ?><span> To Download xls file click this link : </span><a style="color:#F00;" href="<?php echo $link ; ?>"><?php echo $link ; ?>  </a>  <?php   }  ?>
      <div class="mojone-loginbox">
          <div class="login-box">
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
                   		<td><b>##_TODAY_TRANSACTION_REPORTS_## :</b></td>
                        <td><label>##_EXPORT_EXCEL_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="2" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                    </form>
                   <form name="importForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/pdfReportForAccountTransactionReport" method="post">
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
                  <br/><br/>
                  <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/exportExcellJournalReport" method="post">
                    <tr>
                   		<td><b>##_TODAY_JOURNAL_REPORTS_## :</b></td>
                        <td><label>##_EXPORT_EXCEL_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="2" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                   </form>
                   <form name="importForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/pdfReportForJournalTransactionReport" method="post">
                    <tr>
                   		<td>&nbsp;</b></td>
                        <td><label>##_EXPORT_PDF_## :</label></td>
                        <!--<td><input type="file" name="exportFile" class="textbox" tabindex="2" /></td>-->
                        <td><input type="submit" name="cancel_login" class="btn" value="##_DOWNLOAD_##" /></td>
                    </tr>
                  </form>
                </table>
           </div>
      </div>
  </div>