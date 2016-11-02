<?php
error_reporting(0);
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
class UserController extends Controller
{
	public $msg;
	public $errorCode;
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
	public function beforeAction()
	{
		//exit(stop);
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
		if($this->isAjaxRequest())
		{			
			if(!$this->isLogin())
			{
				Yii::app()->user->logout();
				Yii::app()->session->destroy();
				echo "logout";
				exit;							
			}
		}
		else
		{
			//var_dump($this->isLogin());
			//exit;
			if(!$this->isLogin())
			{	
				Yii::app()->user->logout();
				Yii::app()->session->destroy();
				if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
				{					
					Yii::app()->session['todoId']=$_REQUEST['id'];
					$this->redirect(Yii::app()->params->base_path.'site/signin&todoId='.$_REQUEST['id']);
					exit;
				}
				$this->redirect(Yii::app()->params->base_path.'site');
				exit;
			}
			
		}
		return true;
	
	}
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	function actiontestInvoice()
	{
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td width="48%" rowspan="2">Your company Name
			<br />
		[Your Company Slogan]</td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">INVOICE</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">INVOICE #[100]<br /></td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: OCTOBER 9, 2011</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>TO:<br /></td>
			<td>SHIP TO:</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>[Name]</td>
			<td>[Name]</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>[Company Name]</td>
			<td>[Company Name]</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>[Street Address]</td>
			<td>[Street Address]</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>[Phone]</td>
			<td>[Phone]</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>COMMENTS OR SPECIAL INSTRUCTIONS:</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		  <tr align="center" valign="middle">
			<td><strong>SALESPERSON</strong></td>
			<td><strong>P.O. NUMBER</strong></td>
			<td><strong>REQUISITIONER</strong></td>
			<td><strong>SHIPPED VIA</strong></td>
			<td><strong>F.O.B. POINT</strong></td>
			<td><strong>TERMS</strong></td>
		  </tr>
		  <tr align="center" valign="middle">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
			<td width="20%"><strong>QUANTITY</strong></td>
			<td width="54%"><strong>DESCRIPTION</strong></td>
			<td width="16%"><strong>UNIT PRICE</strong></td>
			<td width="10%"><strong>TOTAL</strong></td>
		  </tr>
		  <tr>
			<td height="313">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
			<td colspan="3" align="right" class="noborder">SUBTOTAL<br />
			  SALES TAX<br />
			  SHIPPING &amp; HANDLING<br /></td>
			<td width="10%">&nbsp;</td>
		  </tr>
		  <tr >
			<td colspan="3" align="right" class="noborder1">TOTAL DUE</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/test.pdf", 'F');
		header('location:'.Yii::app()->params->base_url."assets/upload/pdf/test.pdf");

	}
	
	
	function actionraiseInvoice($id)
	{
		error_reporting(0);
		$ticketDetailsObj = new TicketDetails();
		$ticketData = $ticketDetailsObj->getTicketDetailWithCustomer($id);
		
		$ticketSession = Yii::app()->session['ticketData'] ;
		$ticketDescObj  = new TicketDesc();
		$productData = $ticketDescObj->getTicketsData($id);
		
		$invoiceSeriesObj = new InvoiceSeries();
		$seriesId = $invoiceSeriesObj->getSeriesNo($id);
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		//$this->renderPartial("raiseInvoice",array('ticketData'=>$ticketData,'productData'=>$productData));
		//exit;
		if($ticketData['discountType'] == 0)
		{
			$discountType = '<br/>DISCOUNT(%)';	
			$discount =  $ticketData['discount'] ;
		} 
		else
		{
			$discountType = '<br/>DISCOUNT('.Yii::app()->session['currency'].')';	
			$discount =  $ticketData['discount'] ;
		}
		
		if($ticketData['discount'] == 0)
		{
			$discountType = '';	
			$discount =  '';
		} 
		
		if($ticketData['customer_name'] != "")
		{
			$customer = 'CUSTOMER: '.$ticketData['customer_name'] ;	
			$to = 'TO,';
		}else{
			$customer = '' ;	
			$to = '';	
		}
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">INVOICE</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">INVOICE NO: '. $seriesId.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($ticketData['createdAt'])).'</td>
		  </tr>
		  
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($ticketData['createdAt'])).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="left" >'.$customer.'</td>
			<td>&nbsp;</td>
			<td align="right" >&nbsp;</td>
		  </tr>
		  
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		    <td width="5%" align="center"><strong>NO</strong></td>
			<td width="54%" align="center"><strong>PRODUCT NAME</strong></td>
			<td width="20%" align="center"><strong>UNIT PRICE</strong></td>
			<td width="15%" align="center"><strong>QUANTITY</strong></td>
			<td width="10%" align="center"><strong>TOTAL</strong></td>
		  </tr>';
		  $i = 1 ;
	foreach($productData as $row) {
        
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td height="20" align="left">'.$row['product_name'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['quantity'].'</td>
			<td align="right">&nbsp;'.$row['product_total'].'</td>
		  </tr>';
 $i++ ;   } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
		   <td colspan="3" align="right" class="noborder">SUBTOTAL <br />
			  '. $discountType .'<br /></td>
			<td width="10%" align="right">&nbsp;'. $ticketSession['total_amount'].'<br/><br/>'. $discount .'</td>
		  </tr>
		  
		  <tr >
			<td colspan="3" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
			<td align="right">&nbsp;'.$ticketData['total_amount'].'</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
			<td width="20%" align="center"><strong>Cash Payment</strong></td>
			<td width="20%" align="center"><strong>Card Payment</strong></td>
			<td width="20%" align="center"><strong>Cheque Payment</strong></td>
			<td width="20%" align="center"><strong>Credit Amount</strong></td>
			<td width="20%" align="center"><strong>Total Amount('.Yii::app()->session['currency'].')</strong></td>
		  </tr>';
		$html .=  '<tr>
			<td align="right">&nbsp;'.$ticketData['cashPayment'].'</td>
			<td height="20" align="right">'.$ticketData['cardPayment'].'&nbsp;</td>
			<td align="right">&nbsp;'.$ticketData['bankPayment'].'</td>
			<td align="right">&nbsp;'.$ticketData['creditPayment'].'</td>
			<td align="right">&nbsp;'.$ticketData['total_amount'].'</td>
		  </tr>';
		$html .= '</table>
		<p>&nbsp;</p>
		<p align="center">
		<strong>Thank you for the business.</strong>
		</p>
		</body>
		</html>';
		
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/invoice/invoice".$ticketData['invoiceId'].".pdf", 'F');
		
		unset(Yii::app()->session['ticketData']);
		$this->actionIndex();
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/invoice/invoice<?php echo $ticketData['invoiceId'];?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	function actionraiseReturnInvoice($id)
	{
		
		$salesReturnObj = new SalesReturnDetails();
		$ticketData = $salesReturnObj->getReturnTicketDetailWithCustomer($id);
		
		$salesReturnDescObj  = new SalesReturnDesc();
		$productData = $salesReturnDescObj->getTicketsData($id);
		
		$total=0;
		foreach($productData as $row)
		{
			$total += $row['return_product_total'];
		}
		
		$discountType = '<br />DISCOUNT(%)';	
		$discount =  $ticketData['return_discount'];
		
		if($ticketData['return_discount'] == 0)
		{
			$discountType = '';	
			$discount =  '';
		}
		
		if($ticketData['return_customer_id'] != "")
		{
			$customer = 'CUSTOMER: '.$ticketData['customer_name'] ;	
			$to = 'TO,';
		}
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
				
		//$this->renderPartial("raiseInvoice",array('ticketData'=>$ticketData,'productData'=>$productData));
		//exit;
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">RETURN INVOICE</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">RETURN INVOICE: '. $ticketData['sales_return_invoiceId'].'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($ticketData['return_createdAt'])).'</td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($ticketData['return_createdAt'])).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" >'.$customer.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 </table>
		<p>&nbsp;</p>
		
		<p>&nbsp;</p>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td width="5%" align="center"><strong>NO</strong></td>
			<td width="54%" align="center"><strong>PRODUCT NAME</strong></td>
			<td width="20%" align="center"><strong>UNIT PRICE</strong></td>
			<td width="16%" align="center"><strong>QUANTITY</strong></td>
			<td width="10%" align="center"><strong>TOTAL</strong></td>
		  </tr>';
		  $i =1;
	foreach($productData as $row) {
        
		$html .=  '<tr>
			<td  align="center" >'.$i.'</td>
			<td  align="left" height="20">'.$row['product_name'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['return_price'].'</td>
			<td align="right">&nbsp;'.$row['return_quantity'].'</td>
			<td align="right">&nbsp;'.$row['return_product_total'].'</td>
		  </tr>';
 $i++;   } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
			 <td colspan="3" align="right" class="noborder">SUBTOTAL<br />
			  '.$discountType.'<br /></td>
			<td width="10%"  align="right">'.$total.'<br/><br/>'. $discount.'</td>
		  </tr>
		  <tr >
			<td colspan="3" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].') </td>
			<td align="right">&nbsp;'. $ticketData['return_total_amount'].'</td>
		  </tr>
		</table>
		
		<p align="center">
		<strong>Thank you for the business.</strong>
		</p>
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/srinvoice/srinvoice".$ticketData['sales_return_invoiceId'].".pdf", 'F');
		Yii::app()->session['invoiceId'] = $ticketData['sales_return_invoiceId'];
		$this->actionIndex();
		?>
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/srinvoice/srinvoice<?php echo $ticketData['sales_return_invoiceId'];?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	function actionraisePurchaseOrder($id)
	{
		
		$purchaseObj = new Purchase();
		$purchaseData = $purchaseObj->getpurchaseDetails($id);
		
		/*echo "<pre>";
		print_r($purchaseData);
		exit;*/
		
		$purchaseOrderObj  = new PurchaseOrderDetails();
		$po_detail = $purchaseOrderObj->getpurchaseOrderData($id);
		
		//$this->renderPartial("raiseInvoice",array('ticketData'=>$ticketData,'productData'=>$productData));
		//exit;
		
		if($po_detail['supplier_name'] != "")
		{
			$supplier = 'SUPPLIER: '.$po_detail['supplier_name'] ;
			$to = 'TO,'	;
		}
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2">'.$adminObj->company_name.'</td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right" style="margin-right:20px;"><h1> <font color="#808080">PURCHASE ORDER</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">PURCHASE ORDER: '. $id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($po_detail['created'])).'</td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($po_detail['created'])).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" >'.$supplier.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td align="center" width="5%"><strong>NO</strong></td>
			<td align="center" width="50%"><strong>NAME</strong></td>
			<td align="center" width="10%"><strong>UNIT PRICE</strong></td>
			<td align="center" width="10%"><strong>QUANTITY</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  $i=1;
	foreach($purchaseData as $row) {
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">'.$row['quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>';
   $i++; } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
			<td colspan="3" align="right" class="noborder"></td>
			<td width="12%">&nbsp;</td>
		  </tr>
		  <tr >
			<td colspan="3" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
			<td align="right">&nbsp;'.$po_detail['total_amount'].'</td>
		  </tr>
		</table>
		
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/purchaseOrder/purchaseOrder".$id.".pdf", 'F');
		Yii::app()->session['invoiceId'] = $ticketData['sales_return_invoiceId'];
		?>
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/purchaseOrder/purchaseOrder<?php echo $id;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	function actionraisePurchaseReturnOrder($id)
	{
		
		$purchaseReturnObj = new PurchaseReturn();
		$purchaseData = $purchaseReturnObj->getpurchaseReturnDetails($id);
		
		
		
		$purchaseOrderReturnObj  = new PurchaseReturnDetails();
		$po_detail = $purchaseOrderReturnObj->getpurchaseReturnData($id);
		
		/*echo "<pre>";
		print_r($purchaseData);
		print_r($po_detail);
		exit;*/
		if($po_detail['supplier_name'] != "")
		{
			$supplier = 'SUPPLIER: '.$po_detail['supplier_name'] ;
			$to = 'TO,'	;
		}
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		//$this->renderPartial("raiseInvoice",array('ticketData'=>$ticketData,'productData'=>$productData));
		//exit;
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2">'.$adminObj->company_name.'</td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right" style="margin-right:20px;"><h1> <font color="#808080">PURCHASE RETURN</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">PURCHASE RETURN '. $id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '.date('F d, Y',strtotime($po_detail['created'])).'</td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($po_detail['created'])).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$supplier.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td align="center" width="5%"><strong>NO</strong></td>
			<td align="center" width="50%"><strong>NAME</strong></td>
			<td align="center" width="10%"><strong>UNIT PRICE</strong></td>
			<td align="center" width="10%"><strong>QUANTITY</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		$i=1;  
	foreach($purchaseData as $row) {
        
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td height="20" align="left">&nbsp;'.$row['product_name'].'</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right" >'.$row['quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>';
  $i++;  } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
			<td colspan="3" align="right" class="noborder">&nbsp;</td>
			<td width="12%">&nbsp;</td>
		  </tr>
		  <tr >
			<td colspan="3" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
			<td align="right">&nbsp;'. $po_detail['total_return_amount'].'</td>
		  </tr>
		</table>
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/purchaseReturn/purchaseReturn".$id.".pdf", 'F');
		Yii::app()->session['invoiceId'] = $ticketData['sales_return_invoiceId'];
		?>
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/purchaseReturn/purchaseReturn<?php echo $id;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		$this->actionIndex();
		
		
	}
	
	function actiongetPdfFile()
	{
		$invoiceId = Yii::app()->session['invoiceId'];
		$this->redirect(Yii::app()->params->base_url."assets/upload/invoice/invoice".$ticketData['invoiceId'].".pdf");
	}
	
	
	function actiontestpdf()
	{
		$html = "<table cellpadding='5' cellspacing='5' border='0'>
	<tr>
    	<td colspan='4' align='center' style='background-color:#000; color:#FFF;'><b>NVIS PoS</b></td>
    </tr>
    <tr>
    	<td colspan='4'>&nbsp;</td>
    </tr>
	<tr>
    	<td colspan='4' align='center'><b>Shift End Report</b></td>
    </tr>
    <tr bgcolor='#FFFF99'>
    	<td>No.</td>
    	<td>Particulars</td>
    	<td>Amount*</td>
    	<td></td>
    </tr>
	<tr>
    	<td>1</td>
    	<td><b>Opening Cash in Cash Counter</b></td>
    	<td><b>500</b></td>
    	<td>+</td>
    </tr>
	<tr>
    	<td>2</td>
    	<td><b>Sales:</b></td>
    	<td></td>
    	<td></td>
    </tr>
        <tr>
            <td></td>
            <td>Cash</td>
            <td>14500</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit Card</td>
            <td>11000</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit</td>
            <td>5000</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td align='right'><b>TOTAL SALES</b></td>
            <td><b>30500</b></td>
            <td>+</td>
        </tr>
	<tr>
    	<td>3</td>
    	<td><b>Sales Return:</b></td>
    	<td></td>
    	<td></td>
    </tr>
        <tr>
            <td></td>
            <td>Cash</td>
            <td>500</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit Card</td>
            <td>300</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit</td>
            <td>0</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td align='right'><b>TOTAL SALES RETURN</b></td>
            <td><b>800</b></td>
            <td>-</td>
        </tr>
	<tr>
    	<td>4</td>
    	<td><b>Safe Vault:</b></td>
    	<td></td>
    	<td></td>
    </tr>
        <tr>
            <td></td>
            <td>Cash Withdraw</td>
            <td>0</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Cash Deposit</td>
            <td>12000</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td align='right'><b>TOTAL DROPPED IN SAFE</b></td>
            <td><b>12000</b></td>
            <td>-</td>
        </tr>
	<tr>
    	<td>5</td>
    	<td><b>Closing Balance in Cash Counter:</b></td>
    	<td></td>
    	<td></td>
    </tr>
        <tr>
            <td></td>
            <td>Cash Balance</td>
            <td>2000</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit Card Balance</td>
            <td>10700</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit Balance</td>
            <td>5000</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td align='right'><b>TOTAL CLOSING BALANCE</b></td>
            <td><b>17700</b></td>
            <td></td>
        </tr>
</table>";

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/test.pdf", 'F');
		header('location:'.Yii::app()->params->base_url."assets/upload/pdf/test.pdf");
		//$mpdf->Output("test.pdf", 'F');
	}
	
	function isLogin()
	{
	   
	 // echo Yii::app()->session['userId'];
		if(!Yii::app()->session['userId']){
			//exit("if");
			Yii::app()->session->destroy();
			return false;
		}else{
			
			$userId=Yii::app()->session['userId'];	
			$user=new Users();
			$data=$user->getUserId($userId);
			//print_r($data);
			if(!$data)
			{
				//exit("In else");
				Yii::app()->session->destroy();
				return false;			
			}
			return true;
		}
	
	}
	
	public function actionIndex()
	{
			//echo '<pre>';print_r($myLists);exit;
			$algo=new Algoencryption();
			$imageDir=$algo->encrypt("USER_".Yii::app()->session['userId']);
			$invoiceId=1;
			$ticketsObj = new TicketDetails();
			$id = $ticketsObj->getinvoiceId();
			
			$ticketsObj = new TicketDetails();
			$salesCount = $ticketsObj->getDailyTotalSalesCount();
			
			$ticketsObj = new TicketDetails();
			$pendingCount = $ticketsObj->getDailyPendingTotalSalesCount();
			
			$ticketsObj = new TicketDetails();
			$returnCount = $ticketsObj->getDailyReturnTotalSalesCount();
			
			$messageObj = new Messages();
			$messageCount = $messageObj->getNewMessageCount();
			if(empty($messageCount) || $messageCount == 0 || $messageCount == " ")
			{
				$messageCount = '0' ;
			}
			
			
			if(!empty($id) && $id!='')
			{
				$invoiceId = $id  ; 	
			}
			else
			{
				$invoiceId = 1;	
			}
			if($this->isAjaxRequest())
			{	
				$this->renderPartial('home',array("isAjax"=>'true','invoiceId'=>$invoiceId,'salesCount'=>$salesCount,'pendingCount'=>$pendingCount,'returnCount'=>$returnCount,'messageCount'=>$messageCount));
			}
			else
			{
				$this->render('home',array("isAjax"=>'false','invoiceId'=>$invoiceId,'salesCount'=>$salesCount,'pendingCount'=>$pendingCount,'returnCount'=>$returnCount,'messageCount'=>$messageCount));
			}
	}
	
	public function actionWelcome()
	{
		//echo "User controller";
		//exit;
		if(isset($_POST['submit']))
		{			
			$data['cashier_id']	=$_POST['cashier_id'];
			$data['cash_in']=$_POST['cash_in'];
			$data['cash_out']	=$_POST['cash_out'];
			$data['time_in']=date('Y-m-d:H-m-s');
			
			$shiftObj = new Shift();
			$shiftObj->setData($data);
			$lastId = $shiftObj->insertData();
			
			Yii::app()->session['lastId'] = $lastId;
			Yii::app()->session['shiftId'] = $lastId;
			Yii::app()->session['cash_in'] = $_POST['cash_in'];
			if($this->isAjaxRequest())
			{	
				header('location:'.Yii::app()->params->base_path.'user/index');
				exit;
			}
			else
			{
				header('location:'.Yii::app()->params->base_path.'user/index');
				exit;
			}
		}
		elseif(!isset(Yii::app()->session['shiftId']))
		{			
			if($this->isAjaxRequest())
			{	
				$this->renderPartial('welcome',array("isAjax"=>'true'));
			}
			else
			{
				$this->render('welcome',array("isAjax"=>'false'));
			}			
		}
		else
		{
			$this->redirect(Yii::app()->params->base_path.'user/index');
		}
	}
	
	public function actionVault()
	{
		if(isset($_POST['deposite']))
		{			
			$data['cashier_id']	=Yii::app()->session['userId'];
			$data['deposite']=$_POST['deposite'];
			$data['withdraw']=$_POST['withdraw'];
			$data['shift_id']=Yii::app()->session['shiftId'];
			//$data['time']= time(); 
			$data['date']=date('Y-m-d');

			$vaultObj = new Vault();
			$vaultObj->setData($data);
			$lastId = $vaultObj->insertData();

			if($this->isAjaxRequest())
			{	
				Yii::app()->user->setFlash('success',$this->msg['_RECORD_INSERT_SUCCESS_']);
				$this->renderPartial('vault',array("isAjax"=>'true'));
				exit;
				header('location:'.Yii::app()->params->base_path.'user/Vault');
				exit;
			}
			else
			{
				Yii::app()->user->setFlash('success',$this->msg['_RECORD_INSERT_SUCCESS_']);
				$this->render('vault',array("isAjax"=>'false'));
				exit;
				header('location:'.Yii::app()->params->base_path.'user/Vault');
				exit;
			}
		}
		else
		{			
			if($this->isAjaxRequest())
			{	
				$this->renderPartial('vault',array("isAjax"=>'true'));
			}
			else
			{
				$this->render('vault',array("isAjax"=>'false'));
			}			
		}
	}
	
	public function actionsubmitTicket($invoiceId=NULL)
	{
		$ticketData = Yii::app()->session['ticketData'];
		$invoiceId = $ticketData['invoiceId'];
		
		$ticketDescObj = new TicketDesc();
		$total_item = $ticketDescObj->getTotalProduct($invoiceId);
		
		$userObj = new Users();
		$userData = $userObj->getUserById(Yii::app()->session['userId']);
		
		$data['customer_id']=$ticketData['customer_id'];
		$data['discount']	=$_REQUEST['discount'];
		$data['userId'] = Yii::app()->session['userId'];
		$data['modifiedAt']=date('Y-m-d:H-m-s');
		$data['total_quantity']	=$ticketData['total_quantity'];
		$data['total_item']= $total_item;
		$data['shift_id']= Yii::app()->session['shiftId'];
		$data['store_id']= $userData['store_id'];
		$data['admin_id']= $userData['admin_id'];
		$data['total_amount']	= $_REQUEST['totalAmount'];
		$data['cashPayment']=$_REQUEST['cashAmount'];
		$data['cardPayment']=$_REQUEST['cardAmount'];
		$data['bankPayment']=$_REQUEST['bankAmount'];
		$data['creditPayment']=$_REQUEST['crediteAmount'];
		$data['paymentType']=$_REQUEST['paymentType'];
		$data['status']= 1 ;
		$invoiceId = $ticketData['invoiceId'];
		$ticketsObj = new TicketDetails();
		$ticketsObj->setData($data);
		$ticketsObj->insertData($invoiceId);
		
		if($data['creditPayment'] != "" && $data['customer_id'] != "")
		{
			$customer['customer_id'] = $data['customer_id'];
			$customer['credit'] = $data['creditPayment'];
			$customer['modifiedAt']=date('Y-m-d:H-m-s');
			
			$customerObj = new Customers();
			$customerObj->updateCustomerCredit($customer['customer_id'],$customer['credit'],$customer['modifiedAt']);
			$customerGeneral['customer_id'] = $data['customer_id'];
			$customerGeneral['admin_id'] = $userData['admin_id'];
			$customerGeneral['store_id'] = $userData['store_id'];
			$customerGeneral['credit'] = $data['creditPayment'];
			$customerGeneral['paymentType'] = 0 ;
			$customerGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$customerGeneralObj = new CustomerGeneralEntry();
			$customerGeneralObj->setData($customerGeneral);
			$receiptId = $customerGeneralObj->insertData();
		}
		
		$invoiceSeriesObj = new InvoiceSeries();
		$seriesId = $invoiceSeriesObj->getLastSeriesNo();
		
		if(empty($seriesId) || $seriesId == 0)
		{
			$seriesNo = 1 ;
		}
		else
		{
			$seriesNo = $seriesId + 1;	
		}
		
		
		$series['userId'] = Yii::app()->session['userId'];
		$series['invoiceId'] = $invoiceId;
		$series['seriesNo'] = $seriesNo ;
		$series['invoiceNo'] = Yii::app()->session['userId'].date('Y').$seriesNo;
		$series['createdAt']=date('Y-m-d:H-m-s');
		
		$invoiceSeriesObj = new InvoiceSeries();
		$invoiceSeriesObj->setData($series);
		$invoiceSeriesObj->insertData();
		
		
		
		
		/*$general['admin_id']= $userData['admin_id'];
		$general['store_id']= $userData['store_id'];
		$general['amount'] = $data['total_amount'] ;
		$general['credit'] = '4' ;
		$general['debit'] = '0' ;
		$general['created']=date('Y-m-d:H-m-s');
		
		$generalEntryObj = new GeneralEntryAccount();
		$generalEntryObj->setData($general);
		$generalEntryObj->insertData();
		
		$accountMasterObj = new AccountMaster();
		$accountMasterObj->updateAccount($general['credit'],$general['amount']);*/
		
		echo $invoiceId;
			
	}
	
	
	public function actiondiscardTicket()
	{
			$res['invoiceId']=$_REQUEST['invoiceId'];
			
			$ticketdescObj = new TicketDesc();
			$data = $ticketdescObj->getTickets($_REQUEST['invoiceId']);
			
			$ticketdescObj = new TicketDesc();
			$ticketdescObj->deletebyInvoiceId($_REQUEST['invoiceId']);
			
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			foreach ($data as $row){
				$row['modified'] = date('Y-m-d:H-m-s');
				$row['store_id'] = $userData['store_id'];
				$stockObj = new Stock();
				$stockObj->updateStockForSalesReturn($row['product_id'],$row['quantity'],$row['modified'],$row['store_id']);
 			}
			
			$id=TicketDetails::model()->findbyPk($_REQUEST['invoiceId']);

			if(!empty($id))
			{
				$ticketsObj = new TicketDetails();
				$id = $ticketsObj->deleteTicket($_REQUEST['invoiceId']);
			}
			
			Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_DISCARD_SUCCESS_']);
			/*header('location:'.Yii::app()->params->base_path.'user/browseproduct');*/
			echo true;
			
	}
	
	public function actionsubmitPendingTicket($invoiceId=NULL)
	{
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$data['customer_id']=$_REQUEST['customer_id'];
			$data['admin_id']= $userData['admin_id'];
			$data['store_id']= $userData['store_id'];
			$data['discount']	=$_REQUEST['discount'];
			$data['modifiedAt']=date('Y-m-d:H-m-s');
			$data['shift_id']= Yii::app()->session['shiftId'];
			$data['casher']	= Yii::app()->session['fullname'];
			$data['total_quantity']	=$_REQUEST['total_quantity'];
			$data['total_item']=$_REQUEST['total_item'];
			$data['creditPayment']=$_REQUEST['creditPayment'];
			$data['total_amount']	=$_REQUEST['totalPayable'];
			$data['cashPayment']=$_REQUEST['cashPayment'];
			$data['status']= 0 ;
			$invoiceId = $_REQUEST['invoiceId'];
			$ticketsObj = new TicketDetails();
			$ticketsObj->setData($data);
			$ticketsObj->insertData($invoiceId);
			
			if($this->isAjaxRequest())
			{	
				Yii::app()->user->setFlash('success',$this->msg['_TICKET_PENDING_']);
				/*header('location:'.Yii::app()->params->base_path.'user/browseproduct');*/
				echo true;
			}
			else
			{
				Yii::app()->user->setFlash('success',$this->msg['_TICKET_PENDING_']);
				/*header('location:'.Yii::app()->params->base_path.'user/browseproduct');*/
				echo true;
			}
	}
	
	function actionCheckStockDetail()
	{
		$userObj = new Users();
		$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
		$quantity1 = $_REQUEST['quantity'];
		$quantity2 = $_REQUEST['quntityOld'];
		$quantity = $quantity1 - $quantity2 ;
		
		$stockObj = new Stock();
		$result = $stockObj->checkStockDetail($_REQUEST['productId'],$userData['store_id']);
		
		if(empty($result) ||  $result['quantity'] < $quantity)
		{
			echo 0 ;
			exit;
		}
		else
		{
			echo 1 ;
			exit;
		}
	}
	
	function actiongetStockDetail()
	{
		$userObj = new Users();
		$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
		$stockObj = new Stock();
		$result = $stockObj->checkStockDetail($_REQUEST['productId'],$userData['store_id']);
		
		echo $result['quantity'];
	}
	
	public function actionsubmitProductdesc()
	{
			//error_reporting(E_ALL);
			/*echo "<pre>";
			print_r($_REQUEST);
			exit;*/
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$data['invoiceId']=$_REQUEST['invoiceId'];
			$data['product_id']	=$_REQUEST['productId'];
			$data['price']	=$_REQUEST['productPrice'];
			$data['admin_id']	=$userData['admin_id'];
			$data['store_id']	=$userData['store_id'];
			$data['quantity']	=$_REQUEST['quntity'];
			$data['date_add']=date('Y-m-d:H-m-s');
			$data['discount']	=$_REQUEST['discount'];
			$data['product_total']	=$_REQUEST['total1'];
			$quantity1 = $_REQUEST['quntity'];
			$quantity2 = $_REQUEST['quntityOld'];
			$quantity = $quantity1 - $quantity2;
			
			/*$stockObj = new Stock();
			$result = $stockObj->checkStockDetail($data['product_id'],$userData['store_id']);
			
			if(empty($result) || $result['quantity'] == 0 || $result['quantity'] < $quantity)
			{
				echo 0 ;
				exit;
			}
			else
			{*/
			$stock['product_id'] = $_REQUEST['productId'];
			$stock['quantity']	= $quantity;
			$stock['modified'] = date("Y-m-d H:i:s");
			
			$stockObj = new Stock();
			$stockObj->updateStockForProductDesc($stock['product_id'],$stock['quantity'],$stock['modified'],$userData['store_id']);			
			
			$ticketsDescObj = new TicketDesc();
			$res = $ticketsDescObj->checkTicket($_REQUEST['invoiceId'],$_REQUEST['productId']);
							
			if(empty($res))
			{
				$ticketsDescObj = new TicketDesc();
				$ticketsDescObj->setData($data);
				$insertedId = $ticketsDescObj->insertData();
			}
			else
			{
				
				$ticketsDescObj = new TicketDesc();
				$ticketsDescObj->setData($data);
				$insertedId = $ticketsDescObj->insertData($res['id']);
			}
			echo true;
			exit;
			//}
	}
	
	public function actionsubmitProductdescOLD()
	{
			//error_reporting(E_ALL);
			$data['invoiceId']=$_REQUEST['invoiceId'];
			$data['product_id']	=$_REQUEST['productId'];
			$data['quantity']	=$_REQUEST['quntity'];
			$data['date_add']=date('Y-m-d:H-m-s');
			$data['discount']	=$_REQUEST['discount'];
			$data['product_total']	=$_REQUEST['total1'];
			
			$ticketsDescObj = new TicketDesc();
			$res = $ticketsDescObj->checkTicket($_REQUEST['invoiceId'],$_REQUEST['productId']);
			
						
			if(empty($res))
			{
				$ticketsDescObj = new TicketDesc();
				$ticketsDescObj->setData($data);
				$insertedId = $ticketsDescObj->insertData();
			}
			else
			{
				
				$ticketsDescObj = new TicketDesc();
				$ticketsDescObj->setData($data);
				$insertedId = $ticketsDescObj->insertData($res['id']);
			}
				/*$stockObj = new Stock();
                $result = $stockObj->getStockDetailbyProductId($_REQUEST['productId']);*/
				
				$quantity1 = $_REQUEST['quntity'];
				$quantity2 = $_REQUEST['quntityOld'];
				$quantity = $quantity1 - $quantity2;

				$stock['product_id'] = $_REQUEST['productId'];
				$stock['quantity']	= $quantity;
				$stock['modified'] = date("Y-m-d H:i:s");
				
				$stockObj = new Stock();
                $stockObj->updateStock($stock['product_id'],$stock['quantity'],$stock['modified']);
			echo true;
			
	}
	
	public function actiondeleteProductdesc()
	{
		
			$data['invoiceId']=$_REQUEST['invoiceId'];
			$data['product_id']	=$_REQUEST['productId'];
			$data['quantity']	=$_REQUEST['quntity'];
			$data['modified'] = date("Y-m-d H:i:s");

			$ticketsDescObj = new TicketDesc();
			$res = $ticketsDescObj->deleteRecord($_REQUEST['invoiceId'],$_REQUEST['productId']);
			
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$stockObj = new Stock();
			$stockObj->updateStockForSalesReturn($data['product_id'],$data['quantity'],$data['modified'],$userData['store_id']);
			
			echo true;			
			
			
	}
	
	public function actionaddProductdescForReturn()
	{
			$sales_return_invoiceId=1;
			$salesReturnDetailObj = new SalesReturnDetails();
			$id = $salesReturnDetailObj->getinvoiceId();
			if(!empty($id) && $id!='')
			{
				$sales_return_invoiceId = $id + 1; 	
			}
			else
			{
				$sales_return_invoiceId = 1;	
			}
		
			$data['sales_return_invoiceId']=$sales_return_invoiceId;
			$data['return_product_id']	=$_REQUEST['productId'];
			$data['return_quantity']	=$_REQUEST['quntity'];
			$data['return_product_total']	=$_REQUEST['total'];
			$data['return_date'] = date("Y-m-d H:i:s");
			
			
			$salesReturnDescObj = new SalesReturnDesc();
			$salesReturnDescObj->setData($data);
			$salesReturnDescObj->insertData();
			
			/*$stockObj = new Stock();
            $stockObj->updateStockQuantity($data['product_id'],$data['quantity'],$data['modified']);*/			
			echo true;			
			
			
	}
	
	public function actionticketDescriptionNew($invoiceId)
	{
		error_reporting(0);
		$rating = '';
		if(isset($_REQUEST['rating']))
		{
			$rating = $_REQUEST['rating'];
		}
		
		if(isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] != "")
		{
			$invoice['customer_id'] = $_REQUEST['customer_id'] ;
			
			$ticketdetailObj = new TicketDetails();
			$ticketdetailObj->setData($invoice);
			$ticketdetailObj->insertData($invoiceId);
		}
		
		$ticketdescObj	=	new TicketDesc();
		$ticket	=	$ticketdescObj->getTicketsData($invoiceId);

		$ticketObj	=	new TicketDetails();
		$result	=	$ticketObj->getTicketDetails($invoiceId); 
		
		
		
		
		$totalAmount = 0 ;
		foreach($ticket as $row)
		{ 
			$totalAmount = $totalAmount + $row['product_total'];
		}
		/*echo "Sum = ".$totalAmount ;
		
		echo "test";
		echo "<pre>";
		print_r($ticket);
		print_r($result);
		exit;*/
				
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProduct();
		$this->renderPartial('browseproductWithTicketDesc', array('ticket'=>$ticket,'result'=>$result,'res'=>$res,'invoiceId'=>$invoiceId,'totalAmount'=>$totalAmount,'rating'=>$rating));
	}
	
	public function actionticketDescription($invoiceId=NULL)
	{
		$invoiceId = $_REQUEST['invoiceId'];
		$ticketdescObj	=	new TicketDesc();
		$ticket	=	$ticketdescObj->getTicketsData($invoiceId);
		
		if(isset($_REQUEST['rating']))
		{
			$rating = $_REQUEST['rating'];
		}
		if(isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] != "")
		{
			$invoice['customer_id'] = $_REQUEST['customer_id'] ;
			
			$ticketdetailObj = new TicketDetails();
			$ticketdetailObj->setData($invoice);
			$ticketdetailObj->insertData($invoiceId);
		}
		
		if(empty($ticket))
		{
			$invoiceId=1;
			$ticketsObj = new TicketDetails();
			$id = $ticketsObj->getinvoiceId();
			if(!empty($id) && $id!='')
			{
				$invoiceId = $id; 	
			}
			else
			{
				$invoiceId = 1;	
			}
			Yii::app()->user->setFlash('error',$this->msg['_PLEASE_ENTER_CORRECT_INVOICE_']);
			$productObj = new Product();
			$res = $productObj->getAllPaginatedProduct();
			$this->renderPartial('browseproductWithTicketDesc', array('ticket'=>$ticket,'result'=>$result,'res'=>$res,'invoiceId'=>$invoiceId,'totalAmount'=>$totalAmount,'rating'=>$rating));
			/*echo "Sum = ".$totalAmount ;
			exit;*/
		}

		$ticketObj	=	new TicketDetails();
		$result	=	$ticketObj->getTicketDetails($_REQUEST['invoiceId']); 
		
		/*echo "<pre>";
		print_r($ticket);
		print_r($result);
		exit;*/
		
		$totalAmount = 0 ;
		foreach($ticket as $row)
		{ 
			$totalAmount = $totalAmount + $row['product_total'];
		}
		
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProduct();
		$this->renderPartial('browseproductWithTicketDesc', array('ticket'=>$ticket,'result'=>$result,'res'=>$res,'invoiceId'=>$invoiceId,'totalAmount'=>$totalAmount,'rating'=>$rating));
	}
	
	public function actionticketDescriptionForSalesReturn()
	{
		$invoiceSeriesObj = new InvoiceSeries();
		$id = $invoiceSeriesObj->getInvoiceId($_REQUEST['invoiceId']);
		$invoiceSeriesId = $_REQUEST['invoiceId'];

		if(empty($id))
		{
			echo '0' ;
			exit;
		}
		
		$invoiceId = $id;
		
/*---------------------Delete Old Sales Return Ticket Start---------------------------------------*/	
		$returnTicketObj	=	new SalesReturnDesc();
		$returnTicketData	=	$returnTicketObj->getTicketbyInvoiceId($invoiceId); 
		
		if(!empty($returnTicketData))
		{
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			foreach ($returnTicketData as $row)
			{
				$row['modified'] = date('Y-m-d:H-m-s');
				$row['store_id'] = $userData['store_id'];
				$stockObj = new Stock();
				$stockObj->updateStockForProductDesc($row['return_product_id'],$row['return_quantity'],$row['modified'],$row['store_id']);
 			}
			
			$returnTicketObj	=	new SalesReturnDesc();
			$deleteId	=	$returnTicketObj->deleteRecord($invoiceId);
		}
			
/*---------------------Delete Old Sales Return Ticket Finish---------------------------------------*/
		
		$ticketObj	=	new TicketDetails();
		$ticketdata	=	$ticketObj->checkTicket($invoiceId); 
		
		
		$ticketdescObj	=	new TicketDesc();
		$ticket	=	$ticketdescObj->getTicketsDataForSalesReturn($invoiceId);
		
		if(empty($ticket))
		{
			echo '0' ;
			exit;
		}

		$ticketObj	=	new TicketDetails();
		$result	=	$ticketObj->getTicketDetailWithCustomer($invoiceId); 
		/*echo "<pre>";
		print_r($result);
		print_r($ticket);
		exit;*/
		$totalAmount = 0 ;
		foreach($ticket as $row)
		{ 
			$totalAmount = $totalAmount + $row['product_total'];
		}
		/*echo "Sum = ".$totalAmount ;
		exit;*/
		
		$sales_return_invoiceId = $invoiceId ;
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProduct();
		$this->renderPartial('salesReturnWithTicketDesc', array('ticket'=>$ticket,'result'=>$result,'res'=>$res,'invoiceId'=>$invoiceId,'totalAmount'=>$totalAmount,'sales_return_invoiceId'=>$sales_return_invoiceId,'invoiceSeriesId'=>$invoiceSeriesId));
	}
	
	public function actionsubmitReturnProductdesc()
	{
			//error_reporting(E_ALL);
			$data['sales_return_invoiceId']=$_REQUEST['sales_return_invoiceId'];
			$data['return_product_id']	=$_REQUEST['productId'];
			$data['return_quantity']	=$_REQUEST['removedQuntity'];
			$data['return_price']	=$_REQUEST['productPrice'];
			$data['return_date']=date('Y-m-d:H-m-s');
			$data['return_discount']	=$_REQUEST['discount'];
			$data['return_product_total']	=$_REQUEST['removePrice'];
			
			$salesReturnDesc = new SalesReturnDesc();
			$id = $salesReturnDesc->checkTicket($data['sales_return_invoiceId'],$data['return_product_id']);

			if(!empty($id))
			{
				$salesReturnDesc = new SalesReturnDesc();
				$salesReturnDesc->setData($data);
				$insertedId = $salesReturnDesc->insertData($id['sales_desc_id']);
			}
			
			else
			{
				$salesReturnDesc = new SalesReturnDesc();
				$salesReturnDesc->setData($data);
				$insertedId = $salesReturnDesc->insertData();
			}
			
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$quantity1 = $_REQUEST['quntity'];
			$quantity2 = $_REQUEST['quntityOld'];
			$quantity = $quantity2 - $quantity1;

			$stock['product_id'] = $_REQUEST['productId'];
			$stock['quantity']	= $quantity;
			$stock['store_id']	= $userData['store_id'];
			$stock['modified'] = date("Y-m-d H:i:s");
			
			$stockObj = new Stock();
			$stockObj->updateStockForSalesReturn($stock['product_id'],$stock['quantity'],$stock['modified'],$stock['store_id']);
			echo true;
			
	}
	
	function actiongetReturnInvoice()
	{
		$id = $_REQUEST['sales_return_invoiceId'];
		$salesReturnDescObj  = new SalesReturnDesc();
		$productData = $salesReturnDescObj->getTicketsData($id);
		
		$total=0;
		foreach($productData as $row)
		{
			$total += $row['return_product_total'];
		}
		
		echo $total ;
	}
	
	function actionsubmitSalesReturnTicket()
	{
			$sales_return_invoiceId = $_REQUEST['sales_return_invoiceId'];
			$salesReturnDesc = new SalesReturnDesc();
			$ticketData = $salesReturnDesc->getTicketbyInvoiceId($sales_return_invoiceId);
			
			if(empty($ticketData))
			{
				echo 0 ;
				exit;	
			}
			
			$invoiceId = $_REQUEST['invoiceId'];
			$result['sales_return_invoiceId'] = $sales_return_invoiceId ;
			$result['status'] = 2 ;
			$result['modifiedAt'] = date('Y-m-d:H-m-s') ;
			$ticketDetailsObj = new TicketDetails();
			$ticketDetailsObj->setData($result);
			$ticketDetailsObj->insertData($invoiceId);
			
			$total=0;
			foreach($ticketData as $row)
			{
				$total += $row['return_product_total'];
			}
			
			$salesReturnDesc = new SalesReturnDesc();
			$return_total_item = $salesReturnDesc->getTotalReturnProduct($sales_return_invoiceId);
			
			$data['userId']= Yii::app()->session['userId'];
			$data['sales_return_invoiceId'] = $sales_return_invoiceId;
			$data['return_total_item'] = $return_total_item;
			$data['return_customer_id']=$_REQUEST['customer_id'];
			$data['shift_id']= Yii::app()->session['shiftId'];
			$data['return_createdAt']=date('Y-m-d:H-m-s');
			$data['return_casher']	= Yii::app()->session['fullname'];
			$data['return_total_amount']=$_REQUEST['returnAmount'];
			$data['return_discount']=$_REQUEST['discount'];
			$data['return_discountType']=$_REQUEST['discountType'];
			
			$salesReturnDetailObj = new SalesReturnDetails();
			$salesReturnDetailObj->setData($data);
			$insertedId = $salesReturnDetailObj->insertData();
			
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$general['debit'] = '3';
			$general['credit'] = '0';
			$general['amount'] = $data['return_total_amount'] ;
			$general['admin_id'] = $userData['admin_id'] ;
			$general['store_id']= $userData['store_id'];
			$general['created']=date('Y-m-d:H-m-s');
			
			$generalEntryObj = new GeneralEntryAccount();
			$generalEntryObj->setData($general);
			$generalEntryObj->insertData();
			
			$accountMasterObj = new AccountMaster();
			$accountMasterObj->updateAccount($general['debit'],$general['amount']);

			
			echo $sales_return_invoiceId;
			
	}
	
	public function actiondiscardSalesReturnTicket()
	{
			$res['invoiceId']=$_REQUEST['invoiceId'];
			$res['sales_return_invoiceId']=$_REQUEST['sales_return_invoiceId'];
			
			$ticketdescObj = new SalesReturnDesc();
			$data = $ticketdescObj->getTicketbyInvoiceId($_REQUEST['sales_return_invoiceId']);
			
			$ticketdescObj = new SalesReturnDesc();
			$ticketdescObj->deletebyInvoiceId($_REQUEST['sales_return_invoiceId']);
			
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			foreach ($data as $row){
				$row['modified'] = date('Y-m-d:H-m-s');
				$row['store_id'] = $userData['store_id'];
				$stockObj = new Stock();
				$stockObj->updateStockForProductDesc($row['return_product_id'],$row['return_quantity'],$row['modified'],$row['store_id']);
 			}
			
			$ticketObj = new SalesReturnDetails();
			$id = $ticketObj->getReturnTicketDetails($_REQUEST['sales_return_invoiceId']);

			if(!empty($id))
			{
				$ticketsObj = new SalesReturnDetails();
				$id = $ticketsObj->deleteTicket($_REQUEST['invoiceId']);
			}
			
			Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_DISCARD_SUCCESS_']);
			/*header('location:'.Yii::app()->params->base_path.'user/browseproduct');*/
			echo true;
			
	}
	
	public function actionaddDiscount()
	{
		
			$invoiceId = $_REQUEST['invoiceId'];
			$data = array();
			$data['discount']	= $_REQUEST['upc_code'];
			$data['discountType']	= $_REQUEST['discountType'];
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$ticketsObj = new TicketDetails();
			$ticketsObj->setData($data);
			$res = $ticketsObj->insertData($invoiceId);
					
			echo $res;			
			
			
	}
	
	function actionBrowseProduct()
	{
		error_reporting(E_ALL);	
		$ticketsObj = new TicketDetails();
		$ticketData = $ticketsObj->getInvoiceIdWithStatus();
		
		
		if(!empty($ticketData) && $ticketData['status'] != 3 )
		{
			$result['userId'] = Yii::app()->session['userId'];
			$result['casher'] = Yii::app()->session['fullname'];
			$result['createdAt'] = date("Y-m-d H:i:s");
			$result['status'] = 3;
			$ticketsObj = new TicketDetails();
			$ticketsObj->setData($result);
			$invoiceId = $ticketsObj->insertData();
			
			$ids['userId'] = Yii::app()->session['userId'];
			$ids['invoiceId'] = $invoiceId;
			$invoiceIdsObj = new Invoiceids();
			$invoiceIdsObj->setData($ids);
			$invoiceIdsObj->insertData(1);
		}
		
		elseif(empty($ticketData))
		{
			$result['userId'] = Yii::app()->session['userId'];
			$result['casher'] = Yii::app()->session['fullname'];
			$result['createdAt'] = date("Y-m-d H:i:s");
			$result['status'] = 3;
			$ticketsObj = new TicketDetails();
			$ticketsObj->setData($result);
			$invoiceId = $ticketsObj->insertData();
			
			$ids['userId'] = Yii::app()->session['userId'];
			$ids['invoiceId'] = $invoiceId;
			$invoiceIdsObj = new Invoiceids();
			$invoiceIdsObj->setData($ids);
			$invoiceIdsObj->insertData(1);
		}
		else
		{
			$invoiceId = $ticketData['invoiceId'];
		}
		
		$ticketdescObj = new TicketDesc();
		$data = $ticketdescObj->getTicketsData($invoiceId);

		if(!empty($data))
		{
			//$this->redirect(Yii::app()->params->base_path."user/ticketDescription/invoiceId/".$invoiceId);
			$this->actionticketDescriptionNew($invoiceId);
			//$this->renderPartial('browseproduct',array('res'=>$res,'invoiceId'=>$invoiceId));	
		}
		else
		{
			$ticketObj	=	new TicketDetails();
			$result	=	$ticketObj->getTicketDetails($invoiceId);
			
			if(!empty($result))
			{
				$productObj = new Product();
				$res = $productObj->getAllPaginatedProduct();
				
				$this->renderPartial('browseproduct',array('res'=>$res,'invoiceId'=>$invoiceId,'data'=>$data,'result'=>$result));	
			}
			else
			{
				$productObj = new Product();
				$res = $productObj->getAllPaginatedProduct();
				
				$this->renderPartial('browseproduct',array('res'=>$res,'invoiceId'=>$invoiceId,'data'=>$data));
			}
		}
	}
	
	function actionPurchaseItem()
	{
		$invoiceId=1;
		$ticketsObj = new TicketDetails();
		$id = $ticketsObj->getinvoiceId();
		if(!empty($id) && $id!='')
		{
			$invoiceId = $id + 1; 	
		}
		else
		{
			$invoiceId = 1;	
		}
		
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProduct();
		
		$ticketdescObj = new TicketDesc();
		$data = $ticketdescObj->getTicketsData($invoiceId);
		
		/*if(!empty($data))
		{
			//$this->redirect(Yii::app()->params->base_path."user/ticketDescription/invoiceId/".$invoiceId);
			
			$this->ticketDescriptionNew($invoiceId);
			//$this->renderPartial('browseproduct',array('res'=>$res,'invoiceId'=>$invoiceId));	
		}
		else
		{*/
			$this->render('purchaseItem',array('res'=>$res,'invoiceId'=>$invoiceId));	
			exit;
		//}
	}
	
	function actionpurchaseReturn()
	{
		$purchase_order_id = $_REQUEST['id'];
		
		$purchaseOrderObj = new PurchaseOrderDetails();
		$purchaseOrderData = $purchaseOrderObj->getpurchaseOrderData($purchase_order_id);
		
		if(empty($purchaseOrderData))
		{
			echo 0 ; 
			exit;
		}
		
		$purchaseObj = new Purchase();
		$purchaseData = $purchaseObj->getpurchaseDetails($purchase_order_id);
		
		/*echo "<pre>";
		print_r($purchaseOrderData);
		print_r($purchaseData);
		exit;*/
			
		
	$this->render('purchaseReturn',array('purchaseOrderData'=>$purchaseOrderData,'purchaseData'=>$purchaseData));	
	exit;
	}
	
	function actionsubmitPurchaseReturn()
	{
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$data = array();
			$count = $_POST['count'];
			$data['createdAt'] = date("Y-m-d H:i:s");

			$po_detail['total_return_product'] = $count;
			$po_detail['store_id'] = $_POST['store_id'];
			$po_detail['admin_id'] = $userData['admin_id'];
			$po_detail['purchase_order_id'] = $_POST['purchase_order_id'];
			$po_detail['supplier_id'] = $_POST['supplier_id'];
			$po_detail['total_return_amount'] = $_POST['totalPurchase'];
			$po_detail['created'] = date("Y-m-d H:i:s");
			
			$purchaseReturnObj = new PurchaseReturnDetails();
			$purchaseReturnObj->setData($po_detail);
			$purchaseReturnId = $purchaseReturnObj->insertData();
			
			$data['purchase_return_id'] = $purchaseReturnId;
			$data['store_id'] = $_POST['store_id'];
			$data['admin_id'] = $userData['admin_id'];
			
			for($i=1;$i<=$count;$i++)
			{				
				$data['quantity'] = $_POST['quantity'.$i.''];
				$data['price'] = $_POST['rate'.$i.''];
				$data['product_id'] = $_POST['product_id'.$i.''];
				$data['amount'] = $_POST['amount'.$i.''];
				
				$purchaseReturnObj = new PurchaseReturn();
				$purchaseReturnObj->setData($data);
				$purchaseReturnObj->insertData();
				
				$stock['store_id'] = $_POST['store_id'];
				$stock['product_id'] = $_POST['product_id'.$i.''];
				$stock['quantity'] = $_POST['quantity'.$i.''];
				$stock['modified'] = date("Y-m-d H:i:s");
				
				$stockObj = new Stock();
				$stockObj->updateStockForProductDesc($stock['product_id'],$stock['quantity'],$stock['modified'],$stock['store_id']);
				
			}
			echo $purchaseReturnId ;
	}
	
	function actionInsertPurchase()
	{
		$userObj = new Users();
		$userData = $userObj->getUserById(Yii::app()->session['userId']);
		
		$supplierObj = new Supplier();
		$suppliers = $supplierObj->getSupplierDropdown($userData['admin_id']);
		
		$storeObj = new Stores();
		$stores = $storeObj->getStoreDropdown($userData['admin_id']);
		
		$productObj = new Product();
		$products = $productObj->getAllProductList($userData['admin_id']);
		
		/*echo "<pre>";
		print_r($_REQUEST);exit;*/
			
		if(isset($_POST['submit']))
		{
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$data = array();
			$count = $_POST['count'];
			$data['createdAt'] = date("Y-m-d H:i:s");

			$po_detail['total_product'] = $count;
			$po_detail['store_id'] = $_POST['store'];
			$po_detail['admin_id'] = $userData['admin_id'];
			$po_detail['supplier_id'] = $_POST['supplier'];
			$po_detail['total_amount'] = $_POST['totalPurchase'];
			$po_detail['created'] = date("Y-m-d H:i:s");
			
			$purchaseOrderObj = new PurchaseOrderDetails();
			$purchaseOrderObj->setData($po_detail);
			$purchaseId = $purchaseOrderObj->insertData();
/*--------------------------supplier debit update start-----------------------------------------------*/			
			$supplier['supplier_id'] = $_POST['supplier'];
			$supplier['debit'] = $_POST['totalPurchase'];
			$supplier['modified_date'] = date("Y-m-d H:i:s");
			
			$supplierObj = new Supplier();
			$supplierObj->updateSupplierDebit($supplier['supplier_id'],$supplier['debit'],$supplier['modified_date']);
			
			$supplierGeneral['supplier_id'] = $supplier['supplier_id'];
			$supplierGeneral['admin_id'] = $userData['admin_id'];
			$supplierGeneral['store_id'] = $userData['store_id'];
			$supplierGeneral['debit'] = $_POST['totalPurchase'];
			$supplierGeneral['paymentType'] = 0 ;
			$supplierGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$supplierGeneralObj = new SupplierGeneralEntry();
			$supplierGeneralObj->setData($supplierGeneral);
			$supplierGeneralObj->insertData();
/*--------------------------supplier debit update finish-----------------------------------------------*/			
			$data['purchase_order_id'] = $purchaseId;
			$data['store_id'] = $_POST['store'];
			$data['admin_id'] = $userData['admin_id'];
			
			for($i=1;$i<=$count;$i++)
			{				
				$data['quantity'] = $_POST['quantity'.$i.''];
				$data['price'] = $_POST['rate'.$i.''];
				$data['product_id'] = $_POST['product'.$i.''];
				$data['amount'] = $_POST['amount'.$i.''];
				
				$purchaseObj = new Purchase();
				$purchaseObj->setData($data);
				$purchaseObj->insertData();
				
				$stock['store_id'] = $_POST['store'];
				$stock['product_id'] = $_POST['product'.$i.''];
				$stock['quantity'] = $_POST['quantity'.$i.''];
				$stock['modified'] = date("Y-m-d H:i:s");
				
				$stockObj = new Stock();
				$stockData = $stockObj->checkStockDetail($stock['product_id'],$stock['store_id']);
				
				if(!empty($stockData))
				{
					$stockObj = new Stock();
					$stockObj->updateStockForSalesReturn($stock['product_id'],$stock['quantity'],$stock['modified'],$stock['store_id']);
				}
				else
				{
					$stock['created'] = date("Y-m-d H:i:s");
					$stock['admin_id'] = $userData['admin_id'];
					$stockObj = new Stock();
					$stockObj->setData($stock);
					$stockObj->insertData();
					
					$productObject=Product::model()->findbyPk($_POST['product'.$i.'']);
					$UpdateStoreId['store_id'] = $productObject->store_id.",".$_POST['store'].",";
					
					$productObj = new Product();
					$productObj->setData($UpdateStoreId);
					$productObj->insertData($_POST['product'.$i.'']);
				}
			}
			
			$this->actionraisePurchaseOrder($purchaseId);
		}
		$this->render('insertPurchase',array('products'=>$products,'suppliers'=>$suppliers,'stores'=>$stores));	
		exit;
	}
	
	function actionSearchProduct()
	{
		$invoiceId=1;
		$ticketsObj = new TicketDetails();
		$id = $ticketsObj->getinvoiceId();
		if(!empty($id) && $id!='')
		{
			$invoiceId = $id + 1; 	
		}
		else
		{
			$invoiceId = 1;	
		}
		
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProduct();
		
		$ticketdescObj = new TicketDesc();
		$data = $ticketdescObj->getTicketsData($invoiceId);
		
		if(!empty($data))
		{
			$this->redirect(Yii::app()->params->base_path."user/ticketDescription/invoiceId/".$invoiceId);
		}
		else
		{
			$this->renderPartial('browseproduct',array('res'=>$res,'invoiceId'=>$invoiceId));	
			exit;
		}
	}
	
	function actionSearchProductAjax($invoiceId=NULL)
	{
		if(isset($_REQUEST['rating']))
		{
			$rating = $_REQUEST['rating'];
			
		}
		if (isset($invoiceId) && $invoiceId != '' && !empty($invoiceId) )
		{
			$invoiceId = $_REQUEST['invoiceId'];
		}
		else 
		{
			$invoiceId=1;
			$ticketsObj = new TicketDetails();
			$id = $ticketsObj->getinvoiceId();
			if(!empty($id) && $id!='')
			{
				$invoiceId = $id ; 	
			}
			else
			{
				$invoiceId = 1;	
			}
		}
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='product_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		//echo $_REQUEST['credit'];
		//exit;
		$ticketdescObj = new TicketDesc();
		$productIds = $ticketdescObj->getTicketbyInvoiceId($invoiceId);
		
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProduct(5,$_REQUEST['sortType'],$_REQUEST['sortBy'],strip_tags($_REQUEST['keyword']));
		
		$this->renderPartial('searchproduct_ajax',array('res'=>$res,'invoiceId'=>$invoiceId, 'productIds'=>$productIds,'rating'=>$rating));	
	}
	
	function actiongetCategoryProductAjax()
	{
		
		if (isset($invoiceId) && $invoiceId != '' && !empty($invoiceId) )
		{
			$invoiceId = $_REQUEST['invoiceId'];
		}
		else 
		{
			$invoiceId=1;
			$ticketsObj = new TicketDetails();
			$id = $ticketsObj->getinvoiceId();
			if(!empty($id) && $id!='')
			{
				$invoiceId = $id ; 	
			}
			else
			{
				$invoiceId = 1;	
			}
		}
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='product_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		$ticketdescObj = new TicketDesc();
		$productIds = $ticketdescObj->getTicketbyInvoiceId($invoiceId);
		
		$cat_id = $_REQUEST[cat_id];
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
		$store_id = $userData->store_id ;
		
		$productObj = new Product();
		$res = $productObj->getPaginatedProductforCategoryForStore(5,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$cat_id,$store_id);
		
		$this->renderPartial('searchproduct_ajax',array('res'=>$res,'invoiceId'=>$invoiceId, 'productIds'=>$productIds));	
	}
	
	function actioncategoryListing()
	{
		error_reporting(E_ALL);		
		
		/*if (isset($invoiceId) && $invoiceId != '' && !empty($invoiceId) )
		{
			$invoiceId = $_REQUEST['invoiceId'];
		}
		else 
		{
			$invoiceId=1;
			$ticketsObj = new TicketDetails();
			$id = $ticketsObj->getinvoiceId();
			if(!empty($id) && $id!='')
			{
				$invoiceId = $id + 1; 	
			}
			else
			{
				$invoiceId = 1;	
			}
		}*/
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='category_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		/*$ticketdescObj = new TicketDesc();
		$productIds = $ticketdescObj->getTicketbyInvoiceId($invoiceId);*/

		$res=Users::model()->findbyPk(Yii::app()->session['userId']);
		/*echo "<pre>";
		print_r($res);
		exit;*/
		 $admin_id = $res->admin_id ;
		
		$categoryObj = new Category();
		$res = $categoryObj->getAllPaginatedCategoryforAjax(5,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$admin_id);
		//echo "<pre>" ; print_r($res); exit; 
		$this->renderPartial('categorylistWithAjax',array('res'=>$res));	
	}
	
	public function actionsubmitTicketbyUPCcode()
	{
			//echo '<pre>';print_r($myLists);exit;
			$algo=new Algoencryption();
			$imageDir=$algo->encrypt("USER_".Yii::app()->session['userId']);
			$invoiceId=1;
			$ticketsObj = new TicketDetails();
			$id = $ticketsObj->getinvoiceId();
			if(!empty($id) && $id!='')
			{
				$invoiceId = $id ; 	
			}
			else
			{
				$invoiceId = 1;	
			}
			$result['upc_code'] = $_REQUEST['upc_code'];
			$productObj = new Product();
			$data = $productObj->getProductDetailsbyUpcCode($result['upc_code']);

			if(empty($data))
			{
				/*Yii::app()->user->setFlash('error',$this->msg['_PLEASE_ENTER_CORRECT_UPC_CODE_']);*/
				/*header('location:'.Yii::app()->params->base_path.'user/browseproduct');*/
				echo false;
				exit;
			}
			
			$ticketdescObj = new TicketDesc();
			$ticketId =  $ticketdescObj->checkTicket($_REQUEST['invoiceId'],$data['product_id']);
			
			if(!empty($ticketId))
			{
				/*Yii::app()->user->setFlash('error',$this->msg['_PRODUCT_ALREADY_ADDED_']);*/
				/*header('location:'.Yii::app()->params->base_path.'user/browseproduct');*/
				echo -1;
				exit;
			}
			
			$res['invoiceId'] = $invoiceId;
			$res['product_id'] = $data['product_id'];
			$res['quantity'] = 1 ;
			$res['price'] = $data['product_price'];
			$res['product_total'] = $data['product_price'];
			$res['date_add'] = date('Y-m-d:H-m-s');
				
			$ticketdescObj = new TicketDesc();
			$ticketdescObj->setData($res);
			$ticketdescObj->insertData();
			
			$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			$stock['store_id'] = $userData->store_id ;
			
			$stock['product_id'] = $data['product_id'];
			$stock['quantity'] = 1 ;
			$stock['modified'] = date("Y-m-d H:i:s");
			$stockObj = new Stock();
			$stockObj->updateStock($stock['product_id'],$stock['quantity'],$stock['modified'],$stock['store_id']);
			
			/*echo "<pre>";
			print_r($res);
			print_r($data);
			exit;*/
			
			if($this->isAjaxRequest())
			{	
				/*$productObj = new Product();
				$res = $productObj->getAllPaginatedProduct();
				$this->renderPartial('browseproduct',array("isAjax"=>'true','invoiceId'=>$invoiceId,'data'=>$data,'res'=>$res));*/
				echo true;
			}
			else
			{
				/*$this->render('home',array("isAjax"=>'false','invoiceId'=>$invoiceId,'data'=>$data));*/
				echo true;
			}
	}

	
	function actionleftview()
	{
			$userObj = new Users();
			$loginObj	=	new Login();
			$res = $userObj->getUserDetail(Yii::app()->session['loginId']);
			$users = $res['result'];
			$users['email']		=	$loginObj->getVerifiedEmailById(Yii::app()->session['loginId']);
			$users['vPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['userId'], 1);
			$users['uPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['userId']);
			
			$algo=new Algoencryption();
			$imageDir=$algo->encrypt("USER_".Yii::app()->session['userId']);
			
			$this->renderPartial('leftview',array('users'=>$users,'imageDir'=>$imageDir));
	}
	
	function actionGetUpdatedCount()
	{
		$todoItemObj	=	new TodoItems();
		$result=$todoItemObj->getUpdatedCount(Yii::app()->session['loginId']);
		echo json_encode($result);
	}
	/******* MY TODO ITEMS AJAX FUNCTION *******/
	public function actionMyTodoItem($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keywordMyTODO=NULL)
	{
		error_reporting(E_ALL);
		$extraPaginationPara="";
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		$limit=5;
		if(isset($_REQUEST['moreflag']) && $_REQUEST['moreflag']==1)
		{
			$limit=10;	
		}
		else
		{
			$_REQUEST['moreflag']=0;
		}
		
		if(!isset($_REQUEST['mylist']))
		{
			$_REQUEST['mylist']=0;
		}
		if(!isset($_REQUEST['mytodoStatus']))
		{
			$_REQUEST['mytodoStatus']=0;
			
		}		
		if(!isset($_REQUEST['keywordMyTODO']))
		{
			$_REQUEST['keywordMyTODO']='';
			
		}	
		if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!='')
		{
			$_REQUEST['keywordMyTODO']=$_REQUEST['keyword'];
		}
		if(!isset($_REQUEST['assignBySearch']))
		{
			$_REQUEST['assignBySearch']='';
		}
		if(!isset($_REQUEST['flag']))
		{
			$_REQUEST['flag']=0;
			
		}
				
		$todoItemObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$extraPara=$_REQUEST;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['mylist']=$_REQUEST['mylist'];
		$sessionArray['mytodoStatus']=$_REQUEST['mytodoStatus'];
		$items	=	$todoItemObj->getMyToDoItems($sessionArray,$limit, $_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keywordMyTODO'],$_REQUEST['assignBySearch']);
		
		$items['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'myOpenStatus , myDoneStatus, myCloseStatus');
		$items['moreflag']=$_REQUEST['moreflag'];
		
		if($_REQUEST['sortType'] == 'desc'){
			$items['sortType']	=	'asc';
			$items['img_name']	=	'arrow_up.png';
		} else {
			$items['sortType']	=	'desc';
			$items['img_name']	=	'arrow_down.png';
		}
		if($_REQUEST['flag'] == 0){
			$items['img_name']	=	'';
		}
		
		$items['sortBy']	=	$_REQUEST['sortBy'];
		$items['flag']=$_REQUEST['flag'];
		$items['mylist']=$_REQUEST['mylist'];
		$items['assignBySearch']=$_REQUEST['assignBySearch'];
		$items['count']	=	$todoItemObj->getMyTodoCount(Yii::app()->session['loginId']);
		$items['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['pendingItems'] = $items['myLists']['pendingItems'];
		unset($items['myLists']['pendingItems']);
		if(isset($_REQUEST['currentList']) && $_REQUEST['currentList']!=0) {			
			$items['currentList']=$_REQUEST['currentList'];
		}
		
		$this->renderPartial('myTodoAjax', array('items'=>$items,'extraPara'=>$extraPara));
	}
	
	/******* ASSIGNED BY ME TODO ITEMS AJAX FUNCTION *******/
	public function actionAssignedByMeTodoItem($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keywordAssignByMe=NULL)
	{
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='item.id';
		}
		$limit=5;
		if(isset($_REQUEST['moreflag']) && $_REQUEST['moreflag']==1)
		{
			$limit=10;	
		}
		else
		{
			$_REQUEST['moreflag']=0;
		}
		if(!isset($_REQUEST['mylist']))
		{
			$_REQUEST['mylist']=0;
			$mylist=0;
		}
		if(!isset($_REQUEST['mytodoStatus']))
		{
			$_REQUEST['mytodoStatus']=0;
			$mytodoStatus=0;
		}		
		if(!isset($_REQUEST['keywordAssignByMe']))
		{
			$_REQUEST['keywordAssignByMe']='';
		}	
		if(!isset($_REQUEST['assignToSearch']))
		{
			$_REQUEST['assignToSearch']='';
		}
		if(isset($_REQUEST['keyword']))
		{
			$_REQUEST['keywordAssignByMe']=$_REQUEST['keyword'];
		}
		if(!isset($_REQUEST['flag']))
		{
			$_REQUEST['flag']=0;
			$flag=0;
		}
		$sessionArray['mylist']=$_REQUEST['mylist'];
		$sessionArray['mytodoStatus']=$_REQUEST['mytodoStatus'];
		$extraPara=$_REQUEST;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		
		$todoItemObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$assignbyme	=	$todoItemObj->getAssignedByMeItems($sessionArray, $limit, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keywordAssignByMe'], $_REQUEST['assignToSearch']);
		$assignbyme['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'byMeOpenStatus, byMeDoneStatus, byMeCloseStatus');
		
		$assignbyme['moreflag']=$_REQUEST['moreflag'];
		if($_REQUEST['sortType'] == 'desc'){
			$assignbyme['sortType']	=	'asc';
			$assignbyme['img_name']	=	'arrow_up.png';
		} else {
			$assignbyme['sortType']	=	'desc';
			$assignbyme['img_name']	=	'arrow_down.png';
		}
		if($flag == 0){
			$assignbyme['img_name']	=	'';
		}
		$assignbyme['sortBy']	=	$_REQUEST['sortBy'];
		$assignbyme['assignToSearch']	=	$_REQUEST['assignToSearch'];
		
		$assignbyme['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['pendingItems'] = $assignbyme['myLists']['pendingItems'];
		unset($assignbyme['myLists']['pendingItems']);
		$assignbyme['count']		=	$todoItemObj->getByMeTodoCount(Yii::app()->session['loginId']);
		if(isset($_REQUEST['currentList']) && $_REQUEST['currentList']!=0) {			
			$assignbyme['currentList']=$_REQUEST['currentList'];
		}
		$this->renderPartial('assignedByMeTodoAjax', array('assignbyme'=>$assignbyme,'extraPara'=>$extraPara));
	}
	
	/******* OTHER TODO ITEMS AJAX FUNCTION *******/
	public function actionOtherTodoItem($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keywordOther=NULL)
	{
	
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='item.id';
		}
		$limit=5;
		if(isset($_REQUEST['moreflag']) && $_REQUEST['moreflag']==1)
		{
			$limit=10;	
		}
		else
		{
			$_REQUEST['moreflag']=0;
		}
		if(!isset($_REQUEST['mylist']))
		{
			$_REQUEST['mylist']=0;
		}
		if(!isset($_REQUEST['mytodoStatus']))
		{
			$_REQUEST['mytodoStatus']=0;
		}		
		if(!isset($_REQUEST['keywordOther']))
		{
			$_REQUEST['keywordOther']='';
		}	
		if(isset($_REQUEST['keyword']))
		{
			$_REQUEST['keywordOther']=$_REQUEST['keyword'];
		}
		if(!isset($_REQUEST['assignToSearch']))
		{
			$_REQUEST['assignToSearch']='';
		}
		if(!isset($_REQUEST['assignBySearch']))
		{
			$_REQUEST['assignBySearch']='';
		}
		if(!isset($_REQUEST['flag']))
		{
			$_REQUEST['flag']=0;
		}
		
		$extraPara=$_REQUEST;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['userId']=Yii::app()->session['userId'];
		$sessionArray['mylist']=$_REQUEST['mylist'];
		
		$todoItemObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$others	=	$todoItemObj->getOtherToDoItems($sessionArray, $limit, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keywordOther'], $_REQUEST['assignBySearch'],$_REQUEST['assignToSearch']);
		$others['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'otherOpenStatus, otherDoneStatus, otherCloseStatus');
		
		$others['moreflag']=$_REQUEST['moreflag'];
		if($_REQUEST['sortType'] == 'desc'){
			$others['sortType']	=	'asc';
			$others['img_name']	=	'arrow_up.png';
		} else {
			$others['sortType']	=	'desc';
			$others['img_name']	=	'arrow_down.png';
		}
		if($flag == 0){
			$others['img_name']	=	'';
		}
		$others['sortBy']	=	$_REQUEST['sortBy'];
		$others['assignBySearch']=$_REQUEST['assignBySearch'];
		$others['assignToSearch']	=	$_REQUEST['assignToSearch'];
		$others['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['pendingItems'] = $others['myLists']['pendingItems'];
		unset($others['myLists']['pendingItems']);
		$others['count']	=	$todoItemObj->getOtherTodoCount(Yii::app()->session['loginId']);
		if(isset($_REQUEST['currentList']) && $_REQUEST['currentList']!=0) {			
			$others['currentList']=$_REQUEST['currentList'];
		}
		$this->renderPartial('othersTodoAjax', array('others'=>$others,'extraPara'=>$extraPara));
	}
	
	function actionShowAll()
	{
		$usersObj	=	new Users();
		$result	=	$usersObj->showAll(Yii::app()->session['userId']);
		echo json_encode($result);
	}
	
	function actionChangeShowStatus()
	{
		if( isset($_POST['field']) ) {
			$usersObj	=	new Users();
			$result	=	$usersObj->changeShowStatus(Yii::app()->session['userId'], $_POST);
			
			if( $result['status'] == 0 ) {
				echo json_encode($result);
			} else {
				$this->render("/site/error");
			}
		} else {
			$this->render("/site/error");
		}
	}
	 
	public function actionHome()
	{
		if(!$this->isLogin())
		{
			$this->redirect('index');
			exit;
		}
		$userObj	=	new Users();
		$loginObj	=	new Login();
		
		$data['userData']	=	$userObj->getUserById(Yii::app()->session['loginId']);
		$data['verifiedPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['loginId'], 1);
		$data['unverifiedPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['loginId'], 0);
		
		$invoiceId=1;
		$ticketsObj = new TicketDetails();
		$id = $ticketsObj->getinvoiceId();
		if(!empty($id) && $id!='')
		{
			$invoiceId = $id ; 	
		}
		else
		{
			$invoiceId = 1;	
		}
		$this->render('home',array('invoiceId'=>$invoiceId));
	}
	
	/*********** 	ABOUT ME FUNCTION  ***********/
	public function actionaboutme()
	{
		error_reporting(E_ALL);
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$userObj	=	new Users();
		$data	=	array();
		$res=Users::model()->findbyPk(Yii::app()->session['userId']);
		$data['firstName'] = $res->firstName ;
		$data['lastName'] = $res->lastName ;
		$data['loginId'] = $res->loginId ;

		$this->renderPartial("aboutme",array('data'=>$data));

	}
	
	function actiondeletePhone($id=NULL)
	{
		if($this->isAjaxRequest())
		{
		
			if($id != NULL)
			{
				if(!is_numeric($id)){
					$algoencryptionObj	=	new Algoencryption();
					$id	=	$algoencryptionObj->decrypt($id);
				}
				$userObj = new Users();
				$res	=	$userObj->getUserDetail($id);
				$phoneNum  = $res["result"];
  				$result=$userObj->deleteById($id);
				if($result[0]==0)
				{							
					echo "success";
				}
				else
				{
					echo $result[1];
				}
			}
		}
		else
		{
			$this->render("/site/error");
		}
	}
	
	/*********** 	COLLEGUES FUNCTION  ***********/
	public function actionOnlinecollegues()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		/*if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		$invitesObj	=	new Invites();
		$invites	=	$invitesObj->getInvitesByReceiverId(Yii::app()->session['loginId'],NULL,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];*/
		
		$userObj = new Users();
		$userData = $userObj->getUserById(Yii::app()->session['userId']);
		
		$email=Yii::app()->session['email'];
		
		$userObj= new Users();
		$res = $userObj->getFiveOnlineUsers($email,$userData['admin_id']);
		$this->renderPartial('onlinecollegues', array('data'=>'','pagination'=>'','ext'=>'','res'=>$res));
	}
	
	public function actionpaymentTicket()
	{
		$data = array();
		$data['customer_id']=$_REQUEST['customer_id'];
		$data['discount']	=$_REQUEST['discount'];
		$data['total_amount']	=$_REQUEST['totalPayable'];
		$data['invoiceId']=$_REQUEST['invoiceId'];
		Yii::app()->session['ticketData'] = $data ;

		$this->renderPartial('paymentTicket', array('data'=>$data,'pagination'=>'','ext'=>'','res'=>$res));	
	}
	
	
	public function actioncollegues()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		/*if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		$invitesObj	=	new Invites();
		$invites	=	$invitesObj->getInvitesByReceiverId(Yii::app()->session['loginId'],NULL,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];*/
		
		$email=Yii::app()->session['email'];
		
		$userObj= new Users();
		$res = $userObj->getAllOnlineUsers($email);
		$this->renderPartial('collegues', array('data'=>'','pagination'=>'','ext'=>'','res'=>$res));
	}
	
	
	public function actiongeneralEntry()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$this->renderPartial('generalentry');
	}
	
	public function actiongeneralEntryforOther()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$this->renderPartial('generalentryForOther');
	}
	
	public function actionaddGeneralEntryforOther()
	{
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$general['account'] = $_REQUEST['account'];
			$general['credit'] = $_REQUEST['credit'];
			$general['debit'] = $_REQUEST['debit'] ;
			$general['description'] = $_REQUEST['description'];
			$general['admin_id'] = $userData['admin_id'];
			$general['store_id'] = $userData['store_id'];
			$general['created']=date('Y-m-d:H-m-s');
			
			$generalObj = new GeneralEntry();
			$generalObj->setData($general);
			$generalId = $generalObj->insertData();
			
			$this->actiongenerateGeneralRecipts($generalId);
			
	}
	
	public function actiongeneralEntryforCustomer()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$email=Yii::app()->session['email'];
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		
		$customerObj = new Customers();
		$customerList = $customerObj->getAllCustomerListForAdmin($admin_id);
		
		$this->renderPartial('generalentryForCustomer',array('customerList'=>$customerList));
	}
	
	public function actionaddGeneralEntryforCustomer()
	{
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$customer['customer_id'] = $_REQUEST['customer_id'];
			$customer['credit'] = $_REQUEST['credit'];
			$customer['debit'] = $_REQUEST['debit'] ;
			$customer['modifiedAt']=date('Y-m-d:H-m-s');
			
			$customerObj = new Customers();
			$customerObj->updateCustomer($customer['customer_id'],$customer['credit'],$customer['debit'],$customer['modifiedAt']);
			
			$customerGeneral['customer_id'] = $_REQUEST['customer_id'];
			$customerGeneral['admin_id'] = $userData['admin_id'];
			$customerGeneral['credit'] = $_REQUEST['credit'];
			$customerGeneral['store_id'] = $userData['store_id'];
			$customerGeneral['debit'] = $_REQUEST['debit'];
			$customerGeneral['paymentType'] = $_REQUEST['paymentType'];
			$customerGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$customerGeneralObj = new CustomerGeneralEntry();
			$customerGeneralObj->setData($customerGeneral);
			$receiptId = $customerGeneralObj->insertData();
			
			$this->actiongeneratePaymentRecipts($receiptId);
			
			/*$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			$admin_id = $userData->admin_id ;
			
			$customerObj = new Customers();
			$customerList = $customerObj->getAllCustomerListForAdmin($admin_id);
		
			if($this->isAjaxRequest())
			{	
				
				Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
				$this->renderPartial('generalentry',array("isAjax"=>'true','customerList'=>$customerList));
				exit;
			}
			else
			{
				Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
				$this->render('generalentry',array("isAjax"=>'false','customerList'=>$customerList));
				exit;
			}*/
	}
	
	public function actiongeneralEntryforSupplier()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$email=Yii::app()->session['email'];
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		
		$supplierObj = new Supplier();
		$supplierList = $supplierObj->getAllSupplierListForAdmin($admin_id);
		
		$this->renderPartial('generalentryForSupplier',array('supplierList'=>$supplierList));
	}
	
	public function actionaddGeneralEntryforSupplier()
	{
			$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);
			
			$supplier['supplier_id'] = $_REQUEST['supplier_id'];
			$supplier['credit'] = $_REQUEST['credit'];
			$supplier['debit'] = $_REQUEST['debit'];
			$supplier['modified_date']=date('Y-m-d:H-m-s');
			
			$supplierObj = new Supplier();
			$supplierObj->updateSupplier($supplier['supplier_id'],$supplier['credit'],$supplier['debit'],$supplier['modified_date']);
			
			$supplierGeneral['supplier_id'] = $_REQUEST['supplier_id'];
			$supplierGeneral['admin_id'] = $userData['admin_id'];
			$supplierGeneral['store_id'] = $userData['store_id'];
			$supplierGeneral['credit'] = $_REQUEST['credit'];
			$supplierGeneral['debit'] = $_REQUEST['debit'];
			$supplierGeneral['paymentType'] = $_REQUEST['paymentType'];
			$supplierGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$supplierGeneralObj = new SupplierGeneralEntry();
			$supplierGeneralObj->setData($supplierGeneral);
			$receiptId = $supplierGeneralObj->insertData();
			
			$this->actiongenerateSupplierPaymentRecipts($receiptId);
			
			/*$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			$admin_id = $userData->admin_id ;
			
			$customerObj = new Customers();
			$customerList = $customerObj->getAllCustomerListForAdmin($admin_id);
		
			if($this->isAjaxRequest())
			{	
				
				Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
				$this->renderPartial('generalentry',array("isAjax"=>'true','customerList'=>$customerList));
				exit;
			}
			else
			{
				Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
				$this->render('generalentry',array("isAjax"=>'false','customerList'=>$customerList));
				exit;
			}*/
	}
	
	

	/***********  CHANGE ITEM STATUS FUNCTION  ***********/
	public function actionChangeItemStatus($id=NULL, $stat=NULL)
	{
		
		if(isset($_POST['value'])){
			$id	=	$_POST['id'];
			$stat	=	$_POST['value'];
		} else {
			$_POST['value']	=	'';
		}
		$sessionArray['loginId']	=	Yii::app()->session['loginId'];
		$sessionArray['fullname']	=	Yii::app()->session['fullname'];
		$todoItemsObj	=	new TodoItems();
		$todoItemsObj->changeTodoItemsStatus($id,$stat,$sessionArray);
		echo json_encode(array('status'=>0, 'message'=>$this->msg['_STATUS_UPDATE_'], 'change'=>$_POST['value']));
        exit;
	}
	
	/***********  QUERY TODO ITEM FUNCTION  ***********/
	public function actionAssignBack($itemId=NULL)
	{
		$todoItemsObj	=	new TodoItems();
		if( isset($_POST['id']) ) {
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$_POST['userId']	=	Yii::app()->session['loginId'];
			$result	=	$todoItemsObj->assignBack($_POST, $sessionArray);
			//$result	=	array('status'=>0, 'message'=>'success');
			$result['message']	.=	'<script type="text/javascript">setTimeout(function() {
				$j("#update-message").fadeOut();
			}, 10000 );</script>';
			
			echo json_encode($result);
			exit;
		}
		$this->renderPartial('assignBack', array('data'=>$itemId));
	}
	
	/*********** 	REMINDERS FUNCTION  ***********/
	public function actionReminders()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$reminderObj	=	new Reminder();
		$reminders	=	$reminderObj->getReminderByUserId(Yii::app()->session['loginId']);
		$this->renderPartial('reminders', array('data'=>$reminders));
	}
	
	/*********** 	MESSAGES FUNCTION  ***********/
	public function actionMessages()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$messageObj	=	new Messages();
		$data	=	$messageObj->getMessageList(Yii::app()->session['userId']);
		$this->renderPartial('messages', array('data'=>$data));
	}
	
	public function actiondeleteMessage($id)
	{
		$this->isLogin();
        $messageObj	=	new Messages();
        $messageObj->deleteMessage($id);

       echo true ;
        
	}
	
	public function actionreadMessage($id)
	{
		$this->isLogin();
		$data['status'] = 1 ;
        $messageObj	=	new Messages();
        $messageObj->setData($data);
		$messageObj->insertData($id);

       echo true ;
        
	}
	
	public function actioncreateTicket()
	{
		$this->renderPartial('createTicket');	
	}
	/*********** 	SEND REMINDER AGAIN FUNCTION  ***********/
	public function actionRemindAgain($itemId=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$reminderObj	=	new Reminder();
		
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['fullname']=Yii::app()->session['fullname'];
		$result	=	$reminderObj->remindeAgain($itemId, $sessionArray);
		
		echo json_encode($result);
	}
	
	function actiongetMyNetworkDropdown()
	{
		if(!isset($_REQUEST['assignTo']))
		{
			$_REQUEST['assignTo']=0;	
		}
		
		$todoNetworkObj	=	new Todonetwork();
		$networks	=	$todoNetworkObj->getNetworkDropdown(Yii::app()->session['loginId'],$_REQUEST['assignTo']);
		echo $networks;	
	}
	
	/*********** 	REMINDERS FUNCTION  ***********/
	public function actionRemindersAjax()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$ticketObj	=	new TicketDetails();
		$tickets	=	$ticketObj->getTickets();
		/*echo "<pre>";
		print_r($tickets);
		exit;*/

		$this->renderPartial('remindersAjax', array('data'=>$tickets));
	}
	
	/*********** 	ADD TODO ITEMS FUNCTION  ***********/
	public function actionAddTodo($from=NULL)
	{		
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$items = array();
		$userObj = new Users();
		$loginObj = new Login();
		$logindata=$loginObj->getUserId(Yii::app()->session['loginId']);
		$items = $userObj->getAllUsers();
		
		$todoListsObj	=	new TodoLists();
		$res	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($res['pendingItems']);
		$items['myLists'] = $res;
		$items['from']	=	$from;
		
		$result = array();
		$this->renderPartial('addTodoItem', array('data'=>$items,'lastFavrite'=>$logindata));
	}
	
	/******* GET MY ALL LISTS FUNCTION *******/
	public function actionmyLists()
	{
		$todoListsObj	=	new TodoLists();
		$todoItemsObj	=	new TodoItems();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		$myLists	=	$todoListsObj->myLists(Yii::app()->session['loginId'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('myLists', array('data'=>$myLists['items'],'pagination'=>$myLists['pagination'],'ext'=>$ext));
	
	}
	
	/******* GET ALL CUSTOMERS FUNCTION *******/
	public function actioncustomers()
	{
		$customerObj	=	new Customers();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='customer_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		
		$customerList	=	$customerObj->getPaginatedCustomerList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo']);
		
		/*echo "<pre>";
		print_r($customerList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('customerList', array('data'=>$customerList['customers'],'pagination'=>$customerList['pagination'],'ext'=>$ext));
	
	}
	
	
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actioncustomerDescription($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$customerObj	=	new Customers();
		$data	=	$customerObj->getCustomerDetails($id);
		
		$this->renderPartial('customerDescription', array('data'=>$data));
	}
	
	public function actionsuppliers()
	{
		$customerObj	=	new Supplier();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='supplier_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		
		$supplierList	=	$customerObj->getPaginatedSupplierList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo']);
		
		/*echo "<pre>";
		print_r($customerList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('supplierList', array('data'=>$supplierList['suppliers'],'pagination'=>$supplierList['pagination'],'ext'=>$ext));
	
	}
	
	public function actionsupplierDescription($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$supplierObj	=	new Supplier();
		$data	=	$supplierObj->getSupplierDetails($id);
		
		$this->renderPartial('supplierDescription', array('data'=>$data));
	}
	
	public function actioncustomerList($id=NULL)
	{
		$customerObj	=	new Customers();
		$limit = 10;
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='customer_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		
		$customerList	=	$customerObj->getPaginatedCustomerList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo']);
		
		/*echo "<pre>";
		print_r($customerList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		if(isset($_REQUEST['invoiceId']))
		{
			$invoiceId = $_REQUEST['invoiceId'];
		}
		else
		{
			$invoiceId = "";	
		}
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('customers', array('data'=>$customerList['customers'],'pagination'=>$customerList['pagination'],'ext'=>$ext,'invoiceId'=>$invoiceId));
	
	}
	
	/******* GET MY ALL LISTS FUNCTION *******/
	public function actionproductList()
	{
		$productObj	=	new Product();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='product_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		
		$productList	=	$productObj->getPaginatedProductList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo']);
		
		/*echo "<pre>";
		print_r($productList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['searchFrom']	=	$_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('productList', array('data'=>$productList['product'],'pagination'=>$productList['pagination'],'ext'=>$ext));
	
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionproductDescription($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$productObj	=	new Product();
		$data	=	$productObj->getProductDetails($id);
		
		$this->renderPartial('productDescription', array('data'=>$data));
	}
	
	/******* GET MY ALL LISTS FUNCTION *******/
	public function actionticketList()
	{
		error_reporting(0);
		$ticketObj	=	new TicketDetails();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='invoiceNo';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$ticketList	=	$ticketObj->getPaginatedTicketList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('ticketList', array('data'=>$ticketList['listing'],'pagination'=>$ticketList['pagination'],'ext'=>$ext));
	
	}
	
	public function actionticketDeliveryStatus()
	{
		$ticketObj	=	new TicketDetails();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='invoiceNo';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$ticketList	=	$ticketObj->getPaginatedTicketListForDelivery($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		

		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('ticketListForDelivery', array('data'=>$ticketList['ticket'],'pagination'=>$ticketList['pagination'],'ext'=>$ext));
	
	}
	
	function actionchangeTicketStatus()
	{
		$invoiceId = $_REQUEST['invoiceId'];
		$data['status']= 2 ;
		$ticketsObj = new TicketDetails();
		$ticketsObj->setData($data);
		$invoiceId = $ticketsObj->insertData($invoiceId);	
		Yii::app()->user->setFlash('success', $this->msg['_IPAD_ORDER_DISPATCH_']);
		echo true;
	}
	
	function actioncancelTicketDelivery()
	{
		$invoiceId = $_REQUEST['invoiceId'];
		$data['status']= 6 ;
		$ticketsObj = new TicketDetails();
		$ticketsObj->setData($data);
		$invoiceId = $ticketsObj->insertData($invoiceId);	
		Yii::app()->user->setFlash('success', $this->msg['_IPAD_ORDER_CANCEL_']);
		echo true;
	}
	
	public function actionticketListForCustomer()
	{
		$ticketObj	=	new TicketDetails();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='invoiceNo';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$ticketList	=	$ticketObj->getPaginatedTicketListForCustomer($_REQUEST['customer_id'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('ticketListForCustomer', array('data'=>$ticketList['ticket'],'pagination'=>$ticketList['pagination'],'ext'=>$ext,'customer_id'=>$_REQUEST['customer_id'],'customer_name'=>$_REQUEST['customer_name']));
	
	}
	
	public function actionticketListForProduct()
	{
		$ticketObj	=	new TicketDesc();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='invoiceNo';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$ticketList	=	$ticketObj->getPaginatedTicketListForProduct($_REQUEST['product_id'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('ticketListForProduct', array('data'=>$ticketList['ticket'],'pagination'=>$ticketList['pagination'],'ext'=>$ext,'product_id'=>$_REQUEST['product_id'],'product_name'=>$_REQUEST['product_name']));
	
	}
	
	public function actionpurchaseOrderListForSupplier()
	{
		$poObj	=	new PurchaseOrderDetails();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='purchase_order_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$purchaseOrderList	=	$poObj->getPaginatedPOListForSupplier($_REQUEST['supplier_id'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($purchaseOrderList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('purchaseOrderListForSupplier', array('data'=>$purchaseOrderList['purchaseOrders'],'pagination'=>$purchaseOrderList['pagination'],'ext'=>$ext,'supplier_id'=>$_REQUEST['supplier_id'],'supplier_name'=>$_REQUEST['supplier_name']));
	
	}
	
	public function actiongeneralEntryCustomerList()
	{
		$customerGeneralObj	=	new CustomerGeneralEntry();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$generalList	=	$customerGeneralObj->getPaginatedGeneralEntryForCustomer($_REQUEST['customer_id'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('generalEntryForCusomterList', array('data'=>$generalList['generalEntryCustomer'],'pagination'=>$generalList['pagination'],'ext'=>$ext,'customer_id'=>$_REQUEST['customer_id'],'customer_name'=>$_REQUEST['customer_name'] ));
	
	}
	
	public function actiongeneralEntrySupplierList()
	{
		$supplierGeneralObj	=	new SupplierGeneralEntry();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$generalList	=	$supplierGeneralObj->getPaginatedGeneralEntryForSupplier($_REQUEST['supplier_id'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('generalEntryForSupplierList', array('data'=>$generalList['generalEntrySupplier'],'pagination'=>$generalList['pagination'],'ext'=>$ext,'supplier_id'=>$_REQUEST['supplier_id'],'supplier_name'=>$_REQUEST['supplier_name'] ));
	
	}
	
	public function actiongeneralEntryOtherList()
	{
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
		$store_id = $userData->store_id ;
		
		$customerGeneralObj	=	new GeneralEntry();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='general_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$generalList	=	$customerGeneralObj->getPaginatedGeneralEntryForOther($store_id,$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('generalEntryForOtherList', array('data'=>$generalList['generalEntryCustomer'],'pagination'=>$generalList['pagination'],'ext'=>$ext));
	
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionticketDetail()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$ticketObj	=	new TicketDetails();
		$data	=	$ticketObj->getTicketDetailWithCustomer($_REQUEST['id']);
				
		$ticketDescObj  = new TicketDesc();
		$productData = $ticketDescObj->getTicketsData($_REQUEST['id']);
		
		$this->renderPartial('ticketDescription', array('data'=>$data,'productData'=>$productData));
	}
	
	public function actionpurchaseOrderDetail()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$poObj	=	new PurchaseOrderDetails();
		$data	=	$poObj->getPurchaseDetail($_REQUEST['purchase_order_id']);
				
		$poDescObj  = new Purchase();
		$poData = $poDescObj->getpurchaseDetails($_REQUEST['purchase_order_id']);
		
		$this->renderPartial('purchaseOrderDescription', array('data'=>$data,'poData'=>$poData));
	}
	
	/******* GET MY ALL LISTS FUNCTION *******/
	public function actionreturnTicketList()
	{
		$salesReturnDetailObj	=	new SalesReturnDetails();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='sales_return_invoiceId';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$ticketList	=	$salesReturnDetailObj->getPaginatedReturnTicketList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('returnTicketList', array('data'=>$ticketList['ticket'],'pagination'=>$ticketList['pagination'],'ext'=>$ext));
	
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionreturnTicketDetail()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$salesReturnDetailObj	=	new SalesReturnDetails();
		$data	=	$salesReturnDetailObj->getReturnTicketDetailWithCustomer($_REQUEST['id']);
		
		$salesTicketDescObj  = new SalesReturnDesc();
		$productData = $salesTicketDescObj->getTicketsData($_REQUEST['id']);
		
		$this->renderPartial('returnTicketDescription', array('data'=>$data,'productData'=>$productData));
	}
	
	
	
	function callDaemon($daemon_name = "hirenow")
	{
        $sig = new signals_lib();
        $sig->get_queue($this->arr[$daemon_name]);
        $sig->send_msg($daemon_name);
    }
	
	 /*****************Upload Avatar ***************/
 	function actionAvatar($stat = NULL)
	{
		$session = Yii::app()->getSession();
		$_POST['loginId']=$session['loginId'];
		$_POST['userId']=$session['userId'];
		$_POST['loginIdType']=$session['loginIdType'];
		$userObj = new Users;
		$result=$userObj->uploadAvatar($_POST,$_FILES,$stat);
		echo json_encode($result);
		
	}	 	
	
	 /*****************Upload Avatar ***************/
 	function actionAttachment($stat = NULL)
	{
		$session = Yii::app()->getSession();
		//$helperObj = new Helper();
		/*if(!isset(Yii::app()->session['random']))
		{
		Yii::app()->session['random'] = $helperObj->getRandomString();
		}*/
		$_POST['userId']=$session['loginId'];
		$_POST['loginIdType']=$session['loginIdType'];
		//$_POST['random']=Yii::app()->session['random'];
		
		$userObj = new Users;
		$result=$userObj->uploadAttachment($_POST,$_FILES,$stat);
		
		echo json_encode($result['message']);
	}	 	
	
	
	

	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionItemDescription($id=NULL, $flag=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$todoItemsObj	=	new TodoItems();
		$item	=	$todoItemsObj->getItemDetails($id);
		if($item)
		{
			$item['flag']	=	$flag;
			if( isset($_REQUEST['url']) ) {
				$item['url']	=	$_REQUEST['url'];
			} else {
				$item['flag']	=	0;
			}
			if($this->isAjaxRequest())
			{
				$this->renderPartial('description', array('data'=>$item));
			}
			else
			{
				$this->render('description', array('data'=>$item));
			}
		}
		else
		{
			$this->redirect(Yii::app()->params->base_path."user/index");
		}
	}
	
	public function actiongetItemHistory($id=NULL)
	{
		$todoItemChangeHistoryObj	=	new TodoItemChangeHistory();
		$itemHistory	=	$todoItemChangeHistoryObj->getItemHistory($id);
		$this->renderPartial('moreHistoryAjax', array('history'=>$itemHistory[1]));
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionmoreItemHistory($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$todoItemChangeHistoryObj	=	new TodoItemChangeHistory();
		$itemHistory	=	$todoItemChangeHistoryObj->getItemHistory($id);
		$this->renderPartial('moreHistory', array('history'=>$itemHistory,"itemId"=>$id));
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionlistDescription($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$todoListObj	=	new TodoLists();
		$inviteObj	=	new Invites();
		$item	=	$todoListObj->getListDetails($id);
		$listMembers	=	$inviteObj->getListMembers($id);
		
		$this->renderPartial('listdescription', array('data'=>$item,'listMembers'=>$listMembers['users'],'pagination'=>$listMembers['pagination']));
	}
	
	/*********** 	GET COMMENTS FUNCTION  ***********/
	public function actionGetComments($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$commentsObj	=	new Comments();
		$usersObj	=	new Users();
		$loginObj	=	new Login();
		$generalObj	=	new General();
		$algoencryptionObj	=	new Algoencryption();
		$comments	=	$commentsObj->getcommentsByItem($id);
		$index	=	0;
		
		foreach($comments as $comment){
			$res	=	$usersObj->getUserDetail($comment['userId']);
			$commentBy  = $res['result'];
			$userId	=	$loginObj->getUserIdByid($comment['userId']);
			$comments[$index]['commentedByFname']	=	$commentBy['firstName'];
			$comments[$index]['commentedByLname']	=	$commentBy['lastName'];
			$comments[$index]['avatar']	=	$commentBy['avatar'];
			$comments[$index]['imageDir']	=	$algoencryptionObj->encrypt("USER_".$userId);
			$comments[$index]['time']	=	$generalObj->rel_time($commentBy['createdAt']);
			$index++;
		}
		$this->renderPartial('comments', array('data'=>$comments));
	}
	
	public function actionDeleteComment($id=NULL)
	{
		$commentsObj	=	new Comments();
		$post	=	$commentsObj->findByPk($id); 
		if($post)
		{
			$post->delete();
			echo 'success';
		}
	}
	
	/*********** 	ADD COMMENTS FUNCTION  ***********/
	public function actionAddComments()
	{
		$commentsObj	=	new Comments();
		$sessionArray['loginId']	=	Yii::app()->session['loginId'];
		$sessionArray['userId']	=	Yii::app()->session['userId'];
		$result	=	$commentsObj->addItemComments($_POST, $sessionArray);
		echo json_encode($result);
	}
	
	/*********** 	DELETE REMINDER FUNCTION  ***********/
	public function actionDeleteReminder($id=NULL)
	{
		if(isset($id)){
			$reminderObj	=	new Reminder();
			$result	=	$reminderObj->deleteReminder($id);
			echo json_encode($result);
		} else {
			$this->redirect('index');
		}
	}
	
	/*********** 	DELETE TODO ITEM FUNCTION  ***********/
	public function actionDeleteItem($id=NULL)
	{
		if(isset($id)) {
			$todoItemObj	=	new TodoItems();
			$result	=	$todoItemObj->deleteItemById($id);
			//$result	=	array('status'=>0, 'message'=>'success');
			echo json_encode($result);
		} else {
			$this->redirect('index');
		}
	}
	
	public function actionReassignTask($id=NULL)
	{
		$loginObj=new Login();
		$loginData=$loginObj->getLoginDetailsById(Yii::app()->session['loginId'],'last_todoassign');
		$this->renderPartial('reassignTask', array('id'=>$id,'last_todoassign'=>$loginData['last_todoassign']));
	}
	
	/*********** 	ADD REMINDER FUNCTION  ***********/
	public function actionAddReminder($id=NULL)
	{
		$reminderObj	=	new Reminder();
		$data	=	array();
		if(isset($id)){
			$data	=	$reminderObj->getReminderById($id);
			$data['ampm']	=	date('a', strtotime($data['time']));
			$data['time']	=	date('g', strtotime($data['time']));
		}
		
		if($_POST){
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$reminderObj	=	new Reminder();
			
			if( !isset($_POST['id']) ) {
				$result	=	$reminderObj->addReminder($_POST, $sessionArray);
			} else {
				$result	=	$reminderObj->addReminder($_POST, $sessionArray, $_POST['id']);
			}
			
			echo json_encode($result);
			exit;
		}
		$todoListObj	=	new TodoLists();
		$data['lists']	=	$todoListObj->getAllMyList(Yii::app()->session['loginId']);
		unset($data['lists']['pendingItems']);
		$this->renderPartial('addReminder', array('data'=>$data));
	}
	
	public function actionReminderViewMore($id=NULL, $popUp=NULL)
	{
		$reminderObj	=	new Reminder();
		$reminder	=	$reminderObj->getReminderById($id);
		$this->renderPartial('reminderViewMore', array('data'=>$reminder));
	}
	
	//close account
	function actioncloseAccount()
	{
		
		//if($this->isAjaxRequest())
		//{
			$reason='';
			if(isset($_POST['reason']) && $_POST['reason']!='')
			{
				if($_POST['reason']!='' && $_POST['reason']!='Other')
				{
					$reason=$_POST['reason'];
				}
				else
				{
					$reason=$_POST['txtother'];
				}
				$loginObj=new Login();
				$result=$loginObj->deleteById(Yii::app()->session['loginId'],$reason);
				echo $result[1];
			}
			else
			{	
				$this->renderPartial('setting');	
			}
		/*}
		else
		{
			$this->render("/site/error");
		}*/
		
	}
	
	/*********** 	VIEW MORE FOR INVITATION FUNCTION  ***********/
	public function actionviewMoreInvite($id=NULL, $popUp=NULL)
	{
		$inviteObj	=	new Invites();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$data	=	$inviteObj->getInviteById($id);
		$data['listDetails']	=	$todoListsObj->getMyListById($data['listId']);
		$res	=	$usersObj->getUserDetail($data['listDetails']['createdBy']);
		$data['createdByDetails'] = $res['result'];
		if(isset($popUp)){
			$this->renderPartial('viewMoreInvitePopup', array('data'=>$data));
		} else {
			$this->renderPartial('viewMoreInvite', array('data'=>$data));
		}
	}
	
	function actionprefferedLanguage($lang='eng')
	{
		if(isset(Yii::app()->session['userId']) && Yii::app()->session['userId']>0)
		{
			$userObj=new User();
			$userObj->setPrefferedLanguage(Yii::app()->session['userId'],$lang);
		}
		
		Yii::app()->session['prefferd_language']=$lang;
		$this->redirect(Yii::app()->params->base_path."user/index");
	}
	
	
	function actionverifyPhone()
	{
		$this->render("verify_phone");
	}
	
	function actionquantityDetailForProduct()
	{
		$ticketObj = new TicketDesc();
		$totalQuantityForSales	=	$ticketObj->getTotalQuatityCountOfProductForSales($_REQUEST['product_id']);
		if($totalQuantityForSales == "")
		{
			$totalQuantityForSales = 0 ;	
		}
		
		$salesReturnObj = new SalesReturnDesc();
		$totalQuantityForSalesReturn	=	$salesReturnObj->getTotalQuatityCountOfProductForSalesReturn($_REQUEST['product_id']);
		
		if($totalQuantityForSalesReturn == "")
		{
			$totalQuantityForSalesReturn = 0 ;	
		}
		
		$purchaseObj = new Purchase();
		$totalQuantityForPurchase	=	$purchaseObj->getTotalQuatityCountOfProductForPurchase($_REQUEST['product_id']);
		
		if($totalQuantityForPurchase == "")
		{
			$totalQuantityForPurchase = 0 ;	
		}
		
		$purchaseReturnObj = new PurchaseReturnDetails();
		$totalQuantityForPurchaseReturn	=	$purchaseReturnObj->getTotalQuatityCountOfProductForPurchaseReturn($_REQUEST['product_id']);
		
		if($totalQuantityForPurchaseReturn == "")
		{
			$totalQuantityForPurchaseReturn = 0 ;	
		}
		
		
		$this->renderPartial("quantityDetailforProduct",array("product_name"=>$_REQUEST['product_name'],"totalQuantityForSales"=>$totalQuantityForSales,"totalQuantityForSalesReturn"=>$totalQuantityForSalesReturn,"totalQuantityForPurchase"=>$totalQuantityForPurchase,"totalQuantityForPurchaseReturn"=>$totalQuantityForPurchaseReturn));
	}
	
	
	
	
	/*********** 	Checking Email address except current account manager  ***********/ 
	function actioncheckOtherEmail($type=NULL)
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($type != NULL)
			{
				$userObj = new Users();
				$userId='-1';
				$result=$userObj->checkOtherEmail($_POST['email'],$userId,$type);
				if($result == '')
				{				
					echo false;
				}
				else
				{
					echo true;
				}
			}
		}
		
	}

	function actionLogin()
	{
		/***********		Login		************/
		if(isset($_POST['submit_login']))

		{
			$remember=0;
			if(isset($_POST['remenber']))
			{
				$remember=1;
			}
			
			$email_login = $_POST['email_login'];
			$password_login = $_POST['password_login'];
			$Userobj=new Users();		
			$result = $Userobj->login(trim($email_login),$password_login,$remember);
			if($result['status'] == 0)
			{
				$this->redirect(Yii::app()->params->base_path.'user/index');
				exit;
			}
			else
			{
				Yii::app()->user->setFlash('error', $this->msg['_LOGIN_ERROR_']);
				header('location:'.Yii::app()->params->base_path.'user/signin');
			}
		}
		else
		{
			header('location:'.BASE_PATH.'user/index');
		}
	
		exit;
	}
	
	function isAjaxRequest()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function actioneditProfile()
	{
		if(isset($_GET['id']))
		{
			$sessionArray['userId']		=	Yii::app()->session['userId'];
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$generalObj = new General();
			$users = new Users();
			$POST = $_POST;
			$result=$users->editProfile($POST,$sessionArray);
			/*echo "<pre>";
			print_r($result);
			exit;*/
			if(!empty($result) && $result['status'] == 0)
			{
				Yii::app()->session['fullname'] = '';
				Yii::app()->session['fullname'] = $_POST['fName'] .'&nbsp;'.$_POST['lName']; 
				
				Yii::app()->user->setFlash('success',$this->msg['_PROFILE_UPDATE_SUCCESS_MSG_']);
				$this->renderPartial('aboutme',array("isAjax"=>'true',"data"=>$_POST));
				exit;
			}
		}
		else
		{
			echo Yii::app()->user->setFlash('error', $result['message']); 
		}
	}
	
	/*********** 	Logout   ***********/ 
	function actionLogout()
	{
		if(isset($_POST['submit']))
		{	
			if(!isset(Yii::app()->session['shiftId']) || Yii::app()->session['shiftId'] == "")
			{
				Yii::app()->session->destroy();	
				$this->redirect(array("user/index"));		
			}
/*------------------------------- Check Closing Shift Detail Start-------------------------------------*/
			$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
			$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

			$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  			$admin_id = $userData->admin_id ;
			$store_id = $userData->store_id ;
			
			$customerGeneralObj = new CustomerGeneralEntry();
			$custGeneralData = $customerGeneralObj->getDailyAccount($admin_id,$store_id);
			
			$shiftObj = new Shift();
			$shiftData = $shiftObj->getShiftSummary();
			
			$ticketDetailsObj = new TicketDetails();
			$ticketData = $ticketDetailsObj->getDailyTotalSalesAmount();
			
			$salesReturnObj = new SalesReturnDetails();
			$salesReturnData = $salesReturnObj->getDailyTotalSalesReturnAmount();
			
			if($ticketData['cash']!=''){
				
				$cash = $ticketData['cash'];
			}else{
				$cash = 0;
			}
			
			/*if($ticketData['card']!=''){
				
				$card = $ticketData['card'];
			}else{
				$card = 0;
			}
			if($ticketData['credit']!=''){
				
				$credit = $ticketData['credit'];
			}else{
				$credit = 0;
			}
			if($ticketData['bank']!=''){
				
				$bank = $ticketData['bank'];
			}else{
				$bank = 0;
			}*/
			
			if($salesReturnData['returnAmount']!=''){
				
				$returnAmount = $salesReturnData['returnAmount'];
			}else{
				$returnAmount = 0;
			}
			
			$finalTotalIncoming = $shiftData['cash_in'] + $cash + $vaultData['withdraw'] ;
			$finalTotalOutgoing = $vaultData['deposite'] ;
			
			$finalTotalCash = $finalTotalIncoming - $finalTotalOutgoing ; 
			
			$finalCashShiftOut =  $_POST['cash_out'] + $returnAmount ;
			
			$difference = $finalCashShiftOut - $finalTotalCash ;
			
/*------------------------------- Check Closing Shift Detail Finish-------------------------------------*/			
			/*if($finalTotalCash == $finalCashShiftOut || $_POST['difference'] != "")
			{*/
			
			$filename = Yii::app()->session['userId'].'_SHIFT_'.Yii::app()->session['shiftId']."_".date("Ymd");
				$data['cashier_id']	=$_POST['cashier_id'];
				$data['cash_in']=Yii::app()->session['cash_in'];
				$data['cash_out']	=$_POST['cash_out'];
				$data['time_out']=date('Y-m-d:H-m-s');
				$data['admin_id']=$admin_id;
				$data['fileName']=$filename;
				
				$shiftObj = new Shift();
				$shiftObj->setData($data);
				$shiftObj->insertData(Yii::app()->session['lastId']);
				
				
				$shiftObj = new Shift();
				$shiftData = $shiftObj->getShiftSummary();
				
				$ticketDetailsObj = new TicketDetails();
				$ticketData = $ticketDetailsObj->getDailyTotalSalesAmount();
				
				if($ticketData['cash']!=''){
					
					$cash = $ticketData['cash'];
				}else{
					$cash = 0;
				}
				
				if($ticketData['card']!=''){
					
					$card = $ticketData['card'];
				}else{
					$card = 0;
				}
				if($ticketData['credit']!=''){
					
					$credit = $ticketData['credit'];
				}else{
					$credit = 0;
				}
				if($ticketData['bank']!=''){
					
					$bank = $ticketData['bank'];
				}else{
					$bank = 0;
				}
				
				$salesReturnObj = new SalesReturnDetails();
				$salesReturnData = $salesReturnObj->getDailyTotalSalesReturnAmount();
				
				if($salesReturnData['returnAmount']!=''){
					
					$returnAmount = $salesReturnData['returnAmount'];
				}else{
					$returnAmount = 0;
				}
				//$shiftData['shift_id'] = 1;
				
				$vaultObj = new Vault();
				$vaultData = $vaultObj->getVaultDetails($shiftData['shift_id']);
				$totalDeposite = ($vaultData['deposite'])-($vaultData['withdraw']);
				
				$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
				$admin_id = $userData->admin_id ;
				$store_id = $userData->store_id ;
				
				$customerGeneralObj = new CustomerGeneralEntry();
				$custGeneralData = $customerGeneralObj->getDailyAccount($admin_id,$store_id);
				
				$finalCredit = $custGeneralData['credit'] - $custGeneralData['debit'] ; 
				
				$finalClosingBalance =  ($shiftData['cash_out'] + $card ) - ($finalCredit);
				
				
				/*echo "CashOut : ".$shiftData['cash_out'];
				echo "- withdraw : ".$vaultData['withdraw'];
				echo "+ deposite : ".$vaultData['deposite'];
				echo "+ returnAmount : ".$returnAmount;
				echo "- cash : ".$cash;
				echo "- cash_in : ".$shiftData['cash_in'] ;
				exit;
				*/
				$difference = $shiftData['cash_out'] - $vaultData['withdraw'] +  $vaultData['deposite'] + $returnAmount - $cash - $shiftData['cash_in'] ;
				/*echo "<pre>";
				print_r($shiftData);
				print_r($ticketData);
				print_r($salesReturnData);
				print_r($vaultData);
				print_r($custGeneralData);
				exit;*/
				
				
				$html = "
						<table cellpadding='5' cellspacing='5' border='0'>
						<tr>
							<td colspan='4' align='center' style='background-color:#000; color:#FFF;'><b>".$adminObj->company_name."</b></td>
						</tr>
						<tr>
							<td colspan='4' align='right'>date :: ".date('Y-m-d')."</td>
						</tr>
	
						<tr>
							<td colspan='4'>&nbsp;</td>
						</tr>
						<tr>
							<td colspan='4' align='center'><b>SHIFT END REPORT [ <a href='".Yii::app()->params->base_path."site'>Back</a> ] </b></td>
						</tr>
						<tr bgcolor='#FFFF99'>
							<td>SHIFT ID</td>
							<td>CASHER</td>
							<td>SHIFT IN</td>
							<td>SHIFT OUT</td>
						</tr>
						<tr>
							<td>".$shiftData['shift_id']."</td>
							<td>".Yii::app()->session['fullname']."</td>
							<td>".$shiftData['time_in']."</td>
							<td>".$shiftData['time_out']."</td>
						</tr>
						<tr bgcolor='#FFFF99'>
							<td>NO.</td>
							<td>PARTICULARS</td>
							<td align='right'>AMOUNT*(".Yii::app()->session['currency'].")</td>
							<td></td>
						</tr>
						<tr>
							<td>1</td>
							<td><b>Opening Cash in Cash Counter</b></td>
							<td align='right'><b>".$shiftData['cash_in']."</b></td>
							<td>+</td>
						</tr>
						<tr>
							<td>2</td>
							<td><b>Sales:</b></td>
							<td></td>
							<td></td>
						</tr>
							<tr>
								<td></td>
								<td>Cash</td>
								<td align='right'>".$cash."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Credit Card</td>
								<td align='right'>".$card."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Credit</td>
								<td align='right'>".$credit."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Bank(Cheque)</td>
								<td align='right'>".$bank."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td align='right'><b>TOTAL SALES</b></td>
								<td align='right'><b>".($card + $cash + $credit + $bank)."</b></td>
								<td>+</td>
							</tr>
						<tr>
							<td>3</td>
							<td><b>Sales Return:</b></td>
							<td></td>
							<td></td>
						</tr>
							<tr>
								<td></td>
								<td>Amount</td>
								<td align='right'>".$returnAmount."</td>
								<td></td>
							</tr>
							
							<tr>
								<td></td>
								<td align='right'><b>TOTAL SALES RETURN</b></td>
								<td align='right'><b>".$returnAmount."</b></td>
								<td>-</td>
							</tr>
						<tr>
							<td>4</td>
							<td><b>Safe Vault:</b></td>
							<td></td>
							<td></td>
						</tr>
							<tr>
								<td></td>
								<td>Cash Withdraw</td>
								<td align='right'>".$vaultData['withdraw']."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Cash Deposit</td>
								<td align='right'>".$vaultData['deposite']."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td align='right'><b>TOTAL DROPPED IN SAFE</b></td>
								<td align='right'><b>".$totalDeposite."</b></td>
								<td>-</td>
							</tr>
						<tr>
							<td>5</td>
							<td><b>Closing Balance in Cash Counter:</b></td>
							<td></td>
							<td></td>
						</tr>
							<tr>
								<td></td>
								<td>Cash Balance</td>
								<td align='right'>".$shiftData['cash_out']."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Difference In  Balance</td>
								<td align='right'>".$difference."</td>
								<td></td>
							</tr>
					</table>";
		
				$mpdf = new mPDF();
		
				
				$mpdf->WriteHTML($html);
				$mpdf->Output(FILE_PATH."assets/upload/pdf/".$filename.".pdf", 'F');
					
				global $msg;
				$user['isOnline'] = '0';
				$userObj = new Users();
				$userObj->setData($user);
				$userObj->insertData(Yii::app()->session['userId']);
				
				$id=Yii::app()->session['loginId'];
				/*$userObj = new Users();
				$userObj->setOffline($id);*/
				$temp=Yii::app()->session['prefferd_language'];
				if(isset(Yii::app()->session['loginId']))
				{
					Yii::app()->session->destroy();			
				}
				
				
				Yii::app()->session['prefferd_language']=$temp;		
				header('location:'.Yii::app()->params->base_url."assets/upload/pdf/".$filename.".pdf");
				exit;
			//}
			/*else
			{
				
				if($this->isAjaxRequest())
				{	
					if($difference < 0)
					{
						echo Yii::app()->user->setFlash('error',"Amount of ".-($difference)." is missing in Your Total. Please kindly check it."); 
					}
					else if ($difference > 0)
					{
						echo Yii::app()->user->setFlash('error',"Amount of ".$difference." is exceeds in Your Total. Please kindly check it."); 
					}
					$this->renderPartial('exit',array("isAjax"=>'true',"difference"=>$difference));
				}
				else
				{
					if($difference < 0)
					{
						echo Yii::app()->user->setFlash('error',"Amount of ".-($difference)." is missing in Your Total. Please kindly check it."); 
					}
					else if ($difference > 0)
					{
						echo Yii::app()->user->setFlash('error',"Amount of ".$difference." is exceeds in Your Total. Please kindly check it."); 
					}
					$this->render('exit',array("isAjax"=>'false',"difference"=>$difference));
				}	
			}*/
			
		}
		else
		{
			if($this->isAjaxRequest())
			{	
				$this->renderPartial('exit',array("isAjax"=>'true'));
			}
			else
			{
				$this->render('exit',array("isAjax"=>'false'));
			}		
		}
	}
	
	
	
	
	/*********************Get Web Phone Verify*******************/
	function actiongetVerifyCode()
	{
		$jsonarray= array();
		
		if(isset($_POST['phone']))
		{
			$userObj=new Users();
			if(!is_numeric($_POST['phone'])){
				$algoencryptionObj	=	new Algoencryption();
				$_POST['phone']	=	$algoencryptionObj->decrypt($_POST['phone']);
			}
			$result=$userObj->getVerifyCodeById($_POST['phone'],'-1');
			$jsonarray['status']=$result['status'];
			$jsonarray['message']=$result['message'];
		}
		else
		{
			$message=$this->msg['ONLY_PHONE_VALIDATE'];
			$jsonarray['status']='false';
			$jsonarray['message']=$message;
		}
		echo $jsonarray['message'];
	}
	
	/*********** 	Checking phone number  ***********/ 
	function actionchkPhone($type=0)
	{
		global $msg;	
		$generalObj=new General();
		$userObj=new Users();
		$loginObj=new Login();
		$phone=$generalObj->clearPhone($_POST['phoneNumber']);
		if(isset(Yii::app()->session['loginId']) && Yii::app()->session['loginId']!='')
		{
			$session=new CHttpSession;
			$result=$loginObj->isExistPhone($phone,1,$session);	
		}
		else
		{
			$result=$loginObj->isExistPhone($phone,1);	
		}
		
		if($result)
		{	
			if(isset(Yii::app()->session['loginId']) && Yii::app()->session['loginId']!='')
			{
				$userId=0;
				
				$resultmore=$loginObj->isVerifiedPhone(Yii::app()->session['loginId'],$phone,$userId);
			
				if($resultmore)
				{
					echo 2;
				}
				else
				{
					echo true;
				}
			}
			else
			{			
				echo true;
			}
		}
		else
		{
			echo false;
		}
	}
	
	function actiongetActiveVerifyCode()
	{
		$jsonarray= array();
		if(isset($_POST['phone']))
		{	
			$userObj=new User();
			$result=$userObj->getVerifyCode($_POST['phone'],'-1');
			$jsonarray['status']=$result[0];
			$jsonarray['message']=$result[1];
			
		}
		else
		{
			$message=$this->msg['ONLY_PHONE_VALIDATE'];
			$jsonarray['status']='false';
			$jsonarray['message']=$message;
		}
		echo $jsonarray['status'].'**'.$jsonarray['message']; 
	}
	
	function actionrecentTicket()
	{
			$ticketObj=new TicketDetails();
			$result=$ticketObj->getRecentPendingTickets();
			$this->renderPartial('recentTicket', array('result'=>$result));
			
	}
	
	/*********************Phone Verify*******************/
	function actionVerifyNow()
	{
		if(isset($_POST['phoneNumber']))
		{
			$verify_code=rand(10,99).rand(10,99).rand(10,99);
			$verify_sms = new VerifySms();
			$verify_sms->setVerifyCode($_POST['phoneNumber'],$verify_code);
			echo $verify_code;
		}
	}
	
	/*****************method - change password ***************/
	function actionchangePassword()
	{
		error_reporting(E_ALL);
		if($this->isAjaxRequest())
		{
			$algoencryptionObj	=	new Algoencryption();
			$generalObj	=	new General();
			$encryptedUserId	=	$algoencryptionObj->encrypt(Yii::app()->session['loginId']);
			
			if(isset($_POST['oldpassword']))
			{
				$_POST['userId']=Yii::app()->session['loginId'];
				$user = new Users();
				$result=$user->changePassword($_POST);
				if($result[0]==true)
				{
					Yii::app()->user->setFlash('success',$this->msg['_PASSWORD_CHANGE_SUCCESS_']);
					$this->renderPartial('changepassword',array("isAjax"=>'true'));
					 exit;
				}
				else
				{
					
					Yii::app()->user->setFlash('error',$result[1]);
					$this->renderPartial('changepassword',array("isAjax"=>'true'));
					exit;
				}			
			}
			else
			{
				$this->renderPartial('changepassword',array('result'=>'','fToken'=>'',
									'encryptedUserId'=>$encryptedUserId,'userId'=>Yii::app()->session['loginId']));
				
			}
		}
		else
		{
			
			$this->render("/site/error");
		}
	}
	
	function actioncheckemail()
	{
		$email = $_GET['email'];
		$loginObj = new Login();
		$res = $loginObj->checkOtherEmail($email);
		if(isset($res) && $res!='')
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		exit;
	}
	
	public function actionSetting()
	{
		$this->renderPartial('setting');
	}
	
	public function actionmyNetwork($sortType='desc', $sortBy='id', $flag=0)
	{
		$todoNetworkObj	=	new Todonetwork();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		$networks	=	$todoNetworkObj->getMyPaginatedNetwork(Yii::app()->session['loginId'], LIMIT_10, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		$todoLists = new TodoLists();
		$list = $todoLists->getAllMyList(Yii::app()->session['loginId']);
		unset($list['pendingItems']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$networks['sortBy']	=	$sortBy;
		$this->renderPartial('myNetwork', array('networks'=>$networks,'list'=>$list,'ext'=>$ext));
	}
	
	public function actionmyNetworkUser()
	{	
		$todoNetworkObj	=	new Todonetwork();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		
		$networks	=	$todoNetworkObj->getMyPaginatedNetwork(Yii::app()->session['loginId'],LIMIT_10, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$this->renderPartial('myNetworkUser', array('networks'=>$networks,'ext'=>$ext));
	}
	
	public function actiongetNetworkUserDetails()
	{
		$id = $_GET['id'];
		$toDoNetworkObj = new Todonetwork();
		$dataProvider=$toDoNetworkObj->getNetworkUserDetail($id);
		$this->renderPartial('myNetworkUserDetail', array('dataProvider'=>$dataProvider));
		
	}
	
	public function actionremoveFrommyNetwork()
	{
		$id = $_GET['id'];
		$todoNetwork=Todonetwork::model()->findbyPk($id);
		$todoNetwork->delete();
		$this->actionmyNetwork();
	}
	
	public function actionremoveList($id=NULL)
	{
		$id = $_GET['id'];
		$toDoListObj =  new TodoLists();
		$res = $toDoListObj->deleteList($id);
		$this->actionmyLists();
	}
	
	public function actionupdateToDoList()
	{
		$data  = array();
		$data['name'] = $_GET['title'];
		$data['description'] = $_GET['desc'];
		$data['id'] = $_GET['listId'];
		$todoLists=TodoLists::model()->findbyPk($data['id']);
		$todoLists->setData($data);
		$todoLists->insertData($data['id']);
		echo 1;
	}
	
	public function actionupdateLink()
	{
		if($this->isAjaxRequest())
	 	{	
			$userObj	=	new Users();
			$_POST['id']	=	Yii::app()->session['userId'];
			$res	=	$userObj->updateSocialLink($_POST);
			
			if($res['status']==0)
			{
				echo "success";
			}
			else
			{
				echo "error";
			}
		}
		else
		{
			$this->render("/site/error");
		}
	}
	
	/*****************method - add phone number ***************/
	public function actionaddUniquePhone()
	{
		
		if($this->isAjaxRequest())
		{
			if(isset($_POST['userphoneNumber'])) 
			{
				$sessionArray['loginId']=Yii::app()->session['loginId'];
				$sessionArray['userId']=Yii::app()->session['userId'];
				$loginObj=new Login();
				$total=$loginObj->gettotalPhone($sessionArray['userId'],1);
				if($total > 1)
				{
					echo "Limit Exist!";
					exit;
				}
				$totalUnverifiedPhone=$loginObj->gettotalUnverifiedPhone($sessionArray['userId'],1);
				if($totalUnverifiedPhone==1)
				{
					echo "Please first verify unverified phone.";
					exit;
				}
			
				$result=$loginObj->addPhone($_POST,1,$sessionArray);
				
				if($result['status']==0)
				{
					echo "success";
				}
				else
				{
					echo $result['message']; 
				}
			}
		}
		else
		{
			$this->render("/site/error");
		}
	}	
	
	/*****************method - Phone list ***************/
	function actionUserPhoneList()
	{
		//if($this->isAjaxRequest())
		//{
			$loginObj=new Login();
			
			$algoencryptionObj	=	new Algoencryption();
			$userArray=$loginObj->getPhones(Yii::app()->session['userId'],1);
			$i	=	0;
			foreach($userArray as $phoneId){
				$userArray[$i]['encryptedId']	= $algoencryptionObj->encrypt($phoneId['id']);
				$i++;
			}
			$userPhoneArray=$userArray;
			$totalVerfied = $loginObj->gettotalVerifiedPhone(Yii::app()->session['accountManagerId'],1);
			$sessionArray['userId']=Yii::app()->session['userId'];
			$sessionArray['employerId']=Yii::app()->session['employerId'];
			$sessionArray['accountManagerId']=Yii::app()->session['accountManagerId'];
			$userObj = new Users();
			$loggedin_user=$userObj->getUserDetail(Yii::app()->session['loginId']);
			$loggedin_user=$loggedin_user['result'];      
			$totalVerfied=$totalVerfied;
			$this->renderPartial('leftphonelist',array('userPhoneArray'=>$userPhoneArray,'loggedin_user'=>$loggedin_user,'totalVerfied'=>$totalVerfied));
		/*}
		else
		{
			$this->render("/site/error");
		}*/
	}
	
	public function actionRemindMe($reminderId=NULL)
	{
		$reminderObj	=	new Reminder();
		$sessionArray['loginId']	=	Yii::app()->session['loginId'];
		$result	=	$reminderObj->remindMe($reminderId, $sessionArray);
		echo json_encode($result);
	}
	
	function actiontest()
	{
		$reminderObj	=	new Reminder();
		$reminderObj->getReminderEmail(2, 4, 2, 0);
	}

	public function actionMyworkstatus()
	{
		$todoListsObj =  new TodoLists();

		$myLists = $todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($myLists['pendingItems']);
		$this->renderpartial('myworkstatus',array('mylist'=>$myLists), 0, true);
		
	}
	
	public function actionmessageSend()
	{
		$messageList=MessageTemplate::model()->findAll();
		$this->renderPartial("send_message",array('messageList'=>$messageList,'id'=>$_GET['id'],'name'=>$_GET['name']));
	}
	
	public function actionsendMessageToCollegues()
	{
		$messageObj = new Messages();
		$data = array();
		$data['message'] = $_POST['messageText'];
		$data['sender_id'] =  Yii::app()->session['userId'];
		$data['receiver_id'] = $_POST['id'];
		$data['created'] = date("Y-m-d H:i:s");
		$messageObj->setData($data);
		$messageObj->insertData();
		
		$email=Yii::app()->session['email'];
		Yii::app()->user->setFlash('success',$this->msg['_MESSAGE_SEND_SUCCESS_MSG_']);
		$userObj= new Users();
		$res = $userObj->getAllOnlineUsers($email);
		$this->renderPartial('collegues', array('data'=>'','pagination'=>'','ext'=>'','res'=>$res));
		
	}
	
	public function actiongetProductDetail()
	{
		$productObj = new Product();
		$data = $productObj->getProductDetails($_REQUEST['product_id']);
		$this->renderpartial('productDescription',array('data'=>$data));
		
	}
	
	function actiongrantCreditTransaction()
	{
		
		$adminObj	=	new Admin();
		$adminData = $adminObj->getAdminDetailsById(1);
		
		$generalObj	=	new General();
		$isValid	=	$generalObj->validate_password($_POST['grantCode'], $adminData['password']);
		echo  $isValid;
		
	}
	
	function actionaddCustomerView()
	{
		$this->render("addCustomer");
	}
	
	function actionaddCustomer($customer_id=NULL)
	{
		//error_reporting(E_ALL);
		$this->isLogin();
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		$customerObj = new Customers();
		
        $title = 'Add Customer';
        $result = array();
        if ($customer_id != NULL) {
            $title = 'Edit Customer';
            $result = $customerObj->getCustomerDetails($customer_id);
            $_POST['customer_id'] = $result['customer_id'];
        }
        if (isset($_POST['FormSubmit'])) 
		{
			$customer_id = NULL;
			$data['admin_id'] = $admin_id;
            $data['customer_name'] = $_POST['customer_name'];
			$data['cust_address'] = $_POST['cust_address'];
			$data['cust_email'] = $_POST['cust_email'];
			$data['contact_no'] = $_POST['contact_no'];
			$data['credit'] = $_POST['credit'];
			$data['debit'] = $_POST['debit'];
			$data['rating'] = $_POST['rating'];
			$data['total_purchase'] = $_POST['total_purchase'];
			$data['status'] = $_POST['status'];
			
			if (isset($_POST['customer_id']) && $_POST['customer_id'] != '') 
			{
				$data['modifiedAt'] = date("Y-m-d H:i:s");
                $customer_id = $_POST['customer_id'];
				
				$customerObj->setData($data);
                $customerObj->insertData($customer_id);
/*--------------------------------Start Query Log Function----------------------------------------------*/
				$querylogObj = new TblQuerylog();
				$lastLogId = $querylogObj->getLastLogId();
				
				$query['table_log_id'] =$customer_id;
				$query['table_name'] = 'customers';
				
				$querylogObj = new TblQuerylog();
				$querylog_id = $querylogObj->checkLogId($query['table_log_id'],$query['table_name']);
				
				$query['querylog_id'] =$querylog_id;
				
				$query['log_id'] = $lastLogId + 1 ;
				
				$query['query'] = "INSERT OR REPLACE INTO customers ('customer_id', 'admin_id', 'customer_name', 'cust_address', 'cust_email', 'contact_no', 'rating','credit','debit', 'total_purchase', 'createdAt', 'modifiedAt', 'status') VALUES (".$query['table_log_id'].", '".$data['admin_id']."', '".$data['customer_name']."', '".$data['cust_address']."', '".$data['cust_email']."', '".$data['contact_no']."', '".$data['rating']."','".$data['credit']."','".$data['debit']."', '".$data['total_purchase']."', '".$data['createdAt']."', '".$data['modifiedAt']."', '".$data['status']."'); " ;
				
				$querylogObj = new TblQuerylog();
				$querylogObj->setData($query);
                $insertedId = $querylogObj->insertData($query['querylog_id']);
/*--------------------------------End Query Log Function----------------------------------------------*/
				Yii::app()->user->setFlash('success', $this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' .  $_SERVER['HTTP_REFERER']);
                exit;
            } 
			
			else 
			{
                $data['createdAt'] = date("Y-m-d H:i:s");
				$customerObj->setData($data);
                $insertedId = $customerObj->insertData();
/*--------------------------------Start Query Log Function----------------------------------------------*/

				$querylogObj = new TblQuerylog();
				$lastLogId = $querylogObj->getLastLogId();
				
				$query['table_log_id'] =$insertedId;
				$query['table_name'] = 'customers';
				$query['log_id'] = $lastLogId + 1 ;

				$query['query'] = "INSERT OR REPLACE INTO customers ('customer_id', 'admin_id', 'customer_name', 'cust_address', 'cust_email', 'contact_no', 'credit', 'total_purchase', 'createdAt', 'modifiedAt', 'status') VALUES (".$query['table_log_id'].", '".$data['admin_id']."', '".$data['customer_name']."', '".$data['cust_address']."', '".$data['cust_email']."', '".$data['contact_no']."', '".$data['credit']."', '".$data['total_purchase']."', '".$data['createdAt']."', NULL, '".$data['status']."'); " ;
				
				$querylogObj = new TblQuerylog();
				$querylogObj->setData($query);
                $insertedId = $querylogObj->insertData();
				
/*--------------------------------End Query Log Function----------------------------------------------*/


				Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }
			
        }

        $data = array('result' => $result,'advanced' => "Selected", 'title' => $title);
        Yii::app()->session['current'] = 'customers';
		?>
        <script>
		alert("test");
		 $j.fancybox.close();
		</script>
        <?php
		//$this->render('addCustomer', $data);
	}
	
	function actiongeneratePaymentRecipts($receiptId)
	{
		error_reporting(0);
		$obj = CustomerGeneralEntry::model()->findbyPk($receiptId);
		
		$customerObj = Customers::model()->findbyPk($obj->customer_id);
		
		if($obj->paymentType == 1)
		{
			$paymentType = "Cash";	
		} else if ($obj->paymentType == 2)
		{
			$paymentType = "Card";
		}else if ($obj->paymentType == 3)
		{
			$paymentType = "Cheque";	
		}
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">Payment Receipt</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">Receipt NO: '. $obj->id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($obj->createdAt)).'</td>
		  </tr>
		  
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($obj->createdAt)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>To,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="left" >Customer : '.$customerObj->customer_name.'</td>
			<td>&nbsp;</td>
			<td align="right" >&nbsp;</td>
		  </tr>
		  
		</table>
		
		<p>&nbsp;</p>
		<table>
			<tr>
				<td>
				Amount Received('.Yii::app()->session['currency'].') '.$obj->debit.'<br><br>
				Amount Paid('.Yii::app()->session['currency'].') '.$obj->credit.'<br><br><br>
				[ by ]'.$paymentType.'<br><br><br>
		
				For: ________________________________________________<br><br>
				
				Money Received by: '.Yii::app()->session['fullname'].'<br>
				<br><br>
				</td>
			</tr>
		</table>
		
		';
		
		$html .= '
		</body>
		</html>';
		
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/recipt".$obj->id.".pdf", 'F');
		
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/recipt<?php echo $obj->id ;?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		$this->actionIndex();
		//$this->redirect(array("user"));
}
	
	
	function actiongenerateGeneralRecipts($generalId)
	{
		$obj = GeneralEntry::model()->findbyPk($generalId);
		
		if($obj->paymentType == 1)
		{
			$paymentType = "Cash";	
		} else if ($obj->paymentType == 2)
		{
			$paymentType = "Card";
		}else if ($obj->paymentType == 3)
		{
			$paymentType = "Cheque";	
		}
		
		if($obj->credit == '')
		{
			$obj->credit = "0";	
		} 
		
		if($obj->debit == '')
		{
			$obj->debit = "0";	
		}
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ; 
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">Payment Receipt</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">Receipt NO: '. $obj->general_id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($obj->created)).'</td>
		  </tr>
		  
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($obj->created)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>To,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="left" >Account : '.$obj->account.'</td>
			<td>&nbsp;</td>
			<td align="right" >&nbsp;</td>
		  </tr>
		  
		</table>
		
		<p>&nbsp;</p>
		<table>
			<tr>
				<td>
				Amount Received('.Yii::app()->session['currency'].') '.$obj->debit.'<br><br>
				Amount Paid('.Yii::app()->session['currency'].') '.$obj->credit.'<br><br><br>
				[ by ]'.$paymentType.'<br><br><br>
		
				For: '.$obj->description.'<br><br>
				
				Money Received by: '.Yii::app()->session['fullname'].'<br>
				<br><br>
				</td>
			</tr>
		</table>
		
		';
		
		$html .= '
		</body>
		</html>';

			

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/reciptForOther".$obj->general_id.".pdf", 'F'); ?>
		<script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/reciptForOther<?php echo $obj->general_id ;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		$this->actionIndex();
	}
	
	function actiongenerateSupplierPaymentRecipts($receiptId)
	{
		$obj = SupplierGeneralEntry::model()->findbyPk($receiptId);
		
		$supplierObj = Supplier::model()->findbyPk($obj->supplier_id);
		
		if($obj->paymentType == 1)
		{
			$paymentType = "Cash";	
		} else if ($obj->paymentType == 2)
		{
			$paymentType = "Card";
		}else if ($obj->paymentType == 3)
		{
			$paymentType = "Cheque";	
		}
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ; 
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">Payment Receipt</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">Receipt NO: '. $obj->id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($obj->createdAt)).'</td>
		  </tr>
		  
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($obj->createdAt)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>To,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="left" >Supplier : '.$supplierObj->supplier_name.'</td>
			<td>&nbsp;</td>
			<td align="right" >&nbsp;</td>
		  </tr>
		  
		</table>
		
		<p>&nbsp;</p>
		<table>
			<tr>
				<td>
				Amount Received('.Yii::app()->session['currency'].') '.$obj->debit.'<br><br>
				Amount Paid('.Yii::app()->session['currency'].') '.$obj->credit.'<br><br><br>
				[ by ]'.$paymentType.'<br><br><br>
		
				For: ________________________________________________<br><br>
				
				Money Received by: '.Yii::app()->session['fullname'].'<br>
				<br><br>
				</td>
			</tr>
		</table>
		
		';
		
		$html .= '
		</body>
		</html>';

			

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/recipt".$obj->id.".pdf", 'F'); ?>
		<script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/recipt<?php echo $obj->id ;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		$this->actionIndex();
	}
	
	function actiongetTotalPayableReportForSupplier()
	{
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		
		include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		
		
		$qry="select supplier.supplier_name as 'Supplier Name' , (supplier.debit - supplier.credit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from supplier_general_entry where supplier_id = supplier.supplier_id order BY id desc LIMIT 1 ) as 'Balance as on Date' from supplier LEFT JOIN supplier_general_entry ON (supplier_general_entry.supplier_id = supplier.supplier_id ) where supplier.debit - supplier.credit > 0 and supplier.admin_id =  ".$admin_id." Group by supplier.supplier_id ; "; 
		
		$exp->exportWithQuery($qry,"ExportData.xls",$conn);
		
		exit;
	}
	
	function actiongetTotalReceivableReportForSupplier()
	{
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		
		include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*$qry="select supplier.supplier_name as 'Supplier Name' , (supplier.credit - supplier.debit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from supplier_general_entry where supplier_id = supplier.supplier_id order BY id desc LIMIT 1 ) as 'Balance as on Date' from supplier LEFT JOIN supplier_general_entry ON (supplier_general_entry.supplier_id = supplier.supplier_id ) where supplier.credit - supplier.debit > 0 and supplier.admin_id =  ".$admin_id." Group by supplier.supplier_id ; "; */
		
		$qry = "select s.supplier_name as 'Supplier Name' , (s.credit - s.debit) as 'Amount' , (select createdAt  from supplier_general_entry where supplier_id = s.supplier_id order BY id desc LIMIT 1) as 'balance' from supplier_general_entry sg, supplier s where s.credit - s.debit > 0 and s.admin_id =  ".$admin_id." Group by s.supplier_id ";
		
		$exp->exportWithQuery($qry,"ExportData.xls",$conn);
		
		exit;
		
	}
	
	function actiongetTotalPayableReportForCustomer()
	{
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		
		include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'ISO-8859-6'");
		
		
		
		
		$qry="select customers.customer_name as 'Customer Name' , (customers.debit - customers.credit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from customer_general_entry where customer_id = customers.customer_id order BY id desc LIMIT 1  ) as 'Balance as on Date' from customers LEFT JOIN customer_general_entry ON (customer_general_entry.customer_id = customers.customer_id ) where customers.debit - customers.credit > 0 and customers.admin_id =  ".$admin_id." Group by customers.customer_id ; "; 
		
		$exp->exportWithQuery($qry,"ExportData.xls",$conn);
		
		exit;
	}
	
	function actiongetTotalReceivableReportForCustomer()
	{
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		
		include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*mysql_query("character_set_connection = 'utf8'");
		
		mysql_query("character_set_client = 'utf8'");
		
		mysql_query("character_set_server = 'utf8'");*/
		
		$qry="select customers.customer_name as 'Customer Name' , (customers.credit - customers.debit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from customer_general_entry where customer_id = customers.customer_id order BY id desc LIMIT 1 ) as 'Balance as on Date' from customers LEFT JOIN customer_general_entry ON (customer_general_entry.customer_id = customers.customer_id ) where customers.credit - customers.debit > 0 and customers.admin_id =  ".$admin_id." Group by customers.customer_id ; "; 
		
		$exp->exportWithQuery($qry,"ExportData.xls",$conn);
		
		exit;		

	}
	
	function actionpdfReportForCustomerReceivableReport()
	{
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		$date = date('d-m-Y');
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		//include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		//$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*mysql_query("character_set_connection = 'utf8'");
		
		mysql_query("character_set_client = 'utf8'");
		
		mysql_query("character_set_server = 'utf8'");*/
		
		$qry="select customers.customer_name as 'Customer Name' , (customers.credit - customers.debit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from customer_general_entry where customer_id = customers.customer_id order BY id desc LIMIT 1 ) as 'Balance as on Date' from customers LEFT JOIN customer_general_entry ON (customer_general_entry.customer_id = customers.customer_id ) where customers.credit - customers.debit > 0 and customers.admin_id =  ".$admin_id." Group by customers.customer_id ; "; 
		
		$test = mysql_query($qry,$conn);
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right">DATE: '.$date.'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="23%" align="right">TIME: '.date('H:i:s',strtotime($date)).'<font color="#808080"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 </table>
		<h2 align="center">Account Receivable Report(for Customer)</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td height="20" align="center">Customer Name</td>
			<td align="center">Amount('.Yii::app()->session['currency'].')</td>
			<td align="center">Balance as on Date</td>
		</tr>';
		  
	while($row=mysql_fetch_array($test))  
	{
        $html .=  '<tr>
			<td height="20" align="left">'.$row['Customer Name'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['Amount'].'</td>
			<td align="center">&nbsp;'.$row['Balance as on Date'].'</td>
		  </tr>';
    } 
	
		$html .= '</table>';
		$pdfId = date('Y_m_d_H_m_s');	
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/CustomerReceivableReport".$pdfId.".pdf", 'F');
		
		$this->actionIndex();
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/CustomerReceivableReport<?php echo $pdfId ; ?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	function actionpdfReportForCustomerPayableReport()
	{
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		$date = date('d-m-Y');
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		//include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		//$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*mysql_query("character_set_connection = 'utf8'");
		
		mysql_query("character_set_client = 'utf8'");
		
		mysql_query("character_set_server = 'utf8'");*/
		
		$qry="select customers.customer_name as 'Customer Name' , (customers.debit - customers.credit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from customer_general_entry where customer_id = customers.customer_id order BY id desc LIMIT 1  ) as 'Balance as on Date' from customers LEFT JOIN customer_general_entry ON (customer_general_entry.customer_id = customers.customer_id ) where customers.debit - customers.credit > 0 and customers.admin_id =  ".$admin_id." Group by customers.customer_id ; ";  
		
		$test = mysql_query($qry,$conn);
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right">DATE: '.$date.'<font color="#808080"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="23%" align="right">TIME: '.date('H:i:s',strtotime($date)).'<font color="#808080"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 </table>
		<h2 align="center">Account Payable Report(for Customer)</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td height="20" align="center">Customer Name</td>
			<td align="center">Amount('.Yii::app()->session['currency'].')</td>
			<td align="center">Balance as on Date</td>
		</tr>';
		  
	while($row=mysql_fetch_array($test))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['Customer Name'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['Amount'].'</td>
			<td align="center">&nbsp;'.$row['Balance as on Date'].'</td>
		  </tr>';
    } 
	
		$html .= '</table>';
		$pdfId = date('Y_m_d_H_m_s');	
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/CustomerPayableReport".$pdfId.".pdf", 'F');
		
		$this->actionIndex();
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/CustomerPayableReport<?php echo $pdfId ; ?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	function actionpdfReportForSupplierPayableReport()
	{
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		$date = date('d-m-Y');
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*mysql_query("character_set_connection = 'utf8'");
		
		mysql_query("character_set_client = 'utf8'");
		
		mysql_query("character_set_server = 'utf8'");*/
		
		$qry="select supplier.supplier_name as 'Supplier Name' , (supplier.debit - supplier.credit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from supplier_general_entry where supplier_id = supplier.supplier_id order BY id desc LIMIT 1 ) as 'Balance as on Date' from supplier LEFT JOIN supplier_general_entry ON (supplier_general_entry.supplier_id = supplier.supplier_id ) where supplier.debit - supplier.credit > 0 and supplier.admin_id =  ".$admin_id." Group by supplier.supplier_id ; ";  
		
		$test = mysql_query($qry,$conn);
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right">DATE: '.$date.'<font color="#808080"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="23%" align="right">TIME: '.date('H:i:s',strtotime($date)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 </table>
		<h2 align="center">Account Payable Report(for Supplier)</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td align="center" height="20">Supplier Name</td>
			<td align="center">Amount('.Yii::app()->session['currency'].')</td>
			<td align="center">Balance as on Date</td>
		</tr>';
		  
	while($row=mysql_fetch_array($test))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['Supplier Name'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['Amount'].'</td>
			<td align="center">&nbsp;'.$row['Balance as on Date'].'</td>
		  </tr>';
    } 
	
		$html .= '</table>';
		$pdfId = date('Y_m_d_H_m_s');	
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/SupplierPayableReport".$pdfId.".pdf", 'F');
		
		$this->actionIndex();
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/SupplierPayableReport<?php echo $pdfId ; ?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	function actionpdfReportForSupplierReceivableReport()
	{
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		$date = date('d-m-Y');
		
		$adminObj=Admin::model()->findByPk(Yii::app()->session['user_adminId']);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*mysql_query("character_set_connection = 'utf8'");
		
		mysql_query("character_set_client = 'utf8'");
		
		mysql_query("character_set_server = 'utf8'");*/
		
		$qry="select supplier.supplier_name as 'Supplier Name' , (supplier.credit - supplier.debit) as 'Amount' , (select DATE_FORMAT(createdAt,'%d-%m-%Y') from supplier_general_entry where supplier_id = supplier.supplier_id order BY id desc LIMIT 1 ) as 'Balance as on Date' from supplier LEFT JOIN supplier_general_entry ON (supplier_general_entry.supplier_id = supplier.supplier_id ) where supplier.credit - supplier.debit > 0 and supplier.admin_id =  ".$admin_id." Group by supplier.supplier_id ; ";  
		
		$test = mysql_query($qry,$conn);
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right">DATE: '.$date.'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="23%" align="right">TIME: '.date('H:i:s',strtotime($date)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 </table>
		<h2 align="center">Account Receivable Report(For Supplier)</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td height="20" align="center">Supplier Name</td>
			<td align="center">Amount('.Yii::app()->session['currency'].')</td>
			<td align="center">Balance as on Date</td>
		</tr>';
		  
	while($row=mysql_fetch_array($test))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['Supplier Name'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['Amount'].'</td>
			<td align="center">&nbsp;'.$row['Balance as on Date'].'</td>
		  </tr>';
    } 
	
		$html .= '</table>';
		$pdfId = date('Y_m_d_H_m_s');	
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/".$pdfId."supplierReceivableReport.pdf", 'F');
		
		$this->actionIndex();
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/<?php echo $pdfId ; ?>supplierReceivableReport.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
		
}