<!-- Login -->
  <div class="clear"></div>
 
  <div align="center">
      <h5>##_IMP_DATA_##</h5>
      <div class="mojone-loginbox">
          <div class="login-box">
         <div align="center">##_UPLOAD_ONLY_##<b>.xls</b> ##_FILE_##.</div>
                <table cellpadding="1" cellspacing="1" border="0" class="login-table">
                 <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/importCustomerFile" method="post">
                    <tr>
                        <td><label>##_IMP_CUS_##:</label></td>
                        <td><input type="file" id="file" name="file" value=""> </td>
                         <td><input type="submit" name="submit" class="btn" value="##_UPLOAD_##" /></td>
                    </tr>
                 </form>
                 <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/importProductFile" method="post">
                    <tr>
                        <td><label>##_IMP_PRO_##:</label></td>
                        <td><input type="file" id="file" name="file" value=""></td>
                        <td><input type="submit" name="submit" class="btn" value="##_UPLOAD_##" /></td>
                    </tr>
                 </form>
                 <form name="importProductForm" enctype="multipart/form-data" action="<?php echo Yii::app()->params->base_path;?>admin/importSupplierFile" method="post">
                    <tr>
                        <td><label>##_IMP_SUPP_##:</label></td>
                        <td><input type="file" id="file" name="file" value=""></td>
                        <td><input type="submit" name="submit" class="btn" value="##_UPLOAD_##" /></td>
                    </tr>
                 </form>

              </table>
        
            
          </div>
      </div>
  </div>