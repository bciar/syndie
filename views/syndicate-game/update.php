<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SyndicateGame */

$this->title = 'Update Syndicate Game: ' . ' ' . $model->syndicate_id;
$this->params['breadcrumbs'][] = ['label' => 'Syndicate Game', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->syndicate_id, 'url' => ['view', ]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="syndicate-game-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
