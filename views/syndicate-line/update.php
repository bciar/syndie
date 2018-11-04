<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SyndicateLine */

$this->title = 'Update Syndicate Line: ' . ' ' . $model->syndicate_id;
$this->params['breadcrumbs'][] = ['label' => 'Syndicate Line', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->syndicate_id, 'url' => ['view', ]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="syndicate-line-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
