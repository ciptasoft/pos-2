<?php

/**
 * This is the model class for table "stores".
 *
 * The followings are the available columns in table 'stores':
 * @property integer $store_id
 * @property string $store_name
 * @property string $created_date
 * @property string $modified_date
 * @property string $city
 * @property string $status
 */
class Stores extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Stores the static model class
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
		return 'stores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('store_name, created_date, modified_date, city, status', 'required'),
			array('store_name, city', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('store_id, store_name, created_date, modified_date, city, status', 'safe', 'on'=>'search'),*/
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
			'store_id' => 'Store',
			'store_name' => 'Store Name',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
			'city' => 'City',
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

		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('store_name',$this->store_name,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	// set the store data
	function setData($data)
	{
		$this->data = $data;
	}
	
	// insert the store
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
	
	public function getAllPaginatedStore($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where (store_name like '%".$keyword."%')";	
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
			$sql_users = "select * from stores ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
		 	$sql_count = "select count(*) from stores ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 $sql_users = "select * from stores ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from stores ".$search." ".$dateSearch."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'stores'=>$item->getData());
		
	}
	
	function getStoreDetails($id=NULL)
	{
		$result =array();
		if($id!='')
		{
			$condition='store_id=:store_id';
			$params=array(':store_id'=>$id);
			
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->where($condition,$params)
			->queryRow();
		}
		
		return $result;
		
	}
	
	function deleteStore($id)
	{
		$storeObj=Stores::model()->findByPk($id);
		if(is_object($storeObj))
		{
			$storeObj->delete();
		}
	}
	
	function getAllStoreList()
	{
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->queryAll();
		return $result;
	}
	
	function getStoreDropdown($id=NULL)
	{
		$condition='admin_id=:admin_id';
		$params=array(':admin_id'=>$id);
		
		$result = Yii::app()->db->createCommand()
		->select("store_id,store_name")
		->from($this->tableName())
		->where($condition,$params)
        ->queryAll();
			
		return $result;	
	}
	
	function getClientStoreList($id=NULL)
	{
		$result =array();
		if($id!='')
		{
			$condition='admin_id=:admin_id';
			$params=array(':admin_id'=>$id);
			
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->where($condition,$params)
			->queryAll();
		}
		return $result;
		
	}
	
	function getAllStoreListforapi($admin_id=NULL)
	{
		$sql = "select * from stores  where admin_id = ".$admin_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
}