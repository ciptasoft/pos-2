<?php

/**
 * This is the model class for table "inter_store_adjust_entry".
 *
 * The followings are the available columns in table 'inter_store_adjust_entry':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $product_id
 * @property integer $from_store_id
 * @property integer $to_store_id
 * @property integer $quantity
 * @property string $created
 * @property string $modified
 */
class InterStoreAdjustEntry extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InterStoreAdjustEntry the static model class
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
		return 'inter_store_adjust_entry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('admin_id, product_id, from_store_id, to_store_id, quantity', 'numerical', 'integerOnly'=>true),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, admin_id, product_id, from_store_id, to_store_id, quantity, created, modified', 'safe', 'on'=>'search'),
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
			'admin_id' => 'Admin',
			'product_id' => 'Product',
			'from_store_id' => 'From Store',
			'to_store_id' => 'To Store',
			'quantity' => 'Quantity',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('from_store_id',$this->from_store_id);
		$criteria->compare('to_store_id',$this->to_store_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

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
	
	public function getAllPaginatedInterStoreageAdmin($limit=5,$sortType="asc",$sortBy="",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where (product.product_name like '%".$keyword."%' or inter_store_adjust_entry.from_store_id like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and inter_store_adjust_entry.created > '".date("Y-m-d",strtotime($startDate))."' and inter_store_adjust_entry.created < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " where inter_store_adjust_entry.created > '".date("Y-m-d",strtotime($startDate))."' and inter_store_adjust_entry.created < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		
		if($search == NULL && $dateSearch == NULL){ 
			$admin_cond = "where inter_store_adjust_entry.admin_id = ".Yii::app()->session['adminUser']."";
		}else{
			$admin_cond = "and inter_store_adjust_entry.admin_id = ".Yii::app()->session['adminUser']."";
		}
			$sql_users = "select product.product_name, stores.store_name as fromStore, (select store_name from stores where store_id = inter_store_adjust_entry.to_store_id ) as toStore, inter_store_adjust_entry.*  from inter_store_adjust_entry LEFT JOIN product  ON ( product.product_id = inter_store_adjust_entry.product_id ) LEFT JOIN stores  ON ( stores.store_id = inter_store_adjust_entry.from_store_id ) ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from inter_store_adjust_entry LEFT JOIN product  ON ( product.product_id = inter_store_adjust_entry.product_id ) LEFT JOIN stores  ON ( stores.store_id = inter_store_adjust_entry.from_store_id )   ".$search." ".$dateSearch." ".$admin_cond."";
			
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'listing'=>$item->getData());
	}
	
	function deleteIntraStoreEntry($id)
	{
		$intraStoreObj=InterStoreAdjustEntry::model()->findByPk($id);
		if(is_object($intraStoreObj))
		{
			$intraStoreObj->delete();
		}
	}

}