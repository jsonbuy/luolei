<?php
	namespace app\models;
	use Yii;
	use yii\base\Model;
	use yii\web\session;
	use Yii\db\ActiveRecord;
	use yii\db\Query;
	
	class ProductForm extends Model
	{
		/*==============================================================
		  *函数名：  productInf
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	产品详情展示
		  *参数：    
		  *返回值：  
		  *修改记录：
		===============================================================*/
		public function productInf(){
			$id = $_GET['id'];
			$rows = (new \yii\db\Query())
			->select(['title','price','sku','id','freeShipping','qty'])
			->from('ancadmin_product')
			->where(['id'=>$id])
			->one();
			return $rows;
		}
		/*==============================================================
		  *函数名：  productDetails
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	产品详情 文章 展示
		  *参数：    
		  *返回值：  
		  *修改记录：
		===============================================================*/
		public function productDetails(){
			$id = $_GET['id'];
			$rows = (new \yii\db\Query())
			->select(['proinf'])
			->from('ancadmin_productinf')
			->where(['uid'=>$id])
			->one();
			return $rows;
		}
		/*==============================================================
		  *函数名：  productDetails
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	产品详情 文章 展示
		  *参数：    
		  *返回值：  
		  *修改记录：
		===============================================================*/
		public function productImgArr(){
			$id = $_GET['id'];
			$rows = (new \yii\db\Query())
			->select(['imgarr'])
			->from('ancadmin_productimgarr')
			->where(['uid'=>$id])
			->one();
			return $rows;
		}
		/*==============================================================
		  *函数名：  productDetails
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	产品详情 文章 展示
		  *参数：    
		  *返回值：  
		  *修改记录：
		===============================================================*/
		public function ProductList(){
			// $query = new \yii\db\Query();
			// $user = $query->select(['id', 'title']);
			$connection = \Yii::$app->db;
			$command = $connection->createCommand('SELECT * FROM ancadmin_product a left join ancadmin_productimgarr b on a.id=b.uid');
			$posts = $command->queryAll();
			return $posts;
		}

		
	}


?>