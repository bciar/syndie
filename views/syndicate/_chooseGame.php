<div class="col-xl-12 gameChoice">
<h2 class="text-center title-choose-game">Choose Your Game</h2>
</div>

<?php

use app\models\Game;
use yii\helpers\Html;

/**
 * @var $games Game[]
 */
$games = Game::find()->where(['active' => 1])->all();
?>
<div>
<div class="container gameChoice" style="padding:10px 10%;">
    <div class="col-md-12 row">
        <?php foreach ($games as $game) : ?>
            <div class="col-md-3" style="padding:3%;">
                <div class="well game-choose row">
                        <div class="col-md-12">
                            <?= Html::img($game->logo_path, ['class' => 'img-fluid', 'style'=>'padding:15px 10px;']) ?>
                        </div>
                        <div class="col-md-12" style="padding:10px 50px;">
                            <p class="strip-content">
                                <i class="fa fa-calendar"></i>
                                Next: <?= Yii::$app->dates->mysql2ukTextDateTime($game->nextDraw->draw_date) ?>
                            </p>
                            <p class="strip-content">
                            <span>
                                <i class="fa fa-money"></i>
                                Jackpot: <?= '£' . number_format($game->nextDraw->est_jackpot, 0, '', ',') ?>
                                </span>
                            </p>
                        </div>
                </div>
                    <?= Html::a('Start Syndie', $game->getJoinUrl(), ['class' => 'bigBut btn-new-syn nav-link col-xl-12']) ?>
            </div>
            <?php endforeach ?>
    </div>
</div>
<div style="background-color: white; height:30px;"></div>
</div>
