<?php
	namespace app\models;
	use Yii;
	use yii\base\Model;
	use yii\web\UploadedFile;
	
	class UserForm extends Model
	{
		public $file;
	    /**
	    * @return array the validation rules.
	    */
	    public function rules()
	    {
	        return $x = [
	            [['file'], 'file'],
	        ];
			var_dump($x);
			exit;
	    }
	}
?>