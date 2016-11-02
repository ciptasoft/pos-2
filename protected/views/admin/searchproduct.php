<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <div id="browseProduct" class="browseProduct" style="border-left:thin; border-right:thin; border-bottom:thin;">
    
             <?php  foreach ( $data['product'] as $row ) {  ?>
 				 	<p style="background-color:#cccccc; vertical-align:middle; cursor:pointer; margin:0px; padding:0px;" onclick="getProductDetail(<?php echo $row['product_id'];?>);"><?php echo $row['product_name'];?></p><hr />
<?php /*?>                    <input type="text" name="<?php echo $row['product_id'];?>" id="<?php echo $row['product_id'];?>" class="textbox" value="<?php echo $row['product_name'];?>"  /><br/>
<?php */?>		   <?php  } ?>
    </div>
