<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BallType */

$this->title = 'Create Ball Type';
$this->params['breadcrumbs'][] = ['label' => 'Ball Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ball-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
