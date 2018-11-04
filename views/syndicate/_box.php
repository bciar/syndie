<?php
/**
 * Created with love.
 * User: benas
 * Date: 5/20/17
 * Time: 8:29 PM
 */

/**
 * @var $model \app\models\Syndicate
 * @var $transaction \app\models\Transaction
 */

use yii\helpers\Html;

if (!$model->game->nextDraw) return;

$attention = false;

if ($transaction) {
    foreach ($transaction->tickets as $ticket) {
        if ($ticket->syndicate_id == $model->id) {
            $attention = true;
        }
    }

}

?>
<div style="padding:20px;" class="col-md-3">
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
            <?= Html::img($model->game->logo_path, ['class' => 'img-small', 'style' => 'padding:15px 10px;']) ?>

            <p class="boxHeadlines">
                <b><?php echo $model->syndie_lines_per_person ?></b> Lines per share,
                <b><?php echo $model->num_lines ?></b> so far
            </p>
            <p class="boxHeadlines">
                <b>
                    <?php
                    if (isset($model->max_players)) {
                        echo $model->max_players - $model->players;

                    } else {
                        //echo '&#x221e;';
                        echo 'Unlimited';
                    }
                    ?>
                </b> Shares available
            </p>


            <p class="boxHeadlines">
                <b><?= $model->draw->formatDrawDate() ?></b><br>
                Est. Jackpot: <b>£<?= $model->draw->formatEstJackpot() ?></b><br>
            </p>


            <p style="display: none; " data-shake="<?= $attention ? 1 : 0 ?>">

            </p>

        </div>
        <div class="card-footer">
            <div class="fleft col-6">Total (1 share)<br/><b>£<?php echo $model->cost_per_share ?></b></div>
            <div class="fright col-6" style="padding-top: 10px;">
                <?php

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
                ?>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</div>
<?php
$this->registerJs(
    '$( "[data-shake=1]" ).each(function(){
    $(this).effect( "shake" );
})');
?>
