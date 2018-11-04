<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Line */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Line', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="line-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Line'.' '. Html::encode($this->title) ?></h2>
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
        'draw_id',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerChoice->totalCount){
    $gridColumnChoice = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'chosen_number',
            'position',
            'ball_category_id',
            'ball_hierarchy',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerChoice,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-choice']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Choice'),
        ],
        'export' => false,
        'columns' => $gridColumnChoice
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerSyndicateLine->totalCount){
    $gridColumnSyndicateLine = [
        ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'syndicate.id',
                'label' => 'Syndicate'
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerSyndicateLine,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-syndicate-line']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Syndicate Line'),
        ],
        'export' => false,
        'columns' => $gridColumnSyndicateLine
    ]);
}
?>
    </div>
</div>
