<?php
/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property integer $id
 * @property string $message
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property string $created
 */
class Messages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Messages the static model class
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
		return 'messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('sender_id, receiver_id', 'numerical', 'integerOnly'=>true),
			array('message', 'length', 'max'=>255),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, message, sender_id, receiver_id, created', 'safe', 'on'=>'search'),
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
			'message' => 'Message',
			'sender_id' => 'Sender',
			'receiver_id' => 'Receiver',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('sender_id',$this->sender_id);
		$criteria->compare('receiver_id',$this->receiver_id);
		$criteria->compare('created',$this->created,true);

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
	
	function getMessageList($id=NULL)
	{
		$sql_list = "select m.*,u.firstName,u.lastName from messages m,users u  where u.id=m.sender_id and receiver_id = ".$id." order by created desc";
		
		 $sql_count = "select count(*) from messages m,users u  where u.id=m.sender_id and receiver_id = ".$id." order by created desc";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_list, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>5,
						),
					));
		
		return array('pagination'=>$item->pagination, 'lists'=>$item->getData());
		
	}
	
	/*
	DESCRIPTION : GET ALL LISTS WITH PAGINATION
	*/
	public function getAllPaginatedLists($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		
 		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (
name like '%".$keyword."%' or description='%".$keyword."%' or l.loginId='%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			$dateSearch = " and t.createdAt > '".date("Y-m-d",strtotime($startDate))."' and t.createdAt < '".date("Y-m-d",strtotime($endDate))."'";	
		}

		 $sql_list = "select t.id,t.name,t.description,t.createdAt,t.modifiedAt,u.firstName,u.lastName from todo_lists t,users u,login l where t.name not like 'self' and t.createdBy = l.id and l.userId = u.id ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from todo_lists t,users u,login l where t.name not like 'self' and t.createdBy = l.id and l.userId = u.id ".$search." ".$dateSearch."";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_list, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>$limit,
						),
					));
		
		return array('pagination'=>$item->pagination, 'lists'=>$item->getData());
	}
	
	function deleteMessage($id)
	{
		$messageObj=Messages::model()->findByPk($id);
		if(is_object($messageObj))
		{
			$messageObj->delete();
		}
	}
	
	function getNewMessageCount()
	{
		$sql = "select count(*) from messages where status = '0' and receiver_id = ".Yii::app()->session['userId'].";";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
		
	}
	
	
	function getMessageListAPI($userId=NULL)
	{
		$sql = "select * from messages where receiver_id = ".$userId."";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
}