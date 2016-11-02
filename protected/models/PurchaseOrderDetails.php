<?php

/**
 * This is the model class for table "purchase_order_details".
 *
 * The followings are the available columns in table 'purchase_order_details':
 * @property integer $puchase_order_id
 * @property integer $total_product
 * @property integer $total_amount
 * @property integer $total_quantity
 * @property string $tax
 * @property string $shiipping_charge
 * @property string $created
 * @property string $modified
 * @property string $status
 */
class PurchaseOrderDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PurchaseOrderDetails the static model class
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
		return 'purchase_order_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total_product, total_amount, total_quantity', 'numerical', 'integerOnly'=>true),
			array('tax, shiipping_charge', 'length', 'max'=>50),
			array('status', 'length', 'max'=>1),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('puchase_order_id, total_product, total_amount, total_quantity, tax, shiipping_charge, created, modified, status', 'safe', 'on'=>'search'),
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
			'puchase_order_id' => 'Puchase Order',
			'total_product' => 'Total Product',
			'total_amount' => 'Total Amount',
			'total_quantity' => 'Total Quantity',
			'tax' => 'Tax',
			'shiipping_charge' => 'Shiipping Charge',
			'created' => 'Created',
			'modified' => 'Modified',
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

		$criteria->compare('puchase_order_id',$this->puchase_order_id);
		$criteria->compare('total_product',$this->total_product);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('total_quantity',$this->total_quantity);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('shiipping_charge',$this->shiipping_charge,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
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
	
	function getpurchaseOrderData($purchase_order_id=NULL)
	{
		$sql = "select s.store_name,su.supplier_name,p.* from purchase_order_details p LEFT JOIN stores s ON ( s.store_id = p.store_id ) LEFT JOIN supplier su ON ( su.supplier_id = p.supplier_id ) where p.purchase_order_id = ".$purchase_order_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	function getpurchaseOrderDataByAdmin($purchase_order_id=NULL)
	{
		$sql = "select s.store_name,su.supplier_name,p.* from purchase_order_details p LEFT JOIN stores s ON ( s.store_id = p.store_id ) LEFT JOIN supplier su ON ( su.supplier_id = p.supplier_id ) where p.purchase_order_id = ".$purchase_order_id." and p.admin_id = ".Yii::app()->session['adminUser'].";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	public function getAllPaginatedPurchase($limit=10,$sortType="desc",$sortBy="store_name",$keyword=NULL,$startdate=NULL,$enddate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (s.store_name like '%".$keyword."%' or su.supplier_name like '%".$keyword."%')";	
		}
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$startdate1 = strtotime($startdate);
			$enddate1 = strtotime($enddate);
			if($search!='')
			{
				$dateSearch = " and UNIX_TIMESTAMP(g.created) > ".$startdate1." and UNIX_TIMESTAMP(g.created) < ".$enddate1."";	
			}
			else
			{
				$dateSearch = " and UNIX_TIMESTAMP(g.created) > ".$startdate1." and UNIX_TIMESTAMP(g.created) < ".$enddate1."";	
			}
		}
		
		$sql_users = "select s.store_name,su.supplier_name, g.* from purchase_order_details g LEFT JOIN stores s ON ( s.store_id = g.store_id ) LEFT JOIN supplier su ON ( su.supplier_id = g.supplier_id ) WHERE  g.admin_id = ".Yii::app()->session['adminUser']. $search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		$sql_count = "select count(*) from purchase_order_details g LEFT JOIN stores s ON ( s.store_id = g.store_id ) LEFT JOIN supplier su ON ( su.supplier_id = g.supplier_id ) WHERE  g.admin_id = ".Yii::app()->session['adminUser']. $search." ".$dateSearch." order by ".$sortBy." ".$sortType."";

		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'10',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'purchase'=>$item->getData());
		
	}
	
	function getStorePurchaseReport($admin_id=NULL)
	{
		$sql = "select s.store_name,su.supplier_name,count(p.purchase_order_id) as totalOrder,sum(p.total_product) as totalProduct ,sum(p.total_amount) as totalAmount from purchase_order_details p LEFT JOIN stores s ON (s.store_id = p.store_id )  LEFT JOIN supplier su ON (su.supplier_id = p.supplier_id ) where p.admin_id = ".$admin_id." group by p.store_id ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function getPaginatedPOListForSupplier($supplier_id = NULL ,$limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		if(isset($todayDate) && $todayDate != NULL )
		{
			$todaysearch = " and DATE_FORMAT(purchase_order_details.created,'%d-%m-%Y') = '".$todayDate."' ";	
		}
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (purchase_order_details.total_amount like '%".$keyword."%' or purchase_order_details.total_product like '%".$keyword."%')";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$amountSearch = " and purchase_order_details.total_amount > ".$searchFrom." and purchase_order_details.total_amount < ".$searchTo."";	
			}
			else
			{
				$amountSearch = " and purchase_order_details.total_amount > ".$searchFrom." and purchase_order_details.total_amount < ".$searchTo."";	
			}
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and purchase_order_details.created >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and purchase_order_details.created <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}
		
			$sql_users = "select stores.store_name , purchase_order_details.* from purchase_order_details LEFT JOIN stores ON (stores.store_id = purchase_order_details.store_id) WHERE  purchase_order_details.supplier_id = ".$supplier_id." ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from purchase_order_details  WHERE  purchase_order_details.supplier_id = ".$supplier_id."  ".$search." ".$todaysearch." ".$amountSearch." ".$dateSearch."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'7',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'purchaseOrders'=>$item->getData());
		
	}
	
	function getPurchaseDetail($id=NULL)
	{
		$sql = "select s.supplier_name,sr.store_name,p.* from  purchase_order_details p LEFT JOIN supplier s ON ( s.supplier_id = p.supplier_id )  LEFT JOIN stores sr ON ( sr.store_id = p.store_id ) where p.purchase_order_id = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
}