<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Draw */

$this->title = 'Create Draw';
$this->params['breadcrumbs'][] = ['label' => 'Draw', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draw-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
