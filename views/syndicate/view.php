<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

echo '<div class="whiteBack">';
echo '<center>';
echo $this->render('_box', ['model' => $model, 'transaction' => 0]);
echo '</center>';
echo '</div>';
