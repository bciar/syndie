<?php
use yii\helpers\Html;
?>
  <div style="padding:20px;" class="col-md-12">
    <div class="card <?= $attention ? 'attention' : '' ?>">
        <div class="desc">
        <?php echo $model->name; ?>
        </div>

      <div class="captionHolder">
        <?= Html::img($model->creatorUser->avatar, [
            'class' => 'card-img-top img-fluid',
            'style' => 'width: 100%; min-height:122px'
        ]) ?>
      </div>
        <div class="card-block">
            <?= Html::img($model->game->logo_path, ['class' => 'img-small', 'style'=>'padding:15px 10px;']) ?>

            <p class="boxHeadlines">
                <b><?= $model->draw->formatDrawDate() ?></b><br>
                Est. Jackpot: <b>£<?= $model->draw->formatEstJackpot() ?></b><br>
            </p>


            <p style="display: none; " data-shake="<?= $attention ? 1 : 0 ?>">
            </p>

        </div>
        <div class="card-footer">
          Total (1 share)<br /><b>£<?php echo $model->cost_per_share ?></b>
        </div>

    </div>
</div>

