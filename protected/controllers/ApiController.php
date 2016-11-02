<?php
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
header('Content-Type: text/html; charset=ISO-8859-6');
header('Content-Type: text/html; charset=utf-8');

class ApiController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	function beforeAction() 
	{
		if(Yii::app()->controller->action->id !="showLogs" && Yii::app()->controller->action->id !="clearLogs")
		{
		$fp = fopen('pos.txt', 'a+');
		fwrite($fp, "\r\r\n");
		fwrite($fp, "------------------------------------------------------------------------------");
		fwrite($fp, "\r\r\n");
		fwrite($fp,"Function Name : ".Yii::app()->controller->action->id );
		fwrite($fp, "\r\r\n\n");
		fwrite($fp, "PARAMS : " .print_r($_REQUEST,true));
		fwrite($fp, "\r\r\n");
		fwrite($fp, "URL : http://" . $_SERVER['HTTP_HOST'].''.print_r($_SERVER['REQUEST_URI'],true));
		fwrite($fp, "\r\r\n");
		fclose($fp);
		
		}
		return true;
	}
	
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{	
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->renderPartial('apilist');
	}
	
	/*
	Method : GET OR POST
	params : firstname,lastname,age,sex,username,password,email
	*/
	function actionregister()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['email']) && $_REQUEST['email'] !='' && isset($_REQUEST['password']) && $_REQUEST['password'] !='')
		{
			$data=array();
			if(isset($_REQUEST['firstName']) && $_REQUEST['firstName'] != '')
			{
				$data['firstName'] = $_REQUEST['firstName'];
			}
			if(isset($_REQUEST['lastName']) && $_REQUEST['lastName'] != '')
			{
				$data['lastName'] = $_REQUEST['lastName'];
			}
			if(isset($_REQUEST['type']) && $_REQUEST['type'] != '')
			{
				$data['type'] = $_REQUEST['type'];
			}
			$data['email'] = $_REQUEST['email'];
			$data['password'] = $_REQUEST['password'];
			$api = new Api();
			$bool = $api->checkemail($_REQUEST['email']);
			if($bool==false)
			{
				echo json_encode(array("status"=>'1',"message"=>"email already in use."));
				exit;
			}
			$api = new Users();
			$api->firstName=$data['firstName'];
			$api->lastName=$data['lastName'];
			$api->email=$data['email'];
			$api->password=$data['password'];
			$res = $api->save($data);
			if(!empty($res))
			{
				$result['status'] = 1;
				$result['message'] = "Successfully Registered";
				echo json_encode(array("status"=>'1',"message"=>$result));
			}
			else
			{
				echo json_encode(array("status"=>'-1',"message"=>"problem in registration"));
			}
		}
		else
		{
			echo json_encode(array("status"=>'-2',"message"=>"Permision Denied"));
		}
	}
	
	/*
	Method : GET OR POST
	params : firstname,lastname,age,sex,username,password,email
	*/
	function actioneditProfile()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId'] !='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId'] !='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$data=array();
				if(isset($_REQUEST['firstName']) && $_REQUEST['firstName'] != '')
				{
					$data['firstName'] = $_REQUEST['firstName'];
				}
				if(isset($_REQUEST['lastName']) && $_REQUEST['lastName'] != '')
				{
					$data['lastName'] = $_REQUEST['lastName'];
				}
				if(isset($_REQUEST['password']) && $_REQUEST['password'] != '')
				{
					$data['password'] = $_REQUEST['password'];
				}
				//$data['email'] = $_REQUEST['email'];
				if(isset($_REQUEST['email']) && $_REQUEST['email'] != '')
				{
					
					$api = new Api();
					$bool = $api->checkemail($_REQUEST['email']);
					if($bool==false)
					{
						echo json_encode(array("status"=>'1',"message"=>"email already in use."));
						exit;
					}
					$data['email'] = $_REQUEST['email'];
				}
				
				
				$api=Users::model()->findByPk($_REQUEST['userId']);
				$api->firstName=$data['firstName'];
				$api->lastName=$data['lastName'];
				if(isset($data['email']) && $data['email'] != '')
				{
					$api->email=$data['email'];
				}
				if(isset($data['email']) && $data['email'] != '')
				{
					$api->password=$data['password'];
				}
				$res = $api->save($data);
				if(!empty($res))
				{
					$result['status'] = 1;
					$result['message'] = "Successfully Updated";
					echo json_encode(array("status"=>'1',"message"=>$result));
				}
				else
				{
					echo json_encode(array("status"=>'-1',"message"=>"problem in Updating Profile"));
				}
			}
			else
			{
				echo json_encode(array("status"=>'-3',"message"=>"Invalid Session."));
			}
		}
		else
		{
			echo json_encode(array("status"=>'-2',"message"=>"Permision Denied"));
		}
	}
	
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actionlogin()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['loginId']) && $_REQUEST['loginId']!='' && isset($_REQUEST['password']) && $_REQUEST['password']!='')
		{
			$data=array();
			$data['loginId'] 	= $_REQUEST['loginId'];
			$data['password'] 	= $_REQUEST['password'];
			$usersObj = new Users();
			$res = $usersObj->login($data['loginId'],$data['password']);
			$id = $res['userData'][0]['id'];

			if(!empty($res) && $res['status'] == 0)
			{
				$abc= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
										"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
										"0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
				$sessionId = $abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
				$sessionId = $sessionId.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
				$user['sessionId'] = $sessionId;
				$userObj = new Users();
				$userObj->setData($user);
				$userObj->insertData($id);
				
				$userObj = new Users();
				$data = $userObj->getUserData($data['loginId']);
				
				$result['status'] = 1;
				$result['message'] = $res['message'];
				$result['data'] = $data[0] ;
					
				
				echo json_encode($result);	
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>$res['message']));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	function actionapilist()
	{		
		$this->renderPartial('apilist');
	}
	
	
	 public function actiongetTicketList()
 	{
	  if(isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
	  {
	$userObj = new Users();
	$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
	if(!empty($user) && $user['id']!='')
	{
		if(!isset($_REQUEST['sortType']))
		{
		 $_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
		 $_REQUEST['sortBy']='invoiceId';
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
		$ticketData = $ticketObj->getPaginatedTicketList(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		$i=0;
		
		$arr = array();
		foreach($ticketData['ticket'] as $row)
		{
		 
		 $arr[$i]['invoiceNo'] = $row['invoiceNo'];
		 $arr[$i]['invoiceId'] =$row['invoiceId'];
		 $arr[$i]['userId'] = $row['userId'];
		 $arr[$i]['customer_id'] = $row['customer_id'];
		 $arr[$i]['casher'] = $row['casher'];
		 $arr[$i]['total_item'] = $row['total_item'];
		 $arr[$i]['total_amount'] = $row['total_amount'];
		 $arr[$i]['total_quantity'] = $row['total_quantity'];
		 $arr[$i]['paymentType'] = $row['paymentType'];
		 $arr[$i]['cashPayment'] = $row['cashPayment'];
		 $arr[$i]['creditPayment'] = $row['creditPayment'];
		 $arr[$i]['bankPayment'] = $row['bankPayment'];
		 $arr[$i]['cardPayment'] = $row['cardPayment'];
		 $arr[$i]['sales_return_invoiceId'] = $row['sales_return_invoiceId'];
		 $arr[$i]['discount'] = $row['discount'];
		 $arr[$i]['discountType'] = $row['discountType'];
		 $arr[$i]['createdAt'] = $row['createdAt'];
		 $arr[$i]['modifiedAt'] = $row['modifiedAt'];
		 $arr[$i]['status'] = $row['status'];
		 $i++;
		}
		echo json_encode(array('status'=>1,'product'=>$arr)); 
   }
   else
   {
    echo json_encode(array('status'=>'0','error'=>'Invalid Sesssion.'));
   }
  }
  else
  {
   echo json_encode(array('status'=>'0','error'=>'Permission Denied'));
  }
 }
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actioninsertShiftDetails()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['cashier_id']) && $_REQUEST['cashier_id']!='' && isset($_REQUEST['cash']) && $_REQUEST['cash']!='')
		{
		$userObj = new Users();
		$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
		if(!empty($user) && $user['id']!='')
		{
				$usersObj = new Users();
				$userData = $usersObj->getUserById($_REQUEST['cashier_id']);
				
				if(!empty($userData))
				{
					if(!isset($_REQUEST['shift_id']))
					{
						$data = array();
						$data['cashier_id'] = $_REQUEST['cashier_id'];
						$data['cash_in'] = $_REQUEST['cash'];
						$data['time_out'] = date("Y-m-d H:i:s");
						
						$shiftObj = new Shift();
						$shiftObj->setData($data);
						$id = $shiftObj->insertData();
						
						if($id!='')
						{
							$result['status'] = 1;
							$result['message'] = "Record inserted successfully";
							$result['shift_id'] = $id;	
							
							echo json_encode($result);
						}	
						else
						{
							echo json_encode(array('status'=>'0','message'=>'Error while inserting data'));
						}
					}
					else
					{
						$data = array();
						$data['cashier_id'] = $_REQUEST['cashier_id'];
						$data['cash_out'] = $_REQUEST['cash'];
						$data['time_in'] = date("Y-m-d H:i:s");
						
						$shiftObj = new Shift();
						$shiftObj->setData($data);
						$shiftObj->insertData($_REQUEST['shift_id']);
						
						if($_REQUEST['shift_id']!='')
						{
							$result['status'] = 1;
							$result['message'] = "Record updated successfully";
							
							echo json_encode($result);
						}	
						else
						{
							echo json_encode(array('status'=>'0','message'=>'Error while updating data'));
						}
					}
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Invalid Cashier Id'));
				}
		
		   }
		   else
		   {
			echo json_encode(array('status'=>'0','error'=>'Invalid Sesssion.'));
		   }			
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actionexitShiftDetails()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['cashier_id']) && $_REQUEST['cashier_id']!='' && isset($_REQUEST['cash_out']) && $_REQUEST['cash_out']!='' && isset($_REQUEST['shift_id']) && $_REQUEST['shift_id']!='')
		{
		$userObj = new Users();
		$user = $userObj->checksession($_REQUEST['cashier_id'],$_REQUEST['sessionId']);
		
		if($user!='')
		{
				$usersObj = new Users();
				$userData = $usersObj->getUserById($_REQUEST['cashier_id']);
				
				if(!empty($userData))
				{
					$data = array();
					$data['cashier_id'] = $_REQUEST['cashier_id'];
					$data['cash_out'] = $_REQUEST['cash_out'];
					$data['time_out'] = date("Y-m-d H:i:s");
					
					$shiftObj = new Shift();
					$shiftObj->setData($data);
					$shiftObj->insertData($_REQUEST['shift_id']);
				
					$result['status'] = 1;
					$result['message'] = "Record updated successfully";
					
					echo json_encode($result);
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Invalid Cashier Id'));
				}
		   }
		   else
		   {
			echo json_encode(array('status'=>'0','error'=>'Invalid Sesssion.'));
		   }			
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
		/*****************method - change password ***************/
	function actionchangePassword()
	{
			if(!empty($_REQUEST) && isset($_REQUEST['oldpassword']) && $_REQUEST['oldpassword']!='' && isset($_REQUEST['newpassword']) && $_REQUEST['newpassword']!='' && isset($_REQUEST['confirmpassword']) && $_REQUEST['confirmpassword']!='' && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
			{
				if($this->checksession($_REQUEST['userId'],$_REQUEST['sessionId']))
  				{
					$user = new Users();
					$result=$user->changePassword($_REQUEST);
					if($result[0]==true)
					{
						$result1['status'] = 1;
						$result1['message'] = "Password changed successfully.";
						
						echo json_encode($result1);
					}
					else
					{
						$result1['status'] = 0;
						$result1['message'] = $result[1];
						
						echo json_encode($result1);
					}
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
				}			
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'permision Denied'));
			}
	}
	
	
	/*********** 	ABOUT ME FUNCTION  ***********/
	public function actionaboutme()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['firstName']) && $_REQUEST['firstName']!='' && isset($_REQUEST['lastName']) && $_REQUEST['lastName']!='' && isset($_REQUEST['loginId']) && $_REQUEST['loginId']!='' && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
			{
		/*if($this->checksession($_REQUEST['userId'],$_REQUEST['sessionId']))
			{*/
				$sessionArray['userId']		=	$_REQUEST['userId'];
				$sessionArray['loginId']	=	$_REQUEST['loginId'];
				$_REQUEST['email'] = $_REQUEST['loginId'];
				$generalObj = new General();
				$users = new Users();
				$result=$users->editProfileApi($_REQUEST,$sessionArray);
				
				if(!empty($result) && $result['status'] == 0)
				{
					$result1['status'] = 1;
					$result1['message'] = $result;
					
					echo json_encode($result1);
				}
				else
				{
					$result1['status'] = 0;
					$result1['message'] = $result;
					
					echo json_encode($result1);
				}
			/*}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
				}*/	
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'permision Denied'));
			}
	}
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actiongetProduct()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['upc_code']) && $_REQUEST['upc_code']!='')
		{
			$productObj = new Product();
			$productData = $productObj->getProductDetailsbyUpcCode($_REQUEST['upc_code']);
			
			if(!empty($productData))
			{				
				$result['status'] = 1;
				$result['message'] = $productData;	
				
				echo json_encode($result);
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'No Product Found'));
			}			
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actiongetPendingTickets()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='')
		{
			$usersObj = new Users();
			$userData = $usersObj->getUserById($_REQUEST['userId']);
			
			if(!empty($userData))
			{
				
				$ticketObj = new TicketDetails();
				$ticketData = $ticketObj->getPendingTicketsByStatus($_REQUEST['userId']);
				
				if(!empty($ticketData))
				{				
					$result['status'] = 1;
					$result['message'] = $ticketData;	
					
					echo json_encode($result);
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'No Pending Ticket Found'));
				}	
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid User Id'));
			}		
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actiongetQueryLog()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['log_id']) && $_REQUEST['log_id']!='' && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
			{
				
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			
			if($user!='')
			{
			
				$queryLogObj = new TblQuerylog();
				$queryData = $queryLogObj->getQueryLog($_REQUEST['log_id']);
				
				if(!empty($queryData))
				{				
					$result['status'] = 1;
					$result['message'] = $queryData;	
					
					echo json_encode($result);
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'No Query Found'));
				}
			
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Session'));
			}	
				
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actiongetQueryLogCount()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['log_id']) && $_REQUEST['log_id']!='' && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
			{
				
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			
			if($user!='')
			{
			
				$queryLogObj = new TblQuerylog();
				$queryData = $queryLogObj->getQueryLogCount($_REQUEST['log_id']);
				
				if(!empty($queryData))
				{				
					$result['status'] = 1;
					$result['message'] = $queryData;	
					
					echo json_encode($result);
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'No Query Found'));
				}
			
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Session'));
			}	
				
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actiongetDailyReturnTotalSalesCount()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			
			if($user!='')
			{
				$usersObj = new Users();
				$userData = $usersObj->getUserById($_REQUEST['userId']);
				
				if(!empty($userData))
				{
					Yii::app()->session['userId'] = $_REQUEST['userId'];
					$ticketObj = new TicketDetails();
					$ticketData = $ticketObj->getDailyReturnTotalSalesCount($_REQUEST['userId']);
					
					if(!empty($ticketData))
					{				
						$result['status'] = 1;
						$result['message'] = $ticketData;	
						
						echo json_encode($result);
					}
					else
					{
						echo json_encode(array('status'=>'0','message'=>'No Pending Ticket Found'));
					}	
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Invalid User Id'));
				}	
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Session'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actiongetCustomerList()
	{
		
		$customerObj = new Customers();
		$customerData = $customerObj->getAllCustomerList();
		
		if(!empty($customerData))
		{				
			$result['status'] = 1;
			$result['message'] = $customerData;	
			header('Content-Type: text/html; charset=ISO-8859-6');
			
			
			echo json_encode($result);
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'No data Found'));
		}	
		
	}
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	/*public function actiongetDailyReturnTotalSalesCount()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='')
		{
			$usersObj = new Users();
			$userData = $usersObj->getUserById($_REQUEST['userId']);
			
			if(!empty($userData))
			{
				
				Yii::app()->session['userId'] = $_REQUEST['userId'];
				$ticketObj = new TicketDetails();
				$ticketData = $ticketObj->getDailyReturnTotalSalesCount();
				
				if(!empty($ticketData))
				{				
					$result['status'] = 1;
					$result['message'] = $ticketData;	
					
					echo json_encode($result);
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'No data Found'));
				}	
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid User Id'));
			}		
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}*/
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actiongetDailyPendingTotalSalesCount()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			
			if(isset($user) && $user!='')
			{
				$usersObj = new Users();
				$userData = $usersObj->getUserById($_REQUEST['userId']);
				
				if(!empty($userData))
				{
					
					Yii::app()->session['userId'] = $_REQUEST['userId'];
					$ticketObj = new TicketDetails();
					$ticketData = $ticketObj->getDailyPendingTotalSalesCount();
					
					if(!empty($ticketData))
					{				
						$result['status'] = 1;
						$result['message'] = $ticketData;	
						
						echo json_encode($result);
					}
					else
					{
						echo json_encode(array('status'=>'0','message'=>'No data Found'));
					}	
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Invalid User Id'));
				}	
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Session'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	/*
	Method : GET OR POST
	params : loginId,password
	*/
	public function actiongetDailyTotalSalesCount()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			
			if(isset($user) && $user!='')
			{
				$usersObj = new Users();
				$userData = $usersObj->getUserById($_REQUEST['userId']);
				
				if(!empty($userData))
				{
					
					Yii::app()->session['userId'] = $_REQUEST['userId'];
					$ticketObj = new TicketDetails();
					$ticketData = $ticketObj->getDailyTotalSalesCount();
					
					if(!empty($ticketData))
					{				
						$result['status'] = 1;
						$result['message'] = $ticketData;	
						
						echo json_encode($result);
					}
					else
					{
						echo json_encode(array('status'=>'0','message'=>'No data Found'));
					}	
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Invalid User Id'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Session'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function checksession($userId,$sessionId)
	{
			$userObj = new Users();
			$res = $userObj->checksession($userId,$sessionId);
			if(!empty($res) && $res > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
	}
	
	public function actionlogout()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$user=Users::model()->findByPk($_REQUEST['userId']);
				$user->sessionId='';
				$user->isOnline='0';
				$res =  $user->save(); // save the change to database
				if($res ==  1)
				{
					echo json_encode(array('status'=>'1','message'=>'Successfully Logged Out.'));
				}
				else
				{
					echo json_encode(array('status'=>'0','error'=>'Invalid Parameters.'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','error'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','error'=>'permision Denied'));
		}
	}
	
	/*********** 	Logout   ***********/ 
	function actionLogoutOld()
	{
		$data['cashier_id']	=$_POST['cashier_id'];
		$data['cash_in']=Yii::app()->session['cash_in'];
		$data['cash_out']	=$_POST['cash_out'];
		$data['time_out']=date('Y-m-d:H-m-s');
		
		$shiftObj = new Shift();
		$shiftObj->setData($data);
		$shiftObj->insertData($_POST['shift_id']);
		
		
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
	}
	
	public function actionraiseShiftDetail()
	{
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
			
			$html = "
					<table cellpadding='5' cellspacing='5' border='0'>
					<tr>
						<td colspan='4' align='center' style='background-color:#000; color:#FFF;'><b>NVIS POS</b></td>
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
						<td align='right'>AMOUNT*</td>
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
							<td align='right'><b>TOTAL SALES</b></td>
							<td align='right'><b>".($card + $cash + $credit)."</b></td>
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
							<td>Credit Card Balance</td>
							<td align='right'>10700</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>Credit Balance</td>
							<td align='right'>5000</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td align='right'><b>TOTAL CLOSING BALANCE</b></td>
							<td align='right'><b>17700</b></td>
							<td></td>
						</tr>
				</table>";
	
			$mpdf = new mPDF();
	
			$filename = Yii::app()->session['userId'].'_SHIFT_'.Yii::app()->session['shiftId']."_".date("Ymd");
			$mpdf->WriteHTML($html);
			$mpdf->Output(FILE_PATH."assets/upload/pdf/".$filename.".pdf", 'F');
				

		
	}
	
	/*********************Get Web Phone Verify*******************/
	
	public function actiongetProductList()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$productObj = new Product();
				$product	=	$productObj->getAllProductList($_REQUEST['admin_id']);
				$i=0;
				$arr = array();
				foreach($product as $row)
				{
					
					$arr[$i]['product_id'] = $row['product_id'];
					$arr[$i]['store_id'] =$row['store_id'];
					$arr[$i]['product_name'] = $row['product_name'];
					$arr[$i]['product_desc'] = strip_tags($row['product_desc']);
					$arr[$i]['product_image'] = $row['product_image'];
					$arr[$i]['product_discount'] = $row['product_discount'];
					$arr[$i]['product_price'] = $row['product_price'];
					$arr[$i]['product_price2'] = $row['product_price2'];
					$arr[$i]['product_price3'] = $row['product_price3'];
					$arr[$i]['upc_code'] = $row['upc_code'];
					$arr[$i]['quantity'] = $row['quantity'];
					$arr[$i]['manufacturing_date'] = $row['manufacturing_date'];
					$arr[$i]['expiry_date'] = $row['expiry_date'];
					$arr[$i]['cat_id'] = $row['cat_id'];
					$arr[$i]['admin_id'] = $row['admin_id'];
					$arr[$i]['created_date'] = $row['created_date'];
					$arr[$i]['modified_date'] = $row['modified_date'];
					$arr[$i]['status'] = $row['status'];
					$i++;
				}
				echo json_encode(array('status'=>1,'product'=>$arr));
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actiongetCategoryList()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$categoryObj = new Category();
				$categoryList	=	$categoryObj->getClientCategoryList($_REQUEST['admin_id']);
				
				if(!empty($categoryList) && $categoryList != '')
				{
					echo json_encode(array('status'=>1,'categoryList'=>$categoryList));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Data Not Found.'));
				}
				
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'Invalid Parameter'));
		}
	}
	
	public function actiongetProductListByCategoryId()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']!='' && isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$ProductObj = new Product();
				$productList	=	$ProductObj->getProductListByCategoryId($_REQUEST['cat_id'],$_REQUEST['admin_id']);
				
				if(!empty($productList) && $productList != '')
				{
					$i=0;
					$arr = array();
					foreach($productList as $row)
					{
						
						$arr[$i]['product_id'] = $row['product_id'];
						$arr[$i]['store_id'] =$row['store_id'];
						$arr[$i]['product_name'] = $row['product_name'];
						$arr[$i]['product_desc'] = strip_tags($row['product_desc']);
						$arr[$i]['product_image'] = $row['product_image'];
						$arr[$i]['product_discount'] = $row['product_discount'];
						$arr[$i]['product_price'] = $row['product_price'];
						$arr[$i]['upc_code'] = $row['upc_code'];
						$arr[$i]['quantity'] = $row['quantity'];
						$arr[$i]['manufacturing_date'] = $row['manufacturing_date'];
						$arr[$i]['expiry_date'] = $row['expiry_date'];
						$arr[$i]['cat_id'] = $row['cat_id'];
						$arr[$i]['admin_id'] = $row['admin_id'];
						$arr[$i]['created_date'] = $row['created_date'];
						$arr[$i]['modified_date'] = $row['modified_date'];
						$arr[$i]['status'] = $row['status'];
						$i++;
					}
					
					echo json_encode(array('status'=>1,'productList'=>$arr));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Data Not Found.'));
				}
				
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'Invalid Parameter'));
		}
	}
	
	public function actiongetStoreList()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$storeObj = new Stores();
				$store	=	$storeObj->getAllStoreListforapi($_REQUEST['admin_id']);
				
				echo json_encode(array('status'=>1,'stores'=>$store));
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}


	public function actiongetStockList()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$stockObj = new Stock();
				$stock	=	$stockObj->getAllStockListforapi($_REQUEST['admin_id']);
				
				echo json_encode(array('status'=>1,'stores'=>$stock));
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actiongetProductByUpcCode()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']!='' && isset($_REQUEST['upc_code']) && $_REQUEST['upc_code']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$productObj = new Product();
				$product	=$productObj->getProductDetailsbyUpcCodeForApi($_REQUEST['upc_code'],$_REQUEST['admin_id']);
				if(!empty($product) && $product!='')
				{
					$product['product_desc'] = strip_tags($product['product_desc']);
					echo json_encode(array('status'=>1,'product'=>$product));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Product Not Found.'));	
				}
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actiongetProductStockList()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id']!='' && isset($_REQUEST['product_id']) && $_REQUEST['product_id']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$stockObj = new Stock();
				$stock	=	$stockObj->getProductStockDetail($_REQUEST['admin_id'],$_REQUEST['product_id']);
				
				if(!empty($stock) && $stock != "")
				{
					echo json_encode(array('status'=>1,'stores'=>$stock));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Stock Not Found.'));	
				}
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	
	public function sendNotificationToAuthors($para=array())
	{
		
		$authcode = "DQAAALQAAAB0Fdu--PyOnIpzfKhvJCoqz3o__6baV46JdOvXwXiY93nD7D1FQvxYrFjnRX2kzBr_k5j4X3tP0aSMYfC1XrOdQ4QnY4iHqt3J_d2fTC6mh07Y0ER_8oo5aKuz-DUcLORegM7frSU7NLNmscRWYblMI5wR96LcqA1aihTaJ1LXKlW-J8AzVXjOhhWWg5LqKDZLM1-c5JFbchGmDsX6nxCLCGtYyRHhh7jRNEbQ3-60aUKJeOcSHxOF-gM7WOWnDvs";
		
		if(isset($para['deviceId']) && $para['deviceId']!='')
		{
			
		$msgType="text";
		$smarty = new smartyML('eng');
		$messageText=smarty_prefilter_i18n($para['message'],$smarty);
		
		$notificationData=array('senderType'=>$para['senderType'],'message'=>$messageText);
		$headers = array('Authorization: GoogleLogin auth=' . $authcode);
		$data = array(
		 'registration_id' => $para['deviceId'],
		 'collapse_key' => 'text',
		 'data.payload' => $para['senderType']."::".$messageText //TODO Add more params with just simple data instead 
		 );
		 
		$ch = curl_init();
	 	
		curl_setopt($ch, CURLOPT_URL, "https://android.apis.google.com/c2dm/send");
		if ($headers)
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	  
		$response = curl_exec($ch);
		curl_close($ch);
		error_log("Android Response".print_r($response,true));
		return array("status"=>0,'message'=>$response);
		}
		return json_encode(array("status"=>505,'message'=>"Invalid deviceId."));
	}
	
	
	function googleAuthenticate($username, $password, $source="Company-AppName-Version", $service="ac2dm") 
	{    

		if( isset($_SESSION['google_auth_id']) && $_SESSION['google_auth_id'] != null)
			return $_SESSION['google_auth_id'];
	
		// get an authorization token
		$ch = curl_init();
		if(!$ch){
			return false;
		}
	
		curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
		$post_fields = "accountType=" . urlencode('HOSTED_OR_GOOGLE')
			. "&Email=" . urlencode($username)
			. "&Passwd=" . urlencode($password)
			. "&source=" . urlencode($source)
			. "&service=" . urlencode($service);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);    
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
		// for debugging the request
		//curl_setopt($ch, CURLINFO_HEADER_OUT, true); // for debugging the request
	
		$response = curl_exec($ch);
		
		curl_close($ch);
	
		if (strpos($response, '200 OK') === false) {
			return false;
		}
	
		// find the auth code
		preg_match("/(Auth=)([\w|-]+)/", $response, $matches);
	
		if (!$matches[2]) {
			return false;
		}
	
		$_SESSION['google_auth_id'] = $matches[2];
		return $matches[2];
	}
	
	
	
	public function fileUpload($file)
	{
		$base=$file;
		//error_log(print_r($base,true),3,'test.txt');
		// base64 encoded utf-8 string
		$binary=base64_decode($base);
		// binary, utf-8 bytes
		header('Content-Type: bitmap; charset=utf-8');
		// print($binary);
		//$theFile = base64_decode($image_data);
		$str = rand(1000,100000);
		$file = fopen('theauthor/att_"'.$str.'.png', 'wb');
		$filename = 'att_"'.$str.'.png';
		fwrite($file, $binary);
		fclose($file);
		return $filename;
	}
	
	
	
	
	/*
	METHOD : submitTicket
	PARAMS :  customer_id,discount,total_quantity,total_item,total_amount,cashPayment,cardPayment,bankPayment,creditPayment,paymentType,status,quantity1,rate1,product1,amount1,userId
	*/
	public function actionsubmitTicket()
	{
	if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['total_amount']) && $_REQUEST['total_amount']!='' && isset($_REQUEST['total_item']) && $_REQUEST['total_item']!='')
	{
		$userObj = new Users();
		$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
		if(!empty($user) && $user['id']!='')
		{
			$userObj = new Users();
			$userData = $userObj->getUserById($_REQUEST['userId']);
			
			$data = array();
			$data['userId']=$_REQUEST['userId'];
			$data['casher']=$_REQUEST['casher'];
			$data['customer_id']=$_REQUEST['customer_id'];
			$data['admin_id'] = $userData['admin_id'];
			$data['store_id'] = $userData['store_id'];
			$data['discount']	=$_REQUEST['discount'];
			$data['discountType']	=$_REQUEST['discountType'];
			$data['createdAt']=date('Y-m-d:H-m-s');
			$data['modifiedAt']=date('Y-m-d:H-m-s');
			$data['total_quantity']	=$_REQUEST['total_quantity'];
			$data['total_item']= $_REQUEST['total_item'];
			$cnt = $_REQUEST['total_product'];
			$data['total_amount']	= $_REQUEST['total_amount'];
			$data['cashPayment']=$_REQUEST['cashPayment'];
			$data['cardPayment']=$_REQUEST['cardPayment'];
			$data['bankPayment']=$_REQUEST['bankPayment'];
			$data['creditPayment']=$_REQUEST['creditPayment'];
			$data['paymentType']=$_REQUEST['paymentType'];
			$data['status']= 5 ;
			$ticketsObj = new TicketDetails();
			$ticketsObj->setData($data);
			$invoiceId = $ticketsObj->insertData();
			
			$data = array();
			$data['invoiceId'] = $invoiceId;
			$data['admin_id'] = $userData['admin_id'];
			for($i=1;$i<=$cnt;$i++)
			{				
				$data['quantity'] = $_REQUEST['quantity'.$i.''];
				$data['store_id'] = $_REQUEST['store_id'.$i.''];
				$data['product_id'] = $_REQUEST['product'.$i.''];
				$data['price'] = $_REQUEST['rate'.$i.''];
				$data['product_total'] = $_REQUEST['amount'.$i.''];
				$data['date_add'] = date("Y-m-d H:i:s");
				
				$ticketDescObj = new TicketDesc();
				$ticketDescObj->setData($data);
				$ticketDescObj->insertData();
				
				$stock['product_id'] = $_REQUEST['product'.$i.''];
				$stock['quantity']	= $_REQUEST['quantity'.$i.''];
				$stock['store_id'] = $_REQUEST['store_id'.$i.''];
				$stock['modified'] = date("Y-m-d H:i:s");
				
				$stockObj = new Stock();
				$stockObj->updateStockForProductDesc($stock['product_id'],$stock['quantity'],$stock['modified'],$stock['store_id']);
			}
			
			if($_REQUEST['creditPayment'] != "")
			{
				$customer['customer_id'] = $_REQUEST['customer_id'];
				$customer['credit'] = $_REQUEST['creditPayment'];
				$customer['modifiedAt']=date('Y-m-d:H-m-s');
				
				$customerObj = new Customers();
				$customerObj->updateCustomerCredit($customer['customer_id'],$customer['credit'],$customer['modifiedAt']);
				$customerGeneral['customer_id'] = $_REQUEST['customer_id'];
				$customerGeneral['credit'] = $_REQUEST['creditPayment'];
				$customerGeneral['paymentType'] = 0 ;
				$customerGeneral['createdAt'] = date('Y-m-d:H-m-s');
				
				$customerGeneralObj = new CustomerGeneralEntry();
				$customerGeneralObj->setData($customerGeneral);
				$receiptId = $customerGeneralObj->insertData();
			}
			
			/*$general['account'] = 'sale';
			$general['admin_id']= $userData['admin_id'];
			$general['store_id']= $userData['store_id'];
			$general['credit'] = $_REQUEST['total_amount'] ;
			$general['created']=date('Y-m-d:H-m-s');
			
			$generalEntryObj = new GeneralEntry();
			$generalEntryObj->setData($general);
			$generalEntryObj->insertData();*/
			
		   $invoiceSeriesObj = new InvoiceSeries();
		   $seriesId = $invoiceSeriesObj->getLastSeriesNo($_REQUEST['userId']);
		   
		   if(empty($seriesId) || $seriesId == 0)
		   {
			$seriesNo = 1 ;
		   }
		   else
		   {
			$seriesNo = $seriesId + 1; 
		   }
			$series['userId'] = $_REQUEST['userId'];
		    $series['invoiceId'] = $invoiceId;
		    $series['seriesNo'] = $seriesNo ;
		    $series['invoiceNo'] = $_REQUEST['userId'].date('Y').$seriesNo;
		    $series['createdAt']=date('Y-m-d:H-m-s');
		   
		    $invoiceSeriesObj = new InvoiceSeries();
		    $invoiceSeriesObj->setData($series);
		    $invoiceSeriesObj->insertData();
			
			$ids['userId'] = $_REQUEST['userId'];
			$ids['invoiceId'] = $data['invoiceId'];
			$invoiceIdsObj = new Invoiceids();
			$invoiceIdsObj->setData($ids);
			$invoiceIdsObj->insertData(1);
			$pdfUrl = $this->actionraiseInvoice($invoiceId);
			
			$result['status'] = 1;
			$result['message'] = 'success';
			$result['data'] = array('data'=>'Invoice Successfully Created.','pdfUrl'=>$pdfUrl);
			
			echo json_encode($result);		
			
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
		}
		}
	else
	{
		echo json_encode(array('status'=>'0','message'=>'permision Denied'));
	}	
}
	
	
	function actionraiseInvoice($id)
	{
		$ticketDetailsObj = new TicketDetails();
		$ticketData = $ticketDetailsObj->getTicketDetailWithCustomer($id);
		
		$ticketSession = Yii::app()->session['ticketData'] ;
		$ticketDescObj  = new TicketDesc();
		$productData = $ticketDescObj->getTicketsDataforApi($id);
		
		$total=0;
		foreach($productData as $row)
		{
			$total += $row['product_total'];
		}
		
		$invoiceSeriesObj = new InvoiceSeries();
		$seriesId = $invoiceSeriesObj->getSeriesNo($id);
		//$this->renderPartial("raiseInvoice",array('ticketData'=>$ticketData,'productData'=>$productData));
		//exit;
		if($ticketData['discountType'] == 0)
		{
			$discountType = 'DISCOUNT(%)';	
			$discount =  $ticketData['discount'].'%';
		} 
		else
		{
			$discountType = 'DISCOUNT($)';	
			$discount =  $ticketData['discount'].'$';
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
			<td width="48%" rowspan="2">New Vision Integrated Systems | NVIS
			<br />
		[NVIS revolutionizes how you get things done!]</td>
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
			<td align="right">INVOICE '. $seriesId.'<br /></td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($ticketData['createdAt'])).'</td>
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
		
		<p>&nbsp;</p>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
			<td width="15%"><strong>QUANTITY</strong></td>
			<td width="20%"><strong>STORE</strong></td>
			<td width="39%"><strong>PRODUCT</strong></td>
			<td width="16%"><strong>UNIT PRICE</strong></td>
			<td width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  
	foreach($productData as $row) {
        
		$html .=  '<tr>
			<td height="20">'.$row['quantity'].'&nbsp;</td>
			<td height="20">'.$row['store_name'].'&nbsp;</td>
			<td>&nbsp;'.$row['product_name'].'</td>
			<td>&nbsp;'.$row['product_price'].'</td>
			<td>&nbsp;'.$row['product_total'].'</td>
		  </tr>';
    } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
		   <td colspan="3" align="right" class="noborder">SUBTOTAL<br />
			  SALES TAX<br />
			  '.$discountType.'<br /></td>
			<td width="10%">&nbsp;'. $total.'<br/><br/>'. $discount .'</td>
		  </tr>
		  
		  <tr >
			<td colspan="3" align="right" class="noborder1">TOTAL DUE</td>
			<td>&nbsp;'. $ticketData['total_amount'].'</td>
		  </tr>
		</table>
		
		<p align="center">
		<strong>Thank you for the business.</strong>
		</p>
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/invoice/invoice".$ticketData['invoiceId'].".pdf", 'F');
		return Yii::app()->params->base_url.'assets/upload/invoice/invoice'.$ticketData['invoiceId'].'.pdf';
		
		
	}
/*-------------------------------------------Sales Return Start-------------------------------------*/	
	public function actiongetTicketDetailsForSalesReturn()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['invoiceId']) && $_REQUEST['invoiceId']!='' )
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
			
				$invoiceSeriesObj = new InvoiceSeries();
				$id = $invoiceSeriesObj->getInvoiceId($_REQUEST['invoiceId']);
				$invoiceSeriesId = $_REQUEST['invoiceId'];
		
				if(empty($id))
				{
					$result['status'] = 0;
					$result['message'] = 'Wrong Invoice Id.';
					echo json_encode($result);
					exit;
				}
				
				$invoiceId = $id;
				
				$ticketObj	=	new TicketDetails();
				$ticketdata	=	$ticketObj->checkTicketForApi($invoiceId,$_REQUEST['userId']); 
				
				
				$ticketdescObj	=	new TicketDesc();
				$ticket	= $ticketdescObj->getTicketsDataForSalesReturnForapi($invoiceId,$_REQUEST['userId']);
				
				
				if(empty($ticket))
				{
					$result['status'] = 0;
					$result['message'] = 'Ticket Not Found.';
					echo json_encode($result);
					exit;
				}
				
		
				$ticketObj	=	new TicketDetails();
				$response	=	$ticketObj->getTicketDetailWithCustomer($invoiceId); 
				
				foreach($ticket as $row)
				{
					$response['allProductTotal'] += $row['product_total'];
				}
				
				
				$result['status'] = 1;
				$result['ticketDetails'] = $response;
				$result['productDescription'] = $ticket;
				echo json_encode($result);
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}	
				
		
	}
	
	public function actionsubmitSalesReturnTicket()
	{
	if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['return_total_amount']) && $_REQUEST['return_total_amount']!='' && isset($_REQUEST['return_total_item']) && $_REQUEST['return_total_item']!='' && isset($_REQUEST['invoiceId']) && $_REQUEST['invoiceId']!='')
	{
		$userObj = new Users();
		$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
		if(!empty($user) && $user['id']!='')
		{
			$userObj = new Users();
			$userData = $userObj->getUserById($_REQUEST['userId']);
			
			$data = array();
			$data['userId']=$_REQUEST['userId'];
			$data['sales_return_invoiceId']=$_REQUEST['invoiceId'];
			$data['return_casher']=$_REQUEST['return_casher'];
			$data['return_customer_id']=$_REQUEST['return_customer_id'];
			$data['return_discount']	=$_REQUEST['return_discount'];
			$data['return_discountType']	=$_REQUEST['return_discountType'];
			$data['return_createdAt']=date('Y-m-d:H-m-s');
			$data['modifiedAt']=date('Y-m-d:H-m-s');
			$data['return_total_quantity']	=$_REQUEST['return_total_quantity'];
			$data['return_total_item']= $_REQUEST['return_total_item'];
			$cnt = $_REQUEST['total_return_product'];
			$data['return_total_amount']	= $_REQUEST['return_total_amount'];

			$ticketReturnObj = new SalesReturnDetails();
			$ticketReturnObj->setData($data);
			$returninvoiceId = $ticketReturnObj->insertData();
			
			$data = array();
			$data['sales_return_invoiceId'] = $_REQUEST['invoiceId'];
			for($i=1;$i<=$cnt;$i++)
			{				
				$data['return_quantity'] = $_REQUEST['return_quantity'.$i.''];
				$data['return_store_id'] = $_REQUEST['return_store_id'.$i.''];
				$data['return_product_id'] = $_REQUEST['return_product_id'.$i.''];
				$data['return_price'] = $_REQUEST['return_price'.$i.''];
				$data['return_product_total'] = $_REQUEST['return_product_total'.$i.''];
				$data['return_date'] = date("Y-m-d H:i:s");
				
				$ticketReturnDescObj = new SalesReturnDesc();
				$ticketReturnDescObj->setData($data);
				$ticketReturnDescObj->insertData();
				
				$stock['product_id'] = $_REQUEST['return_product_id'.$i.''];
				$stock['quantity']	= $_REQUEST['return_quantity'.$i.''];
				$stock['store_id'] = $_REQUEST['return_store_id'.$i.''];
				$stock['modified'] = date("Y-m-d H:i:s");
				
				$stockObj = new Stock();
				$stockObj->updateStockForSalesReturn($stock['product_id'],$stock['quantity'],$stock['modified'],$stock['store_id']);
			}
			
			$result['sales_return_invoiceId'] = $returninvoiceId ;
			$result['status'] = 2 ;
			$result['modifiedAt'] = date('Y-m-d:H-m-s') ;
			$ticketDetailsObj = new TicketDetails();
			$ticketDetailsObj->setData($result);
			$ticketDetailsObj->insertData($_REQUEST['invoiceId']);
			
			$pdfUrl = $this->actionraiseReturnInvoice($_REQUEST['invoiceId']);
			
			$result['status'] = 1;
			$result['message'] = 'success';
			$result['data'] = array('data'=>'Return Invoice Successfully Created.','pdfUrl'=>$pdfUrl);
			
			echo json_encode($result);		
			
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
		}
		}
	else
	{
		echo json_encode(array('status'=>'0','message'=>'permision Denied'));
	}	
}

	function actionraiseReturnInvoice($id)
	{
		
		$salesReturnObj = new SalesReturnDetails();
		$ticketData = $salesReturnObj->getReturnTicketDetails($id);
		
		$salesReturnDescObj  = new SalesReturnDesc();
		$productData = $salesReturnDescObj->getTicketsData($id);
		
		$total=0;
		foreach($productData as $row)
		{
			$total += $row['return_product_total'];
		}
		
		$discountType = 'DISCOUNT(%)';	
		$discount =  $ticketData[0]['return_discount'].'%';
				
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
			<td width="48%" rowspan="2">New Vision Integrated Systems | NVIS
			<br />
		[NVIS revolutionizes how you get things done!]</td>
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
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">RETURN INVOICE '. $ticketData[0]['sales_return_invoiceId'].'<br /></td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($ticketData[0]['return_createdAt'])).'</td>
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
		
		<p>&nbsp;</p>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
			<td width="20%"><strong>QUANTITY</strong></td>
			<td width="54%"><strong>PRODUCT NAME</strong></td>
			<td width="16%"><strong>UNIT PRICE</strong></td>
			<td width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  
	foreach($productData as $row) {
        
		$html .=  '<tr>
			<td height="20">'.$row['return_quantity'].'&nbsp;</td>
			<td>&nbsp;'.$row['product_name'].'</td>
			<td>&nbsp;'.$row['return_price'].'</td>
			<td>&nbsp;'.$row['return_product_total'].'</td>
		  </tr>';
    } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <tr>
			 <td colspan="3" align="right" class="noborder">SUBTOTAL<br />
			  SALES TAX<br />
			  '.$discountType.'<br /></td>
			<td width="10%">'.$total.'<br/><br/>'. $discount.'</td>
		  </tr>
		  <tr >
			<td colspan="3" align="right" class="noborder1">TOTAL DUE</td>
			<td>&nbsp;'. $ticketData[0]['return_total_amount'].'</td>
		  </tr>
		</table>
		
		<p align="center">
		<strong>Thank you for the business.</strong>
		</p>
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/srinvoice/srinvoice".$ticketData[0]['sales_return_invoiceId'].".pdf", 'F');
		
        $mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/srinvoice/srinvoice".$ticketData[0]['sales_return_invoiceId'].".pdf", 'F');
		return Yii::app()->params->base_url.'assets/upload/srinvoice/srinvoice'.$ticketData[0]['sales_return_invoiceId'].'.pdf';
		
	}
/*-------------------------------------------Sales Return Finish -------------------------------------*/
/*-------------------------------------------Reports Start -------------------------------------*/
	public function actiongetTotalAmountReport()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['date1']) && $_REQUEST['date1']!='' && isset($_REQUEST['date2']) && $_REQUEST['date2']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				
				$ticketObj = new TicketDetails();
				$ticketData	=	$ticketObj->getTotalAmountReportForApi($_REQUEST['userId'],$_REQUEST['date1'],$_REQUEST['date2']);
				if(!empty($ticketData) && $ticketData != "")
				{
					echo json_encode(array('status'=>1,'InvoiceList'=>$ticketData));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Ticket Not Found.'));	
				}
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actiongetProductReport()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['date1']) && $_REQUEST['date1']!='' && isset($_REQUEST['date2']) && $_REQUEST['date2']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				
				$ticketObj = new TicketDetails();
				$ticketData	=	$ticketObj->getTotalProductReportApi($_REQUEST['userId'],$_REQUEST['date1'],$_REQUEST['date2'],$_REQUEST['product_id']);
				/*echo "<pre>";
				print_r($ticketData);
				exit;*/
				if(!empty($ticketData) && $ticketData != "")
				{
					echo json_encode(array('status'=>1,'ProductList'=>$ticketData));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Product Not Found.'));	
				}
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actiongetTotalProductReport()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['date1']) && $_REQUEST['date1']!='' && isset($_REQUEST['date2']) && $_REQUEST['date2']!='')
		{
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				
				$ticketObj = new TicketDetails();
				$ticketData	=	$ticketObj->getTotalProductReportForApi($_REQUEST['userId'],$_REQUEST['date1'],$_REQUEST['date2']);
				if(!empty($ticketData) && $ticketData != "")
				{
					echo json_encode(array('status'=>1,'InvoiceList'=>$ticketData));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'Ticket Not Found.'));	
				}
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	function actiongetProductTotalForReport()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['date1']) && $_REQUEST['date1']!='' && isset($_REQUEST['date2']) && $_REQUEST['date2']!='')
			{
				
			$userObj = new Users();
			$user = $userObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			
			if($user!='')
			{
			
				$ticketObj = new TicketDesc();
				$ticketData = $ticketObj->getProductReportForApi($_REQUEST['userId'],$_REQUEST['date1'],$_REQUEST['date2']);
				
				if(!empty($ticketData))
				{				
					$result['status'] = 1;
					$result['message'] = $ticketData;	
					
					echo json_encode($result);
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'No Data Found'));
				}
			
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid Session'));
			}	
				
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
/*-------------------------------------------Reports Finish -------------------------------------*/
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{	
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	function actiontestCustomer()
	{
		$sql_users = "select * from tbl_querylog";
		$count	=	Yii::app()->db->createCommand($sql_users)->queryAll();
		echo header('Content-Type: text/html; charset=ISO-8859-6');
		echo json_encode($count);
		exit;
	}
	
	function actioncleanDB()
	{
		
		
	//	$command = Yii::app()->db->createCommand();
		//$command->truncateTable('tbl_querylog');
		
		$sql_users = "";
		$count	=	Yii::app()->db->createCommand($sql_users)->execute();
		
		
		echo header('Content-Type: text/html; charset=ISO-8859-6');
		echo json_encode($count);
		exit;
	}
	
	
	function actionshowLogs()
	{
		$handle = @fopen("pos.txt", "r");
		if ($handle) {
   		 while (($buffer = fgets($handle, 4096)) !== false) {
        	echo $buffer;
			echo "<br>";
    		}
    	if (!feof($handle)) {
        	echo "Error: unexpected fgets() fail\n";
    	}
		}
    	fclose($handle);
	}

	function actionclearLogs()
	{
		$handle = fopen("pos.txt", "w");
		fwrite($handle, '');
		fclose($handle);

	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	
}