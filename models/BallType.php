<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ball_type".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $hierarchy
 * @property string $name
 * @property integer $quantity_in_pot
 * @property integer $quantity_drawn
 *
 * @property Game $game
 */
class BallType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ball_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'hierarchy', 'quantity_in_pot', 'quantity_drawn'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'hierarchy' => 'Hierarchy',
            'name' => 'Name',
            'quantity_in_pot' => 'Quantity In Pot',
            'quantity_drawn' => 'Quantity Drawn',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }
}
