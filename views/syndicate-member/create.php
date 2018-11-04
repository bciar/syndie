<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SyndicateMember */

$this->title = 'Create Syndicate Member';
$this->params['breadcrumbs'][] = ['label' => 'Syndicate Member', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syndicate-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
