<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/6/17
 * Time: 5:25 PM
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DepositForm */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->render('newheader.php'); ?>
<?= $this->render('newsidebar.php'); ?>

<!-- <div class="row wallet-button-wrapper">-->
<div class="row">

<div class="col-md-8" style="padding: 50px;">
<div class="deposit-form" style="width:100%">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <div class="row" style="border: 2px solid purple;border-radius: 18px;padding: 0px;    background-color: rgba(227, 206, 229, 0.7);">
    	<div class="col-md-3 label-amount-wrapper">
			<label class="label-amount">Amount</label>
		</div>
		<div class="col-md-9" style="display:inline-block;">
			<input type="number" step=0.01 id="depositform-amount" class="input-amount" name="DepositForm[amount]" aria-required="true" aria-invalid="true" placeholder="Enter amount to top-up...">
		</div>
		<div class="clearfix"></div>
	</div>

	    <div class="form-group col-md-4" style="margin-top:50px;">
	        <?= Html::submitButton("Let's go!!", ['class' => 'btn btn-letsgo', 'style'=>'margin-left: -25px;']) ?>
	    </div>
	<div class="help-block"></div>


    <?php ActiveForm::end(); ?>

</div>
</div>
<div class="col-md-4">
<?= $this->render('_photoWrapper'); ?>
</div>

</div>
<!-- </div> -->
<?= $this->render('newfooter.php'); ?>
<!--
<div class="deposit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'amount')->textInput(); ?>

    <div class="form-group">
        <?= Html::submitButton('Deposit', ['class' => 'btn btn-success']) ?>
    </div>
		<input type="hidden" name="referrer" value="<?php echo $referrer ?>">
    <?php ActiveForm::end(); ?>

</div>
-->