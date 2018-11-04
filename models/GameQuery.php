<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Game]].
 *
 * @see Game
 */
class GameQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Game[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Game|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}