<?php

namespace app\controllers;

use Yii;
use yii\web\Request;
use yii\web\Controller;
use app\models\UserForm;
use app\models\UploadForm;
use yii\web\UploadedFile;

class UserController extends Controller
{
	/*==============================================================
	  *函数名：  actionIndex
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	上传图片
	  *参数：    
	  *返回值：  
	  *修改记录：
	===============================================================*/
    public function actionIndex()
    {
        $model = new UserForm();
        if (Yii::$app->request->isPost) {
            $files = UploadedFile::getInstances($model, 'file');
            foreach ($files as $file) {
                $_model = new UserForm();
                $_model->file = $file;
                if ($_model->validate()) {
                    $_model->file->saveAs('uploads/' . $_model->file->baseName . '.' . $_model->file->extension);
					$fileName = $_model->file->baseName . '.' . $_model->file->extension;
                } else {
                    foreach ($_model->getErrors('file') as $error) {
                        $model->addError('file', $error);
                    }
                }
            }
            if ($model->hasErrors('file')){
                $model->addError(
                    'file',
                    count($model->getErrors('file')) . ' of ' . count($files) . ' files not uploaded'
                );
            }
        }
        return $this->render('index', ['model' => $model]);
    }
}
?>










