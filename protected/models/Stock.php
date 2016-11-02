<?php

/**
 * This is the model class for table "stock".
 *
 * The followings are the available columns in table 'stock':
 * @property integer $id
 * @property integer $storeId
 * @property integer $productId
 * @property integer $quantity
 * @property string $created
 * @property string $modified
 */
class Stock extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Stock the static model class
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
		return 'stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('storeId, productId, quantity', 'numerical', 'integerOnly'=>true),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, storeId, productId, quantity, created, modified', 'safe', 'on'=>'search'),*/
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
			'storeId' => 'Store',
			'productId' => 'Product',
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
		$criteria->compare('storeId',$this->storeId);
		$criteria->compare('productId',$this->productId);
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
	
	function updateStock($product_id,$quantity,$modified,$store_id)
	{
		$sql = "UPDATE stock SET quantity = ".$quantity." , modified= '".$modified."'  where product_id= ".$product_id." and store_id= ".$store_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function updateStockForSalesReturn($product_id,$quantity,$modified,$store_id)
	{
		$sql = "UPDATE stock SET quantity = quantity + ".$quantity." , modified= '".$modified."'  where product_id= ".$product_id." and store_id= ".$store_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function deleteProductFromStore($product_id,$store_id)
	{
		$sql = "delete from stock where product_id= ".$product_id." and store_id= ".$store_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function updateStockForProductDesc($product_id,$quantity,$modified,$store_id)
	{
		$sql = "UPDATE stock SET quantity = quantity - ".$quantity." , modified= '".$modified."'  where product_id= ".$product_id." and store_id= ".$store_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function getStockDetailbyProductId($product_id)
	{
		$sql = "select * from stock where product_id= ".$product_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->queryRow();
		return $result;	
	}
	
	function updateStockQuantity($product_id,$quantity,$modified)
	{
		$sql = "UPDATE stock SET quantity = quantity + ".$quantity." , modified= '".$modified."'  where product_id= ".$product_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function checkStockDetail($product_id,$store_id)
	{
		$sql = "select * from stock where product_id= '".$product_id."' and store_id= '".$store_id."' ;";
		$result	=	Yii::app()->db->createCommand($sql)->queryRow();
		return $result;	
	}
	
	function getAllStockListforapi($admin_id=NULL)
	{
		$sql = "select product.product_name ,stores.store_name ,stock.* from stock LEFT JOIN product  ON ( product.product_id = stock.product_id )  LEFT JOIN stores  ON ( stores.store_id = stock.store_id ) where stock.admin_id = ".$admin_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getProductStockDetail($admin_id=NULL,$product_id=NULL)
	{
		$sql = "select product.product_name ,stores.store_name ,stock.* from stock LEFT JOIN product  ON ( product.product_id = stock.product_id )  LEFT JOIN stores  ON ( stores.store_id = stock.store_id ) where stock.admin_id = ".$admin_id." and stock.product_id = ".$product_id." ; ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
}