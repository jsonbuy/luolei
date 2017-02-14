<?php

// comment out the following two lines when deployed to production
$ini_path = php_ini_loaded_file();
$ini_vars_arr = parse_ini_file($ini_path, true);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', $ini_vars_arr['PHP']['env']);

require(__DIR__ . '/config.php');
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
