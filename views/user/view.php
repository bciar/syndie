<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'User'.' '. Html::encode($this->title) ?></h2>
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
        'username',
        'email:email',
        'password_hash',
        'auth_key',
        'confirmed_at',
        'unconfirmed_email:email',
        'blocked_at',
        'registration_ip',
        'flags',
        'last_login_at',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerSocialAccount->totalCount){
    $gridColumnSocialAccount = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        'provider',
            'client_id',
            'data:ntext',
            'code',
            'email:email',
            'username',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerSocialAccount,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-social-account']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Social Account'),
        ],
        'export' => false,
        'columns' => $gridColumnSocialAccount
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
                'attribute' => 'draw.id',
                'label' => 'Draw'
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
    
    <div class="row">
<?php
if($providerSyndicateMember->totalCount){
    $gridColumnSyndicateMember = [
        ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'syndicate.id',
                'label' => 'Syndicate'
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerSyndicateMember,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-syndicate-member']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Syndicate Member'),
        ],
        'export' => false,
        'columns' => $gridColumnSyndicateMember
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerToken->totalCount){
    $gridColumnToken = [
        ['class' => 'yii\grid\SerialColumn'],
                        'code',
            'type',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerToken,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-token']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Token'),
        ],
        'export' => false,
        'columns' => $gridColumnToken
    ]);
}
?>
    </div>
</div>
