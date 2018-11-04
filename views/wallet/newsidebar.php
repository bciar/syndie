<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>
<div class="row m0">
<div class="col-md-3 sidebar p0">
<div class="text-center" style="padding-top:30px;">
	<div style="text-align: left; width: 200px; margin:0px auto;">
    <h1 class="purple-color" style="font-size:40px;"><span><i class="fa fa-gbp" aria-hidden="true" style="vertical-align: initial;padding-right:5px;"></i><?=Yii::$app->user->identity->wallet->balance ?></span></h1>
    <h4 class="purple-color" style="font-weight:600;">Wallet Balance</h4>
    </div>
</div>
<div class="list-group">
	<a class="list-group-item <?php if ($controller=="wallet" && $action=="history") echo 'active'; ?>" href="<?= Url::toRoute(['wallet/history']) ?>">
		<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;Transaction History
	</a>
	<a class="list-group-item <?php if ($controller=="wallet" && $action=="deposit") echo 'active'; ?>" href="<?= Url::toRoute(['wallet/deposit']) ?>">
		<i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Top up
	</a>
	<a class="list-group-item <?php if ($controller=="wallet" && $action=="withdraw") echo 'active'; ?>" href="<?= Url::toRoute(['wallet/withdraw']) ?>">
		<i class="fa fa-money" aria-hidden="true"></i> &nbsp;Withdraw
	</a>
</div>
</div>
<?php 
$bkclass = "";
if ($controller=="wallet" && $action=="history")
	$bkclass = "wallet-history-bk";
elseif ($controller=="wallet" && ($action=="deposit" || $action=="withdraw"))
	$bkclass = "wallet-deposit-bk";
?>
<div class="whiteBack col-md-9 <?= $bkclass ?>">
