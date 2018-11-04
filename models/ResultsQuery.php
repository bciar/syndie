<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Results]].
 *
 * @see Results
 */
class ResultsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Results[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Results|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}