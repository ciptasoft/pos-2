<?php

error_reporting(0);
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
class AdminController extends Controller {

    public $algo;
    public $adminmsg;
	public $errorCode;
    private $msg;
    private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
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
	
	public function beforeAction()
	{
		$this->msg = Yii::app()->params->adminmsg;
		$this->errorCode = Yii::app()->params->errorCode;
		return true;
	
	}

	
	/* =============== Content Of Check Login Session =============== */

    function isLogin() {
        if (isset(Yii::app()->session['adminUser'])) {
            return true;
        } else {
            Yii::app()->user->setFlash("error", "Username or password required");
            header("Location: " . Yii::app()->params->base_path . "admin");
            exit;
        }
    }

    function actionindex() 
	{
		if(isset(Yii::app()->session['adminUser'])){
			$this->actionmyProfile();
		} else {
			$this->render("index");
		}
    }
	
	function actionaddUser()
	{
		$currencyObj = new Currency();
		$currencyList = $currencyObj->getAllCurrencyList();
		$this->render("addUser",array('currencyList'=>$currencyList));	
	}
	
	function actionexportView()
	{
		Yii::app()->session['current']	=	'settings';
		$this->render("export");	
	}
	
	function actionexportExcellTransactionReport()
	{
		if(isset($_POST['date1']) && $_POST['date1'] != "")
		{
			$date = $_POST['date1'];
		}
		else
		{
			$date = date('d-m-Y');
		}
			
		include_once('ExportReportToExcel.class.php'); 
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		$qry1="select stores.store_name as STORE , ticket_details.total_amount as AMOUNT,customers.customer_name as 'PARTY NAME'  from ticket_details LEFT JOIN stores ON ( stores.store_id = ticket_details.store_id )  LEFT JOIN customers ON ( customers.customer_id = ticket_details.customer_id )  WHERE  ticket_details.admin_id = ".Yii::app()->session['adminUser']." and (ticket_details.status = '1' or ticket_details.status = '2' or ticket_details.status = '5'  ) and ( DATE_FORMAT(ticket_details.createdAt,'%d-%m-%Y') = '".$date."' or  DATE_FORMAT(ticket_details.modifiedAt,'%d-%m-%Y') = '".$date."' ) order by ticket_details.createdAt desc "; 
	   $qry2="select stores.store_name as STORE , sales_return_details.return_total_amount as AMOUNT,customers.customer_name as 'PARTY NAME' from sales_return_details  LEFT JOIN users ON ( users.id = sales_return_details.userId )  LEFT JOIN stores ON ( stores.store_id = users.store_id )  LEFT JOIN customers ON ( customers.customer_id = sales_return_details.return_customer_id )  WHERE  users.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(sales_return_details.return_createdAt,'%d-%m-%Y') = '".$date."' ) order by sales_return_details.return_createdAt desc ";
	   
	  
	  $qry3="select stores.store_name as STORE , purchase_order_details.total_amount as AMOUNT,supplier.supplier_name as 'PARTY NAME'  from purchase_order_details LEFT JOIN stores ON ( stores.store_id = purchase_order_details.store_id )  LEFT JOIN supplier ON ( supplier.supplier_id = purchase_order_details.supplier_id ) WHERE  purchase_order_details.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(purchase_order_details.created,'%d-%m-%Y') = '".$date."' ) order by purchase_order_details.created desc ";
	  
	 $qry4="select stores.store_name as STORE , purchase_return_details.total_return_amount as AMOUNT,supplier.supplier_name as 'PARTY NAME'  from purchase_return_details LEFT JOIN stores ON ( stores.store_id = purchase_return_details.store_id )  LEFT JOIN supplier ON ( supplier.supplier_id = purchase_return_details.supplier_id ) WHERE  purchase_return_details.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(purchase_return_details.created,'%d-%m-%Y') = '".$date."' ) order by purchase_return_details.created desc ";
	
	$exp->exportWithQuery($qry1,$qry2,$qry3,$qry4,"ExportData.xls",$conn);

	}
	
	function actionexportExcellJournalReport()
	{
		if(isset($_POST['date3']) && $_POST['date3'] != "")
		{
			$date = $_POST['date3'];
		}
		else
		{
			$date = date('d-m-Y');
		}
		
		include_once('ExportJournalReportToExcel.class.php'); 
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		$qry1="select stores.store_name as STORE, customers.customer_name as 'PARTY NAME' , customer_general_entry.credit as CREDIT, customer_general_entry.debit as DEBIT   from customer_general_entry LEFT JOIN stores ON ( stores.store_id = customer_general_entry.store_id )  LEFT JOIN customers ON ( customers.customer_id = customer_general_entry.customer_id )  WHERE  customer_general_entry.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(customer_general_entry.createdAt,'%d-%m-%Y') = '".$date."' ) order by customer_general_entry.createdAt desc "; 
		
	  $qry2="select stores.store_name as STORE, supplier.supplier_name as 'PARTY NAME' , supplier_general_entry.credit as CREDIT, supplier_general_entry.debit as DEBIT   from supplier_general_entry LEFT JOIN stores ON ( stores.store_id = supplier_general_entry.store_id )  LEFT JOIN supplier ON ( supplier.supplier_id = customer_general_entry.supplier_id )  WHERE  supplier_general_entry.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(supplier_general_entry.createdAt,'%d-%m-%Y') = '".$date."' ) order by supplier_general_entry.createdAt desc ";
	   
	$qry3="select stores.store_name as STORE, general_entry.account as 'PARTY NAME' , general_entry.credit as CREDIT, general_entry.debit as DEBIT   from general_entry LEFT JOIN stores ON ( stores.store_id = general_entry.store_id ) WHERE  general_entry.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(general_entry.created,'%d-%m-%Y') = '".$date."' ) order by general_entry.created desc "; 
	  
	$exp->exportWithQuery($qry1,$qry2,$qry3,"ExportData.xls",$conn);

	}
	
	function actionexportProductFile()
	{
		include_once('ExportToExcel.class.php'); 
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		$qry="select * from product where admin_id = ".Yii::app()->session['adminUser'].""; 
		
		$exp->exportWithQuery($qry,"ExportData.xls",$conn);

	}
	
	function actionexportCustomerFile()
	{
		include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		$qry="select * from customers where admin_id = ".Yii::app()->session['adminUser'].""; 
		
		$exp->exportWithQuery($qry,"ExportData.xls",$conn);
	}
	
	function actionexportSupplierFile()
	{
		include_once('ExportToExcel.class.php'); 
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		$exp=new ExportToExcel();
		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		$qry="select * from supplier where admin_id = ".Yii::app()->session['adminUser'].""; 
		
		$exp->exportWithQuery($qry,"ExportData.xls",$conn);
	}
	
	function actionimportView()
	{
		Yii::app()->session['current']	=	'settings';
		$this->render("import");	
	}
	
	function actionimportCustomerFile()
	{
		if(!empty($_FILES ['file']['name']))
		{
			error_reporting(E_ALL ^ E_NOTICE); 
			//require_once '../../excel_reader2.php';
			Yii::app()->session['current']	=	'settings';
			//print_r($_FILES);
			$fileName = $_FILES ['file']['name'];
			set_time_limit(0);
			$ext = strstr($_FILES["file"]["name"],'.');
			if(($_FILES["file"]["type"] == "application/vnd.ms-excel" || $_FILES["file"]["type"] == "application/octet-stream") && $ext == '.xls')
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],"assets/upload/bulkupload/" . $_FILES["file"]["name"]);
				require_once 'excel_reader2.php';
				$data = new Spreadsheet_Excel_Reader();
				$data->read("assets/upload/bulkupload/".$_FILES["file"]["name"]);
				$count_array = count($data->sheets[0]['cells']);
				$sheetData = array();
				
				
				/*echo "<pre>";
				print_r($data->sheets);
				exit;*/
				
				$dat = array();	
				//echo "<br>";echo "<br>";
				for($i=2;$i<=count($data->sheets[0]['cells']);$i++)
				{		
					
					$dat[$i]['customer_id'] = $data->sheets[0]['cells'][$i][1];
					$dat[$i]['admin_id'] = Yii::app()->session['adminUser'] ;
					$dat[$i]['customer_name'] = $data->sheets[0]['cells'][$i][3];
					$dat[$i]['cust_address'] = $data->sheets[0]['cells'][$i][4];
					$dat[$i]['cust_email'] = $data->sheets[0]['cells'][$i][5];
					$dat[$i]['contact_no'] = $data->sheets[0]['cells'][$i][6];
					$dat[$i]['credit'] = $data->sheets[0]['cells'][$i][7]; 
					$dat[$i]['total_purchase'] = $data->sheets[0]['cells'][$i][8];
					$dat[$i]['createdAt'] = date('Y-m-d : H-m-s');
					$dat[$i]['modifiedAt'] = $data->sheets[0]['cells'][$i][10];
					$dat[$i]['status'] = 1 ;
					
					$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
					mysql_select_db(DB_DATABASE);
			
					mysql_query("SET NAMES utf8;");
			
					mysql_query("SET character_set_results = 'utf8'");
				
				   $sql = "INSERT INTO `customers` (`customer_id`, `admin_id`, `customer_name`, `cust_address`, `cust_email`, `contact_no`, `credit`, `total_purchase`, `createdAt`, `modifiedAt`, `status`) VALUES (".$dat[$i]['customer_id'].", '".$dat[$i]['admin_id']."', '".$dat[$i]['customer_name']."', NULL, NULL, NULL, '".$dat[$i]['credit']."', '0', '".$dat[$i]['createdAt']."',NULL, '".$dat[$i]['status']."');";
					
					 $result= mysql_query($sql,$conn);
					//echo "<br>";
				
				}
				
			} 
			else
			{
			Yii::app()->user->setFlash('error', 'File Not Supported.Please import only <b>.xls</b> version.');
			$this->render("import");
			}
			
			Yii::app()->user->setFlash('success', 'File import successfully. ');
			$this->render("import");
		}
		else
		{
			Yii::app()->user->setFlash('error', 'Please Select a file.');
			$this->render("import");
		}	
	}
	
	function actionimportProductFile()
	{
		if(!empty($_FILES ['file']['name']))
		{
			error_reporting(E_ALL ^ E_NOTICE); 
			//require_once '../../excel_reader2.php';
			Yii::app()->session['current']	=	'settings';
			//print_r($_FILES);
			$fileName = $_FILES ['file']['name'];
			set_time_limit(0);
			$ext = strstr($_FILES["file"]["name"],'.');
			if(($_FILES["file"]["type"] == "application/vnd.ms-excel" || $_FILES["file"]["type"] == "application/octet-stream") && $ext == '.xls')
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],"assets/upload/bulkupload/" . $_FILES["file"]["name"]);
				require_once 'excel_reader2.php';
				$data = new Spreadsheet_Excel_Reader();
				$data->read("assets/upload/bulkupload/".$_FILES["file"]["name"]);
				$count_array = count($data->sheets[0]['cells']);
				$sheetData = array();
				
				/*echo "<pre>";
				print_r($data->sheets);
				exit;*/
				
	
				
				$productData = array();	
				$catData = array();
				//echo "<br>";echo "<br>";
				for($i=2;$i<=count($data->sheets[0]['cells']);$i++)
				{		
					
				$productData[$i]['upc_code'] = $data->sheets[0]['cells'][$i][11];
				$productData[$i]['product_name'] = $data->sheets[0]['cells'][$i][3]; 
				$productData[$i]['product_desc'] = $data->sheets[0]['cells'][$i][4]; 
				$productData[$i]['product_discount'] = $data->sheets[0]['cells'][$i][6];
				$productData[$i]['cat_id'] = $data->sheets[0]['cells'][$i][15];
				$productData[$i]['quantity'] = $data->sheets[0]['cells'][$i][12];
				$productData[$i]['unitname'] = $data->sheets[0]['cells'][$i][10];
				$productData[$i]['product_price'] = $data->sheets[0]['cells'][$i][7];
				$productData[$i]['product_price2'] = $data->sheets[0]['cells'][$i][8];
				$productData[$i]['product_price3'] = $data->sheets[0]['cells'][$i][9];
				$productData[$i]['expiry_date'] = $data->sheets[0]['cells'][$i][14];
				$productData[$i]['store_id'] = ','.$data->sheets[0]['cells'][$i][2].',';
				$productData[$i]['product_image'] = $data->sheets[0]['cells'][$i][5];
				$productData[$i]['admin_id'] = Yii::app()->session['adminUser'];
				$productData[$i]['created_date'] = date('Y-m-d:H-m-s');
				$productData[$i]['status'] = 1 ;
				
				$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
				mysql_select_db(DB_DATABASE); 
		
				mysql_query("SET NAMES utf8;");
		
				mysql_query("SET CHARACTER_SET utf8;");
				
			   $sql = "INSERT INTO `product` (`product_id`, `store_id`, `product_name`, `product_desc`, `product_image`, `product_discount`, `product_price`,`product_price2`,`product_price3`, `unitname`, `upc_code`, `quantity`, `manufacturing_date`, `expiry_date`, `cat_id`, `admin_id`, `created_date`, `modified_date`, `status`) VALUES (NULL, '".$productData[$i]['store_id']."', '".$productData[$i]['product_name']."', '".$productData[$i]['product_desc']."', '".$productData[$i]['product_image']."', '".$productData[$i]['product_discount']."', ".$productData[$i]['product_price'].",  ".$productData[$i]['product_price2'].", ".$productData[$i]['product_price3'].",'".$productData[$i]['unitname']."', '".$productData[$i]['upc_code']."', '".$productData[$i]['quantity']."', NULL, '".$productData[$i]['expiry_date']."', '".$productData[$i]['cat_id']."', '".$productData[$i]['admin_id']."', '".$productData[$i]['created_date']."', '0000-00-00 00:00:00', '".$productData[$i]['status']."');";
			   
			   //echo "<br>";
			   
			    $result= mysql_query($sql,$conn);
/*-----------------------------------------------Stock Entry----------------------------------------*/	
				$stockIds = explode(',',$data->sheets[0]['cells'][$i][2]);
					foreach($stockIds as $row)
					{
						if($row != "")
						{
							$stock['store_id'] = $row;
							$stock['product_id'] =  mysql_insert_id();
							$stock['quantity'] = $data->sheets[0]['cells'][$i][12];
							$stock['admin_id'] = $data->sheets[0]['cells'][$i][16];
							$stock['created'] = date("Y-m-d H:i:s");
							
							$stockObj = new Stock();
							$stockObj->setData($stock);
							$insertedstockId = $stockObj->insertData();
						}
					}	
				
				}
			
			
			} 
			else
			{
			Yii::app()->user->setFlash('error', 'File Not Supported.Please import only <b>.xls</b> version.');
			$this->render("import");
			}
			
			Yii::app()->user->setFlash('success', 'File import successfully.');
			$this->render("import");
		}
		else
		{
			Yii::app()->user->setFlash('error', 'Please Select a file.');
			$this->render("import");
		}
	}
	
	function actionimportSupplierFile()
	{
		if(!empty($_FILES ['file']['name']))
		{
			error_reporting(E_ALL ^ E_NOTICE); 
			//require_once '../../excel_reader2.php';
			Yii::app()->session['current']	=	'settings';
			//print_r($_FILES);
			$fileName = $_FILES ['file']['name'];
			set_time_limit(0);
			$ext = strstr($_FILES["file"]["name"],'.');
			if(($_FILES["file"]["type"] == "application/vnd.ms-excel" || $_FILES["file"]["type"] == "application/octet-stream") && $ext == '.xls')
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],"assets/upload/bulkupload/" . $_FILES["file"]["name"]);
				require_once 'excel_reader2.php';
				$data = new Spreadsheet_Excel_Reader();
				$data->read("assets/upload/bulkupload/".$_FILES["file"]["name"]);
				$count_array = count($data->sheets[0]['cells']);
				$sheetData = array();
				
				
				/*echo "<pre>";
				print_r($data->sheets);
				exit;*/
				
				$dat = array();	
				//echo "<br>";echo "<br>";
				for($i=2;$i<=count($data->sheets[0]['cells']);$i++)
				{		
					
					$dat[$i]['supplier_id'] = $data->sheets[0]['cells'][$i][1];
					$dat[$i]['admin_id'] = Yii::app()->session['adminUser'] ;
					$dat[$i]['supplier_name'] = $data->sheets[0]['cells'][$i][2];
					$dat[$i]['address'] = $data->sheets[0]['cells'][$i][8];
					$dat[$i]['email'] = $data->sheets[0]['cells'][$i][6];
					$dat[$i]['contact_no'] = $data->sheets[0]['cells'][$i][7];
					$dat[$i]['credit'] = $data->sheets[0]['cells'][$i][4]; 
					$dat[$i]['debit'] = $data->sheets[0]['cells'][$i][5]; 
					$dat[$i]['createdAt'] = $data->sheets[0]['cells'][$i][10]; 
					$dat[$i]['modifiedAt'] = $data->sheets[0]['cells'][$i][11]; 
					$dat[$i]['status'] = 1 ;
					
					$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
					mysql_select_db(DB_DATABASE);
			
					mysql_query("SET NAMES utf8;");
			
					mysql_query("SET character_set_results = 'utf8'");
				
				   $sql = "INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `product_id`, `credit`, `debit`, `email`, `contact_no`, `address`, `admin_id`, `created_date`, `modified_date`, `status`) VALUES ('".$dat[$i]['supplier_id']."', '".$dat[$i]['supplier_name']."', NULL, '".$dat[$i]['credit']."', '".$dat[$i]['debit']."', '".$dat[$i]['email']."', '".$dat[$i]['contact_no']."', '".$dat[$i]['address']."', '".$dat[$i]['admin_id']."', '".$dat[$i]['createdAt']."', '".$dat[$i]['modifiedAt']."', '".$dat[$i]['status']."');";
					
					 $result= mysql_query($sql,$conn);
					//echo "<br>";
				
				}
				
			} 
			else
			{
			Yii::app()->user->setFlash('error', 'File Not Supported.Please import only <b>.xls</b> version.');
			$this->render("import");
			}
			
			Yii::app()->user->setFlash('success', 'File import successfully. ');
			$this->render("import");
		}
		else
		{
			Yii::app()->user->setFlash('error', 'Please Select a file.');
			$this->render("import");
		}	
	}
	
	function actiondailyTransactionReport()
	{
		Yii::app()->session['current']	=	'reports';
		$this->render("dailyTransactionExport");	
	}
	
	function actiondailySalesReport()
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		
		$ticketObj = new TicketDetails();
		$ticketList = $ticketObj->getPaginatedTicketListForAdmin($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
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
		
		$usersObj = new Users();
		$casherList = $usersObj->getAllUserListforadmin(Yii::app()->session['adminUser']);
		
		$storeObj = new Stores();
		$storeList = $storeObj->getClientStoreList(Yii::app()->session['adminUser']);
		
		$customerObj = new Customers();
		$customerList = $customerObj->getAllCustomerListForAdmin(Yii::app()->session['adminUser']);
		
		$productObj = new Product();
		$productList = $productObj->getAllProductList(Yii::app()->session['adminUser']);
		
		Yii::app()->session['current']	=	'reports';
		$this->render("dailySalesReport",array('data'=>$ticketList['ticket'],'pagination'=>$ticketList['pagination'],'ext'=>$ext,"productList"=>$productList,"customerList"=>$customerList,"storeList"=>$storeList,"casherList"=>$casherList));	
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionticketDetail()
	{
		$ticketObj	=	new TicketDetails();
		$data	=	$ticketObj->getTicketDetailWithCustomer($_REQUEST['id']);
				
		$ticketDescObj  = new TicketDesc();
		$productData = $ticketDescObj->getTicketsData($_REQUEST['id']);
		
		$this->render('ticketDescription', array('data'=>$data,'productData'=>$productData));
	}
	
	function actionaccountsReport() 
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='store_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$generalObj	=	new GeneralEntry();
		$lists	=	$generalObj->getAllPaginatedEntries(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		/*echo "<pre>";
		print_r($lists);
		exit;*/
		
		if($_REQUEST['sortType'] == 'desc'){
		$ext['sortType']	=	'asc';
		$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['sortBy'] = $_REQUEST['sortBy'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['currentSortType'] = $_REQUEST['currentSortType'];
		
		$data['pagination']	=	$lists['pagination'];
        $data['lists']	=	$lists['ticket'];
		Yii::app()->session['current']	=	'reports';
        $this->render("accountsReport", array('data'=>$data,'ext'=>$ext));
    }
	
	function actiongetStoresAccountReport()
	{
		$generalObj = new GeneralEntry();
		$data = $generalObj->getStoreAccountReport(Yii::app()->session['adminUser']);
		$this->renderPartial("storesAccountReport",array('data'=>$data));	
	}
	
	function actionpurchaseReport() 
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='store_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$purchaseObj	=	new PurchaseOrderDetails();
		$lists	=	$purchaseObj->getAllPaginatedPurchase(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		/*echo "<pre>";
		print_r($lists);
		exit;*/
		
		if($_REQUEST['sortType'] == 'desc'){
		$ext['sortType']	=	'asc';
		$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['sortBy'] = $_REQUEST['sortBy'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['currentSortType'] = $_REQUEST['currentSortType'];
		
		$data['pagination']	=	$lists['pagination'];
        $data['purchase']	=	$lists['purchase'];
		Yii::app()->session['current']	=	'reports';
        $this->render("purchaseReport", array('data'=>$data,'ext'=>$ext));
    }
	
	function actiongetStoresPurchaseReport()
	{
		$podObj = new PurchaseOrderDetails();
		$data = $podObj->getStorePurchaseReport(Yii::app()->session['adminUser']);
		$this->renderPartial("storePurchaseReport",array('data'=>$data));	
	}
	
	function actiongetProductPurchaseReport()
	{
		$podObj = new Purchase();
		$data = $podObj->getProductPurchaseReport(Yii::app()->session['adminUser']);
		$this->renderPartial("productPurchaseReport",array('data'=>$data));	
	}
	
	function actionaddClientUser()
	{
		$storeObj = new Stores();
		$storeList = $storeObj->getClientStoreList(Yii::app()->session['adminUser']);
		$this->render("addClientUser",array('storeList'=>$storeList));	
	}
	
	function actiongetDailyProductReport()
	{
		if(isset($_REQUEST['date']) && $_REQUEST['date']  != "" )
		{
			$date1 = strtotime($_REQUEST['date']) ;
			$date = date('Y-m-d' , $date1);
		}
		else
		{
			$date = date('Y-m-d');
		}
		$ticketObj = new TicketDesc();
		$data = $ticketObj->getDailyProductReport($date,Yii::app()->session['adminUser']);
		$this->renderPartial("dailyProductReport",array('data'=>$data,'date'=>$_REQUEST['date']));	
	}
	
	function actiongetDailySalesPersonReport()
	{
		if(isset($_REQUEST['date']) && $_REQUEST['date']  != "" )
		{
			$date1 = strtotime($_REQUEST['date']) ;
			$date = date('Y-m-d' , $date1);
		}
		else
		{
			$date = date('Y-m-d');
		}
		$ticketObj = new TicketDetails();
		$data = $ticketObj->getDailySalesPersonReport($date,Yii::app()->session['adminUser']);
		$this->renderPartial("dailySalesPersonReport",array('data'=>$data,'date'=>$date));	
	}
	
	function actiongetDailyCustomerSalesReport()
	{
		if(isset($_REQUEST['date']) && $_REQUEST['date']  != "" )
		{
			$date1 = strtotime($_REQUEST['date']) ;
			$date = date('Y-m-d' , $date1);
		}
		else
		{
			$date = date('Y-m-d');
		}
		$ticketObj = new TicketDetails();
		$data = $ticketObj->getDailyCustomerSalesReport($date,Yii::app()->session['adminUser']);
		$this->renderPartial("dailyCustomerReport",array('data'=>$data,'date'=>$_REQUEST['date']));	
	}
	
	function actiongetDailyStoreSalesReport()
	{
		if(isset($_REQUEST['date']) && $_REQUEST['date']  != "" )
		{
			$date1 = strtotime($_REQUEST['date']) ;
			$date = date('Y-m-d' , $date1);
		}
		else
		{
			$date = date('Y-m-d');
		}
		$ticketObj = new TicketDetails();
		$data = $ticketObj->getDailyStoreSalesReport($date,Yii::app()->session['adminUser']);
		$this->renderPartial("dailyStoreSalesReport",array('data'=>$data,'date'=>$_REQUEST['date']));	
	}
	
	function  actionsaveClientUser()
	{
			//error_reporting(E_ALL);
			if(isset($_POST['store']) && $_POST['store'] != -1 && $_POST['firstName'] != '' && $_POST['lastName'] != '' && $_POST['Email'] != '' &&  $_POST['password'] != '')
			{
				$generalObj = new General();
				$data['firstName'] = $_POST['firstName'];
				$data['admin_id'] = Yii::app()->session['adminUser'];
				$data['store_id'] = $_POST['store'];
				$data['lastName'] = $_POST['lastName'];
				$data['isVerified'] = 1;
				$data['email'] = Yii::app()->session['email'] ;
				$data['loginId'] = $_POST['Email'];
				$Password	=	$generalObj->encrypt_password($_POST['password']);
				$data['password'] = $Password;
				$data['createdAt'] = date("Y-m-d H:i:s");
				
				$usersObj = new Users();
				$emailvalidate = $usersObj->checkEmailId($data['loginId']);
				if(!empty($emailvalidate))
				{
					Yii::app()->user->setFlash("error","Email already registered.");
					
				?>	
					<script>
					window.opener.location.href = window.opener.location.href;
					window.close();
					</script>
				<?php 
				exit;
                }
				$usersObj = new Users();
				$usersObj->setData($data);
				$usersObj->insertData();
				
			
/*----------------------Mail Function Start---------------------------------------------- */			
			$message = '<table style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
  <tr>
    <td align="left"><div><img src="'.Yii::app()->params->base_url.'images/logo/logo.png" alt="NVIS"/></div>
      <div style="color:#666666; display:block; font-family:Arial,Helvetica,sans-serif; font-size:11px; font-weight:normal;
          padding:0px 0px 0px 28px;">NVIS - New Vision Integrated Systems</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Congratulation,</td>
  </tr>
  <tr>
    <td>New User Created by admin.</td>
  </tr>
  <tr>
    <td><table>
		<tr>
			<td><b>First Name</b></td>
			<td><b>'.$data['firstName'].'</b></td>
		</tr>
        <tr>
          <td><b>Last Name</b></td>
		  <td><b>'.$data['lastName'].'</b></td>
        </tr>
		<tr>
          <td><b>Login Id</b></td>
		  <td><b>'.$data['loginId'].'</b></td>
        </tr>
		<tr>
          <td><b>Password</b></td>
		  <td><b>'.$_POST['password'].'</b></td>
        </tr>
	</table></td>
  </tr>
  <tr>
    <td>This account is successfully approved. Now you can log in with above credential.</td>
  </tr>
  <tr>
    <td>For access your account <a href="'.Yii::app()->params->base_path.'site">Click</a> here.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p> Thanks,<br />
        The POS Team<br />
      </p></td>
  </tr>
</table>';
			
			$recipientemail = Yii::app()->session['email'];
			$subject = "User Account Creation";
			
			$this->sendUserCreateMail($recipientemail, $subject, $message);		
			$this->sendUserCreateMail($data['loginId'], $subject, $message);
/*----------------------Mail Function End------------------------------------------------- */		
				Yii::app()->user->setFlash("success","User is sucessfully created.");
			}
			else
			{
				Yii::app()->user->setFlash("error","Please fill all the required fields.");
			}
				?> 
			<script>
			window.opener.location.href = window.opener.location.href;
			window.close();
			</script>
			<?php 
			
	}
	
	
	function actionAdminLogin()
	{
		error_reporting(0);
		$captcha = Yii::app()->getController()->createAction('captcha');
		
		if (isset($_POST['submit_login'])) {
			
			/*if(!$captcha->validate($_POST['verifyCode'],1)) {
				Yii::app()->user->setFlash("error","Enter valid captcha.");
				$this->render('index');
				exit;
			}*/
			
			if(isset($_POST['email_admin']))
			{
				$email_admin = $_POST['email_admin'];
				$pwd = $_POST['password_admin'];
					
				$adminObj	=	new Admin();
				$admin_data	=	$adminObj->getAdminDetailsByEmail($email_admin);
			}
			$generalObj	=	new General();
			$isValid	=	$generalObj->validate_password($_POST['password_admin'], $admin_data['password']);
			
			if ( $isValid === true ) {
				Yii::app()->session['adminUser'] = $admin_data['id'];
				Yii::app()->session['type'] = $admin_data['type'];
				Yii::app()->session['email'] = $admin_data['email'];
				Yii::app()->session['first_name'] = $admin_data['first_name'];
				Yii::app()->session['fullName'] = $admin_data['first_name'] . ' ' . $admin_data['last_name'];
				Yii::app()->session['currency'] = $admin_data['currency'];
				$this->actionIndex();
				exit;
			} else {
				Yii::app()->user->setFlash("error","Username or Password is not valid");
				$this->render('index');
				exit;
			}	
		}
	}

	function actionLogout()
	{
		Yii::app()->session->destroy();
		$this->render('index');
	}
	
	/***** ALL USERS *****/
	function actionstatistics() 
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='u.id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(isset($_GET['listId']) && $_GET['listId'] != '')
		{
			if($_GET['listId']==0)
			{
				$_GET['listId'] = '';
			}
			Yii::app()->session['listId'] = $_GET['listId'];
		}
		else
		{
			$_GET['listId'] = Yii::app()->session['listId'];
		}
		
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$lists = array();
		$statistics = array('data'=>'');
		//$todoItemObj	=	new TodoItems();
		//$statistics	=	$todoItemObj->getAllPaginatedStatistics(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		//$todoListObj =  new TodoLists();
		//$lists = $todoListObj->getListsForStatistics();
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		Yii::app()->session['current']	=	'statistics';
		$this->render("statastics", array('data'=>array(),'ext'=>$ext,'lists'=>$lists,'selectedList'=>$_GET['listId']));
    }
	
	function array_sort($array, $on, $order=SORT_ASC)
	{
		
			$new_array = array();
			$sortable_array = array();
		
			if (count($array) > 0) {
				foreach ($array as $k => $v) {
					if (is_array($v)) {
						foreach ($v as $k2 => $v2) {
							if ($k2 == $on) {
								$sortable_array[$k] = $v2;
							}
						}
					} else {
						$sortable_array[$k] = $v;
					}
				}
		
				switch ($order) {
					case SORT_ASC:
						asort($sortable_array);
					break;
					case SORT_DESC:
						arsort($sortable_array);
					break;
				}
		
				foreach ($sortable_array as $k => $v) {
					$new_array[$k] = $array[$k];
				}
			}
			
			return $new_array;
	}
	
	/***** ALL USERS *****/
	function actionUsers() 
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='u.id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$usersObj	=	new Users();
		$users	=	$usersObj->getAllPaginatedUsers(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$users['pagination'];
        $data['users']	=	$users['users'];
		Yii::app()->session['current']	=	'users';
		$this->render("user", array('data'=>$data,'ext'=>$ext));
    }
	
	function actionclientUser($email=NULL)
	{
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$data['email'] = $_REQUEST['email']; 
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		
		$userObj = new Users();
		$users	=	$userObj->getClientUsers(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate'],$data['email']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$users['pagination'];
        $data['users']	=	$users['users'];
		Yii::app()->session['current']	=	"Client";
		$this->render("clientUser", array('data'=>$data,'ext'=>$ext,'email'=>$email));
		
	}
	
	function actionclientRequestUser($email=NULL)
	{
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$data['email'] = $_REQUEST['email']; 
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		
		$userObj = new Users();
		$users	=	$userObj->getClientRequestUsers(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate'],$data['email']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$users['pagination'];
        $data['users']	=	$users['users'];
		Yii::app()->session['current']	=	"Client's request";
		$this->render("clientRequestUser", array('data'=>$data,'ext'=>$ext,'email'=>$email));
		
	}
	
	function actionclientRequest()
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='email';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$userObj = new Users();
		$users	=	$userObj->getPendingUsers(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$users['pagination'];
        $data['users']	=	$users['users'];
		Yii::app()->session['current']	=	"Client's request";
		$this->render("clientRequest", array('data'=>$data,'ext'=>$ext));
		
	}
	
	function actionClientUsersForClient()
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='email';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType'];
		$keyword = htmlspecialchars($_REQUEST['keyword']) ;
		$userObj = new Users();
		$users	=	$userObj->getVerifiedClientUsers(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$keyword,$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$users['pagination'];
        $data['users']	=	$users['users'];
		Yii::app()->session['current']	=	"Users";
		$this->render("clientusersforclient", array('data'=>$data,'ext'=>$ext));
	}
	
	 function actionclient()
	 {
	  	$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='email';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$userObj = new Users();
		$users	=	$userObj->getVerifiedUsers(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$users['pagination'];
        $data['users']	=	$users['users'];
		Yii::app()->session['current']	=	"Client";
		$this->render("client", array('data'=>$data,'ext'=>$ext));
	 }
	
	function actionsaveClient()
	{
		
		$generalObj =  new General();
		$totalUsers = $_POST['users'];
		$firstname = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['Email'];
		$currency = $_POST['currency'];
			
		$adminObj =  new Admin();
		$adminDetails = $adminObj->getAdminDetailsByEmail($email);
		
		if(isset($adminDetails['id']) || $adminDetails['id'] != NULL)
		{
				Yii::app()->user->setFlash("error","Client already created using this email.");
				 ?> 
			   <script>
				window.opener.location.href = window.opener.location.href;
				window.close();
			   </script>
				<?php 
	   			exit;
		}
			
/*----------------------Mail Function Start---------------------------------------------- */			
			$message = '<table style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
  <tr>
    <td align="left"><div><img src="'.Yii::app()->params->base_url.'images/logo/logo.png" alt="NVIS"/></div>
      <div style="color:#666666; display:block; font-family:Arial,Helvetica,sans-serif; font-size:11px; font-weight:normal;
          padding:0px 0px 0px 28px;">NVIS - New Vision Integrated Systems</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Hello,</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>New User Created by admin.</td>
  </tr>
  <tr>
    <td><table>
		<tr>
			<td><b>First Name</b></td>
			<td><b>'.$firstname.'</b></td>
		</tr>
        <tr>
          <td><b>Last Name</b></td>
		  <td><b>'.$lastName.'</b></td>
        </tr>
		<tr>
          <td><b>User Email</b></td>
		  <td><b>'.$email.'</b></td>
        </tr>
		<tr>
          <td><b>No of Allocate Users</b></td>
		  <td><b>'.$totalUsers.'</b></td>
        </tr>
		<tr>
          <td><b>Currency</b></td>
		  <td><b>'.$currency.'</b></td>
        </tr>
	</table></td>
  </tr>
  <tr>
    <td>This account is successfully created. but It is waiting for approval of admin. We will contact you soon.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p> Thanks,<br />
        The POS Team<br />
      </p></td>
  </tr>
</table>';
			
			$recipientemail = Yii::app()->session['email'];
			$subject = "User Account Creation";
			
			$this->sendUserCreateMail($recipientemail, $subject, $message);		
			$this->sendUserCreateMail($email, $subject, $message);
/*----------------------Mail Function End------------------------------------------------- */		
		$generalObj	=	new General();
		$everify_code=$generalObj->encrypt_password(rand(0,99).rand(0,99).rand(0,99).rand(0,99));
		$adminObj = new Admin();
		$admin = array();
		$admin['email']	= $email;
		$admin['password'] = '683025ada55293ef1e98527b421376f0:2a';
		$admin['first_name'] = $firstname;
		$admin['last_name'] = $lastName;
		$admin['company_name'] = $_POST['company_name'];
		$admin['company_address'] = $_POST['company_address'];
		
		if(isset($_FILES["logo"]["name"]) && $_FILES["logo"]["name"] != "" )
		{
			$admin['company_logo'] = $_FILES["logo"]["name"];
								
			move_uploaded_file($_FILES["logo"]["tmp_name"],
			FILE_UPLOAD."/clientLogo/" . $_FILES["logo"]["name"]);
		}
		
		$admin['isVerified'] = $everify_code;
		$admin['total_users'] = $totalUsers;
		$admin['currency'] = $currency;
		$admin['type'] = 2;
		$admin['created_at'] = date("Y-m-d H:i:s");
		
		$adminObj->setData($admin);
		$adminObj->insertData();
		
		Yii::app()->user->setFlash("success", "Client Created successfully and waiting for approval of AAS.");
       ?> 
	   <script>
		window.opener.location.href = window.opener.location.href;
		window.close();
       </script>
	   <?php 
	   // header("Location: " . Yii::app()->params->base_path . "admin/client");
        exit;
	}
	
	function sendUserCreateMail($email, $subject, $message)
	{
		
		$subject = $subject;
		$msg = $message;

		$to = $email;
		$headers = 'From: team@pos.com' . "\r\n" .
    		'Reply-To: team@pos.com' . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();
		
		$headers .= "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=utf-8\r\n"; 
		$headers .= "From: NVIS <team@pos.com>\r\n";
		$res = mail($to, $subject, $msg, $headers);
		
	}
	
	function actionemployee()
	{	
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='employee_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$employeeObj = new Employees();
		$employees	=	$employeeObj->getAllPaginatedEmployee(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$employees['pagination'];
        $data['employees']	=	$employees['employees'];
		Yii::app()->session['current']	=	'employees';
		$this->render("employee", array('data'=>$data,'ext'=>$ext));
		
	}
	
	//store
	function actionstore()
	{	
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='store_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$storesObj = new Stores();
		$stores	=	$storesObj->getAllPaginatedStore(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$stores['pagination'];
        $data['stores']	=	$stores['stores'];
		Yii::app()->session['current']	=	'stores';
		$this->render("stores", array('data'=>$data,'ext'=>$ext));
		
	}
	
	function actionstock()
	{	
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='store_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$storesObj = new Stores();
		$stores	=	$storesObj->getAllPaginatedStore(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$stores['pagination'];
        $data['stores']	=	$stores['stores'];
		Yii::app()->session['current']	=	'stores';
		$this->render("stores", array('data'=>$data,'ext'=>$ext));
		
	}
	//category
	function actioncategory()
	{	

		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='cat_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$categoryObj = new Category();
		$category	=	$categoryObj->getAllPaginatedCategory(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],
		$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$category['pagination'];
        $data['category']	=	$category['category'];
		Yii::app()->session['current']	=	'category';
		
		$this->render("category", array('data'=>$data,'ext'=>$ext));
		
	}
	
	function actionprouductForCategory()
	{	
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$productObj = new Product();
		$product	=	$productObj->getPaginatedProductforCategory(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['cat_id'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$product['pagination'];
        $data['product']	=	$product['product'];
		Yii::app()->session['current']	=	'category';
		Yii::app()->session['categoryName']	=	$_REQUEST['cat_name'];
		$this->render("productForCategory", array('data'=>$data,'ext'=>$ext,'cat_id'=>$_REQUEST['cat_id'],'cat_name'=>$_REQUEST['cat_name']));
		
	}
	
	function actionprouductForStore()
	{	
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$productObj = new Product();
		$product	=	$productObj->getPaginatedProductforStore(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['store_id'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$product['pagination'];
        $data['product']	=	$product['product'];
		Yii::app()->session['current']	=	'stores';
		Yii::app()->session['storeName']	=	$_REQUEST['store_name'];
		$this->render("productForStore", array('data'=>$data,'ext'=>$ext,'store_id'=>$_REQUEST['store_id'],'store_name'=>$_REQUEST['store_name']));
		
	}
	
	function actionaddCategory($cat_id=NULL)
	{
		//error_reporting(E_ALL);
		$this->isLogin();
		
		$title = 'Add Category';
        $result = array();
        if ($cat_id != NULL) {
            $title = 'Edit Category';
			$categoryObj = new Category();
            $result = $categoryObj->getCategoryDetail($cat_id);
            $_POST['cat_id'] = $result['cat_id'];
        }
        if (isset($_POST['FormSubmit'])) 
		{
			$cat_id = NULL;
			$data['admin_id'] = Yii::app()->session['adminUser'];
            $data['category_name'] = $_POST['category_name'];
			$data['cat_description'] = $_POST['cat_description'];
			
		  if (isset($_POST['cat_id']) && $_POST['cat_id'] != '') 
			{
				$data['admin_id'] = Yii::app()->session['adminUser'];
				$data['modified'] = date("Y-m-d H:i:s");
                $cat_id = $_POST['cat_id'];
				$categoryObj = new Category();
				$categoryObj->setData($data);
               $insertedId = $categoryObj->insertData($cat_id);
			   
			    Yii::app()->user->setFlash('success',$this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' .  $_SERVER['HTTP_REFERER']);
                exit;
            } 
			else 
			{
				$data['modified'] = date("Y-m-d H:i:s");
                $data['created'] = date("Y-m-d H:i:s");
				$categoryObj = new Category();
				$categoryObj->setData($data);
                $insertedId = $categoryObj->insertData();	
				
				 Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }
			
        }
		
        $data = array('result' => $result,'advanced' => "Selected", 'title' => $title);
        Yii::app()->session['current'] = 'category';
		$this->render('addCategory', $data);
	}
	
	
	 /*     * ***************	Delete Product  ************** */

    function actiondeleteCategory($id) {
        $this->isLogin();
        $categoryObj= new Category();
        $categoryObj->deleteCategory($id);

        Yii::app()->user->setFlash('success', $this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
	
	function actionproduct()
	{	
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$productObj = new Product();
		$product	=	$productObj->getAllPaginatedProductforAdmin(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$product['pagination'];
        $data['product']	=	$product['product'];
		Yii::app()->session['current']	=	'product';
		$this->render("product", array('data'=>$data,'ext'=>$ext));
		
	}
	
	function actionsearchProduct()
	{
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='product_name';
		}
		
	  $productObj = new Product();
	  $data = $productObj->getAllPaginatedProductforAdmin(5,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
	  $this->renderPartial("searchproduct",array('data'=>$data));	
	}
	
	function actioncustomers()
	{	
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$customerObj = new Customers();
		$customers	=	$customerObj->getPaginatedCustomerListForAdmin(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$customers['pagination'];
        $data['customers']	=	$customers['customers'];
		Yii::app()->session['current']	=	'customers';
		$this->render("customers", array('data'=>$data,'ext'=>$ext));
		
	}
	
	
	function actionaddCustomer($customer_id=NULL)
	{
		//error_reporting(E_ALL);
		$this->isLogin();
		
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
			$data['admin_id'] = Yii::app()->session['adminUser'];
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
				
				$query['query'] = "INSERT OR REPLACE INTO customers ('customer_id', 'admin_id', 'customer_name', 'cust_address', 'cust_email', 'contact_no', 'rating' , 'credit' ,'debit', 'total_purchase', 'createdAt', 'modifiedAt', 'status') VALUES (".$query['table_log_id'].", '".$data['admin_id']."', '".$data['customer_name']."', '".$data['cust_address']."', '".$data['cust_email']."', '".$data['contact_no']."', '".$data['rating']."' , '".$data['credit']."' , '".$data['debit']."' , '".$data['total_purchase']."', '".$data['createdAt']."', '".$data['modifiedAt']."', '".$data['status']."'); " ;
				
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
		$this->render('addCustomer', $data);
	}
	
	
		
	 /*     * ***************	Delete Customer  ************** */

    function actiondeleteCustomer($id) {
        $this->isLogin();
        $customerObj = new Customers();
        $customerObj->deleteCustomer($id);
		
/*--------------------------------Start Query Log Function----------------------------------------------*/
				$querylogObj = new TblQuerylog();
				$lastLogId = $querylogObj->getLastLogId();
				
				$query['table_log_id'] =$id;
				$query['table_name'] = 'customers';
				
				$querylogObj = new TblQuerylog();
				$querylog_id = $querylogObj->checkLogId($query['table_log_id'],$query['table_name']);
				
				$query['querylog_id'] =$querylog_id;
				$query['log_id'] = $lastLogId + 1 ;
				$query['query'] = "DELETE FROM customers WHERE customer_id='".$query['table_log_id']."' ; " ;
				
				$querylogObj = new TblQuerylog();
				$querylogObj->setData($query);
                $insertedId = $querylogObj->insertData($query['querylog_id']);
/*--------------------------------End Query Log Function----------------------------------------------*/

        Yii::app()->user->setFlash('success', $this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
	
	
	function actionsupplier()
	{	
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$supplierObj = new Supplier();
		$supplier	=	$supplierObj->getAllPaginatedSupplier(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$supplier['pagination'];
        $data['supplier']	=	$supplier['supplier'];
		Yii::app()->session['current']	=	'supplier';
		$this->render("supplier", array('data'=>$data,'ext'=>$ext));
		
	}
	/***** ALL LISTS *****/
	function actionLists() 
	{
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$listsObj	=	new TodoLists();
		$lists	=	$listsObj->getAllPaginatedLists(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['sortBy'] = $_REQUEST['sortBy'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['currentSortType'] = $_REQUEST['currentSortType'];
		
		$data['pagination']	=	$lists['pagination'];
        $data['lists']	=	$lists['lists'];
		Yii::app()->session['current']	=	'lists';
        $this->render("lists", array('data'=>$data,'ext'=>$ext));
    }
	
	
	/***** ALL LISTS *****/
	function actionitems() 
	{
		$this->isLogin();
		
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
		if(!isset($_REQUEST['stat4']))
		{
			$_REQUEST['stat4']='';
			
		}
		if(!isset($_REQUEST['stat3']))
		{
			$_REQUEST['stat3']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		
		$adminObj = new Admin();
		$adminObj->saveToDoStatus($_REQUEST);
		
		$result = $adminObj->findByPk(Yii::app()->session['adminUser']);
		$result = $result->attributes;
		
		$itemsObj	=	new TodoItems();
		$items	=	$itemsObj->getAllPaginatedItems(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate'],$result['myOpenStatus'],$result['myDoneStatus'],$result['myCloseStatus']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['sortBy'] = $_REQUEST['sortBy'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['stat1'] = $result['myOpenStatus'];
		$ext['stat3'] = $result['myDoneStatus'];
		$ext['stat4'] = $result['myCloseStatus'];
		$ext['currentSortType'] = $_REQUEST['currentSortType'];
		$data['pagination']	=	$items['pagination'];
        $data['items']	=	$items['items'];
		Yii::app()->session['current']	=	'items';
        $this->render("items", array('data'=>$data,'ext'=>$ext));
    }
	
		
	function actioncleanDB() 
	{
 		$adminObj = new Admin();
		$adminObj->cleanDB();
		$command="/var/www/html/utils/msg_send 200369 restart";
		passthru($command);
		Yii::app()->user->setFlash("success","DataBase cleaned successfully");
        header("location:" . Yii::app()->params->base_path . "admin");
		exit;
    }
	
	/****** Api Doc ******/

    function actionapprovalApiFunction() {
        if (isset($_POST['statusName']) && isset($_POST['statusValue'])) {
            $Api_functionObj = new ApiFunction();
            $result = $Api_functionObj->setApproval($_POST);
			if($result['status'] == 0){
				return true;
			}else{
				return false;
			}
        }
        return false;
    }
	
		
	function actionPrefferedLanguage($lang='eng')
	{
		if(isset(Yii::app()->session['adminUser']) && Yii::app()->session['adminUser']>0)
		{
			//$userObj=new User();
			//$userObj->setPrefferedLanguage(Yii::app()->session['userId'],$lang);
		}
		
		Yii::app()->session['prefferd_language']=$lang;
		//Yii::app()->language = Yii::app()->user->getState('_lang');
		$this->redirect(Yii::app()->params->base_path."admin/index");
	}

    /*
     * Method:apiFunctions
     * Display function list for rest api
     * $page=>page no for pagination
     */

    function actionapiFunctions($module='-1', $page=1) 
	{
		error_reporting(E_ALL);
		$this->isLogin();
		if(isset($_POST['findname']) && $_POST['findname'] == '')
		{
			unset(Yii::app()->session['findname']);
		}
        $adminObj = new Admin();
        $adminId = $adminObj->getAdminDetailsByEmail(Yii::app()->session['email']);
		$adminDetails = $adminObj->getAdminDetailsById($adminId['id']);
       	
			$Api_functionObj = new ApiFunction();
        $Api_function_resourceObj = new ApiFunctionResource();
        if(isset($_POST['findname']) && $_POST['findname'] != '')
		{
			
	    	$result = $Api_functionObj->listFunction($module, $page,trim($_POST['findname']));
			$data['findname']=trim($_POST['findname']);
		}
		else
		{
			$result = $Api_functionObj->listFunction($module, $page);
		}
        $Api_moduleObj = new ApiModule();
		
        $i = 0;
        foreach ($result[1] as $data) {
            $moduleData = $Api_moduleObj->getModule($data['moduleId']);
            if (isset($moduleData['label'])) {
                $result[1][$i]['moduleLabel'] = $moduleData['label'];
            }
            $resourceData = $Api_function_resourceObj->getData($data['id']);

            if (!empty($resourceData)) {
                $httpmethod = "REQUEST";
                if ($resourceData['http_methods'] == '0') {
                    $httpmethod = "GET";
                }
                if ($resourceData['http_methods'] == '1') {
                    $httpmethod = "POST";
                }

                $response_formats = "XML,JSON";
                if ($resourceData['response_formats'] == '1') {
                    $response_formats = "XML";
                }
                if ($resourceData['response_formats'] == 2) {
                    $response_formats = "JSON";
                }
                $result[1][$i]['resource_url'] = $resourceData['resource_url'];
                $result[1][$i]['http_methods'] = $httpmethod;
                $result[1][$i]['response_formats'] = $response_formats;
            }
            $i++;
        }
		
	   if(isset($_POST['findname']) && $_POST['findname']!='')
	   {
	   		Yii::app()->session['findname'] = $_POST['findname'];
	   }
	    
		$data=array('pagination'=>$result[0],'functionList'=>$result[1],'adminDetails'=>$adminDetails,'advanced'=>"Selected",'title'=>$this->msg['_TITLE_FJN_ADMIN_API_FUNCTIONS_']);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('api-functions',$data);
    }
	
	/*
     * Method:addApiFunction
     * Add/Edit function
     * $id=>id for function
     */

    function actionaddApiFunction($id=NULL) {
     
		$this->isLogin();
		
        $Api_moduleObj = new ApiModule();
        $modules = $Api_moduleObj->getModules();
        $Api_functionObj = new ApiFunction();
        $title = 'Add Function';
		$result=array();
        if ($id != NULL) {
            $title = 'Edit Functions';
            $result=$Api_functionObj->getFunction($id);
			$_POST['id']=$result['id'];
        }
        if (isset($_POST['FormSubmit'])) {
            $id = NULL;
            $Api_functionArray['function_name'] = $_POST['function_name'];
            $Api_functionArray['moduleId'] = $_POST['moduleId'];
            $Api_functionArray['fn_description'] = $_POST['fn_description'];
            $Api_functionArray['published'] = isset($_POST['published']) ? $_POST['published'] : 1;

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $Api_functionArray['id'] = $_POST['id'];
                $Api_functionArray['modifiedAt'] = 'now()';
                $id = $_POST['id'];
            } else {
                $Api_functionArray['createdAt'] = 'now()';
            }
			
			if(isset($id) && $id!=NULL)
			{
				$Api_functionObj->setData($Api_functionArray);
				$Api_functionObj->insertData($id);
			}
			else
			{
				$Api_functionObj->setData($Api_functionArray);
				$insertedId= $Api_functionObj->insertData();
			}
            if(isset($insertedId) && $insertedId > 0) {
				Yii::app()->user->setFlash('success', "Function added successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/apiFunctions');
                exit;
            } else {
				Yii::app()->user->setFlash('success', "Function updated successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/apiFunctions');
                exit;
            }
        }
		
		$data=array('result'=>$result,'modules'=>$modules,'advanced'=>"Selected",'title'=>$title);
		Yii::app()->session['current'] = 'advanced';
		$this->render('add-api-function',$data);
    }

	/*
     * Method:deleteApiFunction
     * delete function
     * $id=>id for function
     */

    function actiondeleteApiFunction($id) {
        $this->isLogin();
        $Api_functionObj = new ApiFunction();
        $Api_functionObj->deleteFunction($id);
		
		Yii::app()->user->setFlash('success', "Function deleted successfully.");
        header('location:' . Yii::app()->params->base_path . 'admin/apiFunctions');
		exit;
    }

    /*
     * Method:functionParametes
     * Display list of function parameters
     * $fn_id=>function id
     * $page=>page no. for function parameters
     */

    function actionfunctionParametes($fn_id=NULL, $page=1) {
        $this->isLogin();
		if(!isset($fn_id)){
			header("Location:" . Yii::app()->params->base_path . "admin/apiFunctions");
		}
        $Api_function_paramObj = new ApiFunctionParam();
        $result = $Api_function_paramObj->listParam($fn_id, $page);
		$data=array('pagination'=>$result[0],'paramList'=>$result[1],'advanced'=>"Selected",'fun_ref_id'=>$fn_id);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('function-parameters',$data);
    }

 	/*
     * Method:addFunctionParamete
     * Add/Edit function parameter
     * $id=>id for function parameter
     */

    function actionaddFunctionParameter($fn_id, $id=NULL) {
		
        $this->isLogin();
        $Api_function_paramObj = new ApiFunctionParam();
        $Api_functionObj = new ApiFunction();
        $functions = $Api_functionObj->getFunctions();
		$result=array();
        $title = 'Add Parameter';
        if ($id != NULL) {
            $title = 'Edit Parameter';
            $result = $Api_function_paramObj->getParameter($id);
            $fn_id = $result['fn_id'];
			$_POST['id'] = $result['id'];
        }
        if (isset($_POST['FormSubmit'])) {
            $id = NULL;
            $paramArray['fnParamName'] = $_POST['fnParamName'];
            $paramArray['fnParamDescription'] = $_POST['fnParamDescription'];
            $paramArray['example'] = $_POST['example'];
            $paramArray['uiValidationRule'] = $_POST['uiValidationRule'];
            $paramArray['fn_id'] = $_POST['fn_id'];
            $paramArray['ParamType'] = isset($_POST['ParamType']) ? $_POST['ParamType'] : 1;
            $paramArray['published'] = isset($_POST['published']) ? $_POST['published'] : 1;

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $paramArray['id'] = $_POST['id'];
                $paramArray['modifiedAt'] = 'now()';
                $id = $_POST['id'];
            } else {
                $paramArray['createdAt'] = 'now()';
            }
			if(isset($id) && $id!=NULL)
			{
				$Api_function_paramObj->setData($paramArray);
				$Api_function_paramObj->insertData($id);
			}
			else
			{
				$Api_function_paramObj->setData($paramArray);
				$insertedId= $Api_function_paramObj->insertData();
			}
            if(isset($insertedId) && $insertedId > 0) {
				Yii::app()->user->setFlash('success', "Parameter added successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/functionParametes/&fn_id=' . $fn_id);
                exit;
            } else {
				Yii::app()->user->setFlash('success', "Parameter updated successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/functionParametes/&fn_id=' . $fn_id);
                exit;
            }
			
        }
		
		$data=array('result'=>$result,'functions'=>$functions,'fun_ref_id'=>$fn_id,'advanced'=>"Selected",'title'=>$title);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('add-function-parameter',$data);
		
    }

    /*
     * Method:deleteFunctionParameter
     * delete function
     * $id=>id for function
     */

    function actiondeleteFunctionParameter($fn_id, $id) {
        $this->isLogin();
        $Api_function_paramObj = new ApiFunctionParam();
        $Api_function_paramObj->deleteParameter($id);
		Yii::app()->user->setFlash('success', "Parameter deleted successfully.");
        header('location:' . Yii::app()->params->base_path . 'admin/functionParametes/fn_id/' . $fn_id);
		exit;
    }

    function actionapiResource($fn_id=NULL) {
        $this->isLogin();
		error_reporting(E_ALL);
		if(!isset($fn_id)){
			header("Location:" . Yii::app()->params->base_path . "admin/apiFunctions");
		}
        $Api_function_resourceObj = new ApiFunctionResource();
        if (isset($_POST['FormSubmit'])) {
            $dataArray['resource_url'] = $_POST['resource_url'];
            $dataArray['authentication'] = $_POST['authentication'];
            $dataArray['response_formats'] = $_POST['response_formats'];
            $dataArray['http_methods'] = $_POST['http_methods'];
            $dataArray['example'] = $_POST['example'];
            $dataArray['response'] = $_POST['response'];
            $dataArray['fn_id'] = $fn_id;
            $Api_function_resourceObj->setData($dataArray);
            $Api_function_resourceObj->insertData($_POST['id']);
			Yii::app()->user->setFlash('success', "Resource url updated successfully.");
        }
        $data = $Api_function_resourceObj->getData($fn_id);
        $Response_formatObj = new ResponseFormat();
        $resResult = $Response_formatObj->getResponseFormat();
		$data=array('data'=>$data,'fn_id'=>$fn_id,'http_mth_id'=>array(0, 1, 2),'http_mth_val'=>array('GET ', 'POST', 'REQUEST'),'http_mth_selected'=>(isset($data['http_methods']) ? $data['http_methods'] : 0),'res_fr_id'=>$resResult['id'],'res_fr_val'=>$resResult['label'],'res_fr_selected'=>(isset($data['response_formats']) ? $data['response_formats'] : 1),'advanced'=>"Selected");
		
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('function-resource',$data);
    }
	
	/****** End Api Doc ******/
	
	/*
     * Method:apiModules
     * Display module list for rest api
     * $page=>page no for pagination
     */

    function actionapiModules($page=1) {
        $this->isLogin();
		Yii::app()->session['current'] = 'apiFunctions';
        $adminObj = new Admin();
        $adminId = $adminObj->getAdminDetailsByEmail(Yii::app()->session['email']);
        $adminDetails = $adminObj->getAdminDetailsById($adminId);
      
        $Api_moduleObj = new ApiModule();
        $result[0] = $Api_moduleObj->getModules($page);

		$data=array('moduleList'=>$result[0],'adminDetails'=>$adminDetails,'advanced'=>"Selected",'TITLE_ADMIN'=>$this->msg['_TITLE_FJN_ADMIN_API_MODULES_']);
		$this->render('api_modules',$data);
    }

    /*
     * Method:addApiModule
     * Add/Edit module
     * $id=>id for module
     */

    function actionaddApiModule($id=NULL) {
        $this->isLogin();
        $Api_moduleObj = new ApiModule();
        $title = 'Add Module';
		$result =array();
        if ($id != NULL) {
            $title = 'Edit Module';
			$result=$Api_moduleObj->getModule($id);
			$_POST['id']=$result['id'];
        }
        if (isset($_POST['FormSubmit'])) {
            $id = NULL;
            $Api_moduleArray['label'] = $_POST['label'];
            $Api_moduleArray['description'] = $_POST['description'];
            $Api_moduleArray['published'] = isset($_POST['published']) ? $_POST['published'] : 1;

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $Api_moduleArray['id'] = $_POST['id'];
                $Api_moduleArray['modifiedAt'] = 'now()';
                $id = $_POST['id'];
            } else {
                $Api_moduleArray['createdAt'] = 'now()';
            }
			
			if(isset($id) && $id!=NULL)
			{
				$Api_moduleObj->setData($Api_moduleArray);
				$Api_moduleObj->insertData($id);
			}
			else
			{
				$Api_moduleObj->setData($Api_moduleArray);
				$insertedId= $Api_moduleObj->insertData();
			}
            if(isset($insertedId) && $insertedId > 0) {
				Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . Yii::app()->params->base_path . 'admin/apiModules');
                exit;
            } else {
				Yii::app()->user->setFlash('success',$this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' . Yii::app()->params->base_path . 'admin/apiModules');
                exit;
            }
        }
		$data=array('result'=>$result,'advanced'=>"Selected",'title'=>$title);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('add_api_module',$data);
    }

    /*
     * Method:deleteApiModule
     * delete module
     * $id=>id for module
     */

    function actiondeleteApiModule($id) {
        $this->isLogin();
        $Api_moduleObj = new ApiModule();
        $Api_moduleObj->deleteModule($id);
		Yii::app()->user->setFlash('success',$this->msg['_RECORD_DEL_MSG_']);
        header('location:' . Yii::app()->params->base_path . 'admin/apiModules');
		exit;
    }
	
	public function actiongeneralEntryforAdmin()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$admin_id = Yii::app()->session['adminUser'];
		$generalObj = new AccountMaster();
		$accounts = $generalObj->getAllAccounts($admin_id);
		
		Yii::app()->session['current'] = 'accounts';
		$this->render('generalentry',array('accounts'=>$accounts));
	}
	
	public function actionaddGeneralEntryforAdmin()
	{
		$general['amount'] = $_REQUEST['amount'];
		$general['admin_id'] = Yii::app()->session['adminUser'];
		$general['credit'] = $_REQUEST['credit'];
		$general['debit'] = $_REQUEST['debit'];
		$general['created']=date('Y-m-d:H-m-s');
		
		$generalEntryObj = new GeneralEntryAccount();
		$generalEntryObj->setData($general);
		$generalEntryObj->insertData();

		Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
		$this->renderPartial('generalentry',array("isAjax"=>'true'));
		
	}
	
	public function actiongeneralEntryforCustomer()
	{
		$admin_id = Yii::app()->session['adminUser'];
		
		$customerObj = new Customers();
		$customerList = $customerObj->getAllCustomerListForAdmin($admin_id);
		
		$this->renderPartial('generalentryForCustomer',array('customerList'=>$customerList));
	}
	
	public function actiongeneralEntryforSupplier()
	{
		$admin_id = Yii::app()->session['adminUser'];
		
		$supplierObj = new Supplier();
		$supplierList = $supplierObj->getAllSupplierListForAdmin($admin_id);
		
		$this->renderPartial('generalentryForSupplier',array('supplierList'=>$supplierList));
	}
	
	public function actionaddGeneralEntryforCustomer()
	{
			$customer['customer_id'] = $_REQUEST['customer_id'];
			$customer['credit'] = $_REQUEST['credit'];
			$customer['debit'] = $_REQUEST['debit'] ;
			$customer['modifiedAt']=date('Y-m-d:H-m-s');
			
			$customerObj = new Customers();
			$customerObj->updateCustomer($customer['customer_id'],$customer['credit'],$customer['debit'],$customer['modifiedAt']);
			
			$customerGeneral['customer_id'] = $_REQUEST['customer_id'];
			$customerGeneral['admin_id'] = Yii::app()->session['adminUser'];
			$customerGeneral['credit'] = $_REQUEST['credit'];
			$customerGeneral['store_id'] = 0 ;
			$customerGeneral['debit'] = $_REQUEST['debit'];
			$customerGeneral['paymentType'] = $_REQUEST['paymentType'];
			$customerGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$customerGeneralObj = new CustomerGeneralEntry();
			$customerGeneralObj->setData($customerGeneral);
			$receiptId = $customerGeneralObj->insertData();
			
			/*$this->actiongeneralEntryforAdmin();
			exit;*/
			
			$this->actiongeneratePaymentRecipts($receiptId);
	}
	
	public function actionaddGeneralEntryforSupplier()
	{
			$supplier['supplier_id'] = $_REQUEST['supplier_id'];
			$supplier['credit'] = $_REQUEST['credit'];
			$supplier['debit'] = $_REQUEST['debit'];
			$supplier['modified_date']=date('Y-m-d:H-m-s');
			
			$supplierObj = new Supplier();
			$supplierObj->updateSupplier($supplier['supplier_id'],$supplier['credit'],$supplier['debit'],$supplier['modified_date']);
			
			$supplierGeneral['supplier_id'] = $_REQUEST['supplier_id'];
			$supplierGeneral['admin_id'] = Yii::app()->session['adminUser'];
			$supplierGeneral['store_id'] = 0 ;
			$supplierGeneral['credit'] = $_REQUEST['credit'];
			$supplierGeneral['debit'] = $_REQUEST['debit'];
			$supplierGeneral['paymentType'] = $_REQUEST['paymentType'];
			$supplierGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$supplierGeneralObj = new SupplierGeneralEntry();
			$supplierGeneralObj->setData($supplierGeneral);
			$receiptId = $supplierGeneralObj->insertData();
			
			/*$this->actiongeneralEntryforAdmin();
			exit;*/
			
			$this->actiongenerateSupplierPaymentRecipts($receiptId);
			
	}
	
	public function actionaccountMaster()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$admin_id = Yii::app()->session['adminUser'];
		$generalObj = new AccountGroup();
		$groups = $generalObj->getAllGroups($admin_id);
		
		Yii::app()->session['current'] = 'accounts';
		$this->render('account_master',array('groups'=>$groups));
	}
	
	function actionaddAccountMaster()
	{
		$general['accountName'] = $_REQUEST['accountName'];
		$general['group_id'] = $_REQUEST['group_id'];
		$general['balance'] = $_REQUEST['balance'];
		$general['admin_id'] = Yii::app()->session['adminUser'];
		$general['created']=date('Y-m-d:H-m-s');
		
		$generalEntryObj = new AccountMaster();
		$generalEntryObj->setData($general);
		$generalEntryObj->insertData();

		Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
		$this->renderPartial('account_master',array("isAjax"=>'true'));
		
	}
	
	public function actionaccountGroup()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		Yii::app()->session['current'] = 'accounts';
		$this->render('account_group',array('accounts'=>$accounts));
	}
	
	function actionaddAccountGroup()
	{
		$general['group_name'] = $_REQUEST['group_name'];
		$general['admin_id'] = Yii::app()->session['adminUser'];
		$general['created']=date('Y-m-d:H-m-s');
		
		$generalEntryObj = new AccountGroup();
		$generalEntryObj->setData($general);
		$generalEntryObj->insertData();

		Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
		$this->renderPartial('account_group',array("isAjax"=>'true'));
		
	}
	
	public function actioninterStoreAdjust()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$productObj = new Product();
		$products = $productObj->getAllProductList($admin_id);
		
		$storeObj = new Stores();
		$storeList = $storeObj->getClientStoreList($admin_id);
		
		Yii::app()->session['current'] = 'accounts';
		$this->render('inter_store_adjust',array('products'=>$products,'storeList'=>$storeList));
	}
	
	function actionCheckStockDetail()
	{
		$stockObj = new Stock();
		$result = $stockObj->checkStockDetail($_REQUEST['product_id'],$_REQUEST['store_id']);
		
		echo $result['quantity'];
	}
	
	function actioninterChangeProduct()
	{
		$admin_id = Yii::app()->session['adminUser'];
		
		$intrastock['product_id'] = $_REQUEST['product_id'];
		$intrastock['admin_id'] = $admin_id;
		$intrastock['from_store_id'] = $_REQUEST['fromStore'];
		$intrastock['quantity']	= $_REQUEST['quantity'];
		$intrastock['to_store_id']	= $_REQUEST['toStore'];
		$intrastock['created'] = date("Y-m-d H:i:s");
		$intrastock['modified'] = date("Y-m-d H:i:s");
		
		$intrastockObj = new InterStoreAdjustEntry();
		$intrastockObj->setData($intrastock);
		$intrastockObj->insertData();
		
		$stock['product_id'] = $_REQUEST['product_id'];
		$stock['admin_id'] = $admin_id;
		$stock1['store_id'] = $_REQUEST['fromStore'];
		$stock['quantity']	= $_REQUEST['quantity'];
		$stock['store_id']	= $_REQUEST['toStore'];
		$stock['modified'] = date("Y-m-d H:i:s");
		
		$stockObj = new Stock();
		$stockObj->updateStockForProductDesc($stock['product_id'],$stock['quantity'],$stock['modified'],$stock1['store_id']);
		
		$stockObj = new Stock();
		$result = $stockObj->checkStockDetail($_REQUEST['product_id'],$_REQUEST['toStore']);
		
		if(!empty($result) && $result != "")
		{
			$stockObj = new Stock();
			$stockObj->updateStockForSalesReturn($stock['product_id'],$stock['quantity'],$stock['modified'],$stock['store_id']);
		}
		else
		{
			$stock['created'] = date("Y-m-d H:i:s");
			$stockObj = new Stock();
			$stockObj->setData($stock);
			$stockObj->insertData();
		}
/*------------------------------------Start--Update Product Store_id field------------------------------*/
		$productObj = new Product();
		$productData = $productObj->checkProductStoreDetails($_REQUEST['product_id'],$_REQUEST['toStore']);	
		
		if(empty($productData))
		{
			$productObject=Product::model()->findbyPk($_REQUEST['product_id']);
			$UpdateStoreId['store_id'] = $productObject->store_id.",".$_REQUEST['toStore'].",";
			
			$productObj = new Product();
			$productObj->setData($UpdateStoreId);
			$productObj->insertData($_REQUEST['product_id']);
		}
/*-----------------------------------Finish-Update Product Store_id field------------------------------*/		
		
		$productObj = new Product();
		$products = $productObj->getAllProductList($admin_id);
		
		$storeObj = new Stores();
		$storeList = $storeObj->getClientStoreList($admin_id);
		
		Yii::app()->user->setFlash('success',Yii::app()->params->msg['_RECORD_INSERT_SUCCESS_']);
		$this->renderPartial('inter_store_adjust',array('products'=>$products,'storeList'=>$storeList));
		
	}
	
	function actionmyprofile()
	{
		
		Yii::app()->session['current']   =   'settings';
		$adminObj	=	new Admin();
		
		if(isset(Yii::app()->session['email'])){
    		$adminId	=	$adminObj->getAdminIdByLoginId(Yii::app()->session['email']);
    		$adminDetails	=	$adminObj->getAdminDetailsById($adminId);
            $data['adminDetails']   =   $adminDetails;
			$currencyObj = new Currency();
			$currencyList = $currencyObj->getAllCurrencyList();
			$this->render('myprofile', array('data'=>$data,'currencyList'=>$currencyList));
		}else{
            $this->redirect(Yii::app()->params->base_path.'admin/index');
		}
	}
	
	function actionsaveProfile()
	{	
		error_reporting(E_ALL);
		if(isset($_POST['FormSubmit']) && $_POST['FormSubmit'] == "Submit")
		{
			$adminObj	=	new Admin();
			$Admin_value['first_name'] = $_POST['FirstName'];
			$Admin_value['last_name'] = $_POST['LastName'];
			$Admin_value['company_name'] = $_POST['company_name'];
			$Admin_value['company_address'] = $_POST['company_address'];
			
			if(isset($_FILES["logo"]["name"]) && $_FILES["logo"]["name"] != "" )
			{
			   $Admin_value['company_logo'] = $_FILES["logo"]["name"];
						
			 move_uploaded_file($_FILES["logo"]["tmp_name"],
					FILE_UPLOAD."/clientLogo/" . $_FILES["logo"]["name"]);
			}
			$Admin_value['currency'] = $_POST['currency'];
			$validationObj = new Validation();
			$res = $validationObj->updateAdminProfile($Admin_value);	
		   if($res['status'] == 0)
		   {
				 $adminObj->updateProfile($Admin_value,$_POST['AdminID']);
				 Yii::app()->session['FullName'] = $Admin_value['first_name'] .''.$Admin_value['last_name'];
				 Yii::app()->session['currency'] = $Admin_value['currency'] ;
				 Yii::app()->user->setFlash('success', $this->msg['_UPDATE_SUCC_MSG_']);
		   }
		   else
		   {
				Yii::app()->user->setFlash('error',$res['message']);
		   }
		}
		$this->actionmyprofile();   
	}
	
	function actionchangePassword()
	{
		$this->isLogin();
		if(!isset($_REQUEST['ajax']))
		{
			$_REQUEST['ajax']='false';
		}
		$resultArray['ajax']=$_REQUEST['ajax'];
		if(isset($_GET['id']) && $_GET['id'] != '')
		{
			$resultArray['id']=$_GET['id'];
		}
		else
		{
			$resultArray['id']=Yii::app()->session['adminUser'];
		}
		if($_REQUEST['ajax']=='true')
		{
			$this->render('change_password',$resultArray);	
		}
		else
		{
			$this->render('change_password',$resultArray);	
		}	
	}
	
	function actionchangeAdminPassword()
	{
		$this->isLogin();
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != '')
		{
			$adminObj = new Admin();
			$adminId = $adminObj->getAdminIdByLoginId(Yii::app()->session['email']);
			$adminDetails = $adminObj->getAdminDetailsById($adminId);
			Yii::app()->session['current'] =   'settings';
			$data['adminDetails']=$adminDetails;
			$data['id']=$adminId;
			$data["settings"]= "Selected";
			$data['TITLE_ADMIN']=$this->msg['_TITLE_FJN_ADMIN_CHANGE_PASSWORD_'];
			$pass_flag = 0;
			if (isset($_POST['Save'])) {
				$adminObj=Admin::model()->findbyPk($adminId);
				$res = $adminObj->attributes;
				$generalObj = new General();
				$res = $generalObj->validate_password($_POST['opassword'],$res['password']);
				if($res!=true)
				{	
					Yii::app()->user->setFlash("error","Old Password is wrong.");
				}
				else
				{
					$generalObj = new General();
					$password_flag = $generalObj->check_password($_POST['password'], $_POST['cpassword']);
		
					switch ($password_flag) {
						case 0:
							$pass_flag = 0;
							break;
						case 1:
							
							Yii::app()->user->setFlash("error","Please don't blank password.");
							$pass_flag = 1;
							break;
						case 2:
							
							Yii::app()->user->setFlash("error","Password minimum length need to six character.");
							$pass_flag = 1;
							break;
						case 3:
							Yii::app()->user->setFlash("error","Password minimum need to one lowercase.");
							
							$pass_flag = 1;
							break;
						case 4:
							Yii::app()->user->setFlash("error","Password minimum need to one upercase.");
							$pass_flag = 1;
							break;
						case 5:
							Yii::app()->user->setFlash("error","Password minimum need to one digit number.");
							$pass_flag = 1;
							break;
						case 6:
							Yii::app()->user->setFlash("error","Password minimum need to one special character.");
							$pass_flag = 1;
							break;
						case 7:
							Yii::app()->user->setFlash("error","Password is not match with confirm password.");
							$pass_flag = 1;
							break;
					}
				
					if ($pass_flag == 0) {
						if (isset($_POST['opassword'])) {
							if (strlen($_POST['opassword']) < 1) {
								
								 Yii::app()->user->setFlash("error",$this->msg['WRONG_PASS_MSG']);
							} else if (strlen($_POST['password']) < 5) {
								
								 Yii::app()->user->setFlash("error",$this->msg['_VALIDATE_PASSWORD_GT_6_']);
							} else if ($_POST['password'] != $_POST['cpassword']) {
								
								 Yii::app()->user->setFlash("error",$this->msg['_CONFIRM_PASSWORD_NOT_MATCH_']);
							} else {
								$admin = new admin();
								$result = $admin->changePassword(Yii::app()->session['adminUser'], $_POST);
								if ($result == '2') {
								   
									Yii::app()->user->setFlash("error","Old Password don't match with over database.");
								} else {
								  
									Yii::app()->user->setFlash("error",$this->msg['_PASSWORD_CHANGE_SUCCESS_']);
									Yii::app()->user->setFlash('success',"Successfully Changed Password.");
								}
							}
						}
					}
				}
			}
		}
		if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
		{
			if (isset($_POST['Save'])) {
				$loginObj=Login::model()->findbyPk($_REQUEST['user_id']);
				$res = $loginObj->attributes;
				$generalObj = new General();
				$res = $generalObj->validate_password($_POST['opassword'],$res['password']);
				if($res!=true)
				{	
					Yii::app()->user->setFlash("error","Old Password is wrong.");
				}
				$adminObj = new admin();
				$result = $adminObj->changeUserPassword($_REQUEST['user_id'], $_REQUEST);
				Yii::app()->user->setFlash("error",$this->msg['_PASSWORD_CHANGE_SUCCESS_']);
				Yii::app()->user->setFlash('success',"Successfully Changed Password.");
			}
		}
		
		$this->render("change_password",$data);
	}
	
	function actionforgotPassword() 
	{
		$captcha = Yii::app()->getController()->createAction('captcha');
        if (isset(Yii::app()->session['adminUser'])) {
			 Yii::app()->request->redirect( Yii::app()->params->base_path . 'admin');
        }
		
        if (isset($_POST['verifyCode']) && !$captcha->validate($_POST['verifyCode'],1)) 
		{
			Yii::app()->user->setFlash("error",$this->msg['_INVALID_CAPTCHA_']);
            header("Location: " . Yii::app()->params->base_path . 'admin/forgotPassword');
            exit;
        } else {
            if (isset($_POST['loginId'])) {
                $AdminObj = new Admin();
                $result = $AdminObj->forgot_password($_POST['loginId']);
                if ($result[0] == 'success') {
					Yii::app()->user->setFlash("success",$result[1]);
                    $data['message_static']=$result[1];
                    $this->render("password_confirm",array("data"=>$data));
					exit;
                } else {
					Yii::app()->user->setFlash("error",$result[1]);
                    $this->render("forgot_password");
					exit;
                }
            }
        }
		if(empty($_POST))
		{
			$this->render("forgot_password");
		}
    }

    function actionresetPassword() 
	{
        $message = '';
        if (isset($_POST['submit_reset_password_btn'])) {
            $adminObj = new Admin();
            $result = $adminObj->resetpassword($_POST);
            $message = $result[1];
            if ($result[0] == 'success') {
				Yii::app()->user->setFlash("success",$message);
                header("Location: " . Yii::app()->params->base_path . 'admin/');
                exit;
            }
			else
			{
				Yii::app()->user->setFlash("error",$message);
                header("Location: " . Yii::app()->params->base_path . 'admin/resetpassword');
                exit;
			}
        }
        if ($message != '') {
			Yii::app()->user->setFlash("success",$message);
        }
        if( isset($_REQUEST['token']) ) {
			$data['token']	=	trim($_REQUEST['token']);
		}
		$this->render('password_confirm',$data);
    }
	
	/* =============== Contain Of Approve User Login ============== */

    function actionapproveUser($id=NULL) 
	{
		error_reporting(E_ALL);
        $this->isLogin();
        if(!isset($id)){
			header("Location: " . Yii::app()->params->base_path . "admin/clientRequest");
		}
		//	DELETE OTHER VERIFIED PHONE NUMBERS
		$userObj	=	new Users();
		$incoming_sms_sender	=	$userObj->getPhoneById($id);
		
		if($incoming_sms_sender!=''){
			$userObj = new Users();
			//$userObj->deletePhoneNumber($incoming_sms_sender,$id);
			//$userObj->deleteOtherVerifiedPhone($id);
		}
		
		$userObj=Users::model()->findByPk($id);
		$user_value['id'] = $id;
        $user_value['modifiedAt']=date('Y-m-d h:m:s');
        $user_value['isVerified'] = '1';
		$userObj = new Users();
		$userObj->veriryUser($user_value,$id);
		
		
		
		
		
		Yii::app()->user->setFlash('success',$this->msg['_VERIFY_ACCOUNT_']);
        $this->actionclientRequest();
    }
	
	function actionapproveAllUser($email=NULL) 
	{
		error_reporting(E_ALL);
        $this->isLogin();
        if(!isset($email)){
			header("Location: " . Yii::app()->params->base_path . "admin/clientRequest");
		}
		//	DELETE OTHER VERIFIED PHONE NUMBERS
		$userObj	=	new Users();
		$incoming_sms_sender	=	$userObj->getEmailById($email);
		
		if($incoming_sms_sender!=''){
			$userObj = new Users();
			//$userObj->deletePhoneNumber($incoming_sms_sender,$id);
			//$userObj->deleteOtherVerifiedPhone($id);
		}
		foreach($incoming_sms_sender as $row)
		{
			$userObj=Users::model()->findByPk($row['id']);
			$user_value['id'] = $row['id'];
			$user_value['modifiedAt']=date('Y-m-d h:m:s');
			$user_value['isVerified'] = '1';
			$userObj = new Users();
			$userObj->veriryUser($user_value,$row['id']);
		}
		Yii::app()->user->setFlash('success',$this->msg['_VERIFY_ACCOUNT_']);
        $this->actionclientRequest();
    }
	
	
	function actionapproveClient($id=NULL) 
	{
		error_reporting(0);
        $this->isLogin();
        if(!isset($id)){
			header("Location: " . Yii::app()->params->base_path . "admin/clientRequest");
		}
		//	DELETE OTHER VERIFIED PHONE NUMBERS
		$adminObj	=	new Admin();
		$admin_data	=	$adminObj->getAdminDetailsById($id);
		
		$user_value['modified_at']=date('Y-m-d h:m:s');
		$user_value['isVerified'] = '1';
		$adminObj = new Admin();
		$adminObj->veriryUser($user_value,$admin_data['id']);
		
			
/*----------------------Mail Function Start---------------------------------------------- */			
			$adminObj=Admin::model()->findbyPk($id);
			$res = $adminObj->attributes;
						
			$message = '<table style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
  <tr>
    <td align="left"><div><img src="'.Yii::app()->params->base_url.'images/logo/logo.png" alt="NVIS"/></div>
      <div style="color:#666666; display:block; font-family:Arial,Helvetica,sans-serif; font-size:11px; font-weight:normal;
          padding:0px 0px 0px 28px;">NVIS - New Vision Integrated Systems</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Congratulation,</td>
  </tr>
  <tr>
    <td>New User Approved by admin.</td>
  </tr>
  <tr>
    <td><table>
		<tr>
			<td><b>First Name</b></td>
			<td><b>'.$res['first_name'].'</b></td>
		</tr>
        <tr>
          <td><b>Last Name</b></td>
		  <td><b>'.$res['last_name'].'</b></td>
        </tr>
		<tr>
          <td><b>User Email</b></td>
		  <td><b>'.$res['email'].'</b></td>
        </tr>
		<tr>
          <td><b>No of Allocate Users</b></td>
		  <td><b>'.$res['total_users'].'</b></td>
        </tr>
		<tr>
          <td><b>Login Id</b></td>
		  <td><b>'.$res['email'].'</b></td>
        </tr>
		<tr>
          <td><b>Password</b></td>
		  <td><b>*alibaba*</b></td>
        </tr>
	</table></td>
  </tr>
  <tr>
    <td>This account is successfully approved. Now you can log in with above credential.</td>
  </tr>
  <tr>
    <td>For access your account <a href="'.Yii::app()->params->base_path.'admin">Click</a> here.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p> Thanks,<br />
        The POS Team<br />
      </p></td>
  </tr>
</table>';
			
			$recipientemail = Yii::app()->session['email'];
			$subject = "User Account Approved";
			
			$this->sendUserCreateMail($recipientemail, $subject, $message);		
			$this->sendUserCreateMail($res['email'], $subject, $message);
/*----------------------Mail Function End------------------------------------------------- */

		Yii::app()->user->setFlash('success',$this->msg['_VERIFY_ACCOUNT_']);
        $this->actionclientRequest();
    }
	
	
	function actionaddEmployee($employee_id=NULL)
	{
		$this->isLogin();
		
		$employeeObj = new Employees();
		
        $title = 'Add Employee';
        $result = array();
        if ($employee_id != NULL) {
            $title = 'Edit Employee';
            $result = $employeeObj->getEmployeeDetails($employee_id);
            $_POST['employee_id'] = $result['employee_id'];
        }
        if (isset($_POST['FormSubmit'])) 
		{
			$employee_id = NULL;
			$data['admin_id'] = Yii::app()->session['adminUser'];
            $data['firstName'] = $_POST['firstName'];
			$data['lastName'] = $_POST['lastName'];
			$data['email'] = $_POST['email'];
			$data['contact_no'] = $_POST['contact_no'];
			$data['salary'] = $_POST['salary'];
			$data['status'] = $_POST['status'];

            if (isset($_POST['employee_id']) && $_POST['employee_id'] != '') 
			{
                $data['admin_id'] = Yii::app()->session['adminUser'];
				$data['employee_id'] = $_POST['employee_id'];
                $data['modified_date'] = date("Y-m-d H:i:s");
                $employee_id = $_POST['employee_id'];
            } 
			else 
			{
				$data['joining_date'] = date("Y-m-d H:i:s");
                $data['created_date'] = date("Y-m-d H:i:s");
            }
			if (isset($employee_id) && $employee_id != NULL) {                
				$employeeObj->setData($data);
                $employeeObj->insertData($employee_id);
            } else {
				$employeeObj->setData($data);
                $insertedId = $employeeObj->insertData();				
            }
			
            if (isset($insertedId) && $insertedId > 0) {
                Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                Yii::app()->user->setFlash('success',$this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' .  $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        $data = array('result' => $result,'advanced' => "Selected", 'title' => $title);
        Yii::app()->session['current'] = 'employees';
		$this->render('addEmployee', $data);
	}
	
	 /*     * ***************	Delete Employee  ************** */

    function actiondeleteEmployee($id) {
        $this->isLogin();
        $employeeObj = new Employees();
        $employeeObj->deleteEmployee($id);

        Yii::app()->user->setFlash('success',$this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
		 /*     * ***************	Add store  ************** */
	function actionaddStore($store_id=NULL)
	{
		error_reporting(E_ALL);
		$this->isLogin();
		
		$storeObj = new Stores();
		
        $title = 'Add Store';
        $result = array();
        if ($store_id != NULL) {
		
            $title = 'Edit Store';
            $result = $storeObj->getStoreDetails($store_id);
            $_POST['store_id'] = $result['store_id'];
        }
		
		 if (isset($_POST['FormSubmit'])) 
		{
			$store_id = NULL;
			
			$data['admin_id'] = Yii::app()->session['adminUser'];
            $data['store_name'] = $_POST['store_name'];
			$data['city'] = $_POST['city'];
			
			$data['status'] = $_POST['status'];

            if (isset($_POST['store_id']) && $_POST['store_id'] != '') 
			{
                $data['admin_id'] = Yii::app()->session['adminUser'];
				$data['store_id'] = $_POST['store_id'];
                $data['modified_date'] = date("Y-m-d H:i:s");
                $store_id = $_POST['store_id'];
            } 
			else 
			{
				$data['modified_date'] = date("Y-m-d H:i:s");
                $data['created_date'] = date("Y-m-d H:i:s");
            }
			if (isset($store_id) && $store_id != NULL) {                
				$storeObj->setData($data);
                $storeObj->insertData($store_id);
            } else {
				$storeObj->setData($data);
                $insertedId = $storeObj->insertData();				
            }
			
            if (isset($insertedId) && $insertedId > 0) {
                Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                Yii::app()->user->setFlash('success',$this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' .  $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        $data = array('result' => $result,'advanced' => "Selected", 'title' => $title);
        Yii::app()->session['current'] = 'stores';
		$this->render('addStore', $data);
        
	}


    function actiondeleteStore($id) {
        $this->isLogin();
        $storeObj = new Stores();
        $storeObj->deleteStore($id);

        Yii::app()->user->setFlash('success',$this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
	
	
	
	function actionaddProduct($product_id=NULL)
	{
		//error_reporting(E_ALL);
		$this->isLogin();
		
		if(Yii::app()->session['adminUser'] == 1 || Yii::app()->session['adminUser'] == 2)
		{
			$storeObj = new Stores();
			$storeList = $storeObj->getAllStoreList();
			
			$categoryObj = new Category();
			$categoryList = $categoryObj->getAllCategoryList();
		}
		else
		{
			$storeObj = new Stores();
			$storeList = $storeObj->getClientStoreList(Yii::app()->session['adminUser']);
			
			$categoryObj = new Category();
			$categoryList = $categoryObj->getClientCategoryList(Yii::app()->session['adminUser']);
		}		
		
		
		
		$productObj = new Product();
		
        $title = 'Add Product';
        $result = array();
        if ($product_id != NULL) {
            $title = 'Edit Product';
            $result = $productObj->getProductDetails($product_id);
			/*echo "id".$product_id;
			echo "<pre>";
			print_r($result);
			exit;*/
            $_POST['product_id'] = $result['product_id'];
        }
        if (isset($_POST['FormSubmit'])) 
		{
			if(isset($_POST['product_id']) && $_POST['product_id'] != '')
			{
				$result_product = $productObj->getProductDetails($_POST['product_id']);
			}
			$product_id = NULL;
			$data['admin_id'] = Yii::app()->session['adminUser'];
            $data['product_name'] = $_POST['product_name'];
			if(isset($_FILES["product_image"]["name"]) && $_FILES["product_image"]["name"] != "" )
			{
			   $data['product_image']=$_FILES["product_image"]["name"];
						
			 move_uploaded_file($_FILES["product_image"]["tmp_name"],
					FILE_UPLOAD."/product/" . $_FILES["product_image"]["name"]);
			}
					
			$data['product_price'] = $_POST['product_price'];
			$data['product_price2'] = $_POST['product_price2'];
			$data['product_price3'] = $_POST['product_price3'];
			$data['upc_code'] = $_POST['upc_code'];
			$data['cat_id'] = $_POST['cat_id'];
			$data['expiry_date'] = date('Y-m-d',strtotime($_POST['expiry_date']));
			$data['quantity'] = $result_product['quantity'] + $_POST['quantity'];
			$data['product_discount'] = $_POST['product_discount'];
			$data['product_desc'] = $_POST['product_desc'];
			if($_POST['Oldstore_id'] != "")
			{
				//echo $_POST['Oldstore_id'];
				/*echo $_POST['Oldstore_id'].",".$_POST['store_id']."," ;
				exit;
				$arr = explode(',',$_POST['Oldstore_id']);
				$arr[] = $_POST['store_id'];
				$str  = implode(',',$arr);*/
				//$data['store_id'] = $_POST['Oldstore_id'].$_POST['store_id']."," ;
				$data['store_id'] = $_POST['Oldstore_id'] ;
			}
			else
			{
				$data['store_id'] = ",".$_POST['store_id'].",";
			}
			$data['status'] = $_POST['status'];
			
			$stock['store_id'] = $_POST['store_id'];
			$stock['product_id'] = $_POST['product_id'];
			$stock['quantity'] = $_POST['quantity'];
			$stock['admin_id'] = Yii::app()->session['adminUser'];
			
			
					
     		if (isset($_POST['product_id']) && $_POST['product_id'] != '') 
			{
       			$data['admin_id'] = Yii::app()->session['adminUser'];
				$data['product_id'] = $_POST['product_id'];
                $data['modified_date'] = date("Y-m-d H:i:s");
				$stock['modified'] = date("Y-m-d H:i:s");
                $product_id = $_POST['product_id'];
            } 
			else 
			{
                $data['created_date'] = date("Y-m-d H:i:s");
				$stock['created'] = date("Y-m-d H:i:s");
            }
			if (isset($product_id) && $product_id != NULL) {                
				$productObj->setData($data);
                $productObj->insertData($product_id);
/*--------------------------------Start Query Log Function----------------------------------------------*/
				$querylogObj = new TblQuerylog();
				$lastLogId = $querylogObj->getLastLogId();
				
				$query['table_log_id'] =$product_id;
				$query['table_name'] = 'product';
				
				$querylogObj = new TblQuerylog();
				$querylog_id = $querylogObj->checkLogId($query['table_log_id'],$query['table_name']);
				
				$query['querylog_id'] =$querylog_id;
				$query['table_log_id'] =$product_id;
				
				$query['log_id'] = $lastLogId + 1 ;
				$query['query'] = "INSERT OR REPLACE INTO product ('product_id', 'store_id', 'product_name', 'product_desc', 'product_image', 'product_discount', 'product_price', 'product_price2', 'product_price3', 'unitname', 'upc_code', 'quantity', 'manufacturing_date', 'expiry_date', 'cat_id', 'admin_id', 'created_date', 'modified_date', 'status') VALUES (".$query['table_log_id'].", '".$data['store_id']."', '".$data['product_name']."', '".$data['product_desc']."', '".$data['product_image']."', '".$data['product_discount']."', '".$data['product_price']."', '".$data['product_price2']."', '".$data['product_price3']."', NULL, '".$data['upc_code']."', '".$data['quantity']."', NULL , '".$data['expiry_date']."', '".$data['cat_id']."', '".$data['admin_id']."', '".$data['created_date']."', '".$data['modified_date']."', '1') ; " ;
				
				$querylogObj = new TblQuerylog();
				$querylogObj->setData($query);
                $insertedId = $querylogObj->insertData($query['querylog_id']);
/*--------------------------------End Query Log Function----------------------------------------------*/
				
				$stockObj = new Stock();
				$stockData = $stockObj->checkStockDetail($product_id,$_POST['store_id']);
				
								
				if(!empty($stockData))
				{
					$stockObj = new Stock();
					$qnt = $stockData ['quantity'] + $stock['quantity'];
					$stockObj->updateStock($product_id,$qnt,$stock['modified'],$_POST['store_id']);
				}
				else
				{
					$stock['created'] = date("Y-m-d H:i:s");
					$stock['product_id'] = $_POST['product_id'];
					$stockObj = new Stock();
					$stockObj->setData($stock);
					$insertedstockId = $stockObj->insertData();
					
				}
				
            } else {				
				$productObj->setData($data);
                $insertedId = $productObj->insertData();
/*--------------------------------Start Query Log Function----------------------------------------------*/
				$querylogObj = new TblQuerylog();
				$lastLogId = $querylogObj->getLastLogId();
				
				$query['table_log_id'] = $insertedId;
				$query['table_name'] = 'product';
				$query['log_id'] = $lastLogId + 1 ;
				$query['query'] = "INSERT OR REPLACE INTO product ('product_id', 'store_id', 'product_name', 'product_desc', 'product_image', 'product_discount', 'product_price', 'product_price2', 'product_price3', 'unitname', 'upc_code', 'quantity', 'manufacturing_date', 'expiry_date', 'cat_id', 'admin_id', 'created_date', 'modified_date', 'status') VALUES (".$query['table_log_id'].", '".$data['store_id']."', '".$data['product_name']."', '".$data['product_desc']."', '".$data['product_image']."', '".$data['product_discount']."', '".$data['product_price']."', '".$data['product_price2']."', '".$data['product_price3']."', NULL, '".$data['upc_code']."', '".$data['quantity']."', NULL , '".$data['expiry_date']."', '".$data['cat_id']."', '".$data['admin_id']."', '".$data['created_date']."', '', '1') ; " ;
				
				$querylogObj = new TblQuerylog();
				$querylogObj->setData($query);
                $insertedQueryId = $querylogObj->insertData();
/*--------------------------------End Query Log Function----------------------------------------------*/
				
				
				$stock['product_id'] = $insertedId;
				$stockObj = new Stock();
				$stockObj->setData($stock);
                $insertedstockId = $stockObj->insertData();				
            }
			
            if (isset($insertedId) && $insertedId > 0 && isset($insertedstockId) && $insertedstockId > 0 ) {
                Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                Yii::app()->user->setFlash('success', $this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' .  $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        $data = array('result' => $result,'advanced' => "Selected", 'title' => $title, 'storeList' => $storeList,  'categoryList' => $categoryList);
        Yii::app()->session['current'] = 'product';
		$this->render('addProduct', $data);
	}
	
	
	 /*     * ***************	Delete Product  ************** */

    function actiondeleteProduct($id) {
        $this->isLogin();
        $productObj = new Product();
        $productObj->deleteProduct($id);

/*--------------------------------Start Query Log Function----------------------------------------------*/
				$querylogObj = new TblQuerylog();
				$lastLogId = $querylogObj->getLastLogId();
				
				$query['table_log_id'] =$id;
				$query['table_name'] = 'product';
				
				$querylogObj = new TblQuerylog();
				$querylog_id = $querylogObj->checkLogId($query['table_log_id'],$query['table_name']);
				
				$query['querylog_id'] =$querylog_id;
				$query['log_id'] = $lastLogId + 1 ;
				$query['query'] = "DELETE FROM product WHERE product_id='".$query['table_log_id']."' ; " ;
				
				$querylogObj = new TblQuerylog();
				$querylogObj->setData($query);
                $insertedId = $querylogObj->insertData($query['querylog_id']);
/*--------------------------------End Query Log Function----------------------------------------------*/
        Yii::app()->user->setFlash('success',$this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
	
	function actiondeleteProductFromStore()
	{
		$stockObj = new Stock();
		$stockObj->deleteProductFromStore($_REQUEST['id'],$_REQUEST['store_id']);
		Yii::app()->user->setFlash('success',$this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
		exit;
	}
	
	function actiongetProduct()
	{
		if(Yii::app()->session['adminUser'] == 1 || Yii::app()->session['adminUser'] == 2)
		{
			$storeObj = new Stores();
			$storeList = $storeObj->getAllStoreList();
			
			$categoryObj = new Category();
			$categoryList = $categoryObj->getAllCategoryList();
		}
		else
		{
			$storeObj = new Stores();
			$storeList = $storeObj->getClientStoreList(Yii::app()->session['adminUser']);
			
			$categoryObj = new Category();
			$categoryList = $categoryObj->getClientCategoryList(Yii::app()->session['adminUser']);
		}		
		$productObj = new Product();
		$result = $productObj->getProductDetails($_REQUEST['product_id']);
		$this->renderPartial('addProductWithAjax',array("result"=>$result,'storeList' => $storeList,'categoryList' => $categoryList));
	}
	
	function actionproductInQueryLog()
	{
		/*---------------Start Query Log Function----------------------------------------------*/
				$productObj = new Product();
				$result = $productObj->getProductforQueryLog();
				
				foreach($result as $data )
				{
					$querylogObj = new TblQuerylog();
					$lastLogId = $querylogObj->getLastLogId();
					
					$query['table_log_id'] = $data['product_id'];
					$query['table_name'] = 'product';
					$query['log_id'] = $lastLogId + 1 ;
					$query['query'] = "INSERT OR REPLACE INTO product ('product_id', 'store_id', 'product_name', 'product_desc', 'product_image', 'product_discount', 'product_price', 'product_price2', 'product_price3', 'unitname', 'upc_code', 'quantity', 'manufacturing_date', 'expiry_date', 'cat_id', 'admin_id', 'created_date', 'modified_date', 'status') VALUES (".$query['table_log_id'].", '".$data['store_id']."', '".$data['product_name']."', '".$data['product_desc']."', '".$data['product_image']."', '".$data['product_discount']."', '".$data['product_price']."', '".$data['product_price2']."', '".$data['product_price3']."', NULL, '".$data['upc_code']."', '".$data['quantity']."', NULL , '".$data['expiry_date']."', '".$data['cat_id']."', '".$data['admin_id']."', '".$data['created_date']."', '', '1') ; " ;
					
					$querylogObj = new TblQuerylog();
					$querylogObj->setData($query);
					$insertedId = $querylogObj->insertData();
				}
/*--------------------------------End Query Log Function----------------------------------------------*/	
	}
	
	function actioncustomerInQueryLog()
	{
		/*-----------------------Start Query Log Function----------------------------*/
			$customerObj = new Customers();
			$result = $customerObj->getCustomersforQueryLog();
			
			foreach($result as $data )
			{

				$querylogObj = new TblQuerylog();
				$lastLogId = $querylogObj->getLastLogId();
				
				$query['table_log_id'] =$data['customer_id'];
				$query['table_name'] = 'customers';
				$query['log_id'] = $lastLogId + 1 ;

				$query['query'] = "INSERT OR REPLACE INTO customers ('customer_id', 'admin_id', 'customer_name', 'cust_address', 'cust_email', 'contact_no', 'credit', 'total_purchase', 'createdAt', 'modifiedAt', 'status') VALUES (".$query['table_log_id'].", '".$data['admin_id']."', '".$data['customer_name']."', '".$data['cust_address']."', '".$data['cust_email']."', '".$data['contact_no']."', '".$data['credit']."', '".$data['total_purchase']."', '".$data['createdAt']."', NULL, '".$data['status']."'); " ;
				
				$querylogObj = new TblQuerylog();
				$querylogObj->setData($query);
                $insertedId = $querylogObj->insertData();
			}
				
/*--------------------------------End Query Log Function----------------------------------------------*/	
	}
	//messages
	
	function actionmessage()
	{	
				$this->isLogin();
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
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$messageObj = new MessageTemplate();

		$message =	$messageObj->getAllPaginatedMessage(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		
	/*	echo "<pre>";
		print_r($message);
		exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else 
		{
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$message['pagination'];
        $data['message']	=	$message['message_template'];
		Yii::app()->session['current']	= 'message_template';
		$this->render("message", array('data'=>$data,'ext'=>$ext));
		
	}
	
	//message add
	function actionaddMessage($id=NULL)
	{
		$this->isLogin();
		$messageObj = new MessageTemplate();
	    $title = 'Add Message';
        $result = array();
        if ($id != NULL) {
            $title = 'Edit Message';
            $result = $messageObj->getMessageDetails($id);
            $_POST['id'] = $result['id'];
		}
        if (isset($_POST['FormSubmit'])) 
		{
			
			$id = NULL;
		   $data['message'] = $_POST['message'];
		   if (isset($_POST['id']) && $_POST['id'] != '') 
			{
               	$data['id'] = $_POST['id'];
                $id = $_POST['id'];
            } 
			if (isset($id) && $id != NULL) {                
				$messageObj->setData($data);
                $messageObj->insertData($id);
            } else {
				$messageObj->setData($data);
                $insertedId = $messageObj->insertData();				
            }
            if (isset($insertedId) && $insertedId > 0) {
                Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                Yii::app()->user->setFlash('success',$this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' .  $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        $data = array('result' => $result,'advanced' => "Selected", 'title' => $title);
        Yii::app()->session['current'] = 'message';
		$this->render('addMessage', $data);
	}
	
	//delete message
	function actiondeleteMessage($id) 
	{
        $this->isLogin();
        $messageObj = new MessageTemplate();
        $messageObj->deleteMessage($id);

        Yii::app()->user->setFlash('success',$this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
	function actionaddSupplier($supplier_id=NULL)
	{
		$this->isLogin();
		
		$supplierObj = new Supplier();
		
        $title = 'Add Supplier';
        $result = array();
        if ($supplier_id != NULL) {
            $title = 'Edit Supplier';
            $result = $supplierObj->getSupplierDetails($supplier_id);
            $_POST['supplier_id'] = $result['supplier_id'];
        }
        if (isset($_POST['FormSubmit'])) 
		{
			$supplier_id = NULL;
			$data['admin_id'] = Yii::app()->session['adminUser'];
            $data['supplier_name'] = $_POST['supplier_name'];
			$data['email'] = $_POST['email'];
			$data['contact_no'] = $_POST['contact_no'];
			$data['address'] = $_POST['address'];
			$data['product_id'] = $_POST['product_id'];
			$data['status'] = $_POST['status'];

            if (isset($_POST['supplier_id']) && $_POST['supplier_id'] != '') 
			{
                $data['admin_id'] = Yii::app()->session['adminUser'];
				$data['supplier_id'] = $_POST['supplier_id'];
                $data['modified_date'] = date("Y-m-d H:i:s");
                $supplier_id = $_POST['supplier_id'];
            } 
			else 
			{
                $data['created_date'] = date("Y-m-d H:i:s");
            }
			if (isset($supplier_id) && $supplier_id != NULL) {                
				$supplierObj->setData($data);
                $supplierObj->insertData($supplier_id);
            } else {
				$supplierObj->setData($data);
                $insertedId = $supplierObj->insertData();				
            }
			
            if (isset($insertedId) && $insertedId > 0) {
                Yii::app()->user->setFlash('success',$this->msg['_INSERT_RECORD_']);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                Yii::app()->user->setFlash('success', $this->msg['_UPDATE_SUCC_MSG_']);
                header('location:' .  $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        $data = array('result' => $result,'advanced' => "Selected", 'title' => $title);
        Yii::app()->session['current'] = 'supplier';
		$this->render('addSupplier', $data);
	}
	
	function actiongeneratePaymentRecipts($receiptId)
	{
		$obj = CustomerGeneralEntry::model()->findbyPk($receiptId);
		$adminObj = Admin::model()->findbyPk(Yii::app()->session['adminUser']);
		
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
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
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
		$mpdf->Output(FILE_PATH."assets/upload/pdf/recipt".$obj->id.".pdf", 'F'); ?>
		<script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/recipt<?php echo $obj->id ;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		$this->actiongeneralEntryforAdmin();
		
		
	
	}
	
	function actiongenerateSupplierPaymentRecipts($receiptId)
	{
		$obj = SupplierGeneralEntry::model()->findbyPk($receiptId);
		$adminObj = Admin::model()->findbyPk(Yii::app()->session['adminUser']);
		
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
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
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
		
		$this->actiongeneralEntryforAdmin();
		
		
	
	}
	
	public function actiongeneralEntryforOther()
	{
		 $this->isLogin();
		$this->renderPartial('generalentryForOther');
	}
	
	public function actionaddGeneralEntryforOther()
	{
			
			$general['account'] = $_REQUEST['account'];
			$general['credit'] = $_REQUEST['credit'];
			$general['debit'] = $_REQUEST['debit'] ;
			$general['description'] = $_REQUEST['description'];
			$general['admin_id'] = Yii::app()->session['adminUser'];
			$general['store_id'] = 0 ;
			$general['created']=date('Y-m-d:H-m-s');
			
			$generalObj = new GeneralEntry();
			$generalObj->setData($general);
			$generalId = $generalObj->insertData();
			
			$this->actiongenerateGeneralRecipts($generalId);
			
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
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
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
		$mpdf->Output(FILE_PATH."assets/upload/pdf/recipt".$obj->general_id.".pdf", 'F'); ?>
		<script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/recipt<?php echo $obj->general_id ;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		$this->actionIndex();
	}
	
	function actionpdfReportForAccountTransactionReport()
	{
		if(isset($_POST['date2']) && $_POST['date2'] != "")
		{
			$date = $_POST['date2'];
		}
		else
		{
			$date = date('d-m-Y');
		}
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*mysql_query("character_set_connection = 'utf8'");
		
		mysql_query("character_set_client = 'utf8'");
		
		mysql_query("character_set_server = 'utf8'");*/
		$qry1="select stores.store_name as STORE, customers.customer_name as 'PARTY NAME' , customer_general_entry.credit as CREDIT, customer_general_entry.debit as DEBIT   from customer_general_entry LEFT JOIN stores ON ( stores.store_id = customer_general_entry.store_id )  LEFT JOIN customers ON ( customers.customer_id = customer_general_entry.customer_id )  WHERE  customer_general_entry.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(customer_general_entry.createdAt,'%d-%m-%Y') = '".$date."' ) order by customer_general_entry.createdAt desc "; 
		
		$qry2="select stores.store_name as STORE, supplier.supplier_name as 'PARTY NAME' , supplier_general_entry.credit as CREDIT, supplier_general_entry.debit as DEBIT   from supplier_general_entry LEFT JOIN stores ON ( stores.store_id = supplier_general_entry.store_id )  LEFT JOIN supplier ON ( supplier.supplier_id = customer_general_entry.supplier_id )  WHERE  supplier_general_entry.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(supplier_general_entry.createdAt,'%d-%m-%Y') = '".$date."' ) order by supplier_general_entry.createdAt desc ";
		
		$qry3="select stores.store_name as STORE, general_entry.account as 'PARTY NAME' , general_entry.credit as CREDIT, general_entry.debit as DEBIT   from general_entry LEFT JOIN stores ON ( stores.store_id = general_entry.store_id ) WHERE  general_entry.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(general_entry.created,'%d-%m-%Y') = '".$date."' ) order by general_entry.created desc "; 
		
		$test1 = mysql_query($qry1,$conn);
		$test2 = mysql_query($qry2,$conn);
		$test3 = mysql_query($qry3,$conn);
		
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
			<td width="23%" align="right">TIME: '. date('H:i:s',strtotime($date)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 </table>
		<h2 align="center">Account Transactions Reports</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td align="center" height="20">STORE</td>
			<td align="center">PARTY NAME</td>
			<td align="center">CREDIT('.Yii::app()->session['currency'].')</td>
			<td align="center">DEBIT('.Yii::app()->session['currency'].')</td>
		</tr>';
	
	while($row=mysql_fetch_array($test1))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['STORE'].'&nbsp;</td>
			<td align="left">&nbsp;'.$row['PARTY NAME'].'</td>
			<td align="right">&nbsp;'.$row['CREDIT'].'</td>
			<td align="right">&nbsp;'.$row['DEBIT'].'</td>
		  </tr>';
    } 
	
	while($row=mysql_fetch_array($test2))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['STORE'].'&nbsp;</td>
			<td align="left">&nbsp;'.$row['PARTY NAME'].'</td>
			<td align="right">&nbsp;'.$row['CREDIT'].'</td>
			<td align="right">&nbsp;'.$row['DEBIT'].'</td>
		  </tr>';
    }
	
	while($row=mysql_fetch_array($test3))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['STORE'].'&nbsp;</td>
			<td align="left">&nbsp;'.$row['PARTY NAME'].'</td>
			<td align="right">&nbsp;'.$row['CREDIT'].'</td>
			<td align="right">&nbsp;'.$row['DEBIT'].'</td>
		  </tr>';
    }
	
		$html .= '</table>';
		$pdfId = date('Y_m_d_H_m_s');	
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/accountTransactionReport".$pdfId.".pdf", 'F');
		
		$this->actionIndex();
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/accountTransactionReport<?php echo $pdfId ; ?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	function actionpdfReportForJournalTransactionReport()
	{
		if(isset($_POST['date4']) && $_POST['date4'] != "")
		{
			$date = $_POST['date4'];
		}
		else
		{
			$date = date('d-m-Y');
		}
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
		//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
		$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
		mysql_select_db(DB_DATABASE); 

		
		mysql_query("SET NAMES utf8;");
							
		mysql_query("SET character_set_results = 'utf8'");
		
		/*mysql_query("character_set_connection = 'utf8'");
		
		mysql_query("character_set_client = 'utf8'");
		
		mysql_query("character_set_server = 'utf8'");*/
		$qry1="select stores.store_name as STORE , ticket_details.total_amount as AMOUNT,customers.customer_name as 'PARTY NAME'  from ticket_details LEFT JOIN stores ON ( stores.store_id = ticket_details.store_id )  LEFT JOIN customers ON ( customers.customer_id = ticket_details.customer_id )  WHERE  ticket_details.admin_id = ".Yii::app()->session['adminUser']." and (ticket_details.status = '1' or ticket_details.status = '2' or ticket_details.status = '5'  ) and ( DATE_FORMAT(ticket_details.createdAt,'%d-%m-%Y') = '".$date."' or  DATE_FORMAT(ticket_details.modifiedAt,'%d-%m-%Y') = '".$date."' ) order by ticket_details.createdAt desc "; 
	   $qry2="select stores.store_name as STORE , sales_return_details.return_total_amount as AMOUNT,customers.customer_name as 'PARTY NAME' from sales_return_details  LEFT JOIN users ON ( users.id = sales_return_details.userId )  LEFT JOIN stores ON ( stores.store_id = users.store_id )  LEFT JOIN customers ON ( customers.customer_id = sales_return_details.return_customer_id )  WHERE  users.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(sales_return_details.return_createdAt,'%d-%m-%Y') = '".$date."' ) order by sales_return_details.return_createdAt desc ";
	   
	  
	  $qry3="select stores.store_name as STORE , purchase_order_details.total_amount as AMOUNT,supplier.supplier_name as 'PARTY NAME'  from purchase_order_details LEFT JOIN stores ON ( stores.store_id = purchase_order_details.store_id )  LEFT JOIN supplier ON ( supplier.supplier_id = purchase_order_details.supplier_id ) WHERE  purchase_order_details.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(purchase_order_details.created,'%d-%m-%Y') = '".$date."' ) order by purchase_order_details.created desc ";
	  
	 	$qry4="select stores.store_name as STORE , purchase_return_details.total_return_amount as AMOUNT,supplier.supplier_name as 'PARTY NAME'  from purchase_return_details LEFT JOIN stores ON ( stores.store_id = purchase_return_details.store_id )  LEFT JOIN supplier ON ( supplier.supplier_id = purchase_return_details.supplier_id ) WHERE  purchase_return_details.admin_id = ".Yii::app()->session['adminUser']." and ( DATE_FORMAT(purchase_return_details.created,'%d-%m-%Y') = '".$date."' ) order by purchase_return_details.created desc ";
		
		$test1 = mysql_query($qry1,$conn);
		$test2 = mysql_query($qry2,$conn);
		$test3 = mysql_query($qry3,$conn);
		$test4 = mysql_query($qry3,$conn);
		
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
			<td width="23%" align="right">TIME: '. date('H:i:s',strtotime($date)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 </table>
		<h2 align="center">Journal Transactions Report</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td align="center" height="20">STORE</td>
			<td align="center">AMOUNT('.Yii::app()->session['currency'].')</td>
			<td align="center">PARTY NAME</td>
			<td align="center">TYPE</td>
		</tr>';
		  
	while($row=mysql_fetch_array($test1))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['STORE'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['AMOUNT'].'</td>
			<td align="left">&nbsp;'.$row['PARTY NAME'].'</td>
			<td align="left">&nbsp;Sales</td>
		  </tr>';
    } 
	
	while($row=mysql_fetch_array($test2))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['STORE'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['AMOUNT'].'</td>
			<td align="left">&nbsp;'.$row['PARTY NAME'].'</td>
			<td align="left">&nbsp;Sales Return</td>
		  </tr>';
    }
	
	while($row=mysql_fetch_array($test3))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['STORE'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['AMOUNT'].'</td>
			<td align="left">&nbsp;'.$row['PARTY NAME'].'</td>
			<td align="left">&nbsp;Purchase</td>
		  </tr>';
    }
	
	while($row=mysql_fetch_array($test4))  
	{
        
		$html .=  '<tr>
			<td height="20" align="left">'.$row['STORE'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['AMOUNT'].'</td>
			<td align="left">&nbsp;'.$row['PARTY NAME'].'</td>
			<td align="left">&nbsp;Purchase Return</td>
		  </tr>';
    }
	
		$html .= '</table>';
		$pdfId = date('Y_m_d_H_m_s');	
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/journalTransactionReport".$pdfId.".pdf", 'F');
		
		$this->actionIndex();
		?>
        
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/journalTransactionReport<?php echo $pdfId ; ?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
		
		
	}
	
	 /*     * ***************	Delete Product  ************** */

    function actiondeleteSupplier($id) {
        $this->isLogin();
        $supplierObj = new Supplier();
        $supplierObj->deleteSupplier($id);

        Yii::app()->user->setFlash('success', $this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
	
	 /*     * ***************	Purchase MOdule  ************** */
	
	function actionInsertPurchase()
	{
		$this->isLogin();
		/*$userObj = new Users();
		$userData = $userObj->getUserById(Yii::app()->session['userId']);*/
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$supplierObj = new Supplier();
		$suppliers = $supplierObj->getSupplierDropdown($admin_id);
		
		$storeObj = new Stores();
		$stores = $storeObj->getStoreDropdown($admin_id);
		
		$productObj = new Product();
		$products = $productObj->getAllProductList($admin_id);
		
		/*echo "<pre>";
		print_r($_REQUEST);exit;*/
			
		if(isset($_POST['submit']))
		{
			/*$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);*/
			
			$data = array();
			$count = $_POST['count'];
			$data['createdAt'] = date("Y-m-d H:i:s");

			$po_detail['total_product'] = $count;
			$po_detail['store_id'] = $_POST['store'];
			$po_detail['admin_id'] = $admin_id;
			$po_detail['supplier_id'] = $_POST['supplier'];
			$po_detail['total_amount'] = $_POST['totalPurchase'];
			$po_detail['created'] = date("Y-m-d H:i:s");
			
			$purchaseOrderObj = new PurchaseOrderDetails();
			$purchaseOrderObj->setData($po_detail);
			$purchaseId = $purchaseOrderObj->insertData();
/*--------------------------supplier debit update start-----------------------------------------------*/			
			/*$supplier['supplier_id'] = $_POST['supplier'];
			$supplier['debit'] = $_POST['totalPurchase'];
			$supplier['modified_date'] = date("Y-m-d H:i:s");
			
			$supplierObj = new Supplier();
			$supplierObj->updateSupplierDebit($supplier['supplier_id'],$supplier['debit'],$supplier['modified_date']);
			
			$supplierGeneral['supplier_id'] = $supplier['supplier_id'];
			$supplierGeneral['admin_id'] = $admin_id ;
			$supplierGeneral['store_id'] =  $_POST['store'];
			$supplierGeneral['debit'] = $_POST['totalPurchase'];
			$supplierGeneral['paymentType'] = 0 ;
			$supplierGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$supplierGeneralObj = new SupplierGeneralEntry();
			$supplierGeneralObj->setData($supplierGeneral);
			$supplierGeneralObj->insertData();*/
/*--------------------------supplier debit update finish-----------------------------------------------*/			
			$data['purchase_order_id'] = $purchaseId;
			$data['store_id'] = $_POST['store'];
			$data['admin_id'] = $admin_id ;
			
			for($i=1;$i<=$count;$i++)
			{				
				$data['quantity'] = $_POST['quantity'.$i.''];
				$data['price'] = $_POST['rate'.$i.''];
				$data['product_id'] = $_POST['product'.$i.''];
				$data['amount'] = $_POST['amount'.$i.''];
				
				$purchaseObj = new Purchase();
				$purchaseObj->setData($data);
				$purchaseObj->insertData();
				
				/*$stock['store_id'] = $_POST['store'];
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
					$stock['admin_id'] = $admin_id ;
					$stockObj = new Stock();
					$stockObj->setData($stock);
					$stockObj->insertData();
					
					$productObject=Product::model()->findbyPk($_POST['product'.$i.'']);
					$UpdateStoreId['store_id'] = $productObject->store_id.",".$_POST['store'].",";
					
					$productObj = new Product();
					$productObj->setData($UpdateStoreId);
					$productObj->insertData($_POST['product'.$i.'']);
				}*/
			}
			
			$this->actionraisePurchaseOrder($purchaseId);
		}
		Yii::app()->session['current'] = 'purchase';
		$this->render('insertPurchase',array('products'=>$products,'suppliers'=>$suppliers,'stores'=>$stores));	
		exit;
	}
	
	function actionraisePurchaseOrder($id)
	{
		$purchaseObj = new Purchase();
		$purchaseData = $purchaseObj->getpurchaseDetails($id);
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		
		$purchaseOrderObj  = new PurchaseOrderDetails();
		$po_detail = $purchaseOrderObj->getpurchaseOrderData($id);
		
		//$this->renderPartial("raiseInvoice",array('ticketData'=>$ticketData,'productData'=>$productData));
		//exit;
		
		if($po_detail['supplier_name'] != "")
		{
			$supplier = 'SUPPLIER: '.$po_detail['supplier_name'] ;
			$to = 'TO,'	;
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
			<td align="center" width="10%"><strong>QUANTITY</strong></td>
			<td align="center" width="10%"><strong>RECEIVED QUANTITY</strong></td>
			<td align="center" width="10%"><strong>UNIT PRICE</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  $i=1;
		 // $finalAmount = 0 ;
	foreach($purchaseData as $row) {
		//$finalAmount = $finalAmount + $row['amount'] ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['quantity'].'&nbsp;</td>
			<td align="right">'.$row['receive_qnt'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>';
   $i++; } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
			<td colspan="4" align="right" class="noborder"></td>
			<td width="10%">&nbsp;</td>
		  </tr>
		  <tr >
			<td colspan="4" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
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
	
	public function actionconfirmPurchaseOrderFirst()
	{
		$this->isLogin();
		
		Yii::app()->session['current'] = 'purchase';
		$this->render('confirmPurchaseFirst');
	}
	
	function actionconfirmPurchaseView()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'purchase';
		if(isset($_POST['submit']))
		{
			$purchase_order_id = $_REQUEST['id'];
			
			$purchaseOrderObj = new PurchaseOrderDetails();
			$purchaseOrderData = $purchaseOrderObj->getpurchaseOrderDataByAdmin($purchase_order_id);
			
			if(empty($purchaseOrderData))
			{
				Yii::app()->user->setFlash('error', $this->msg['_INVALID_PURCHASE_NO_']);
				$this->render("confirmPurchaseFirst");
				exit;
			}
			else
			{	
				if($purchaseOrderData['status'] == 1)
				{
					Yii::app()->user->setFlash('error', $this->msg['_ALREADY_PURCHASE_NO_']);
					$this->render("confirmPurchaseFirst");
					exit;	
				}		
				$purchaseObj = new Purchase();
				$purchaseData = $purchaseObj->getpurchaseDetails($purchase_order_id);
				
				/*echo "<pre>";
				print_r($purchaseOrderData);
				print_r($purchaseData);
				exit;*/
				
				$this->render('confirmPurchase',array('purchaseOrderData'=>$purchaseOrderData,'purchaseData'=>$purchaseData));	
				exit;
			}
		}else{
			Yii::app()->session['current'] = 'purchase';
			$this->render('confirmPurchaseFirst');
		}
	}
	
	function actionconfirmPurchaseOrder()
	{
		$this->isLogin();
		/*$userObj = new Users();
		$userData = $userObj->getUserById(Yii::app()->session['userId']);*/
		
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		if(isset($_POST['submit']))
		{
			/*$userObj = new Users();
			$userData = $userObj->getUserById(Yii::app()->session['userId']);*/
			
			$data = array();
			$count = $_POST['count'];
			$data['createdAt'] = date("Y-m-d H:i:s");
			$admin_id = Yii::app()->session['adminUser'];
				
			//$po_detail['total_product'] = $count;
			$po_detail['store_id'] = $_POST['store_id'];
			$po_detail['admin_id'] = $admin_id;
			$po_detail['supplier_id'] = $_POST['supplier_id'];
			//$po_detail['total_amount'] = $_POST['totalPurchase'];
			$po_detail['modified'] = date("Y-m-d H:i:s");
			$po_detail['status'] = '1';
			
			$purchaseOrderObj = new PurchaseOrderDetails();
			$purchaseOrderObj->setData($po_detail);
			$purchaseOrderObj->insertData($_POST['purchase_order_id']);
			$purchaseId = $_POST['purchase_order_id'];
/*--------------------------supplier debit update start-----------------------------------------------*/			
			$supplier['supplier_id'] = $_POST['supplier_id'];
			$supplier['debit'] = $_POST['totalPurchase'];
			$supplier['modified_date'] = date("Y-m-d H:i:s");
			
			$supplierObj = new Supplier();
			$supplierObj->updateSupplierDebit($supplier['supplier_id'],$supplier['debit'],$supplier['modified_date']);
			
			$supplierGeneral['supplier_id'] = $supplier['supplier_id'];
			$supplierGeneral['admin_id'] = $admin_id ;
			$supplierGeneral['store_id'] =  $_POST['store_id'];
			$supplierGeneral['debit'] = $_POST['totalPurchase'];
			$supplierGeneral['paymentType'] = 0 ;
			$supplierGeneral['createdAt'] = date('Y-m-d:H-m-s');
			
			$supplierGeneralObj = new SupplierGeneralEntry();
			$supplierGeneralObj->setData($supplierGeneral);
			$supplierGeneralObj->insertData();
/*--------------------------supplier debit update finish-----------------------------------------------*/			
			$data['purchase_order_id'] = $purchaseId;
			$data['store_id'] = $_POST['store_id'];
			$data['admin_id'] = $admin_id ;
			
			$status = 1 ;
			for($i=1;$i<=$count;$i++)
			{	
				$data['quantity'] = $_POST['quantity'.$i.''];
				$data['receive_qnt'] = $_POST['oldRecQuantity'.$i.''] + $_POST['recquantity'.$i.''];
				$data['price'] = $_POST['rate'.$i.''];
				$data['product_id'] = $_POST['product_id'.$i.''];
				//$data['amount'] = $data['receive_qnt'] * $data['price'];
				
				$purchaseObj = new Purchase();
				$purchaseObj->setData($data);
				$purchaseObj->insertData($_POST['id'.$i.'']);
				
				if($data['receive_qnt'] < $data['quantity'])
				{
				   $status = 0 ;	
				}
				
				$stock['store_id'] = $_POST['store_id'];
				$stock['product_id'] = $_POST['product_id'.$i.''];
				$stock['quantity'] = $_POST['recquantity'.$i.''];
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
					$stock['admin_id'] = $admin_id ;
					$stockObj = new Stock();
					$stockObj->setData($stock);
					$stockObj->insertData();
					
					$productObject=Product::model()->findbyPk($_POST['product_id'.$i.'']);
					$UpdateStoreId['store_id'] = $productObject->store_id.",".$_POST['store_id'].",";
					
					$productObj = new Product();
					$productObj->setData($UpdateStoreId);
					$productObj->insertData($_POST['product'.$i.'']);
				}
			
			}
			
			if($status == 0)
			{
				$detail['status'] = 0 ;
				$purchaseOrderObj = new PurchaseOrderDetails();
				$purchaseOrderObj->setData($detail);
				$purchaseOrderObj->insertData($_POST['purchase_order_id']);	
			}
			
			$this->actionraisePurchaseOrder($purchaseId);
		}
		Yii::app()->session['current'] = 'purchase';
		$this->render('confirmPurchaseFirst');	
		exit;
	}
	
	public function actionpurchaseReturn()
	{
		$this->isLogin();
		
		Yii::app()->session['current'] = 'purchase';
		$this->render('purchaseReturnfirst');
	}
	
	function actionpurchaseReturnView()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'purchase';
		if(isset($_POST['submit']))
		{
			
				$purchase_order_id = $_REQUEST['id'];
				
				$purchaseOrderObj = new PurchaseOrderDetails();
				$purchaseOrderData = $purchaseOrderObj->getpurchaseOrderDataByAdmin($purchase_order_id);
				
				if(empty($purchaseOrderData))
				{
					Yii::app()->user->setFlash('error', $this->msg['_INVALID_PURCHASE_NO_']);
					$this->render("purchaseReturnfirst");
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
		}else{
			Yii::app()->session['current'] = 'purchase';
			$this->render('purchaseReturnfirst');	
		}
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
			
			$this->actionraisePurchaseReturnOrder($purchaseReturnId);
		
		Yii::app()->session['current'] = 'purchase';
		$this->render('purchaseReturnfirst');	
		exit;
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
		//$this->renderPartial("raiseInvoice",array('ticketData'=>$ticketData,'productData'=>$productData));
		//exit;
		
		$admin_id = Yii::app()->session['adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
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
			<td align="right">TIME: '.date('H:i:s',strtotime($po_detail['created'])).'</td>
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
		
	}
	
	public function actionticketListForProduct()
	{
		$this->isLogin();
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
		
		$ticketList	=	$ticketObj->getPaginatedTicketListForProductInAdmin($_REQUEST['product_id'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
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
		$this->render('ticketListForProduct', array('data'=>$ticketList['ticket'],'pagination'=>$ticketList['pagination'],'ext'=>$ext,'product_id'=>$_REQUEST['product_id'],'product_name'=>$_REQUEST['product_name']));
	
	}
	
	function actionquantityDetailForProduct()
	{
		$this->isLogin();
		error_reporting(E_ALL);
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
		
		
		$this->render("quantity_detail_for_product",array("product_name"=>$_REQUEST['product_name'],"totalQuantityForSales"=>$totalQuantityForSales,"totalQuantityForSalesReturn"=>$totalQuantityForSalesReturn,"totalQuantityForPurchase"=>$totalQuantityForPurchase,"totalQuantityForPurchaseReturn"=>$totalQuantityForPurchaseReturn));
	}
	
	function actionshiftlisting()
	{
		error_reporting(0);
		$this->isLogin();
		$ticketObj	=	new TicketDetails();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='shift_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		
		$shiftObj = new Shift();
		$shiftList = $shiftObj->getPaginatedshiftList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		/*echo "<pre>";
		print_r($shiftList);exit;*/
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
		Yii::app()->session['current']   =   'reports';
		$this->render("shiftlisting",array('data'=>$shiftList['shift'],'pagination'=>$shiftList['pagination'],'ext'=>$ext));	
	}
	
	function actioninterStoreAdjustListing()
	{	
		$this->isLogin();
		error_reporting(0);
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='inter_store_adjust_entry.id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$intraStoreObj = new InterStoreAdjustEntry();
		$Listing	=	$intraStoreObj->getAllPaginatedInterStoreageAdmin(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$Listing['pagination'];
        $data['listing']	=	$Listing['listing'];
		
		Yii::app()->session['current'] = 'accounts';
		
		$this->render("interStoreAdjustList", array('data'=>$data,'ext'=>$ext));
		
	}
	
	function actiondeleteIntraStoreEntry($id) 
	{
        $this->isLogin();
        $intraStoreObj = new InterStoreAdjustEntry();
        $intraStoreObj->deleteIntraStoreEntry($id);

        Yii::app()->user->setFlash('success',$this->msg['_RECORD_DEL_MSG_']);
		header('location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
	
	function actionshrinkStockQuantity()
	{
		$admin_id = Yii::app()->session['adminUser'];
		
		$shrinkStock['product_id'] = $_REQUEST['product_id'];
		$shrinkStock['admin_id'] = $admin_id;
		$shrinkStock['store_id'] = $_REQUEST['store_id'];
		$shrinkStock['system_qnt']	= $_REQUEST['systemQnt'];
		$shrinkStock['actual_qnt']	= $_REQUEST['realQnt'];
		$shrinkStock['qnt_difference']	= $_REQUEST['realQnt'] - $_REQUEST['systemQnt'];
		$shrinkStock['created'] = date("Y-m-d H:i:s");
		
		$shrinkStockObj = new ShrinkQuantity();
		$shrinkStockObj->setData($shrinkStock);
		$shrinkStockObj->insertData();
		
		$stock['product_id'] = $_REQUEST['product_id'];
		$stock['admin_id'] = $admin_id;
		$stock['quantity']	= $_REQUEST['realQnt'];
		$stock['store_id']	= $_REQUEST['store_id'];
		$stock['modified'] = date("Y-m-d H:i:s");

	
		$stockObj = new Stock();
		$result = $stockObj->checkStockDetail($_REQUEST['product_id'],$_REQUEST['store_id']);
		
		$stockObj = new Stock();
		$stockObj->setData($stock);
		$stockObj->insertData($result['id']);
		
		echo true;
		exit;
		
	}
	
}
//classs