<?php

/**
 * This is the model class for table "purchase_return".
 *
 * The followings are the available columns in table 'purchase_return':
 * @property integer $return_id
 * @property integer $purchase_return_id
 * @property string $quantity
 * @property string $product_id
 * @property string $price
 * @property string $amount
 * @property string $createdAt
 */
class PurchaseReturn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PurchaseReturn the static model class
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
		return 'purchase_return';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('quantity, product_id, amount, createdAt', 'required'),
			array('purchase_return_id', 'numerical', 'integerOnly'=>true),
			array('quantity, product_id, price, amount', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('return_id, purchase_return_id, quantity, product_id, price, amount, createdAt', 'safe', 'on'=>'search'),
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
			'return_id' => 'Return',
			'purchase_return_id' => 'Purchase Return',
			'quantity' => 'Quantity',
			'product_id' => 'Product',
			'price' => 'Price',
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

		$criteria->compare('return_id',$this->return_id);
		$criteria->compare('purchase_return_id',$this->purchase_return_id);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('price',$this->price,true);
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
	
	function getpurchaseReturnDetails($purchase_return_id=NULL)
	{
		$sql = "select p.product_name,p.product_desc,pu.* from purchase_return pu , product p where p.product_id = pu.product_id and pu.purchase_return_id = ".$purchase_return_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
}