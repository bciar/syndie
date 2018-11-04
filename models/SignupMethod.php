<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "signup_method".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_social_media
 */
class SignupMethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'signup_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_social_media'], 'integer'],
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
            'is_social_media' => 'Is Social Media',
        ];
    }
}
