<?php
/**
 * Created with love.
 * User: benas
 * Date: 5/21/17
 * Time: 11:11 PM
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;

?>
<div class="alert alert-info bigPad">
<div class="mainHeader">
Welcome to Syndie!
</div>

    To sign up with Syndie, you must first confirm you have read our Terms & Conditions<br /><br />

    <?php

    Modal::begin([
        'header' => 'Terms & Conditions',
        'toggleButton' => ['label' => 'Click here to read'],
    ]);

    echo $this->render('tacText');

    Modal::end();

    ?>
<br /><br />
<?= Html::a('Confirm', ['site/tac', 'confirm' => 1], [
    'class' => 'btn btn-success'
]); ?>
    
</div>


