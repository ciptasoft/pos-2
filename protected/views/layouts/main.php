<html  dir="LTL" lang="en" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>نظام إدارة الشقق المفروشة AMS | NVIS</title>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var BASHPATH='<?php echo Yii::app()->params->base_url; ?>';
var $j = jQuery.noConflict();
var csrfToken	=	'<?php echo Yii::app()->request->csrfTokenName;?>'+'='+'<?php echo Yii::app()->request->csrfToken;?>';
var csrfTokenVal = '<?php echo Yii::app()->request->csrfToken;?>';
$j(document).ready(function(){
	var msgBox	=	$j('#msgbox');
	msgBox.click(function(){
		msgBox.fadeOut();
	});
});
function confirmBox() {
	if(confirm("Are sure want to clear db?")) {
		return true;
	}
	return false;
}

function changeBG()
 {
	if($j("#password").val()=='')
	{
		$j("#password").css('background','#ffffff url(../images/##_PASSWORD_IMAGE_##) left center');
		$j("#password").css('background-repeat','no-repeat');
	}
 }
</script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "<?php echo Yii::app()->params->base_url; ?>css/css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "<?php echo Yii::app()->params->base_url; ?>js/lists/template_list.js",
		external_link_list_url : "<?php echo Yii::app()->params->base_url; ?>js/lists/link_list.js",
		external_image_list_url : "<?php echo Yii::app()->params->base_url; ?>js/lists/image_list.js",
		media_external_list_url : "<?php echo Yii::app()->params->base_url; ?>js/lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.alerts.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/jquery.alerts.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/registration.css" />
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/todooliapp/logo/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/apple-touch-icon.png" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos-admin.css" />

<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/admin-style.css"  />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-ui-1.8.13.custom.min.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />



<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine.js" type="text/javascript"></script>
</head>
<body class="body">
<script type="text/ecmascript">
	if (navigator.cookieEnabled == 0) {
	   document.write("<div class='error-area'><a href='' class='error-close'></a>You need to enable cookies for this site to load properly!</div>");
	}
</script>
<div class="main-wrapper">
  	<div class="header"  id="header">
        <div class="navigation">
            <div class="leftNavigation">
				<?php 
				if(isset(Yii::app()->session['adminUser'])){ ?>
                  <ul id="nav">
                 
                  <?php /*?><li <?php if(Yii::app()->session['current'] == 'statistics'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/statistics"; ?>">##_ADMIN_STATISTICS_##</a>
                    </li><?php */?>
                  <?php 
				  if(Yii::app()->session['type'] == 1){ 
				  ?>
                   <li <?php if(Yii::app()->session['current'] == "Client's request"){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/clientRequest"; ?>">##_ADMIN_CLIENT_REQUEST_##</a>
                    </li>
                  <?php } ?>
                   <?php 
				  if(Yii::app()->session['type'] != 2){ 
				  ?>
                  <li <?php if(Yii::app()->session['current'] == 'Client'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/client"; ?>">##_ADMIN_CLIENTS_##</a>
                    </li>
                  <?php } ?>
                   <?php 
				  if(Yii::app()->session['type'] == 2){ 
				  ?>
                  <li <?php if(Yii::app()->session['current'] == 'Users'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/clientusersForClient"; ?>">##_ADMIN_USERS_##</a>
                    </li>
                     <?php } ?>
                     <?php  if(Yii::app()->session['type'] == 2 ){  ?>
				  <li <?php if(Yii::app()->session['current'] == 'category'){?>class="current"<?php }?>>
                   <a href="<?php echo Yii::app()->params->base_path."admin/category"; ?>">##_ADMIN_CATEGORY_##</a>
                  </li>
                  <li <?php if(Yii::app()->session['current'] == 'product'){?>class="current"<?php }?>>
                  <a href="<?php echo Yii::app()->params->base_path."admin/product"; ?>">##_ADMIN_PRODUCTS_##</a>
                  </li>
                  <li <?php if(Yii::app()->session['current'] == 'stores'){?>class="current"<?php }?>>
                  <a href="<?php echo Yii::app()->params->base_path."admin/store"; ?>">##_ADMIN_STORES_##</a>
                  <ul>
    	                <li><a href="<?php echo Yii::app()->params->base_path."admin/interStoreAdjust"; ?>">##_INTER_STORE_ADJUST_##</a></li>
	             </ul>
                  </li>
                 <?php /*?> <?php  if(Yii::app()->session['adminUser'] != 2 && Yii::app()->session['adminUser'] != 1){  ?>
                    <li <?php if(Yii::app()->session['current'] == 'stock'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/stock"; ?>">Stock</a>
                    </li>
                  <?php } ?><?php */?>
                    <li <?php if(Yii::app()->session['current'] == 'supplier'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/supplier"; ?>">##_ADMIN_SUPPLIERS_##</a>
                    </li>
                    <li <?php if(Yii::app()->session['current'] == 'employees'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/employee"; ?>">##_ADMIN_EMPLOYEES_##</a>
                    </li>
                   	<li <?php if(Yii::app()->session['current'] == 'customers'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/customers"; ?>">##_ADMIN_CUSTOMERS_##</a>
                    </li>
                     <li <?php if(Yii::app()->session['current'] == 'purchase'){?>class="current"<?php }?>>
                  <a href="<?php echo Yii::app()->params->base_path."admin/InsertPurchase"; ?>">##_MODULE_PURCHASE_##</a>
                  <ul>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/InsertPurchase"; ?>">##_HEADER_PURCHASE_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/confirmPurchaseOrderFirst"; ?>">##_HEADER_GOODS_RECEIPT_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/purchaseReturn"; ?>">##_HEADER_PURCHASE_RETURN_##</a></li>
                   </ul>
                </li>
                <li style="width:85px !important; height: 15px !important;" <?php if(Yii::app()->session['current'] == 'accounts'){?>class="current"<?php }?>>
                  <a href="<?php echo Yii::app()->params->base_path."admin/generalEntryforAdmin"; ?>">##_MONEY_TRANSACTION_##</a>
                  <ul>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/generalEntryforAdmin"; ?>">##_ADMIN_GENERAL_ENTRY_##</a></li>
                    <?php /*?><li><a href="<?php echo Yii::app()->params->base_path."admin/accountGroup"; ?>">##_ADD_GROUP_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/accountMaster"; ?>">##_ADD_MASTER_##</a></li><?php */?>
                   </ul>
                </li>
                	<li <?php if(Yii::app()->session['current'] == 'reports'){?>class="current"<?php }?>>
                  <a href="<?php echo Yii::app()->params->base_path."admin/dailySalesReport"; ?>">##_ADMIN_REPORTS_##</a>
                  <ul>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/dailySalesReport"; ?>">##_ADMIN_DAILY_REPORTS_##</a></li>
                     <?php /*?><li><a href="<?php echo Yii::app()->params->base_path."admin/dailyTransactionReport"; ?>">##_ADMIN_DAILY_TRANSACTION_REPORTS_##</a></li><?php */?>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/accountsReport"; ?>">##_ADMIN_ACCOUNTS_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/purchaseReport"; ?>">##_HEADER_PURCHASE_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/shiftlisting"; ?>">##_SHFIT_LIST_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/interStoreAdjustListing"; ?>">##_INTER_STORE_ADJUST_LIST_##</a></li>

                  </ul>
                </li>
                 <?php } ?>
                     <li <?php if(Yii::app()->session['current'] == 'settings'){?>class="current"<?php }?>>
                  <a href="<?php echo Yii::app()->params->base_path."admin/myProfile"; ?>">##_ADMIN_SETTING_##</a>
                  <ul>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/myProfile"; ?>">##_ADMIN_PROFILE_##</a></li>
                    
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/changePassword"; ?>">##_ADMIN_CHANGE_PASS_##</a></li>
                    <?php  if(Yii::app()->session['type'] == 2 ){  ?>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/message"; ?>">##_ADMIN_MESSAGES_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/exportView"; ?>">##_ADMIN_EXPORT_##</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/importView"; ?>">##_ADMIN_IMPORT_##</a></li>
                     
                     <?php } ?>
                  </ul>
                </li>
                    <?php /*?><li <?php if(Yii::app()->session['current'] == 'apiFunctions'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/apiFunctions"; ?>">##_ADMIN_API_##</a>
                        <ul>
                            <li>
                                <a href="<?php echo Yii::app()->params->base_path."admin/apiFunctions"; ?>">##_ADMIN_API_FUNC_##</a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::app()->params->base_path."admin/apiModules"; ?>">##_ADMIN_API_MODULE_##</a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::app()->params->base_path."admin/cleanDB"; ?>" onClick="return confirmBox();">##_ADMIN_CLEANDB_##</a>
                            </li>
                        </ul>
                    </li><?php */?>
                <li>
                  <a href="<?php echo Yii::app()->params->base_path;?>admin/prefferedLanguage&lang=eng">##_LANGUAGE_##</a>   
					<ul>
                    <li class="selected en">
                    <a lang="en" href="<?php echo Yii::app()->params->base_path;?>admin/prefferedLanguage&lang=eng"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='eng'){  ?><strong>English</strong><?php }else { ?><span>English</span><?php } ?></a></li>
	 <li class="es"><a lang="ar" href="<?php echo Yii::app()->params->base_path;?>admin/prefferedLanguage&lang=ar"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='ar'){  ?><strong>##_ARABIC_##</strong><?php }else { ?><span>##_ARABIC_##</span><?php } ?></a>
	 				</li>
                    </ul>
                </li>
                  </ul>
                <?php } ?>
		  </div>
            <div class="rightNavigation">
            	<div class="login">
                	 <?php 
					 if( isset(Yii::app()->session['adminUser']) ) {
						 echo CHtml::beginForm(Yii::app()->params->base_path.'admin/logout','post',array('id' => 'frm','name' => 'frm')) ?>
                     <?php 
					 if( isset(Yii::app()->session['type']) && Yii::app()->session['type'] == 0 ) { ?>
                        <div class="field username"><b>##_WELCOME_## <?php echo Yii::app()->session['first_name']?> (Application Owner)</b></div>
                        <?php } else if (isset(Yii::app()->session['type']) && Yii::app()->session['type'] == 1) { ?>
                       <div class="field username"><b>##_WELCOME_## <?php echo Yii::app()->session['first_name']?> (Application Owner)</b></div>
                        <?php } else if (isset(Yii::app()->session['type']) && Yii::app()->session['type'] == 2) { ?>
                       <div class="field username"><b>##_WELCOME_## <?php echo Yii::app()->session['first_name']?>(Store Manager)</b></div>
						<?php } ?>
                          <div class="field">
                          <div>
                            <input type="submit" value="##_BTN_LOGOUT_##" class="btn" name="submit">
                          </div>
                        </div>
                    <?php 
					echo CHtml::endForm();
					 } ?>
                </div>
            </div>
            <div class="clear"></div>
		</div>
    	<?php /*?><div class="wrapper mojone-wrapper">
		  <?php if(isset(Yii::app()->session['adminUser'])){ ?>
            <div class="logo"> <a href="<?php echo Yii::app()->params->base_path;?>admin/index"><img border="0" alt="##_SITENAME_##.com" src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo.png" /></a> </div>
          <?php }else{ ?> 
            <div class="logo"> <a href="<?php echo Yii::app()->params->base_path;?>admin"><img border="0" alt="##_SITENAME_##.com" src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo.png" /></a> </div>
          <?php } ?>
            
            <div class="clear"></div>
    	</div><?php */?>
  	</div>
 
	<div class="middle">
        <div class="wrapper" style="margin:0px auto;">
            <div align="center"> 
            <?php if(Yii::app()->user->hasFlash('success')): ?>								   
            <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
            <div class="clear"></div>
            <?php endif; ?>
            <?php if(Yii::app()->user->hasFlash('error')): ?>
            <div id="msgbox" class="errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>     
            <?php endif; ?>
            </div>
            <div style="padding:10px 0px;">
                <?php echo $content; ?>
            </div>
        </div>
            <!-- Footer Part content-->
    </div>     
        <div class="clear"></div>
    
    <div class="footer-bottom">
    <div id="post-footer"><div class="site-info">POS © 2012</div></div>
    </div>

</div>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_path_language; ?>languages/eng/global.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/language_popup.js"></script>

</body>
</html>
