<?php
/**
 * @desc 自定义帮助类
 */
namespace app\ancdone\code;
use Yii;
// use yii\helpers\ArrayHelper;
// use yii\helpers\Html;

class AncHelper{
    
   
	/*==============================================================
	  *函数名：  jsonEncode
	  *作者：    luolei
	  *日期：    2015-12-04
	  *功能：    数组转换成json
	  *参数：    
	   @param   $data     数组
	  *返回值：  Type（String)
	  *修改记录：
	===============================================================*/
	public static function jsonEncode($data){
		return json_encode($data,JSON_HEX_AMP);
	}
	
    /*==============================================================
      *函数名：  settingPath
      *作者：    luolei
      *日期：    2015-12-04
      *功能：   根据环境 传地址
      *参数：    
       @param   $data     数组
      *返回值：  Type（String)
      *修改记录：
    ===============================================================*/
    public static function settingPath(){
        if(YII_ENV != 'prod'){
            return '..';
        }else{
            return '';
        }
    }
    public static function settingPaths(){
        if(YII_ENV != 'prod'){
            return '';
        }else{
            return '/';
        }
    }

    /*==============================================================
      *函数名：  randNumber
      *作者：    luolei
      *日期：    2015-12-04
      *功能：   生成随机数
      *参数：    $length
      *返回值：  Type（String)
      *修改记录：
    ===============================================================*/
    public static function randNumber($length){
        $str = array_merge(range(0,9),range('A','Z'));
        shuffle($str);
        $str = implode('',array_slice($str,0,$length));
        return $str;
    }

}