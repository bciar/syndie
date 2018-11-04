<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Wallet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wallet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Wallet'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'user.username',
            'label' => 'User',
        ],
        'balance',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerTransaction->totalCount){
    $gridColumnTransaction = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'user.username',
                'label' => 'User'
            ],
            'value',
            'balance_from',
            'balance_to',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerTransaction,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-transaction']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Transaction'),
        ],
        'export' => false,
        'columns' => $gridColumnTransaction
    ]);
}
?>
    </div>
</div>
