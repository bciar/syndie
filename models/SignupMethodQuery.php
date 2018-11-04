<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SignupMethod]].
 *
 * @see SignupMethod
 */
class SignupMethodQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SignupMethod[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SignupMethod|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}