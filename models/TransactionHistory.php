<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $transaction_date
 * @property string $amount
 * @property string $reference
 * @property string $type
 * @property integer $status
 */
class TransactionHistory extends \yii\db\ActiveRecord
{
    const STATUS_PAID = 1;
    const STATUS_FAILURE = 0;

    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_BUY = 'buy';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['transaction_date'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'transaction_date' => 'Transaction Date',
            'amount' => 'Amount',
        ];
    }
}
