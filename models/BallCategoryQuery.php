<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BallCategory]].
 *
 * @see BallCategory
 */
class BallCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BallCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BallCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}