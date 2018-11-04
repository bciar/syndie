<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\ColorInput;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Brand */
/* @var $form yii\widgets\ActiveForm */

$options = [
    'options' => ['placeholder' => 'Select color ...'],
];
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'slogan')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'head_back_colour')->widget(ColorInput::className(), $options) ?>

    <?= $form->field($model, 'head_fore_colour')->widget(ColorInput::className(), $options) ?>

    <?= $form->field($model, 'main_back_colour')->widget(ColorInput::className(), $options) ?>

    <?= $form->field($model, 'main_fore_colour')->widget(ColorInput::className(), $options) ?>

    <?php foreach ($model->images as $attribute): ?>

        <?= $form->field($model, $attribute)->widget(FileInput::className(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showPreview' => false,
                'initialPreview' => $model->$attribute ? [
                    $model->$attribute
                ] : []
            ]
        ]) ?>
    <?php endforeach ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
