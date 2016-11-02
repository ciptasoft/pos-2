<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_desc
 * @property string $product_image
 * @property string $product_price
 * @property string $upc_code
 * @property integer $quantity
 * @property string $manufacturing_date
 * @property string $expiry_date
 * @property integer $cat_id
 * @property string $created_date
 * @property string $modified_date
 * @property string $status
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('quantity, cat_id', 'numerical', 'integerOnly'=>true),
			array('product_name, product_desc, product_image, product_price, upc_code', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('manufacturing_date, expiry_date, created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_id, product_name, product_desc, product_image, product_price, upc_code, quantity, manufacturing_date, expiry_date, cat_id, created_date, modified_date, status', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'product_name' => 'Product Name',
			'product_desc' => 'Product Desc',
			'product_image' => 'Product Image',
			'product_price' => 'Product Price',
			'upc_code' => 'Upc Code',
			'quantity' => 'Quantity',
			'manufacturing_date' => 'Manufacturing Date',
			'expiry_date' => 'Expiry Date',
			'cat_id' => 'Cat',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
			'status' => 'Status',
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

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_desc',$this->product_desc,true);
		$criteria->compare('product_image',$this->product_image,true);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('upc_code',$this->upc_code,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('manufacturing_date',$this->manufacturing_date,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('status',$this->status,true);

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
	
	public function getAllPaginatedProduct($limit=5,$sortType="asc",$sortBy="product_name",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		
			
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (product_name like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " and created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		
/*		if(Yii::app()->session['type']==2)
		{
			if($search == NULL && $dateSearch == NULL){ 
				$admin_cond = "where admin_id = ".Yii::app()->session['adminUser']." ";
			}else{
				$admin_cond = "and admin_id = ".Yii::app()->session['adminUser']." ";
			}
				$sql_users = "select * from product ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
			 	$sql_count = "select count(*) from product ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{*/
			$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			$store_id = $userData->store_id ;
		
			
		 	/*$sql_users = "select * from product  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";*/
			
			$sql_users = "select * from product where store_id LIKE '%,".$store_id.",%' ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product where store_id LIKE '%,".$store_id.",%' ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		//}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>50,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'product'=>$item->getData());
	}
	
	public function getAllPaginatedProductforAdmin($limit=5,$sortType="asc",$sortBy="product_name",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where (product_name like '%".$keyword."%' or upc_code like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and product.created_date > '".date("Y-m-d",strtotime($startDate))."' and product.created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " where product.created_date > '".date("Y-m-d",strtotime($startDate))."' and product.created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		
		if(Yii::app()->session['type']==2)
		{
			if($search == NULL && $dateSearch == NULL){ 
				$admin_cond = "where product.admin_id = ".Yii::app()->session['adminUser']."";
			}else{
				$admin_cond = "and product.admin_id = ".Yii::app()->session['adminUser']."";
			}
				$sql_users = "select stores.store_name,product.*  from product LEFT JOIN stores  ON ( stores.store_id = product.store_id ) ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
			 	$sql_count = "select count(*) from product ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 	$sql_users = "select stores.store_name  ,product.*  from product  LEFT JOIN stores  ON ( stores.store_id = product.store_id ) ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'product'=>$item->getData());
	}
	
	public function getPaginatedProductforCategory($limit=5,$sortType="asc",$sortBy="product_name",$keyword=NULL,$cat_id,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (product.product_name like '%".$keyword."%' or product.upc_code like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and product.created_date > '".date("Y-m-d",strtotime($startDate))."' and product.created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " and product.created_date > '".date("Y-m-d",strtotime($startDate))."' and product.created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		
		if(Yii::app()->session['type']==2)
		{
			if($search == NULL && $dateSearch == NULL){ 
				$admin_cond = "and product.admin_id = ".Yii::app()->session['adminUser']." ";
			}else{
				$admin_cond = "and product.admin_id = ".Yii::app()->session['adminUser']." ";
			}
				$sql_users = "select stores.store_name  ,product.*  from product  LEFT JOIN stores  ON ( stores.store_id = product.store_id ) WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
			 	$sql_count = "select count(*) from product WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 	$sql_users = "select stores.store_name  ,product.*  from product  LEFT JOIN stores  ON ( stores.store_id = product.store_id ) WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'product'=>$item->getData());
	}
	
	public function getPaginatedProductforStore($limit=5,$sortType="asc",$sortBy="product_name",$keyword=NULL,$store_id,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (product.product_name like '%".$keyword."%' or product.upc_code like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and product.created_date > '".date("Y-m-d",strtotime($startDate))."' and product.created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " and product.created_date > '".date("Y-m-d",strtotime($startDate))."' and product.created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		
		if(Yii::app()->session['type']==2)
		{
			if($search == NULL && $dateSearch == NULL){ 
				$admin_cond = "and product.admin_id = ".Yii::app()->session['adminUser']." ";
			}else{
				$admin_cond = "and product.admin_id = ".Yii::app()->session['adminUser']." ";
			}
				$sql_users = "select stores.store_name ,stock.quantity as quantityForStore ,product.*  from product  LEFT JOIN stores  ON ( stores.store_id = product.store_id )  LEFT JOIN stock  ON ( stock.product_id = product.product_id ) WHERE product.store_id LIKE '%,".$store_id.",%' and stock.store_id = ".$store_id." ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
			 	$sql_count = "select count(*) from product WHERE store_id LIKE '%,".$store_id.",%' ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 	$sql_users = "select stores.store_name  ,product.*  from product  LEFT JOIN stores  ON ( stores.store_id = product.store_id ) WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'product'=>$item->getData());
	}
	
	public function getPaginatedProductforCategoryForStore($limit=5,$sortType="asc",$sortBy="product_name",$keyword=NULL,$cat_id,$store_id,$startDate=NULL,$endDate=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (product_name like '%".$keyword."%' or upc_code like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " and created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		
		if(Yii::app()->session['type']==2)
		{
			if($search == NULL && $dateSearch == NULL){ 
				$admin_cond = "and product.admin_id = ".Yii::app()->session['adminUser']." ";
			}else{
				$admin_cond = "and product.admin_id = ".Yii::app()->session['adminUser']." ";
			}
				$sql_users = "select stores.store_name  ,product.*  from product  LEFT JOIN stores  ON ( stores.store_id = product.store_id ) WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
			 	$sql_count = "select count(*) from product WHERE cat_id = ".$cat_id."  ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{
		 	$sql_users = "select *  from product WHERE cat_id = ".$cat_id." and store_id LIKE '%".$store_id."%'  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product WHERE cat_id = ".$cat_id." and store_id LIKE '%".$store_id."%'  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'product'=>$item->getData());
	}
	
	public function getPaginatedProductList($limit=7,$sortType="desc",$sortBy="product_id",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL)
	{
			
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (product_name like '%".$keyword."%' or upc_code like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
			else
			{
			$dateSearch = " and created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			}
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$productSearch = " and product_price > ".$searchFrom." and product_price < ".$searchTo."";	
			}
			else
			{
				$productSearch = " and product_price > ".$searchFrom." and product_price < ".$searchTo."";	
			}
		}
		
/*		if(Yii::app()->session['type']==2)
		{
			if($search == NULL && $dateSearch == NULL){ 
				$admin_cond = "where admin_id = ".Yii::app()->session['adminUser']." ";
			}else{
				$admin_cond = "and admin_id = ".Yii::app()->session['adminUser']." ";
			}
				$sql_users = "select * from product ".$search." ".$dateSearch." ".$admin_cond." order by ".$sortBy." ".$sortType."";
			 	$sql_count = "select count(*) from product ".$search." ".$dateSearch." ".$admin_cond."";
		}
		else
		{*/
			$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			$store_id = $userData->store_id ;
		
			
		 	/*$sql_users = "select * from product  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product  ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";*/
			
			$sql_users = "select * from product where store_id LIKE '%,".$store_id.",%' ".$search." ".$productSearch."  ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product where store_id LIKE '%,".$store_id.",%' ".$search." ".$productSearch."  ".$dateSearch." order by ".$sortBy." ".$sortType."";
		//}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_7,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'product'=>$item->getData());
		
	}
	
	function getProductDropdown()
	{
		$result = Yii::app()->db->createCommand()
		->select("product_id,product_name")
		->from($this->tableName())
        ->queryAll();
			
		return $result;	
	}
	
	function getProductDetails($product_id=NULL)
	{
	 	$sql = "select c.category_name,s.store_name,p.* from product p left join stores s on ( p.store_id = s.store_id ) left join category c on ( p.cat_id = c.cat_id ) where p.product_id = ".$product_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	function getProductListByCategoryId($cat_id=NULL,$admin_id)
	{
	 	$sql = "select c.category_name,s.store_name,p.* from product p left join stores s on ( p.store_id = s.store_id ) left join category c on ( p.cat_id = c.cat_id ) where p.cat_id = ".$cat_id." and p.admin_id = ".$admin_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getAllProductList($admin_id=NULL)
	{
		$sql = "select * from product  where admin_id = ".$admin_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getProductDetailsbyUpcCodeForApi($id=NULL,$admin_id=NULL)
	{
		$sql = "select * from product where upc_code = '".$id."' and admin_id = ".$admin_id." ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	function getProductDetailsbyUpcCode($id=NULL)
	{
		$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
		$store_id = $userData->store_id ;
		$admin_id = $userData->admin_id ; 
			
		$sql = "select * from product where upc_code = '".$id."' and admin_id = ".$admin_id." and store_id LIKE '%,".$store_id.",%' ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	function deleteProduct($id)
	{
		$productObj=Product::model()->findByPk($id);
		if(is_object($productObj))
		{
			$productObj->delete();
		}
	}
	
	function getProductforQueryLog()
	{
		$sql = "select * from product ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function checkProductStoreDetails($product_id,$store_id)
	{
		$sql = "select * from product where product_id = '".$product_id."' and store_id LIKE '%,".$store_id.",%' ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
}