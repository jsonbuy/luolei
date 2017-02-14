<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\AppVipsparkAsset;
use app\assets\AppUserAsset;
use app\assets\AppAncadminAsset;
use app\assets\AppProductAsset;
use app\assets\AppOrderAsset;


//$this->layout = FALSE;//不要头底
//AppVipsparkAsset::register($this);
//print_r($this);
if($this->context->id=='vipspark'||$this->context->id=='user'){
	AppVipsparkAsset::register($this);
}elseif($this->context->id=='ancadmin'){
	AppAncadminAsset::register($this);
}elseif($this->context->id=='product'){
	AppProductAsset::register($this);
}elseif($this->context->id=='order'){
    AppOrderAsset::register($this);
}elseif($this->context->id='login'){
	AppAsset::register($this);
}


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php
    $this->beginBody();
    /**@var 头部加载*/
   	echo $this->render('header.php');
    /**@var 导航加载*/
   // echo Yii::$app->view->renderFile('@layout/nav.php');
    /**@var 加载内容*/
    echo $content;
    /**@var 底部加载*/
   	echo $this->render('footer.php');
    $this->endBody();
?>
</body>
</html>
<?php $this->endPage() ?>
