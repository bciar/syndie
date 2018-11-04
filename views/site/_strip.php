<?php

use app\models\Game;
use yii\helpers\Html;

/**
 * @var $games Game[]
 */
$games = Game::find()->where(['active' => 1])->all();
?>
<!--<div style="background-color:rgba(230, 230, 230, 0.5);">-->
<?php 
//array_push($games, $games[0]);
    $columns = count($games);
    if ($columns >= 4) $columns = 3;
    else if ($columns == 0) $columns = 1;
?>
<div class="container-original-wrapper">
<div class="container-original" style="margin:0px auto;">
    <div class="row hidden-md-down" style="<?=$columns==2 ? 'width:800px;' : 'width:100%;'?> margin:auto;">
        <?php foreach ($games as $game): ?>
            <div class="strip-item" style="width:<?= $columns==2 ? '400px' : 100/$columns.'%'?>">
                <div class="well game row knockout-around">
									<div class="desc">
									Play <?php echo $game->name; ?>
									</div>


                        <div class="col-md-5 strip-logo">
                            <?= Html::img($game->logo_path, ['class' => 'img-fluid', 'style'=>'padding:15px 10px;']) ?>

                        </div>
                        <div class="col-md-7" style="padding:25px 0px 15px 10px;">

                            <p class="strip-content">
                                Next Draw: <?= Yii::$app->dates->mysql2ukTextDateTime($game->nextDraw->draw_date) ?>
                            </p>
                            <p class="strip-content">
                            <span>
                                Est. Jackpot: <?= '£' . number_format($game->nextDraw->est_jackpot, 0, '', ',') ?>
                                </span>
                            </p>
                            <p>
                              <?= Html::a('Game Info', $game->getInfoUrl(), ['class' => 'bigBut btn-info']) ?>

                            </p>

                        </div>
                </div>
                    <?= Html::a('Start Syndie', $game->getJoinUrl(), ['class' => 'bigBut btn-new-syn nav-link col-lg-6 offset-xl-3']) ?>
            </div>
        <?php endforeach; ?>    
    </div>

    <div class="row hidden-lg-up">
        <?php foreach ($games as $game): ?>
            <div class="col-12" style="margin-bottom:20px;">
                <div class="well game row">
                        <div class="col-4 strip-logo">
                            <?= Html::img($game->logo_path, ['class' => 'img-fluid', 'style'=>'width:100px;']) ?>
                        </div>
                        <div class="col-8" style="padding:50px 0px 15px 10px;">
                            <p class="strip-content">
                                Next Draw: <?= Yii::$app->dates->mysql2ukTextDateTime($game->nextDraw->draw_date) ?>
                            </p>
                            <p class="strip-content">
                            <span>
                                Est. Jackpot: <?= '£' . number_format($game->nextDraw->est_jackpot, 0, '', ',') ?>
                                </span>
                            </p>
                            <p>
                              <?= Html::a('Game Info', $game->getInfoUrl(), ['class' => 'bigBut btn-info']) ?>

                            </p>

                        </div>
                </div>
                    <?= Html::a('<b>Create</b>', $game->getJoinUrl(), ['class' => 'triangle-button']) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
<!--<div style="height:30px;"></div>
</div>-->
