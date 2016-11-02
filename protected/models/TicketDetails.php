<?php

/**
 * This is the model class for table "ticket_details".
 *
 * The followings are the available columns in table 'ticket_details':
 * @property integer $invoiceId
 * @property integer $customer_id
 * @property integer $userId
 * @property integer $reg_no
 * @property integer $product_id
 * @property integer $total_amount
 * @property integer $quantity
 * @property integer $cashPayment
 * @property integer $creditPayment
 * @property integer $unit
 * @property integer $discount
 * @property string $status
 */
class TicketDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TicketDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticket_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		/*// will receive user inputs.
		return array(
			array('customer_id, userId, reg_no, product_id, total_amount, quantity, cashPayment, creditPayment, unit, discount', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoiceId, customer_id, userId, reg_no, product_id, total_amount, quantity, cashPayment, creditPayment, unit, discount, status', 'safe', 'on'=>'search'),
		);*/
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoiceId' => 'Invoice',
			'customer_id' => 'Customer',
			'userId' => 'User',
			'reg_no' => 'Reg No',
			'product_id' => 'Product',
			'total_amount' => 'Total Amount',
			'quantity' => 'Quantity',
			'cashPayment' => 'Cash Payment',
			'creditPayment' => 'Credit Payment',
			'unit' => 'Unit',
			'discount' => 'Discount',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('invoiceId',$this->invoiceId);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('reg_no',$this->reg_no);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cashPayment',$this->cashPayment);
		$criteria->compare('creditPayment',$this->creditPayment);
		$criteria->compare('unit',$this->unit);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// set the user data
	function setData($data)
	{
		$this->data = $data;
	}
	
	// insert the user
	function insertData($id=NULL)
	{
		if($id!=NULL)
		{
			$transaction=$this->dbConnection->beginTransaction();
			try
			{
				$post=$this->findByPk($id);
				if(is_object($post))
				{
					$p=$this->data;
					
					foreach($p as $key=>$value)
					{
						$post->$key=$value;
					}
					$post->save(false);
				}
				$transaction->commit();
			}
			catch(Exception $e)
			{						
				$transaction->rollBack();
			}
			
		}
		else
		{
			$p=$this->data;
			foreach($p as $key=>$value)
			{
				$this->$key=$value;
			}
			$this->setIsNewRecord(true);
			$this->save(false);
			return Yii::app()->db->getLastInsertID();
		}
		
	}
	
	function getinvoiceId()
	{	
		$sql = "select invoiceId from ticket_details where userId = ".Yii::app()->session['userId']."  order by invoiceId desc";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getInvoiceIdWithStatus()
	{	
		$sql = "select invoiceId , status from ticket_details where userId = ".Yii::app()->session['userId']."  order by invoiceId desc";
		$result	=	Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getCountInvoiceId()
	{	
		$sql = "select count(invoiceId) from ticket_details";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}

	
	function getRecentPendingTickets()
	{
		$sql = "SELECT * FROM ticket_details WHERE status = '0' and userId = ".Yii::app()->session['userId']." order by invoiceId desc LIMIT 5";	
		$result	= Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTicketDetails($invoiceId)
	{
		$sql = "SELECT customers.customer_name,ticket_details.* FROM ticket_details LEFT JOIN customers ON (customers.customer_id = ticket_details.customer_id) WHERE ticket_details.invoiceId = ".$invoiceId." ";	
		$result	= Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function checkTicket($invoiceId)
	{
		$sql = "SELECT * FROM ticket_details WHERE invoiceId = ".$invoiceId." and userId = ".Yii::app()->session['userId']." ";	
		$result	= Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function checkTicketForApi($invoiceId,$userId)
	{
		$sql = "SELECT * FROM ticket_details WHERE invoiceId = ".$invoiceId." and userId = ".$userId." ";	
		$result	= Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function deleteTicket($invoiceId)
	{
		$sql = "delete from ticket_details where invoiceId = ".$invoiceId.";";	
		$result	= Yii::app()->db->createCommand($sql)->query();
	}
	
	public function getPaginatedTicketList($limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(ticket_details.createdAt,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		else
		{
			$todaysearch = " ";
		}
		
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (casher like '%".$keyword."%' or invoiceNo like '%".$keyword."%')";	
		}
		else
		{
			$search = " ";
		}
		
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$amountSearch = " and ticket_details.total_amount > ".$searchFrom." and ticket_details.total_amount < ".$searchTo."";	
			}
			else
			{
				$amountSearch = " and ticket_details.total_amount > ".$searchFrom." and ticket_details.total_amount < ".$searchTo."";	
			}
		}else{
			$amountSearch = " ";
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and ticket_details.createdAt >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and ticket_details.createdAt <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}else{
			$dateSearch = " ";
		}
		
			$sql_users = "select invoice_series.invoiceNo ,ticket_details.* from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.userId = ".Yii::app()->session['userId']." and (status = '1' or status = '2' ) ".$search." ".$todaysearch."  ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
			$sql_count = "select count(*) from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.userId = ".Yii::app()->session['userId']." and ( status = '1' or status = '2' ) ".$search." ".$todaysearch."  ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'10',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'ticket'=>$item->getData());
		
	}
	
	public function getPaginatedTicketListForCustomer($customer_id = NULL ,$limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(ticket_details.createdAt,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (casher like '%".$keyword."%' or invoiceNo like '%".$keyword."%')";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$amountSearch = " and total_amount > ".$searchFrom." and total_amount < ".$searchTo."";	
			}
			else
			{
				$amountSearch = " and total_amount > ".$searchFrom." and total_amount < ".$searchTo."";	
			}
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and ticket_details.createdAt >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and ticket_details.createdAt <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
			$sql_users = "select invoice_series.invoiceNo ,ticket_details.* from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.userId = ".Yii::app()->session['userId']." and (status = '1' or status = '2' or status = '5' ) and customer_id = ".$customer_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
			$sql_count = "select count(*) from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.userId = ".Yii::app()->session['userId']." and ( status = '1' or status = '2' or status = '5' ) and customer_id = ".$customer_id." ".$search." ".$todaysearch."  ".$amountSearch." ".$dateSearch."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'7',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'ticket'=>$item->getData());
		
	}
	
	public function getPaginatedTicketListForDelivery($limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
  		$admin_id = $userData->admin_id ;
		
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(ticket_details.createdAt,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (casher like '%".$keyword."%' or invoiceNo like '%".$keyword."%')";	
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and ticket_details.createdAt >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and ticket_details.createdAt <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$amountSearch = " and total_amount > ".$searchFrom." and total_amount < ".$searchTo."";	
			}
			else
			{
				$amountSearch = " and total_amount > ".$searchFrom." and total_amount < ".$searchTo."";	
			}
		}
		
			$sql_users = "select invoice_series.invoiceNo ,ticket_details.* from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.admin_id = ".$admin_id." and (status = '5' ) ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.admin_id = ".$admin_id." and ( status = '5' )  ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'7',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'ticket'=>$item->getData());
		
	}
	
	public function getPaginatedTicketListForAdmin($limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$startdate=NULL,$enddate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (ticket_details.casher like '%".$keyword."%' or invoice_series.invoiceNo like '%".$keyword."%' or ticket_details.invoiceId like '%".$keyword."%')";	
		}
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			if($search!='')
			{
				$startdate1 = strtotime($startdate);
				$enddate1 = strtotime($enddate);
				$dateSearch = " and  UNIX_TIMESTAMP(ticket_details.createdAt)  > ".$startdate1." and  UNIX_TIMESTAMP(ticket_details.createdAt)  < ". $enddate1 ."";	
			}
			else
			{
				$startdate1 = strtotime($startdate);
				$enddate1 = strtotime($enddate);
				$dateSearch = " and  UNIX_TIMESTAMP(ticket_details.createdAt)  > ".$startdate1." and  UNIX_TIMESTAMP(ticket_details.createdAt)  < ".$enddate1."";	
			}
		}
		
		 $sql_users = "select invoice_series.invoiceNo ,ticket_details.* from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.admin_id = ".Yii::app()->session['adminUser']." and (status = '1' or status = '2' ) ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
		$sql_count = "select count(*) from ticket_details LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) WHERE  ticket_details.admin_id = ".Yii::app()->session['adminUser']." and ( status = '1' or status = '2' ) ".$search." ".$dateSearch." ".$admin_cond."";

		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'10',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'ticket'=>$item->getData());
		
	}
	
	function getTicketDetailWithCustomer($id=NULL)
	{
		$sql = "select c.customer_name,t.* from  ticket_details t LEFT JOIN customers c ON (t.customer_id= c.customer_id) where t.invoiceId = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	function getDailyTotalSalesAmount()
	{
		$sql = "select sum(cashPayment) as cash,sum(cardPayment) as card,sum(creditPayment) as credit,sum(bankPayment) as bank from ticket_details where userId = ".Yii::app()->session['userId']." and shift_id = ".Yii::app()->session['shiftId']." and createdAt like '%".date('Y-m-d')."%'";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getDailyTotalSalesCount()
	{
		$sql = "select count(*) as totalsales from ticket_details where userId = ".Yii::app()->session['userId']." and (status = '1' or status = '2') and createdAt like '%".date('Y-m-d')."%'";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getDailyPendingTotalSalesCount()
	{
		$sql = "select count(*) as totalsales from ticket_details where userId = ".Yii::app()->session['userId']." and status = '0' and createdAt like '%".date('Y-m-d')."%'";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getDailyReturnTotalSalesCount()
	{
		$sql = "select count(*) as totalsales from ticket_details where userId = ".Yii::app()->session['userId']." and status = '2' and createdAt like '%".date('Y-m-d')."%'";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getPendingTicketsByStatus($userId=NULL)
	{
		$sql = "select * from ticket_details where userId = ".$userId." and status = '0'";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getReturnTicketsByUserId($userId=NULL)
	{
		$sql = "select * from ticket_details where userId = ".$userId." and status = '2'";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDailySalesPersonReport($date=NULL,$admin_id=NULL)
	{
		$sql = "select userId,stores.store_name ,casher,sum(total_amount) as Amount,sum(total_item) as Product from ticket_details left join stores ON (stores.store_id=ticket_details.store_id) where ticket_details.createdAt like '%".$date."%' and ticket_details.admin_id = ".$admin_id." and ( ticket_details.status = '1' or ticket_details.status = '2' ) group by ticket_details.userId ;";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDailyCustomerSalesReport($date=NULL,$admin_id=NULL)
	{
		$sql = "select c.customer_name,t.customer_id,sum(t.total_amount) as Amount,sum(t.total_item) as Product from ticket_details t JOIN customers c ON (c.customer_id = t.customer_id ) where t.createdAt like '%".$date."%' and t.admin_id = ".$admin_id." and ( t.status = '1' or t.status = '2' )  group by t.customer_id ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDailyStoreSalesReport($date=NULL,$admin_id=NULL)
	{
		$sql = "select s.store_name,count(invoiceId) as totalInvoices,sum(t.total_amount) as Amount,sum(t.total_item) as Product from ticket_details t LEFT JOIN stores s ON (s.store_id = t.store_id ) where t.createdAt like '%".$date."%' and t.admin_id = ".$admin_id." and ( t.status = '1' or t.status = '2' )  group by t.store_id ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTotalProductReportApi($userId,$date1,$date2,$product_id=NULL)
	{
		if($product_id != NULL || $product_id != "")
		{
		
		$sql = "select invoice_series.invoiceNo ,ticket_desc.*, product.product_name , stores.store_name , ticket_details.invoiceId from ticket_details  LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId )   LEFT JOIN ticket_desc   ON ( ticket_desc.invoiceId = ticket_details.invoiceId ) LEFT JOIN product   ON ( product.product_id = ticket_desc.product_id )  LEFT JOIN stores   ON ( stores.store_id = ticket_desc.store_id )  where ticket_desc.product_id = '".$product_id."' and UNIX_TIMESTAMP(ticket_details.createdAt) >= '".strtotime($date1. ' - 1 days')."'  and  UNIX_TIMESTAMP(ticket_details.createdAt) <= '".strtotime($date2. ' + 1 days') ."' and ticket_details.userId = ".$userId."  and (ticket_details.status = '1' or ticket_details.status = '2' )  ;";	
		
		}
		else 
		{
			$sql = "select invoice_series.invoiceNo ,ticket_desc.*, product.product_name , stores.store_name , ticket_details.invoiceId from ticket_details  LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId )   LEFT JOIN ticket_desc   ON ( ticket_desc.invoiceId = ticket_details.invoiceId ) LEFT JOIN product   ON ( product.product_id = ticket_desc.product_id )  LEFT JOIN stores   ON ( stores.store_id = ticket_desc.store_id ) WHERE UNIX_TIMESTAMP(ticket_details.createdAt) >= '".strtotime($date1. ' - 1 days')."'  and  UNIX_TIMESTAMP(ticket_details.createdAt) <= '".strtotime($date2. ' + 1 days') ."' and ticket_details.userId = ".$userId."  and (ticket_details.status = '1' or ticket_details.status = '2' )  ;";
		}
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTotalAmountReportForApi($userId,$date1,$date2)
	{
		$sql = "select invoice_series.invoiceNo , customers.customer_name , ticket_details.* from ticket_details  LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_details.invoiceId ) LEFT JOIN customers  ON ( customers.customer_id = ticket_details.customer_id ) where  DATE_FORMAT(ticket_details.createdAt,'%Y-%m-%d') >= '".$date1."'  and  DATE_FORMAT(ticket_details.createdAt,'%Y-%m-%d') <= '".$date2."' and ticket_details.userId = ".$userId."  and (ticket_details.status = '1' or ticket_details.status = '2' )  ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	
}