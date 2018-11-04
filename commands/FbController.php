<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class FbController extends Controller
{

	public function actionIndex() {

    $social = Yii::$app->getModule('social');
    $fb = $social->getFb(); // gets facebook object based on module settings


	}	
}
?>
