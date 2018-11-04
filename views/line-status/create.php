<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LineStatus */

$this->title = 'Create Line Status';
$this->params['breadcrumbs'][] = ['label' => 'Line Status', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="line-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
