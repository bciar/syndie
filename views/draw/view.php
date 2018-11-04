<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Draw */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Draw', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draw-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Draw'.' '. Html::encode($this->title) ?></h2>
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
            'attribute' => 'game.name',
            'label' => 'Game',
        ],
        'draw_date',
        'est_jackpot',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerResult->totalCount){
    $gridColumnResult = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'drawn_number',
            'position',
            'ball_category_id',
            'ball_hierarchy',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerResult,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-result']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Result'),
        ],
        'export' => false,
        'columns' => $gridColumnResult
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerSyndicate->totalCount){
    $gridColumnSyndicate = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'creatorUser.username',
                'label' => 'Creator User'
            ],
            'num_lines',
            'num_shares',
            'cost_per_share',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerSyndicate,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-syndicate']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Syndicate'),
        ],
        'export' => false,
        'columns' => $gridColumnSyndicate
    ]);
}
?>
    </div>
</div>
