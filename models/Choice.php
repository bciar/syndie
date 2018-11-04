<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "choice".
 *
 * @property integer $id
 * @property integer $line_id
 * @property integer $chosen_number
 * @property integer $position
 * @property integer $ball_hierarchy
 *
 * @property Line $line
 * @property BallType $ballType
 */
class Choice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'choice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['line_id', 'chosen_number', 'position', 'ball_hierarchy'], 'integer'],
            [['line_id'], 'exist', 'skipOnError' => true, 'targetClass' => Line::className(), 'targetAttribute' => ['line_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'line_id' => 'Line ID',
            'chosen_number' => 'Chosen Number',
            'position' => 'Position',
            'ball_hierarchy' => 'Ball Hierarchy',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(Line::className(), ['id' => 'line_id']);
    }

    public function getBallType()
    {
        return $this->hasOne(BallType::className(), ['id' => 'ball_hierarchy']);
    }
}
