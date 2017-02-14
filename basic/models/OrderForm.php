<?php
    namespace app\models;
    use Yii;
    use yii\base\Model;
    use yii\web\session;
    use Yii\db\ActiveRecord;
    use yii\db\Query;

    class OrderForm extends Model
    {
        /*==============================================================
          *函数名：  productInf
          *作者：    json
          *日期：    2015-03-19
          *功能：  产品详情展示
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderQty(){
            $session = \yii::$app->session;
            $id = $_GET['id'];
            $qty = $_GET['qty'];
            $rows = (new \yii\db\Query())
            ->select(['qty'])
            ->from('ancadmin_product')
            ->where(['id'=>$id])
            ->one();
            if(isset($session['username'])){
                if($rows['qty'] >= $qty){
                    if(isset($_COOKIE["plist"])){
                        $plistCookie = json_decode($_COOKIE["plist"],true);
                        $plistNum = false;
                        foreach ($plistCookie as $key => $value) {
                            if($value['uid'] == $id){
                                $plistNum = true;
                                $qtys = $qty+$value['qty'];
                                $check = $value['check'];
                                $plistCookie[$key] = array('uid'=>$id,'qty'=>$qtys,'check'=>$check);
                            }
                        }
                        if($plistNum == false){
                            array_push($plistCookie,array('uid'=>$id,'qty'=>$qty,'check'=>true));
                        }
                        $plist = json_encode($plistCookie);
                        setcookie("plist", $plist, time()+360000);
                    }else{
                        $plist = json_encode(array(array('uid'=>$id,'qty'=>$qty,'check'=>true)));
                        setcookie("plist", $plist, time()+360000);
                    }
                    return array('ret'=>1);
                }else{
                    return array('ret'=>0);
                }
            }else{
                return array('ret'=>2);
            }
        }
        /*==============================================================
          *函数名：  productInf
          *作者：    json
          *日期：    2015-03-19
          *功能：  产品详情展示
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderInf(){
            if(isset($_COOKIE["plist"])){
                $plistCookie = json_decode($_COOKIE["plist"],true);
                $id = array();
                foreach ($plistCookie as $key => $value) {
                    array_push($id,$value['uid']);
                }
                $id = implode("','",$id);
                $connection = \Yii::$app->db;
                $sql="SELECT * FROM ancadmin_product a left join ancadmin_productimgarr b on a.id=b.uid WHERE a.id in('".$id."')";
                $command = $connection->createCommand($sql)
                ->queryAll();
                return $command;
            }
        }
        /*==============================================================
          *函数名：  adressInf
          *作者：    json
          *日期：    2015-03-19
          *功能：  获取地址信息
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function adressInf(){
            $session = \yii::$app->session;
            $connection = \Yii::$app->db;
            $user = $session['username'];
            $sql="SELECT * FROM shipping_address WHERE user='".$user."'";
            $command = $connection->createCommand($sql)
            ->queryAll();
            return $command;
        }
        /*==============================================================
          *函数名：  orderAddress
          *作者：    json
          *日期：    2015-03-19
          *功能：  添加地址
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderAddress($upfile){
            $session = \yii::$app->session;
            $connection = \Yii::$app->db;
            $user = $session['username'];
            if($upfile['checkDefault'] == 1){
                //查询default为1的该用户
                $rows = (new \yii\db\Query())
                ->select(['id'])
                ->from('shipping_address')
                ->where(['default'=>1,'user'=>$user])
                ->one();
                $default = 'id='.$rows['id'];
                //修改
                $upData = $connection->createCommand()
                ->update('shipping_address', 
                    [
                        'default'        => 0,
                    ], 
                    $default
                )
                ->execute();
            }
            $insert = $connection->createCommand()
            ->insert('shipping_address',array(
                'user'        => $user,
                'firstName'   => $upfile['firstName'],
                'lastName'    => $upfile['lastName'],
                'country'     => $upfile['country'],
                'address'     => $upfile['address'],
                'city'        => $upfile['city'],
                'phoneNumber' => $upfile['phoneNumber'],
                'default'     => $upfile['checkDefault'],
            ))
            ->execute();
            return $insert;
        }
        /*==============================================================
          *函数名：  orderUpdatadress
          *作者：    json
          *日期：    2015-03-19
          *功能：  修改默认地址
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderUpdatadress($datas){
            $session = \yii::$app->session;
            $connection = \Yii::$app->db;
            $user = $session['username'];
            
            $default = "id=".$datas['id'];
            $defaultDel = "user='".$user."'";
            
            $upData = $connection->createCommand()
            ->update('shipping_address', 
                [
                    'default'        => 0,
                ], 
                $defaultDel
            )
            ->execute();
            $upData = $connection->createCommand()
            ->update('shipping_address', 
                [
                    'default'        => 1,
                ], 
                $default
            )
            ->execute();
        }
        /*==============================================================
          *函数名：  orderDefaultupdata
          *作者：    json
          *日期：    2015-03-19
          *功能：  修改默认地址
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderDefaultupdata($delete){
            $connection = \Yii::$app->db;
            $command = $connection->createCommand()
            ->delete('shipping_address','id ='.$delete['id'])
            ->execute();
            return $command;
        }
        /*==============================================================
          *函数名：  orderDeletdress
          *作者：    json
          *日期：    2015-03-19
          *功能：  删除地址
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderDeletdress($delete){
            $connection = \Yii::$app->db;
            $command = $connection->createCommand()
            ->delete('shipping_address','id ='.$delete['id'])
            ->execute();
            return $command;
        }
        /*==============================================================
          *函数名：  orderPayment
          *作者：    json
          *日期：    2015-03-19
          *功能：  获取支付方式
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderPayment(){
            $rows = (new \yii\db\Query())
            ->select(['id','name','key'])
            ->from('payment')
            ->all();
            return $rows;
        }
        /*==============================================================
          *函数名：  orderPaymentclip
          *作者：    json
          *日期：    2015-03-19
          *功能：  付款页面 交易页面
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderPaymentclip($upfile){
            $response = $upfile['order'];
            $rows = (new \yii\db\Query())
            ->select(['totalprice'])
            ->from('create_order')
            ->where(['orderNumber'=>$response])
            ->all();
            return $rows;
        }
        /*==============================================================
          *函数名：  orderCreate
          *作者：    json
          *日期：    2017-02-07
          *功能：  点击确认按钮 生成订单
          *参数：    
          *返回值：  
          *修改记录：
        ===============================================================*/
        public function orderCreate($data){
            $connection = \Yii::$app->db;
            $insert = $connection->createCommand()
            ->insert('create_order',array(
                'user'       => $data['user'],
                'ordernumber'=> $data['ordernumber'],
                'date'       => $data['date'],
                'address'    => $data['address'],
                'totalprice' => $data['priceTotal'],
                'payment'    => $data['payment'],
            ))
            ->execute();
            $insertId = $connection->getLastInsertId();
            $response = false;
            if($insertId > 0){
                $dataArr = array('pid' => $insertId , 'uid' => $data['id']);
                $result = $this->orderCreatelist($dataArr);
                if($result){
                    return $response = true;
                }else{
                    return $response = false;
                }
            }
        }
        public function orderCreatelist($data){
            $connection = \Yii::$app->db;
            $id = explode(',',$data['uid']);
            foreach ($id as $key => $value) {
                $dataid = explode('-',$value);
                $uid = $dataid[0];
                $rows = (new \yii\db\Query())
                ->select(['price','disprice'])
                ->from('ancadmin_product')
                ->where(['id'=>$uid])
                ->all();
                $price = $rows[0]['price'];
                $disprice = $rows[0]['disprice'];
                $insert = $connection->createCommand()
                ->insert('create_orderlist',array(
                    'pid'       => $data['pid'],
                    'uid'       => $dataid[0],
                    'price'     => $price,
                    'disprice'  => $disprice,
                    'qty'       => $dataid[1],
                ))
                ->execute();
             };
            return $insert;
        }
    }


?>