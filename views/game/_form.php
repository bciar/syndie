<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Game */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'BallType', 
        'relID' => 'ball-type', 
        'value' => \yii\helpers\Json::encode($model->ballTypes),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Draw', 
        'relID' => 'draw', 
        'value' => \yii\helpers\Json::encode($model->draws),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Line', 
        'relID' => 'line', 
        'value' => \yii\helpers\Json::encode($model->lines),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Prize', 
        'relID' => 'prize', 
        'value' => \yii\helpers\Json::encode($model->prizes),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'SyndicateGame', 
        'relID' => 'syndicate-game', 
        'value' => \yii\helpers\Json::encode($model->syndicateGames),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="game-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'country_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Country::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Choose Country'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'price_per_line')->textInput(['maxlength' => true, 'placeholder' => 'Price Per Line']) ?>

    <?= $form->field($model, 'logo_path')->textInput(['maxlength' => true, 'placeholder' => 'Logo Path']) ?>

    <?= $form->field($model, 'next_draw')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Next Draw',
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'active')->textInput(['placeholder' => 'Active']) ?>

    <?= $form->field($model, 'draw_frequency')->textInput(['maxlength' => true, 'placeholder' => 'Draw Frequency']) ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('BallType'),
            'content' => $this->render('_formBallType', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->ballTypes),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Draw'),
            'content' => $this->render('_formDraw', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->draws),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Line'),
            'content' => $this->render('_formLine', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->lines),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Prize'),
            'content' => $this->render('_formPrize', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->prizes),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('SyndicateGame'),
            'content' => $this->render('_formSyndicateGame', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->syndicateGames),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
