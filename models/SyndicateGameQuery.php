<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SyndicateGame]].
 *
 * @see SyndicateGame
 */
class SyndicateGameQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SyndicateGame[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SyndicateGame|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}