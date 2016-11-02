<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property integer $id
 * @property string $firstName
 * @property string $lastName
 * @property string $cust_address
 * @property string $cust_category
 * @property string $email
 * @property string $contact_no
 * @property integer $reward_point
 * @property integer $total_purchase
 * @property string $createdAt
 * @property string $modifiedAt
 * @property string $status
 */
class Customers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customers the static model class
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
		return 'customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('id', 'required'),
			array('id, reward_point, total_purchase', 'numerical', 'integerOnly'=>true),
			array('firstName, lastName, cust_address, email, contact_no', 'length', 'max'=>255),
			array('cust_category, status', 'length', 'max'=>1),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstName, lastName, cust_address, cust_category, email, contact_no, reward_point, total_purchase, createdAt, modifiedAt, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
			'cust_address' => 'Cust Address',
			'email' => 'Email',
			'contact_no' => 'Contact No',
			'reward_point' => 'Reward Point',
			'total_purchase' => 'Total Purchase',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('cust_address',$this->cust_address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact_no',$this->contact_no,true);
		$criteria->compare('reward_point',$this->reward_point);
		$criteria->compare('total_purchase',$this->total_purchase);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
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
	
	public function getPaginatedCustomerList($limit=5,$sortType="desc",$sortBy="customer_id",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (customer_name like '%".$keyword."%')";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and credit-debit > ".$searchFrom." and credit-debit < ".$searchTo."";	
			}
			else
			{
				$dateSearch = " and credit-debit > ".$searchFrom." and credit-debit < ".$searchTo."";	
			}
		}
			$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			$admin_id = $userData->admin_id ;
		
			$sql_users = "select * from customers where admin_id = ".$admin_id." ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from customers where admin_id = ".$admin_id." ".$search." ".$dateSearch."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		
		return array('pagination'=>$item->pagination, 'customers'=>$item->getData());			
	}
	
	public function getPaginatedCustomerListForAdmin($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (customer_name like '%".$keyword."%')";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and createdAt > ".$searchFrom." and createdAt < ".$searchTo."";	
			}
			else
			{
				$dateSearch = " and createdAt > ".$searchFrom." and createdAt < ".$searchTo."";	
			}
		}
		
		$sql_users = "select * from customers where admin_id = ".Yii::app()->session['adminUser']." ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		$sql_count = "select count(*) from customers where admin_id = ".Yii::app()->session['adminUser']." ".$search." ".$dateSearch."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		
		return array('pagination'=>$item->pagination, 'customers'=>$item->getData());			
	}
	
	function getCustomerDetails($id=NULL)
	{
		$result =array();
		if($id!='')
		{
			$condition='customer_id=:customer_id';
			$params=array(':customer_id'=>$id);
			
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->where($condition,$params)
			->queryRow();
		}
		
		return $result;
		
	}
	
	function getAllCustomerList($id=NULL)
	{
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from($this->tableName())
		->queryAll();
		
		return $result;
	}
	
	function getAllCustomerListForAdmin($admin_id=NULL)
	{
		$sql = "select * from customers  where admin_id = ".$admin_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function deleteCustomer($id)
	{
		$customerObj=Customers::model()->findByPk($id);
		if(is_object($customerObj))
		{
			$customerObj->delete();
		}
	}
	
	function getCustomersforQueryLog()
	{
		$sql = "select * from customers ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function updateCustomer($customer_id,$credit,$debit,$modifiedAt)
	{
		$sql = "UPDATE customers SET credit = credit + ".$credit." , debit = debit + ".$debit." , modifiedAt= '".$modifiedAt."'  where customer_id= ".$customer_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function updateCustomerCredit($customer_id,$credit,$modifiedAt)
	{
		$sql = "UPDATE customers SET credit = credit + ".$credit." , modifiedAt= '".$modifiedAt."'  where customer_id= ".$customer_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
}