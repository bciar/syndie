<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "syndicate_game".
 *
 * @property integer $syndicate_id
 * @property integer $game_id
 *
 * @property Game $game
 * @property Syndicate $syndicate
 */
class SyndicateGame extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'syndicate_game';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['syndicate_id', 'game_id'], 'integer'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['syndicate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Syndicate::className(), 'targetAttribute' => ['syndicate_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'syndicate_id' => 'Syndicate ID',
            'game_id' => 'Game ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicate()
    {
        return $this->hasOne(Syndicate::className(), ['id' => 'syndicate_id']);
    }
}
