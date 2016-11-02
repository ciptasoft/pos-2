<?php

/**
 * This is the model class for table "general_entry".
 *
 * The followings are the available columns in table 'general_entry':
 * @property integer $general_id
 * @property string $account
 * @property integer $credit
 * @property integer $debit
 * @property string $created
 * @property string $modified
 */
class GeneralEntry extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeneralEntry the static model class
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
		return 'general_entry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('credit, debit', 'numerical', 'integerOnly'=>true),
			array('account', 'length', 'max'=>100),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('general_id, account, credit, debit, created, modified', 'safe', 'on'=>'search'),
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
			'general_id' => 'General',
			'account' => 'Account',
			'credit' => 'Credit',
			'debit' => 'Debit',
			'created' => 'Created',
			'modified' => 'Modified',
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

		$criteria->compare('general_id',$this->general_id);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

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
	
	public function getAllPaginatedEntries($limit=10,$sortType="desc",$sortBy="store_name",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (store_name like '%".$keyword."%')";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and credit > ".$searchFrom." and credit < ".$searchTo."";	
			}
			else
			{
				$dateSearch = " and credit > ".$searchFrom." and credit < ".$searchTo."";	
			}
		}
		
		$sql_users = "select s.store_name, g.* from general_entry g LEFT JOIN stores s ON ( s.store_id = g.store_id ) WHERE  g.admin_id = ".Yii::app()->session['adminUser']. $search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		$sql_count = "select count(*) from general_entry g LEFT JOIN stores s ON ( s.store_id = g.store_id ) WHERE  g.admin_id = ".Yii::app()->session['adminUser']. $search." ".$dateSearch." order by ".$sortBy." ".$sortType."";

		
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
	
	public function getPaginatedGeneralEntryForOther($store_id,$limit=10,$sortType="desc",$sortBy="general_id",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(created,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$amountSearch = " and credit > ".$searchFrom." and credit < ".$searchTo."";	
			}
			else
			{
				$amountSearch = " and credit > ".$searchFrom." and credit < ".$searchTo."";	
			}
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and created >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and created <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
			$sql_users = "select * from general_entry  WHERE  store_id = ".$store_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from general_entry WHERE  store_id = ".$store_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch."";
		
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
	
	function getStoreAccountReport($admin_id=NULL)
	{
		$sql = "select s.store_name,sum(g.credit) as totalCredit,sum(g.debit) as totalDebit from general_entry g LEFT JOIN stores s ON (s.store_id = g.store_id ) where g.admin_id = ".$admin_id." group by g.store_id ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
}