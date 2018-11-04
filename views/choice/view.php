<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Choice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Choice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="choice-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Choice'.' '. Html::encode($this->title) ?></h2>
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
            'attribute' => 'line.id',
            'label' => 'Line',
        ],
        'chosen_number',
        'position',
        'ball_category_id',
        'ball_hierarchy',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
