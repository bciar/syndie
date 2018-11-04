<?php

use yii\helpers\Html;
use yii\helpers\Url;


/**
 * @var $user \app\models\User
 * @var $transaction \app\models\Transaction
 * @var $syndicates \app\models\Syndicate[]
 * @var $member_syndicates \app\models\Syndicate[]
 */

if (!Yii::$app->user->isGuest && $user->id == Yii::$app->user->id) {

	echo $this->render('/wallet/newheader.php'); 

}

?>
<div class="whiteBack">
<?php
if ($user->type == 'sponsor' && $user->brand) {
    $headBackColour = $user->brand->head_back_colour;
    $headForeColour = $user->brand->head_fore_colour;
} else {
    $headBackColour = 'blue';
    $headForeColour = 'white';
}

$transaction_sids = [];

if ($transaction) {
		$all_private = 1;
    $transaction_syndicates = [];
    foreach ($transaction->tickets as $ticket){
        $transaction_syndicates[] = $ticket->syndicate;
				$transaction_sids[] = $ticket->syndicate->id;
				if ($ticket->syndicate->privacy_level_id > 1) {
					$all_private = 0;
				}
    }
		if (count($transaction->tickets) > 1) {
			$text = 'your Syndies have';
		} else {
			$text = 'your Syndie has';
		}
		echo "<div class=mainHeader>Congratulations - $text been purchased!</div>";
		if ($all_private == 0) {
			echo "<div class=instructionText>Now's the time to get people involved - click the share links on the right of your syndicates below to share them on social media!</div>";
		}
	
		/*
    echo Html::tag('h4', 'You have purchased the following syndies');

    echo $this->render('_slider', [
        'transaction' => $transaction,
        'syndicates' => $transaction_syndicates
    ]);
		*/
    /*echo $this->render('//basket/confirm-purchase', [
        'transaction' => $transaction
    ]);*/
}
/*
?>

    <div id="publicHeader"
         style="color: <?php echo $headForeColour ?>; background-color: <?php echo $headBackColour ?>">
    </div>
    <div id="publicMain">
    </div>

<?php
*/
if (!Yii::$app->user->isGuest && $user->id == Yii::$app->user->id) {

	//echo Html::tag('h4', "My Syndicates"); 
	echo '<br /><br />';
	echo '<div class="basketTable">';
  echo '<div class="headerRow">';
  echo '<div class="cell topLeft">Game</div>';
  echo '<div class="cell">Syndie Name</div>';
  echo '<div class="cell">Creator</div>';
  echo '<div class="cell">Draw Date</div>';
  echo '<div class="cell">Est. Jackpot</div>';
  echo '<div class="cell">Cost per Share</div>';
  echo '<div class="cell">Lines per Share</div>';
  echo '<div class="cell">No. of Shares</div>';
  echo '<div class="cell">Subtotal</div>';
  echo '<div style="width: 120px" class="cell topRight">Actions</div>';
  echo '</div>';

	foreach ($syndicates as $s) {
		echo $this->render('_table', ['model' => $s, 'purchased' => $transaction_sids]);
	}
  foreach ($member_syndicates as $s) {
    echo $this->render('_table', ['model' => $s, 'purchased' => $transaction_sids]);
  }

	if (count($syndicates) == 0 && count($member_syndicates) == 0) {
		echo '<div class=padSmall>You have no active Syndies.  Why not ';
		echo '<a href="' . Url::toRoute(['syndicate/create']);
		echo '">start one?</a></div>';
	}
	echo '</div>';
} else {
  echo '<p class="mainHeader">' . $user->profile->name . "'s Syndicates</p>";


	echo $this->render('_slider', [
		'transaction' => $transaction,
		'syndicates' => $syndicates
	]);

}
?>
<br /><br />
</div>
