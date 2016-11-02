<?php

/**
 * This is the model class for table "purchase_return_details".
 *
 * The followings are the available columns in table 'purchase_return_details':
 * @property integer $purchase_return_id
 * @property integer $purchase_order_id
 * @property integer $store_id
 * @property integer $supplier_id
 * @property integer $total_return_product
 * @property integer $total_return_amount
 * @property integer $total_return_quantity
 * @property string $tax
 * @property string $shiipping_charge
 * @property string $created
 * @property string $modified
 * @property string $status
 */
class PurchaseReturnDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PurchaseReturnDetails the static model class
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
		return 'purchase_return_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('purchase_order_id, store_id, supplier_id, total_return_product, total_return_amount, total_return_quantity', 'numerical', 'integerOnly'=>true),
			array('tax, shiipping_charge', 'length', 'max'=>50),
			array('status', 'length', 'max'=>1),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('purchase_return_id, purchase_order_id, store_id, supplier_id, total_return_product, total_return_amount, total_return_quantity, tax, shiipping_charge, created, modified, status', 'safe', 'on'=>'search'),
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
			'purchase_return_id' => 'Purchase Return',
			'purchase_order_id' => 'Purchase Order',
			'store_id' => 'Store',
			'supplier_id' => 'Supplier',
			'total_return_product' => 'Total Return Product',
			'total_return_amount' => 'Total Return Amount',
			'total_return_quantity' => 'Total Return Quantity',
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

		$criteria->compare('purchase_return_id',$this->purchase_return_id);
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('total_return_product',$this->total_return_product);
		$criteria->compare('total_return_amount',$this->total_return_amount);
		$criteria->compare('total_return_quantity',$this->total_return_quantity);
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
	
	function getpurchaseReturnData($purchase_return_id=NULL)
	{
		$sql = "select s.store_name,su.supplier_name,p.* from purchase_return_details p LEFT JOIN stores s ON ( s.store_id = p.store_id ) LEFT JOIN supplier su ON ( su.supplier_id = p.supplier_id ) where p.purchase_return_id = ".$purchase_return_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	public function getTotalQuatityCountOfProductForPurchaseReturn($product_id = NULL )
	{
		$sql = "select sum(quantity) as totalPurchaseReturnQuantity from purchase_return_details LEFT JOIN purchase_return ON (purchase_return.purchase_return_id = purchase_return_details.purchase_return_id ) WHERE purchase_return.product_id = ".$product_id ;
			
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
}