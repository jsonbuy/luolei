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
			->select(['title','price','disprice','sku','spu','id','freeShipping','qty'])
			->from('ancadmin_product')
			->where(['id'=>$id])
			->one();
			return $rows;
		}
        public function productDataInf(){
            $id = $_GET['id'];
            $rows = (new \yii\db\Query())
            ->select(['product_data'])
            ->from('ancadmin_product')
            ->leftJoin('ancadmin_productdata', 'ancadmin_productdata.product_sku_id = ancadmin_product.id')
            ->where(['id'=>$id])
            ->all();
            return $rows;
        }
        /*==============================================================
          *函数名：  productDataspu
          *作者：    json
          *日期：    2015-03-19
          *功能：  获取spu数据
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function productDataspu(){
            $id = $_GET['id'];
            $rows = (new \yii\db\Query())
            ->select(['spu'])
            ->from('ancadmin_product')
            ->where(['id'=>$id])
            ->one();
            
            $command = (new \yii\db\Query())
            ->select(['id','title','price','disprice','sku','freeShipping','qty','product_class','product_data','product_sku_id'])
            ->from('ancadmin_product')
            ->leftJoin('ancadmin_productdata', 'ancadmin_productdata.product_sku_id = ancadmin_product.id')
            //->leftJoin('ancadmin_productinf', 'ancadmin_productinf.uid = ancadmin_product.id')
            ->where(['spu'=>$rows])
            ->all();
            return $command;
            
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
	}


?>