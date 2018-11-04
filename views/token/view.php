<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Token */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Token', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="token-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Token'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'user_id' => $model->user_id, 'code' => $model->code, 'type' => $model->type], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'user_id' => $model->user_id, 'code' => $model->code, 'type' => $model->type], [
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
        [
            'attribute' => 'user.username',
            'label' => 'User',
        ],
        'code',
        'type',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
