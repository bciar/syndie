<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Game', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Game'.' '. Html::encode($this->title) ?></h2>
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
        'name',
        [
            'attribute' => 'country.name',
            'label' => 'Country',
        ],
        'price_per_line',
        'logo_path',
        'next_draw',
        'active',
        'draw_frequency',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerBallType->totalCount){
    $gridColumnBallType = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'hierarchy',
            'name',
            'quantity_in_pot',
            'quantity_drawn',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerBallType,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-ball-type']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Ball Type'),
        ],
        'export' => false,
        'columns' => $gridColumnBallType
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerDraw->totalCount){
    $gridColumnDraw = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'draw_date',
            'est_jackpot',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerDraw,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-draw']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Draw'),
        ],
        'export' => false,
        'columns' => $gridColumnDraw
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerLine->totalCount){
    $gridColumnLine = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'draw_id',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerLine,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-line']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Line'),
        ],
        'export' => false,
        'columns' => $gridColumnLine
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerPrize->totalCount){
    $gridColumnPrize = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerPrize,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-prize']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Prize'),
        ],
        'export' => false,
        'columns' => $gridColumnPrize
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerSyndicateGame->totalCount){
    $gridColumnSyndicateGame = [
        ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'syndicate.id',
                'label' => 'Syndicate'
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerSyndicateGame,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-syndicate-game']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Syndicate Game'),
        ],
        'export' => false,
        'columns' => $gridColumnSyndicateGame
    ]);
}
?>
    </div>
</div>
