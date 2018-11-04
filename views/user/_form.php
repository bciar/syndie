<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'SocialAccount', 
        'relID' => 'social-account', 
        'value' => \yii\helpers\Json::encode($model->socialAccounts),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Syndicate', 
        'relID' => 'syndicate', 
        'value' => \yii\helpers\Json::encode($model->syndicates),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'SyndicateMember', 
        'relID' => 'syndicate-member', 
        'value' => \yii\helpers\Json::encode($model->syndicateMembers),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Token', 
        'relID' => 'token', 
        'value' => \yii\helpers\Json::encode($model->tokens),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Username']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'placeholder' => 'Password Hash']) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true, 'placeholder' => 'Auth Key']) ?>

    <?= $form->field($model, 'confirmed_at')->textInput(['placeholder' => 'Confirmed At']) ?>

    <?= $form->field($model, 'unconfirmed_email')->textInput(['maxlength' => true, 'placeholder' => 'Unconfirmed Email']) ?>

    <?= $form->field($model, 'blocked_at')->textInput(['placeholder' => 'Blocked At']) ?>

    <?= $form->field($model, 'registration_ip')->textInput(['maxlength' => true, 'placeholder' => 'Registration Ip']) ?>

    <?= $form->field($model, 'flags')->textInput(['placeholder' => 'Flags']) ?>

    <?= $form->field($model, 'last_login_at')->textInput(['placeholder' => 'Last Login At']) ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Profile'),
            'content' => $this->render('_formProfile', [
                'form' => $form,
                'Profile' => is_null($model->profile) ? new app\models\Profile() : $model->profile,
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('SocialAccount'),
            'content' => $this->render('_formSocialAccount', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->socialAccounts),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Syndicate'),
            'content' => $this->render('_formSyndicate', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->syndicates),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('SyndicateMember'),
            'content' => $this->render('_formSyndicateMember', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->syndicateMembers),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Token'),
            'content' => $this->render('_formToken', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->tokens),
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
