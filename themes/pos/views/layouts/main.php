<html>
<head>

<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>-->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>

<script src="<?php echo Yii::app()->params->base_path_language; ?>/languages/eng/global.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.alerts.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/jquery.alerts.css" type="text/css" />
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/style.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/registration.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url;?>css/custom-theme/jquery-ui-1.8.13.custom.css" />
<link href="<?php echo Yii::app()->params->base_url; ?>css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.validationEngine.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-ui-1.8.13.custom.min.js"></script>
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/apple-touch-icon.png" />
<title>##_HOME_HEADER_TITLE_NAME_##</title>

</head>
<body>
 <div id="loading" style="background-color:#6AA566;"></div>
<div id="mainWrapper">
    <?php if(!isset(Yii::app()->session['userId'])){?>
		<div class="header" id="header">
	<div class="navigation">
    	<div class="leftNavigation">        	
            <?php if(!isset(Yii::app()->session['userId'])){?>
           	 <ul>
            	<li class="current tabRef"><a href="<?php echo Yii::app()->params->base_url; ?>">##_HOME_HOME_##</a></li>
            	<li class="nav tabRef lastNav" id="howItWorks" lang=""><a href="javascript:;" id="howItWorks" lang="<?php echo Yii::app()->params->base_path;?>site/HowItWorks">##_HOME_HEADER_HOW_WORKS_##</a></li>
                <li class="nav tabRef lastNav" id="howItWorks" lang=""><a href="javascript:;" id="language" lang="<?php echo Yii::app()->params->base_path;?>site/Language">##_LANGUAGE_##</a>
                <ul>
					<li class="selected en"><a lang="en" href="<?php echo Yii::app()->params->base_path;?>site/prefferedLanguage&lang=eng"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='eng'){  ?><strong>English</strong><?php }else { ?><span>English</span><?php } ?></a></li>
	 <li class="es"><a lang="ar" href="<?php echo Yii::app()->params->base_path;?>site/prefferedLanguage&lang=ar"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='ar'){  ?><strong>Arabic</strong><?php }else { ?><span>Arabic</span><?php } ?></a>
	 				</li>
                </ul>
                </li>
                
            </ul>
            
            <?php } ?>
        </div>
    	<div class="rightNavigation">
        	<div class="login">
        	<?php
        	if(isset(Yii::app()->session['userId'])){ 
			?>
            	
                <div class="clear"></div>
            <?php
            }
			else
			{
				if(isset(Yii::app()->session['loginflag']) && Yii::app()->session['loginflag']!=1)
				{ 
			?>
            	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/login','post',array('id' => 'loginform','name' => 'loginorm',)) ?>
                    <div class="toplogin">
                        <label class="floatLeft">##_HOME_EMAIL_##:</label>
                        <div class="floatLeft">
                            <div><input tabindex="1" type="text" id="tt_email_login" name="email_login" class="textbox width130" <?php if(isset($_COOKIE['email_login']) && $_COOKIE['email_login']!='') { ?>  value="<?php echo $_COOKIE['email_login'];?>" <?php } ?> /></div>
                            <div class="checkbox1"><input type="checkbox" name="remenber" /><span>##_HOME_REMEMBER_##</span></div>
                            <div class="clear"></div>
                        </div>
                        <label class="floatLeft">##_HOME_PASSWORD_##:</label>
                        <div class="floatLeft">
                            <div><input tabindex="2"  name="password_login" id="password_login" type="password" class="textbox width130" <?php if(isset($_COOKIE['password_login']) && $_COOKIE['password_login']!='') { ?>  value="<?php echo $_COOKIE['password_login'];?>" <?php } ?>/></div>
                            <div><a href="<?php echo Yii::app()->params->base_path; ?>site/support">##_HOME_ACCESS_ACCOUNT_##</a></div>
                        </div>
                        <div class="floatLeft">
                            <input tabindex="3" type="submit" name="submit_login" class="btn" value="##_LOGIN_SIGNIN_BUTTON_##" />
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php echo CHtml::endForm(); ?> 
            <?php
				}
			}
			?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
	<?php } ?>


   
	<div id="middle" class="middle">
    
	<div class="wrapper" id="secondLayer">
    	<div id="lodingContent"></div>
		<?php echo $content; ?>
    </div>
</div>
</div>
</body>
</html>