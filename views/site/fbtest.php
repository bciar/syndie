<?php

if(!session_id()) {
    session_start();
}

use kartik\social\Module;
use yii\helpers\Url;
$social = Yii::$app->getModule('social');
$callback = Url::toRoute(['site/validate-fb'], true); // or any absolute url you want to redirect
echo $social->getFbLoginLink($callback, ['class'=>'btn btn-primary']);

?>

