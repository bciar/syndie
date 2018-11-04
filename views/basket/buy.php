<?php

use app\models\Basket;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?= $this->render('/wallet/newheader.php'); ?>

<?= Html::cssFile('@web/css/owl.carousel.min.css') ?>
<?= Html::cssFile('@web/css/owl.theme.default.min.css') ?>


<?php
// retrieve basket

/**
 * @var \app\models\Transaction $tickets
 * @var \app\models\BuyForm $model
 */

echo '<div class="whiteBack" style="padding-top:80px;">';
$balance = Yii::$app->user->identity->wallet->balance;
$tickets = Basket::getTickets();
$total_cost = 0;
foreach ($tickets as $ticket) {
    //$total_cost += (double) $ticket->syndicate->costOfLines;
		$total_cost += $ticket->syndicate->cost_per_share * $ticket->syndicate->number_of_draws;
}
?>
<div class="basketTable">
	<div class="headerRow">
		<div class="cell topLeft">Game</div>
    <div class="cell">Syndie Name</div>
    <div class="cell">Creator</div>
    <div class="cell">Draw Date</div>
    <div class="cell">Est. Jackpot</div>
    <div class="cell">Cost per Share</div>
    <div class="cell">Lines per Share</div>
    <div class="cell">No. Shares</div>
    <div class="cell">No, Draws </div>
    <div class="cell topRight">Subtotal</div>

	</div>


<?php 
    $tIdArr = [];
    foreach ($tickets as $ticket) {
        //echo $ticket->id . '<br />';
        //echo "<br /><br />You have created a syndicate with ID #" . $ticket->syndicate_id;
        $tIdArr[] = $ticket->id;
//        echo '<div class="item">';
            echo $this->render("_box", ['attention' => 0, 'model' => $ticket->syndicate, 'ticket' => $ticket]);
  //      echo '</div>';
    }
?>
<div class="bottomRow">
<?php 
if ($balance < $total_cost) {

    echo 'Total Cost: £' . $total_cost . '<br /><br />';
    //echo 'Wallet Balance: £' . $balance . '<br /><br />';

    //echo "You need to add more funds to complete your purchase.<br /><br />";
    echo Html::a('Deposit Now', ['/wallet/deposit'], ['class' => 'btn btn-primary']);

} else {

    $form = ActiveForm::begin(['action' => ['/basket/buy']]);

    echo '<b>TOTAL: £' . number_format($total_cost,2) . '</b><br /><br />';

		if ($total_cost > 0) { 
			echo Html::submitButton('Buy Now', ['class' => 'btn btn-primary']);
			echo Html::activeHiddenInput($model, 'amount', ['value' => $total_cost]);
			echo Html::activeHiddenInput($model, 'tIdStr', ['value' => implode(",", $tIdArr)]);
		} else {
			echo 'Your basket is empty.';
		}

    ActiveForm::end();

}

?>
</div>
</div>
<br /><br />
</div>
<?= Html::jsFile('@web/js/owl.carousel.min.js') ?>
<script>
$('.owl-carousel').owlCarousel({
    loop:false,
    margin:10,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
})
</script>
