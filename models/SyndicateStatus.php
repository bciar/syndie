<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "syndicate_status".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Syndicate[] $syndicates
 */
class SyndicateStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'syndicate_status';
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
        return $this->hasMany(Syndicate::className(), ['syndicate_status_id' => 'id']);
    }
}
