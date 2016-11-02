<?php

/**
 * This is the model class for table "account_master".
 *
 * The followings are the available columns in table 'account_master':
 * @property integer $accountID
 * @property string $accountName
 * @property string $balance
 * @property string $modified
 * @property string $created
 */
class AccountMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountMaster the static model class
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
		return 'account_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('accountName', 'length', 'max'=>255),
			array('balance', 'length', 'max'=>100),
			array('modified, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('accountID, accountName, balance, modified, created', 'safe', 'on'=>'search'),
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
			'accountID' => 'Account',
			'accountName' => 'Account Name',
			'balance' => 'Balance',
			'modified' => 'Modified',
			'created' => 'Created',
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

		$criteria->compare('accountID',$this->accountID);
		$criteria->compare('accountName',$this->accountName,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('created',$this->created,true);

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
	
	function getAllAccounts($admin_id=NULL)
	{
		$sql = "select * from account_master where admin_id = ".$admin_id." ;";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function updateAccount($accountID,$balance)
	{
		$sql = "UPDATE account_master SET balance = balance + ".$balance." where accountID = ".$accountID." ;";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;
	}
}