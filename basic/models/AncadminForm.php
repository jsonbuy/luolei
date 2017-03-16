<?php
	namespace app\models;
	use Yii;
	use yii\base\Model;
	use yii\web\session;
	use Yii\db\ActiveRecord;
	use yii\web\UploadedFile;
	
	class AncadminForm extends Model
	{
		public $file;
		public $path = "/web/banner/";
		/*==============================================================
		  *函数名：  LoginIn
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	用户点击登陆，成功设置session：username；
		  *参数：    
		  *返回值：0，1
		  *修改记录：
		===============================================================*/
		public function LoginIn()
		{
			$session = \yii::$app->session;
			
			$username = htmlspecialchars($_POST['email']);
			$pass = $_POST['pw'];
			$command = (new \yii\db\Query())
			->select(['user','pass'])
			->from('ancadmin_user')
			->where(['user'=>$username,'pass'=>$pass])
			->one();
			
			if($command){
				$session->set('user',$username);
				$response = array('status'=>1,'message'=>'login sucess');
				echo json_encode($response);
				exit;
			}else{
				$respons = array('status' => 0,'message'=>'login error');
				echo json_encode($respons);
				exit;
			}
			return $command;
		}
		/*==============================================================
		  *函数名：  rules
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	文件上传
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function rules()
	    {
	        return [
	            [['file'], 'file'],
	        ];
	    }
		/*==============================================================
		  *函数名：  UpFile
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   文件存储到数据库
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function UpFile($upfile){
			$connection = \Yii::$app->db;
			$insert = $connection->createCommand()
			->insert('ancadmin_banner',array(
				'title' => $upfile['title'],
				'imgpath' => $upfile['imgpath'],
				'imgurl' => $upfile['imgurl'],
			))
			->execute();
			return $insert;
		}
		/*==============================================================
		  *函数名：  EdiShowBanner
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   显示banner 编辑
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function EdiShowBanner(){
			//$connection = \Yii::$app->db;
			$command = (new \yii\db\Query())
			->select(['id','imgpath','title','imgurl'])
			->from('ancadmin_banner')
			->all();
			return $command;
		}
		/*==============================================================
		  *函数名：  EdiBanner
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   编辑bnner
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function UpdateBanner($update){
			$connection = \Yii::$app->db;
			$command = $connection->createCommand()
			->update('ancadmin_banner',
				[
					'title' => $update['title'],
					'imgurl' => $update['imgurl']
				], 
				'id ='.$update['id']
			)
			->execute();
			if($command){
				$response = array('status'=>1,'message'=>'update sucess');
				echo json_encode($response);
				exit;
			}else{
				$respons = array('status' => 0,'message'=>'update error');
				echo json_encode($respons);
				exit;
			}
			return $command;
		}
		/*==============================================================
		  *函数名：  DeleteBanner
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   删除banner
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function DeleteBanner($delete){
			$connection = \Yii::$app->db;
			$command = $connection->createCommand()
			->delete('ancadmin_banner','id ='.$delete['id'])
			->execute();
			 $file_delete = basename($delete['banner']);
			unlink("../web/banner/".$file_delete);
			if($command){
				$response = array('status'=>1,'message'=>'delete sucess');
				echo json_encode($response);
				exit;
			}else{
				$respons = array('status' => 0,'message'=>'delete error');
				echo json_encode($respons);
				exit;
			}
			return $command;
		}
		/*==============================================================
		  *函数名：  ProductProinf
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   上传产品基本信息
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function ProductProinf($proinf){
			$connection = \Yii::$app->db;
            
            $skuArr   = $proinf['sku'];
            $defaults = $proinf['default'];
            $skuArr = explode(',', $skuArr);
            $spu = explode('-', $skuArr[0]);
            $skuData = explode(',', $proinf['skuData']);
            foreach ($skuArr as $key => $value) {
                if($key == $defaults){
                    $default = 1;
                }else{
                    $default = 0;
                };
    			$insert = $connection->createCommand()
    			->insert('ancadmin_product',array(
    				'title'        => $proinf['title'],
    				'sku'          => $value,
                    'spu'          => $spu[0],
    				'price'        => $proinf['price'],
                    'default'      => $default,
                    'disprice'     => $proinf['disprice'],
    				'freeShipping' => $proinf['freeShipping'],
    				'qty'          => $proinf['qty'],
    			))
    			->execute();
    			$insertID = $connection->getLastInsertID();
                
                $skuDatas = explode('|', $skuData[$key]);
                foreach ($skuDatas as $key1 => $value1) {
                    $skuDatas1 = explode(':', $skuDatas[$key1]);
                    $insert = $connection->createCommand()
                    ->insert('ancadmin_productdata',array(
                        'product_sku_id'        => $insertID,
                        'product_class'         => $skuDatas1[0],
                        'product_data'          => $skuDatas1[1],
                    ))
                    ->execute();
                }
    			
    			//$response = FALSE;
    			if($insertID > 0){
    				$params = array('uid'=>$insertID,'productInf'=>$proinf['productInf']);
    				$result = $this->ProductDetails($params);
    				
    				$imgArr = array('uid'=>$insertID,'imgArray'=>$proinf['imgArray']);
    				$imgresult = $this->ProductImgArray($imgArr);
    			}
            }
            
            if($result){
                //$response = TRUE;
                header('Location:index.php?r=ancadmin/index&page=product');
                exit;
            }else{
                //如果不成功 删除当前id
            }
			//return $response;
		}
		/*==============================================================
		  *函数名：  ProductProinf
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   上传产品基本信息
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function ProductDetails($params){
			$connection = \Yii::$app->db;
			$insert = $connection->createCommand()
			->insert('ancadmin_productinf',array(
				'uid'        => $params['uid'],
				'proinf' => $params['productInf'],
			))
			->execute();
			return $insert;
		}
		/*==============================================================
		  *函数名：  ProductImgArray
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   上传产品图片信息
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function ProductImgArray($imgArr){
			$connection = \Yii::$app->db;
			$insert = $connection->createCommand()
			->insert('ancadmin_productimgarr',array(
				'uid'        => $imgArr['uid'],
				'imgarr' 	 => $imgArr['imgArray'],
			))
			->execute();
			return $insert;
		}
		/*==============================================================
		  *函数名：  searchSku
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   编辑页面产品 搜索sku
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function searchSku($proinf){
			$sku = $proinf['sku'];
			$sku = 'sku=\''.$sku.'\'';
			$command = (new \yii\db\Query())
			->select(['id','title','sku','spu','price','disprice','qty','freeShipping','imgarr','proinf'])
			->from('ancadmin_product')
			->leftJoin('ancadmin_productimgarr', 'ancadmin_productimgarr.uid = ancadmin_product.id')
			->leftJoin('ancadmin_productinf', 'ancadmin_productinf.uid = ancadmin_product.id')
			->where($sku)
			->one();
			return $command;
		}
		/*==============================================================
		  *函数名：  updateProduct
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   编辑页面产品 
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function updateProduct($proinf){
			$id = $proinf['id'];
			$id = 'id=\''.$id.'\'';
            $spu = 'spu=\''.$proinf['spu'].'\'';
			$connection = \Yii::$app->db;
			$update = $connection->createCommand()
			->update('ancadmin_product', 
				[
					'title' 	   => $proinf['title'],
					'sku'          => $proinf['sku'],
                    'spu'          => $proinf['spu'],
					'price'        => $proinf['price'],
                    'disprice'     => $proinf['disprice'],
					'qty'          => $proinf['qty'],
				], 
				$id
			)
			->execute();
            //==========修改 spu==============//
            if($proinf['defaultSKU'] == 1){
                $update = $connection->createCommand()
                ->update('ancadmin_product', 
                    [
                        'default'          => 0,
                    ], 
                    $spu
                )
                ->execute();
                $update = $connection->createCommand()
                ->update('ancadmin_product', 
                    [
                        'default'          => 1,
                    ], 
                    $id
                )
                ->execute();
            };
			//==========修改 产品详情==============//
			$params = array(
				'uid'         => $proinf['id'],
				'productInf'  => $proinf['productInf']
			);
			$result = $this->UpdateDetails($params);
			//==========修改 产品图片==============//
			$postInfo = array(
				'uid'         => $proinf['id'],
				'imgarr'  => $proinf['imgArray']
			);
			$result = $this->UpdateProimg($postInfo);
			
			header('Location:index.php?r=ancadmin/index&page=productsearch&sku='.$proinf['sku']);
			return $update;
		}
		
		/*==============================================================
		  *函数名：  UpdateDetails
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   编辑页面详细信息
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function UpdateDetails($params){
			$uid = $params['uid'];
			$uid = 'uid=\''.$uid.'\'';
			$connection = \Yii::$app->db;
			$update = $connection->createCommand()
			->update('ancadmin_productinf', 
				[
					'proinf'          => $params['productInf'],
				], 
				$uid
			)
			->execute();
			return $update;
		}
		/*==============================================================
		  *函数名：  UpdateProimg
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：   编辑页面图片
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function UpdateProimg($postInfo){
			$uid = $postInfo['uid'];
			$uid = 'uid=\''.$uid.'\'';
			$connection = \Yii::$app->db;
			$update = $connection->createCommand()
			->update('ancadmin_productimgarr', 
				[
					'imgarr'          => $postInfo['imgarr'],
				], 
				$uid
			)
			->execute();
			return $update;
		}
		
		/*==============================================================
          *函数名：  SelectClass
          *作者：    json
          *日期：    2015-03-19
          *功能：   选择商品类目
          *参数：    
          *返回值：
          *修改记录：
        ===============================================================*/
        public function SelectClass(){
            $command = (new \yii\db\Query())
            ->select(['id','class','short'])
            ->from('ancadmin_product_1_class')
            ->all();
            return $command;
        }
        /*==============================================================
          *函数名：  SelectBrand
          *作者：    json
          *日期：    2015-03-19
          *功能：   选择商品品牌
          *参数：    
          *返回值：
          *修改记录：
        ===============================================================*/
        public function SelectBrand($update){
            $connection = \Yii::$app->db;
            $sql="SELECT * FROM ancadmin_product_2_brand a left join ancadmin_product_2_brand_id b on a.brand=b.id WHERE a.pid=".$update['id'];
            $command = $connection->createCommand($sql)
            ->queryAll();
            return $command;
        }
        /*==============================================================
          *函数名：  SelectClassify
          *作者：    json
          *日期：    2015-03-19
          *功能：   选择商品品牌
          *参数：    
          *返回值：
          *修改记录：
        ===============================================================*/
        public function SelectClassify($update){
            $connection = \Yii::$app->db;
            $sql="SELECT * FROM ancadmin_product_3_classify a left join ancadmin_product_3_classify_id b on a.classify=b.id WHERE a.pid=".$update['id'];
            $command = $connection->createCommand($sql)
            ->queryAll();
            return $command;
        }
        /*==============================================================
          *函数名：  SelectAttribute
          *作者：    json
          *日期：    2015-03-19
          *功能：   选择商品属性
          *参数：    
          *返回值：
          *修改记录：
        ===============================================================*/
        public function SelectAttribute($update){
            $connection = \Yii::$app->db;
            $sql="SELECT * FROM ancadmin_product_4_attribute a left join ancadmin_product_4_attribute_id b on a.class=b.id WHERE a.pid='".$update['id']."'";
            $command = $connection->createCommand($sql)
            ->queryAll();
            // $command = (new \yii\db\Query())
            // ->select(['pid','class','attribute'])
            // ->from('ancadmin_product_4_attribute')
            // ->where(['pid' => $update])
            // ->all();
            return $command;
        }
        /*==============================================================
          *函数名：  SelectSkulast
          *作者：    json
          *日期：    2015-03-19
          *功能：   返回数据库最后一条记录
          *参数：    
          *返回值：
          *修改记录：
        ===============================================================*/
        public function SelectSkulast(){
            $connection = \Yii::$app->db;
            $sql="select * from ancadmin_product order by id desc limit 1";
            $command = $connection->createCommand($sql)
            ->queryAll();
            return $command;
        }
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
?>