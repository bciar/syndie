<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SyndicateLine */

$this->title = 'Create Syndicate Line';
$this->params['breadcrumbs'][] = ['label' => 'Syndicate Line', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syndicate-line-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
