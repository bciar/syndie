<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Token */

$this->title = 'Update Token: ' . ' ' . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Token', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'code' => $model->code, 'type' => $model->type]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="token-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
