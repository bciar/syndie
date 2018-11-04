<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Wallet';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
    <!--<h1><?= Html::encode($this->title) ?></h1>-->
<div class="wallet-index">
    <?= $this->render('_photoWrapper'); ?>
    <div class="row wallet-button-wrapper">
        <div class="col-md-3" style="padding:0px;">
          <div class="wallet-btn-align1">
            <button class="btn-withdraw" onclick="location.href='<?=Yii::$app->urlManager->createUrl('wallet/withdraw')?>'"><i class="fa fa-money wallet-icon" aria-hidden="true"></i></button>
            <div class="clearfix"></div>
            <h4 class="wallet-text-below-button label-withdraw">Withdraw</h4>
          </div>
        </div>
        <div class="col-md-6 text-center">
            <h1 class="wallet-balance purple-color font-price"><span><i class="fa fa-gbp" aria-hidden="true" style="vertical-align: initial;padding-right:5px;"></i>52.54</span></h1>
            <h3 style="font-weight: 400" class="purple-color">Wallet Balance</h3>
        </div>
        <div class="col-md-3">
          <div class="wallet-btn-align2">
            <button class="btn-deposit" onclick="location.href='<?=Yii::$app->urlManager->createUrl('wallet/deposit')?>'"><i class="fa fa-plus wallet-icon" aria-hidden="true"></i></button>
            <div class="clearfix"></div>
            <h4 class="wallet-text-below-button label-deposit">Top Up</h4>
          </div>
        </div>
    </div>

    <!--<p>
        <?= Html::a('Deposit', ['deposit'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Withdraw', ['withdraw'], ['class' => 'btn btn-success']) ?>
    </p>-->
<?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'user_id',
                'label' => 'User',
                'value' => function($model){
                    if ($model->user)
                    {return $model->user->username;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->asArray()->all(), 'id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'User', 'id' => 'grid--user_id']
            ],
        'balance',
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ]; 
    ?>


</div>
