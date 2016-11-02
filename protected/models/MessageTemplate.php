<?php

/**
 * This is the model class for table "message_template".
 *
 * The followings are the available columns in table 'message_template':
 * @property integer $id
 * @property string $message
 */
class MessageTemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MessageTemplate the static model class
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
		return 'message_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, message', 'safe', 'on'=>'search'),
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
			'message' => 'Message',
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
		$criteria->compare('message',$this->message,true);

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
	public function getAllPaginatedMessage($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where (message like '%".$keyword."%')";	
		}
				
		if(Yii::app()->session['type']==2)
		{
			/*if($search == NULL ){ 
				$admin_cond = "where admin_id = ".Yii::app()->session['adminUser']." ";
			}else{
				$admin_cond = "and admin_id = ".Yii::app()->session['adminUser']." ";
			}*/
			$sql_users = "select * from message_template ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
		 	$sql_count = "select count(*) from message_template ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 $sql_users = "select * from message_template ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from message_template ".$search." ".$dateSearch."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'message_template'=>$item->getData());
	}
	
	public function getMessageDetails($id=NULL)
	{ 
		$result =array();
		if($id!='')
		{
			$condition='id=:id';
			$params=array(':id'=>$id);
			
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->where($condition,$params)
			->queryRow();
		}
		
		return $result;
	}
	function deleteMessage($id)
	{
		$messageObj=MessageTemplate::model()->findByPk($id);
		if(is_object($messageObj))
		{
			$messageObj->delete();
		}
	}
}