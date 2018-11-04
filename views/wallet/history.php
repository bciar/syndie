<?php
/**
 * Created with love.
 * User: benas
 * Date: 7/9/17
 * Time: 3:30 PM
 */

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;

?>
<?= $this->render('newheader.php'); ?>
<?= $this->render('newsidebar.php'); ?>

<table class="transaction-history">
<thead>
    <tr>
        <th>Transaction Name</th> 
        <th>Payment Reference</th>
        <th>Amount(£)</th>
        <th>Date</th> 
    </tr>
</thead>
<tbody>
    <?php foreach ($transactions as $row): ?>
    <tr>
        <td><?= $row->type ?></td>
        <td><?= $row->reference ?></td>
        <td><?= $row->amount ?></td>
        <td><?= $row->transaction_date ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
</table>
<!--
<div class="wallet-button-wrapper">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'PAYMENT TYPE',
                'value' => function($model){
                    //var_dump($model); exit;
                    if($model->type == $model::TYPE_WITHDRAWAL){
                        return 'Withdrawal';
                    } else if($model->type == $model::TYPE_DEPOSIT){
                        return 'Deposit';
                    } else if($model->type == $model::TYPE_BUY){
                        return 'Purchase';
                    }
                }
            ],
            [
                'attribute' => 'reference',
                'label' => 'PAYMENT REFERENCE'
            ],
            [
                'attribute' => 'amount',
                'label' => 'AMOUNT (£)'
            ],
            [
                'attribute' => 'transaction_date',
            ]
        ]
    ]) ?>
</div>-->

<?= $this->render('newfooter.php'); ?>
