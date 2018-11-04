<?php

use yii\helpers\Html;

if (in_array($model->id, $purchased)) {

	$class = "flash";

} else {

	$class = "";

}

?>

<div class="row <?= $class ?>">
	<div class="cell">
		<?= Html::img($model->game->logo_path, ['class' => 'img-small']) ?>
	</div>
	<div class="cell">
		<b><?php echo $model->name; ?></b>
	</div>
  <div class="cell">
    <?= Html::img($model->creatorUser->avatar, ['class' => 'small-user']) ?>
  </div>
	<div class="cell">
		<b><?= $model->draw->formatDrawDate() ?></b>
	</div>
	<div class="cell">
		<b>£<?= $model->draw->formatEstJackpot() ?></b>
	</div>
	<div class="cell">
		<b>£<?php echo $model->cost_per_share ?></b>
	</div>
	<div class="cell">
		<b><?php echo $model->syndie_lines_per_person?></b> 
	</div>
  <div class="cell">
    <b>1</b>
  </div>
  <div class="cell">
    <b>£<?php echo $model->cost_per_share ?></b>
  </div>

<?php
	if (!isset($hideActions)) { $hideActions = 0; }
	if ($hideActions == 0) {
  	echo '<div class="cell">';

                if ($model->can('share')) {

                    $share_url = Yii::$app->urlManager->createAbsoluteUrl(['syndicate/view', 'id' => $model->id, 'share' => false]);

                    ?>

                    <!-- Single button -->
                    <div class="btn-group dropup">
                        <button type="button" class="bigBut btn-share col-md-12 dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Share <i class="fa fa-share"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><?= Html::a('<i class="fa fa-facebook"></i> Facebook', ['syndicate/share', 'id' => $model->id], [
                                    'data-confirm' => 'Are you sure you want to share this syndie?'
                                ]); ?></li>
                            <li><?= Html::a('<i class="fa fa-twitter"></i> Twitter', 'http://twitter.com/share?url=' . $share_url, [
                                    'data-confirm' => 'Are you sure you want to share this syndie?'
                                ]) ?></li>
                        </ul>
                    </div>
                    <?php

                } else if ($model->can('join')) {
                    echo Html::a('Join <i class="fa fa-plus"></i>', ['syndicate/join', 'id' => $model->id], [
                        'class' => 'bigBut btn-join col-md-12'
                    ]);
                }

		echo '</div>';
	}
?>
</div>
