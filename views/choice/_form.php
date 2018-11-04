<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Choice */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="choice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'line_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Line::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
        'options' => ['placeholder' => 'Choose Line'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'chosen_number')->textInput(['placeholder' => 'Chosen Number']) ?>

    <?= $form->field($model, 'position')->textInput(['placeholder' => 'Position']) ?>

    <?= $form->field($model, 'ball_category_id')->textInput(['placeholder' => 'Ball Category']) ?>

    <?= $form->field($model, 'ball_hierarchy')->textInput(['placeholder' => 'Ball Hierarchy']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
