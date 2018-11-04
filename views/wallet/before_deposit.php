<?php
/**
 * Created with love.
 * User: benas
 * Date: 7/4/17
 * Time: 7:39 PM
 */

/**
 * @var $user \app\models\User
 */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use app\components\DatePicker;

?>

<?= $this->render('newheader.php'); ?>
<?= $this->render('newsidebar.php'); ?>

<div class="row wallet-button-wrapper">
    <?php

echo Html::tag('div', 'We need to get a few more details before you make your first deposit...', [
    'class' => 'alert alert-info'
]);

$form = ActiveForm::begin();

if(!$user->username){
    echo $form->field($user, 'username');
}

if(!$user->dob || $user->dob == '0000-00-00'){
    echo $form->field($user, 'dob')->widget(DatePicker::className(),[
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose'=>true,
        ]
    ]);
}

foreach(['address1', 'address2', 'address3', 'city', 'postcode'] as $attribute){
    if(!$user->$attribute){
        echo $form->field($user, $attribute);
    }
}

echo Html::submitButton('Continue', [
    'class' => 'btn btn-success'
]);


ActiveForm::end();

?>
    </div>
