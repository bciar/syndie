<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SyndicateGame */

$this->title = 'Create Syndicate Game';
$this->params['breadcrumbs'][] = ['label' => 'Syndicate Game', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syndicate-game-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
