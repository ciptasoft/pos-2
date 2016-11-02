<?php

/**
 * This is the model class for table "tbl_querylog".
 *
 * The followings are the available columns in table 'tbl_querylog':
 * @property integer $querylog_id
 * @property string $table_log_id
 * @property string $table_name
 * @property string $log_id
 * @property string $query
 */
class TblQuerylog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblQuerylog the static model class
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
		return 'tbl_querylog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('table_log_id, table_name, log_id, query', 'required'),
			array('table_log_id, table_name, log_id', 'length', 'max'=>20),
			array('query', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('querylog_id, table_log_id, table_name, log_id, query', 'safe', 'on'=>'search'),
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
			'querylog_id' => 'Querylog',
			'table_log_id' => 'Table Log',
			'table_name' => 'Table Name',
			'log_id' => 'Log',
			'query' => 'Query',
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

		$criteria->compare('querylog_id',$this->querylog_id);
		$criteria->compare('table_log_id',$this->table_log_id,true);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('log_id',$this->log_id,true);
		$criteria->compare('query',$this->query,true);

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
	
	function getLastLogId()
	{	
	    $sql = "select max(log_id) from tbl_querylog ;";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function checkLogId($table_log_id,$table_name)
	{	
	    $sql = "select querylog_id from tbl_querylog where table_log_id = ".$table_log_id." and table_name = '".$table_name."' ";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getQueryLog($log_id)
	{	
	    $sql = "select * from tbl_querylog where log_id > ".$log_id." ;";
		$result	=	Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getQueryLogCount($log_id)
	{	
	    $sql = "select count(*) as totalQuery from tbl_querylog where log_id > ".$log_id." ;";
		$result	=	Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}

}