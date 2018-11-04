<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "privacy_level".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Syndicate[] $syndicates
 */
class PrivacyLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'privacy_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicates()
    {
        return $this->hasMany(Syndicate::className(), ['privacy_level_id' => 'id']);
    }
}
