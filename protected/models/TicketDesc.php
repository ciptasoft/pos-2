<?php

/**
 * This is the model class for table "ticket_desc".
 *
 * The followings are the available columns in table 'ticket_desc':
 * @property integer $id
 * @property integer $invoiceId
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $discount
 * @property integer $product_total
 * @property string $date_add
 */
class TicketDesc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TicketDesc the static model class
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
		return 'ticket_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('invoiceId, product_id, quantity, discount, product_total', 'numerical', 'integerOnly'=>true),
			//array('date_add', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, invoiceId, product_id, quantity, discount, product_total, date_add', 'safe', 'on'=>'search'),
		);
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
			'id' => 'ID',
			'invoiceId' => 'Invoice',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
			'discount' => 'Discount',
			'product_total' => 'Product Total',
			'date_add' => 'Date Add',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('invoiceId',$this->invoiceId);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('product_total',$this->product_total);
		$criteria->compare('date_add',$this->date_add,true);

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
	
	function checkTicket($invoiceId,$productId)
	{
		$sql_users = "select * from ticket_desc where invoiceId='".$invoiceId."' and product_id= '".$productId."'";
		$result	=	Yii::app()->db->createCommand($sql_users)->queryRow();
		return $result;
	}
	
		
	function getTickets($id=NULL)
	{
		$sql = "select p.product_name,p.product_price,td.* from ticket_desc td,product p where p.product_id = td.product_id and td.invoiceId = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTicketsData($id=NULL)
	{
		$sql = "select p.*,td.*,td.quantity as quantityForProduct  from ticket_desc td,product p where p.product_id = td.product_id and td.invoiceId = '".$id."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTicketsDataForSalesReturn($id=NULL)
	{
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
		$store_id = $userData->store_id ;
		
		$sql = "select p.*,td.*,td.quantity as quantityForProduct  from ticket_desc td,product p where p.product_id = td.product_id and td.invoiceId = '".$id."' and td.store_id = '".$store_id."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTicketsDataForSalesReturnForapi($id=NULL,$userId)
	{
		$userData=Users::model()->findbyPk($userId);
		$store_id = $userData->store_id ;
		
		$sql = "select p.product_name,p.product_image,s.store_name,td.*,td.quantity as quantityForProduct  from ticket_desc td left join product p on  p.product_id = td.product_id left join stores s on s.store_id = td.store_id where td.invoiceId = '".$id."' ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTicketsDataforApi($id=NULL)
	{
		$sql = "select s.store_name,p.*,td.*,td.quantity as quantityForProduct  from ticket_desc td LEFT JOIN product p ON ( p.product_id = td.product_id ) LEFT JOIN stores s ON ( s.store_id = td.store_id ) where td.invoiceId = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTicketbyInvoiceId($invoiceId=NULL)
	{
		$sql = "select product_id from ticket_desc where invoiceId = ".$invoiceId.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	} 
	
	function deleteRecord($invoiceId=NULL,$productId=NULL)
	{
		$sql = "delete from ticket_desc where invoiceId = ".$invoiceId." and product_id = ".$productId.";";	
		$result	= Yii::app()->db->createCommand($sql)->query();
		//return $result;
	} 
	
	function deletebyInvoiceId($invoiceId=NULL)
	{
		$sql = "delete from ticket_desc where invoiceId = ".$invoiceId."";	
		$result	= Yii::app()->db->createCommand($sql)->query();
		//return $result;
	} 
	
	function getTotalProduct($invoiceId=NULL)
	{
		$sql = "select count(product_id) from ticket_desc where invoiceId = ".$invoiceId.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	} 
	
	function getDailyProductReport($date=NULL,$admin_id=NULL)
	{
		$sql = "select product.product_name,ticket_desc.product_id,sum(ticket_desc.product_total) as Amount,sum(ticket_desc.quantity) as Quantity from ticket_desc LEFT JOIN product ON (product.product_id = ticket_desc.product_id ) where ticket_desc.date_add like '%".$date."%' and ticket_desc.admin_id = ".$admin_id." group by ticket_desc.product_id;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTotalProductReportForApi($userId,$date1,$date2)
	{
		$sql = "select * from ticket_details where createdAt > '".$date1."' and createdAt < '".$date2."' and userId = ".$userId."  and ( status = '1' or status = '2' )  ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getProductReportForApi($userId,$date1,$date2)
	{
		$sql = "select product.product_name,ticket_desc.product_id,sum(ticket_desc.product_total) as Amount,sum(ticket_desc.quantity) as Quantity from ticket_desc LEFT JOIN product ON (product.product_id = ticket_desc.product_id ) LEFT JOIN ticket_details ON (ticket_details.invoiceId = ticket_desc.invoiceId )  where  DATE_FORMAT(ticket_desc.date_add,'%Y-%m-%d') >= '".$date1."'  and  DATE_FORMAT(ticket_desc.date_add,'%Y-%m-%d') <= '".$date2."' and ticket_details.userId = '".$userId."'  group by ticket_desc.product_id order by product.product_name asc ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function getPaginatedTicketListForProduct($product_id = NULL ,$limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(ticket_details.createdAt,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (ticket_details.casher like '%".$keyword."%' or invoice_series.invoiceNo like '%".$keyword."%')";	
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
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and ticket_details.createdAt >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and ticket_details.createdAt <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
			$sql_users = "select invoice_series.invoiceNo ,ticket_details.* ,ticket_desc.* from ticket_desc LEFT JOIN ticket_details  ON ( ticket_details.invoiceId = ticket_desc.invoiceId ) LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_desc.invoiceId ) WHERE  ticket_details.userId = ".Yii::app()->session['userId']." and (ticket_details.status = '1' or ticket_details.status = '2' or ticket_details.status = '5' ) and ticket_desc.product_id = ".$product_id." ".$search." ".$todaysearch."  ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
			$sql_count = "select count(*) from ticket_desc LEFT JOIN ticket_details  ON ( ticket_details.invoiceId = ticket_desc.invoiceId ) LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_desc.invoiceId ) WHERE  ticket_details.userId = ".Yii::app()->session['userId']." and (ticket_details.status = '1' or ticket_details.status = '2' or ticket_details.status = '5' ) and ticket_desc.product_id = ".$product_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
		
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
	
	public function getTotalQuatityCountOfProductForSales($product_id = NULL )
	{
		$sql = "select sum(quantity) as totalQuantity from ticket_details LEFT JOIN ticket_desc ON  (ticket_desc.invoiceId =  ticket_details.invoiceId )    WHERE  (ticket_details.status = '1' or ticket_details.status = '5') and ticket_desc.product_id = ".$product_id ;
			
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	
	
	public function getPaginatedTicketListForProductInAdmin($product_id = NULL ,$limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(ticket_details.createdAt,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (ticket_details.casher like '%".$keyword."%' or invoice_series.invoiceNo like '%".$keyword."%')";	
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
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and ticket_details.createdAt >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and ticket_details.createdAt <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
			$sql_users = "select invoice_series.invoiceNo ,ticket_details.* ,ticket_desc.* from ticket_desc LEFT JOIN ticket_details  ON ( ticket_details.invoiceId = ticket_desc.invoiceId ) LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_desc.invoiceId ) WHERE  (ticket_details.status = '1' or ticket_details.status = '2' or ticket_details.status = '5' ) and ticket_desc.product_id = ".$product_id." ".$search." ".$todaysearch."  ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
			$sql_count = "select count(*) from ticket_desc LEFT JOIN ticket_details  ON ( ticket_details.invoiceId = ticket_desc.invoiceId ) LEFT JOIN invoice_series  ON ( invoice_series.invoiceId = ticket_desc.invoiceId ) WHERE (ticket_details.status = '1' or ticket_details.status = '2' or ticket_details.status = '5' ) and ticket_desc.product_id = ".$product_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
		
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
}