<?php

use app\models\Transaction;
use yii\widgets\DetailView;
use yii\helpers\Html;

/**
 * @var $transaction Transaction
 */

echo Html::tag('div', '<i class="fa fa-ticket"></i> Purchase Confirmed: Transaction #' . $transaction->id, [
    'class' => 'alert alert-success'
]);


?>

<h3>Purchased tickets:</h3>
<div class="row">
    <?php foreach ($transaction->tickets as $ticket): ?>
        <div class="col-md-4">
            <?= DetailView::widget([
                'model' => $transaction,
                'attributes' => [
                    [                      // the owner name of the model
                        'label' => 'Syndicate #',
                        'value' => $ticket->syndicate_id
                    ],
                    [
                        'label' => 'Lines per person',
                        'value' => $ticket->syndicate->syndie_lines_per_person,
                    ],
                    [
                        'label' => 'Per person',
                        'value' => '£' . $ticket->syndicate->cost_per_share
                    ]
                ],
            ]) ?>
        </div>

    <?php endforeach ?>
</div>