<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/6/17
 * Time: 5:31 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WithdrawForm */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->render('newheader.php'); ?>
<?= $this->render('newsidebar.php'); ?>

<div class="row">

<div class="col-md-8" style="padding: 50px;">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->errorSummary($model); ?>

	    <div class="row" style="border: 2px solid purple;border-radius: 18px;padding: 0px;    background-color: rgba(227, 206, 229, 0.7);">
	    	<div class="col-md-3 label-amount-wrapper">
				<label class="label-amount">Amount</label>
			</div>
			<div class="col-md-9" style="display:inline-block;">
				<input type="number" step=0.01 id="withdrawform-amount" class="input-amount" name="WithdrawForm[amount]" aria-required="true" placeholder="Enter winnings you'd like to take...">
			</div>
			<div class="clearfix"></div>
		</div>

		    <div class="form-group col-md-4" style="margin-top:50px;">
		        <?= Html::submitButton("Let's go!!", ['class' => 'btn btn-letsgo', 'style'=>'margin-left: -25px;']) ?>
		    </div>
		<div class="help-block"></div>
	    <?php ActiveForm::end(); ?>
</div>

<div class="col-md-4">
<?= $this->render('_photoWrapper'); ?>
</div>
</div>

<?= $this->render('newfooter.php'); ?>