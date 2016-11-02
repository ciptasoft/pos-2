<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
 * @property integer $employee_id
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property integer $contact_no
 * @property string $joining_date
 * @property string $created_date
 * @property string $modified_date
 * @property string $login_date
 * @property integer $salary
 * @property string $status
 */
class Employees extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employees the static model class
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
		return 'employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		/*// will receive user inputs.
		return array(
			array('contact_no, salary', 'numerical', 'integerOnly'=>true),
			array('firstName, lastName, email', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('joining_date, created_date, modified_date, login_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employee_id, firstName, lastName, email, contact_no, joining_date, created_date, modified_date, login_date, salary, status', 'safe', 'on'=>'search'),
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
			'employee_id' => 'Employee',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
			'email' => 'Email',
			'contact_no' => 'Contact No',
			'joining_date' => 'Joining Date',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
			'login_date' => 'Login Date',
			'salary' => 'Salary',
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

		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact_no',$this->contact_no);
		$criteria->compare('joining_date',$this->joining_date,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('login_date',$this->login_date,true);
		$criteria->compare('salary',$this->salary);
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
	
	public function getAllPaginatedEmployee($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where (firstName like '%".$keyword."%' or lastName like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " where created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		
		if(Yii::app()->session['type']==2)
		{
			if($search == NULL && $dateSearch == NULL){ 
				$admin_cond = "where admin_id = ".Yii::app()->session['adminUser']." ";
			}else{
				$admin_cond = "and admin_id = ".Yii::app()->session['adminUser']." ";
			}
			$sql_users = "select * from employees ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
		 	$sql_count = "select count(*) from employees ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 $sql_users = "select * from employees ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from employees ".$search." ".$dateSearch."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'employees'=>$item->getData());
	}
	
	function getEmployeeDetails($id=NULL)
	{
		$result =array();
		if($id!='')
		{
			$condition='employee_id=:employee_id';
			$params=array(':employee_id'=>$id);
			
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->where($condition,$params)
			->queryRow();
		}
		
		return $result;
		
	}
	
	function deleteEmployee($id)
	{
		$employeeObj=Employees::model()->findByPk($id);
		if(is_object($employeeObj))
		{
			$employeeObj->delete();
		}
	}
}