<?php
	namespace app\models;
	use Yii;
	use yii\base\Model;
	use yii\web\session;
	use Yii\db\ActiveRecord;
	use yii\db\Query;
	
	class ProductlistForm extends Model
	{
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