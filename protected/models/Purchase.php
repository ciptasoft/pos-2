<?php

/**
 * This is the model class for table "purchase".
 *
 * The followings are the available columns in table 'purchase':
 * @property integer $id
 * @property integer $store_id
 * @property integer $user_id
 * @property string $quantity
 * @property string $productName
 * @property string $amount
 * @property string $createdAt
 */
class Purchase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Purchase the static model class
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
		return 'purchase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('store_id, user_id, quantity, productName, amount, createdAt', 'required'),
			array('store_id, user_id', 'numerical', 'integerOnly'=>true),
			array('quantity, productName, amount', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, store_id, user_id, quantity, productName, amount, createdAt', 'safe', 'on'=>'search'),*/
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
			'id' => 'ID',
			'store_id' => 'Store',
			'user_id' => 'User',
			'quantity' => 'Quantity',
			'productName' => 'Product Name',
			'amount' => 'Amount',
			'createdAt' => 'Created At',
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
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('productName',$this->productName,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('createdAt',$this->createdAt,true);

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
	
	public function getTotalQuatityCountOfProductForPurchase($product_id = NULL )
	{
		$sql = "select sum(quantity) as totalPurchaseQuantity from purchase_order_details LEFT JOIN purchase ON  (purchase.purchase_order_id =  purchase_order_details.purchase_order_id )    WHERE purchase.product_id  = ".$product_id ;
			
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getpurchaseDetails($purchase_order_id=NULL)
	{
		$sql = "select p.product_name,p.product_desc,pu.* from purchase pu , product p where p.product_id = pu.product_id and pu.purchase_order_id = ".$purchase_order_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getProductPurchaseReport($admin_id=NULL)
	{
		$sql = "select pr.product_name , sum(p.quantity) as totalQuantity ,sum(p.amount) as totalAmount from purchase p LEFT JOIN product pr ON (pr.product_id = p.product_id ) where p.admin_id = ".$admin_id." group by p.product_id ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}

}