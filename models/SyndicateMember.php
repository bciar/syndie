<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "syndicate_member".
 *
 * @property integer $syndicate_id
 * @property integer $user_id
 *
 * @property Syndicate $syndicate
 * @property User $user
 */
class SyndicateMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'syndicate_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['syndicate_id', 'user_id'], 'integer'],
            [['syndicate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Syndicate::className(), 'targetAttribute' => ['syndicate_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'syndicate_id' => 'Syndicate ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicate()
    {
        return $this->hasOne(Syndicate::className(), ['id' => 'syndicate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
