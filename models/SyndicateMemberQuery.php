<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SyndicateMember]].
 *
 * @see SyndicateMember
 */
class SyndicateMemberQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SyndicateMember[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SyndicateMember|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}