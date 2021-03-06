<?php

/**
 * This is the model class for table "invoice_series".
 *
 * The followings are the available columns in table 'invoice_series':
 * @property integer $id
 * @property integer $userId
 * @property integer $invoiceId
 * @property integer $seriesNo
 * @property integer $InvoiceNo
 * @property string $createdAt
 */
class InvoiceSeries extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoiceSeries the static model class
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
		return 'invoice_series';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('id', 'required'),
			array('id, userId, invoiceId, seriesNo, InvoiceNo', 'numerical', 'integerOnly'=>true),
			array('createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, invoiceId, seriesNo, InvoiceNo, createdAt', 'safe', 'on'=>'search'),
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
			'userId' => 'User',
			'invoiceId' => 'Invoice',
			'seriesNo' => 'Series No',
			'InvoiceNo' => 'Invoice No',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('invoiceId',$this->invoiceId);
		$criteria->compare('seriesNo',$this->seriesNo);
		$criteria->compare('InvoiceNo',$this->InvoiceNo);
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
	
	function getLastSeriesNo($userId=NULL)
	{	
	    if($userId==NULL)
		{
			$id = Yii::app()->session['userId'];
		}
		else
		{
			$id = $userId;
		}
		$sql = "select seriesNo from invoice_series where userId = ".$id."  order by seriesNo desc";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getSeriesNo($id)
	{	
		$sql = "select invoiceNo from invoice_series where invoiceId = ".$id." ";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getInvoiceId($id)
	{	
		$sql = "select invoiceId from invoice_series where invoiceNo = '".$id."' ";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
}