<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TransactionHistory]].
 *
 * @see TransactionHistory
 */
class TransactionHistoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TransactionHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TransactionHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}