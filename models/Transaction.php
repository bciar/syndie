<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property integer $transaction_status_id
 *
 * @property TransactionStatus $transactionStatus
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_status_id'], 'integer'],
            [['transaction_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionStatus::className(), 'targetAttribute' => ['transaction_status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_status_id' => 'Transaction Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionStatus()
    {
        return $this->hasOne(TransactionStatus::className(), ['id' => 'transaction_status_id']);
    }

    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['transaction_id' => 'id']);
    }

}
