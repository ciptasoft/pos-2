<?php

/**
 * This is the model class for table "sales_return_details".
 *
 * The followings are the available columns in table 'sales_return_details':
 * @property integer $sales_return_invoiceId
 * @property integer $return_customer_id
 * @property string $return_casher
 * @property integer $return_total_item
 * @property integer $return_total_amount
 * @property integer $return_total_quantity
 * @property integer $return_discount
 * @property string $return_createdAt
 * @property string $modifiedAt
 */
class SalesReturnDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SalesReturnDetails the static model class
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
		return 'sales_return_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('return_customer_id, return_total_item, return_total_amount, return_total_quantity, return_discount', 'numerical', 'integerOnly'=>true),
			array('return_casher', 'length', 'max'=>255),
			array('return_createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sales_return_invoiceId, return_customer_id, return_casher, return_total_item, return_total_amount, return_total_quantity, return_discount, return_createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'sales_return_invoiceId' => 'Sales Return Invoice',
			'return_customer_id' => 'Return Customer',
			'return_casher' => 'Return Casher',
			'return_total_item' => 'Return Total Item',
			'return_total_amount' => 'Return Total Amount',
			'return_total_quantity' => 'Return Total Quantity',
			'return_discount' => 'Return Discount',
			'return_createdAt' => 'Return Created At',
			'modifiedAt' => 'Modified At',
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

		$criteria->compare('sales_return_invoiceId',$this->sales_return_invoiceId);
		$criteria->compare('return_customer_id',$this->return_customer_id);
		$criteria->compare('return_casher',$this->return_casher,true);
		$criteria->compare('return_total_item',$this->return_total_item);
		$criteria->compare('return_total_amount',$this->return_total_amount);
		$criteria->compare('return_total_quantity',$this->return_total_quantity);
		$criteria->compare('return_discount',$this->return_discount);
		$criteria->compare('return_createdAt',$this->return_createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);

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
		$sql = "select sales_return_invoiceId from sales_return_details order by sales_return_invoiceId desc";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getReturnTicketDetails($invoiceId)
	{
		$sql = "SELECT * FROM sales_return_details WHERE sales_return_invoiceId = ".$invoiceId." ";	
		$result	= Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function getPaginatedReturnTicketList($limit=10,$sortType="desc",$sortBy="sales_return_invoiceId",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(sales_return_details.return_createdAt,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (return_casher like '%".$keyword."%' or sales_return_invoiceId like '%".$keyword."%')";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$amountSearch = " and return_total_amount > ".$searchFrom." and return_total_amount < ".$searchTo."";	
			}
			else
			{
				$amountSearch = " and return_total_amount > ".$searchFrom." and return_total_amount < ".$searchTo."";	
			}
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and sales_return_details.return_createdAt >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and sales_return_details.return_createdAt <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
		    $sql_users = "select * from sales_return_details  where userId = ".Yii::app()->session['userId']." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from sales_return_details  where userId = ".Yii::app()->session['userId']."   ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch."";
		
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
	
	function getDailyTotalSalesReturnAmount()
	{
		$sql = "select sum(return_total_amount) as returnAmount from sales_return_details where userId = ".Yii::app()->session['userId']." and shift_id = ".Yii::app()->session['shiftId']." and return_createdAt like '%".date('Y-m-d')."%'
";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}

	
	function getReturnTicketDetailWithCustomer($id=NULL)
	{
		$sql = "select c.customer_name,t.* from  sales_return_details t LEFT JOIN customers c ON (t.return_customer_id= c.customer_id) where t.sales_return_invoiceId = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	function deleteTicket($invoiceId)
	{
		$sql = "delete from sales_return_details where sales_return_invoiceId = ".$invoiceId.";";	
		$result	= Yii::app()->db->createCommand($sql)->query();
	}

}