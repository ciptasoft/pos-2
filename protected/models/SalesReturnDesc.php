<?php

/**
 * This is the model class for table "sales_return_desc".
 *
 * The followings are the available columns in table 'sales_return_desc':
 * @property integer $sales_desc_id
 * @property integer $sales_return_invoiceId
 * @property integer $return_product_id
 * @property integer $return_quantity
 * @property integer $return_discount
 * @property integer $return_product_total
 * @property string $return_date
 */
class SalesReturnDesc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SalesReturnDesc the static model class
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
		return 'sales_return_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('sales_return_invoiceId, return_product_id, return_quantity, return_discount, return_product_total', 'numerical', 'integerOnly'=>true),
			array('return_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sales_desc_id, sales_return_invoiceId, return_product_id, return_quantity, return_discount, return_product_total, return_date', 'safe', 'on'=>'search'),
		);
*/	}

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
			'sales_desc_id' => 'Sales Desc',
			'sales_return_invoiceId' => 'Sales Return Invoice',
			'return_product_id' => 'Return Product',
			'return_quantity' => 'Return Quantity',
			'return_discount' => 'Return Discount',
			'return_product_total' => 'Return Product Total',
			'return_date' => 'Return Date',
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

		$criteria->compare('sales_desc_id',$this->sales_desc_id);
		$criteria->compare('sales_return_invoiceId',$this->sales_return_invoiceId);
		$criteria->compare('return_product_id',$this->return_product_id);
		$criteria->compare('return_quantity',$this->return_quantity);
		$criteria->compare('return_discount',$this->return_discount);
		$criteria->compare('return_product_total',$this->return_product_total);
		$criteria->compare('return_date',$this->return_date,true);

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
	
	public function getTotalQuatityCountOfProductForSalesReturn($product_id = NULL )
	{
		$sql = "select sum(return_quantity) as totalReturnQuantity from sales_return_details LEFT JOIN sales_return_desc ON  (sales_return_desc.sales_return_invoiceId =  sales_return_details.sales_return_invoiceId )    WHERE  sales_return_desc.return_product_id = ".$product_id ;
			
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function checkTicket($sales_return_invoiceId,$return_product_id)
	{
		$sql_users = "select sales_desc_id from sales_return_desc where sales_return_invoiceId='".$sales_return_invoiceId."' and return_product_id= '".$return_product_id."';";
		$result	=	Yii::app()->db->createCommand($sql_users)->queryRow();
		return $result;
	}
	
	function getTicketbyInvoiceId($sales_return_invoiceId)
	{
		$sql = "select * from sales_return_desc where sales_return_invoiceId = ".$sales_return_invoiceId.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	} 
	
	function getTicketsData($id=NULL)
	{
		$sql = "select p.*,td.* from sales_return_desc td,product p where p.product_id = td.return_product_id and td.sales_return_invoiceId = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getTotalReturnProduct($invoiceId=NULL)
	{
		$sql = "select count(return_product_id) from sales_return_desc where sales_return_invoiceId = ".$invoiceId.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function deletebyInvoiceId($sales_return_invoiceId=NULL)
	{
		$sql = "delete from sales_return_desc where sales_return_invoiceId = ".$sales_return_invoiceId."";	
		$result	= Yii::app()->db->createCommand($sql)->query();
		//return $result;
	}  
	
	function deleteRecord($invoiceId=NULL)
	{
		$sql = "delete from sales_return_desc where sales_return_invoiceId = ".$invoiceId." ; ";	
		$result	= Yii::app()->db->createCommand($sql)->query();
		//return $result;
	}

}