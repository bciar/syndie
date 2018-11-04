<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>
<div class="wallet-top-wrapper">
<div class="photo" style="position:absolute; left:50px; top: 5px;z-index: 10">
	<div style="float:left;">
	<?=Html::img(Yii::$app->user->identity->getAvatar(), ['alt' => 'My Photo', 'width'=>'125px', 'height'=>'125px', 'style'=>'border-radius:50%;'])?>
	</div>
	<div style="float:left;padding-top:20px;padding-left:20px;">
	<h2 class="purple-color"><?=Yii::$app->user->identity->profile->name ?></h2>
	</div>
</div>
<ul class="nav">
  <li class="nav-item custom-navitem">
    <a class="nav-link custom-navlink wallet-top-nav-item parallelogram text-center <?php if ($controller=="syndicate" && $action=="public") echo 'active'; ?>" href="<?= Url::toRoute(['syndicate/public', 'username' => Yii::$app->user->identity->username]) ?>"><span>My Syndies</span></a>
  </li>
  <li class="nav-item custom-navitem">
    <a class="nav-link custom-navlink wallet-top-nav-item parallelogram text-center <?php if ($controller=="wallet") echo 'active'; ?>" href="<?= Url::toRoute(['wallet/history']) ?>"><span>My Wallet</span></a>
  </li>
  <li class="nav-item custom-navitem">
    <a class="nav-link custom-navlink wallet-top-nav-item parallelogram text-center <?php if ($controller=="game" || $controller == 'basket') echo 'active'; ?>" href="<?= Url::toRoute(['basket/buy']) ?>"><span>My Basket</span></a>
  </li>
</ul>
</div>
<div class="bottom-strip"></div>
