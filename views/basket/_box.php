<?php

use yii\helpers\Html;
?>

<div class="row">
	<div class="cell">
		<?= Html::img($model->game->logo_path, ['class' => 'img-small']) ?>
	</div>
	<div class="cell">
		<?php echo $model->name; ?>
	</div>
  <div class="cell">
    <?= Html::img($model->creatorUser->avatar, ['class' => 'small-user']) ?>
  </div>
	<div class="cell">
		<?= $model->draw->formatDrawDate() ?>
	</div>
	<div class="cell">
		£<?= $model->draw->formatEstJackpot() ?>
	</div>
	<div class="cell">
		£<?php echo $model->cost_per_share ?>
	</div>
	<div class="cell">
		<?php echo $model->syndie_lines_per_person?> 
	</div>
  <div class="cell">
    1
  </div>
  <div class="cell">
    <?php echo $model->number_of_draws ?>
  </div>
  <div class="cell">
    £<?php echo number_format($model->cost_per_share * $model->number_of_draws, 2) ?>
  </div>

</div>
