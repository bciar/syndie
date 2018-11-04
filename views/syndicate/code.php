<?php
/**
 * Created with love.
 * User: benas
 * Date: 5/10/17
 * Time: 5:50 AM
 */

/**
 * @var $code \app\models\SyndicateCodeForm
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin();

echo Html::tag('div', 'Enter private code to join syndicate', [
    'class' => 'alert alert-info'
]);

echo $form->field($code, 'code');
echo $form->field($code, 'retries')->hiddenInput()->label(false);

echo Html::submitButton('Enter', ['class' => 'btn btn-success']);
ActiveForm::end();