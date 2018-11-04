<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "result".
 *
 * @property integer $id
 * @property integer $draw_id
 * @property integer $drawn_number
 * @property integer $position
 * @property integer $ball_category_id
 * @property integer $ball_hierarchy
 *
 * @property Draw $draw
 */
class Result extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['draw_id', 'drawn_number', 'position', 'ball_category_id', 'ball_hierarchy'], 'integer'],
            [['draw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draw::className(), 'targetAttribute' => ['draw_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'draw_id' => 'Draw ID',
            'drawn_number' => 'Drawn Number',
            'position' => 'Position',
            'ball_category_id' => 'Ball Category ID',
            'ball_hierarchy' => 'Ball Hierarchy',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraw()
    {
        return $this->hasOne(Draw::className(), ['id' => 'draw_id']);
    }
}
