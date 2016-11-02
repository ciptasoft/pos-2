<?php

/**
 * This is the model class for table "customer_general_entry".
 *
 * The followings are the available columns in table 'customer_general_entry':
 * @property integer $id
 * @property integer $customer_id
 * @property integer $credit
 * @property integer $debit
 * @property integer $paymentType
 * @property string $createdAt
 * @property string $modifiedAt
 */
class CustomerGeneralEntry extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CustomerGeneralEntry the static model class
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
		return 'customer_general_entry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('customer_id, credit, debit, paymentType', 'numerical', 'integerOnly'=>true),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer_id, credit, debit, paymentType, createdAt, modifiedAt', 'safe', 'on'=>'search'),
		*/);
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
			'customer_id' => 'Customer',
			'credit' => 'Credit',
			'debit' => 'Debit',
			'paymentType' => 'Payment Type',
			'createdAt' => 'Created At',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('paymentType',$this->paymentType);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
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
	
	public function getPaginatedGeneralEntryForCustomer($customer_id,$limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(customer_general_entry.createdAt,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$amountSearch = " and customer_general_entry.credit > ".$searchFrom." and customer_general_entry.credit < ".$searchTo."";	
			}
			else
			{
				$amountSearch = " and customer_general_entry.credit > ".$searchFrom." and customer_general_entry.credit < ".$searchTo."";	
			}
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and customer_general_entry.createdAt >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and customer_general_entry.createdAt <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
			$sql_users = "select customers.customer_name ,customer_general_entry.* from customer_general_entry LEFT JOIN customers  ON ( customers.customer_id = customer_general_entry.customer_id ) WHERE  customer_general_entry.customer_id = ".$customer_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from customer_general_entry LEFT JOIN customers  ON ( customers.customer_id = customer_general_entry.customer_id ) WHERE  customer_general_entry.customer_id = ".$customer_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'7',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'generalEntryCustomer'=>$item->getData());
		
	}
	
	function getDailyAccount($admin_id,$store_id)
	{
		$sql = "select sum(credit) as credit,sum(debit) as debit from customer_general_entry where admin_id = ".$admin_id ." and store_id = ".$store_id." and createdAt like '%".date('Y-m-d')."%'";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
}