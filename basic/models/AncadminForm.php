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
			$insert = $connection->createCommand()
			->insert('ancadmin_product',array(
				'title'        => $proinf['title'],
				'sku'          => $proinf['sku'],
				'price'        => $proinf['price'],
                'disprice'     => $proinf['disprice'],
				'freeShipping' => $proinf['freeShipping'],
				'qty'          => $proinf['qty'],
			))
			->execute();
			$insertID = $connection->getLastInsertID();
			
			$response = FALSE;
			if($insertID>0){
				$params = array('uid'=>$insertID,'productInf'=>$proinf['productInf']);
				$result = $this->ProductDetails($params);
				
				$imgArr = array('uid'=>$insertID,'imgArray'=>$proinf['imgArray']);
				$imgresult = $this->ProductImgArray($imgArr);
				if($result){
					$response = TRUE;
					header('Location:index.php?r=ancadmin/index&page=product');
					exit;
				}else{
					//如果不成功 删除当前id
				}
			}
			return $response;
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
			->select(['id','title','sku','price','disprice','qty','freeShipping','imgarr','proinf'])
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
			$connection = \Yii::$app->db;
			$update = $connection->createCommand()
			->update('ancadmin_product', 
				[
					'title' 	   => $proinf['title'],
					'sku'          => $proinf['sku'],
					'price'        => $proinf['price'],
                    'disprice'     => $proinf['disprice'],
					'qty'          => $proinf['qty'],
				], 
				$id
			)
			->execute();
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
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
?>