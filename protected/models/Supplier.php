<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $supplier_id
 * @property string $supplier_name
 * @property integer $product_id
 * @property string $email
 * @property integer $contact_no
 * @property string $address
 * @property string $created_date
 * @property string $modified_date
 * @property string $status
 */
class Supplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Supplier the static model class
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
		return 'supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('product_id, contact_no', 'numerical', 'integerOnly'=>true),
			array('supplier_name, email, address', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('supplier_id, supplier_name, product_id, email, contact_no, address, created_date, modified_date, status', 'safe', 'on'=>'search'),
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
			'supplier_id' => 'Supplier',
			'supplier_name' => 'Supplier Name',
			'product_id' => 'Product',
			'email' => 'Email',
			'contact_no' => 'Contact No',
			'address' => 'Address',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
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

		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_name',$this->supplier_name,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact_no',$this->contact_no);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('status',$this->status,true);

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
	  
	public function getAllPaginatedSupplier($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where (supplier_name like '%".$keyword."%')";	
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
			$sql_users = "select * from supplier ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
		 	$sql_count = "select count(*) from supplier ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 $sql_users = "select * from supplier ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from supplier ".$search." ".$dateSearch."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'supplier'=>$item->getData());
	}
	
	public function getPaginatedSupplierList($limit=5,$sortType="desc",$sortBy="supplier_id",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (supplier_name like '%".$keyword."%')";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and credit - debit >= ".$searchFrom." and credit - debit <= ".$searchTo."";	
			}
			else
			{
				$dateSearch = " and credit - debit >= ".$searchFrom." and credit - debit <= ".$searchTo."";	
			}
		}
			$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			$admin_id = $userData->admin_id ;
		
			$sql_users = "select * from supplier where admin_id = ".$admin_id." ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from supplier where admin_id = ".$admin_id." ".$search." ".$dateSearch."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		
		return array('pagination'=>$item->pagination, 'suppliers'=>$item->getData());			
	}
	
	function getSupplierDetails($id=NULL)
	{
		$result =array();
		if($id!='')
		{
			$condition='supplier_id=:supplier_id';
			$params=array(':supplier_id'=>$id);
			
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->where($condition,$params)
			->queryRow();
		}
		
		return $result;
		
	}
	
	function getSupplierDropdown($id=NULL)
	{
		$condition='admin_id=:admin_id';
		$params=array(':admin_id'=>$id);
			
		$result = Yii::app()->db->createCommand()
		->select("supplier_id,supplier_name")
		->from($this->tableName())
		->where($condition,$params)
        ->queryAll();
			
		return $result;	
	}
	
	function deleteSupplier($id)
	{
		$supplierObj=Supplier::model()->findByPk($id);
		if(is_object($supplierObj))
		{
			$supplierObj->delete();
		}
	}
	
	function updateSupplierDebit($supplier_id,$debit,$modified)
	{
		$sql = "UPDATE supplier SET debit = debit + ".$debit." , modified_date = '".$modified."'  where supplier_id= ".$supplier_id." ;";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function getAllSupplierListForAdmin($admin_id=NULL)
	{
		$sql = "select * from supplier  where admin_id = ".$admin_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function updateSupplier($supplier_id,$credit,$debit,$modified_date)
	{
		$sql = "UPDATE supplier SET credit = credit + ".$credit." , debit = debit + ".$debit." , modified_date= '".$modifiedAt."'  where supplier_id= ".$supplier_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
}