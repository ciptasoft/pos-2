<?php

/**
 * This is the model class for table "carddetails".
 *
 * The followings are the available columns in table 'carddetails':
 * @property integer $card_id
 * @property integer $card_type
 * @property string $card_number
 * @property string $holder_name
 * @property integer $invoiceId
 * @property integer $amount
 * @property string $createdAt
 */
class CardDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CardDetails the static model class
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
		return 'carddetails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('card_type, invoiceId, amount', 'numerical', 'integerOnly'=>true),
			array('card_number, holder_name', 'length', 'max'=>50),
			array('createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('card_id, card_type, card_number, holder_name, invoiceId, amount, createdAt', 'safe', 'on'=>'search'),
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
			'card_id' => 'Card',
			'card_type' => 'Card Type',
			'card_number' => 'Card Number',
			'holder_name' => 'Holder Name',
			'invoiceId' => 'Invoice',
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

		$criteria->compare('card_id',$this->card_id);
		$criteria->compare('card_type',$this->card_type);
		$criteria->compare('card_number',$this->card_number,true);
		$criteria->compare('holder_name',$this->holder_name,true);
		$criteria->compare('invoiceId',$this->invoiceId);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('createdAt',$this->createdAt,true);

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
}