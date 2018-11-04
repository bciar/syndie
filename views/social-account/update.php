<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SocialAccount */

$this->title = 'Update Social Account: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Social Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="social-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
