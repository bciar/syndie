<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TransactionHistory */

$this->title = 'Create Transaction History';
$this->params['breadcrumbs'][] = ['label' => 'Transaction History', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
