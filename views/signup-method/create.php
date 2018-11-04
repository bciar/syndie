<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SignupMethod */

$this->title = 'Create Signup Method';
$this->params['breadcrumbs'][] = ['label' => 'Signup Method', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup-method-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
