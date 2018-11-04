<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "draw".
 *
 * @property integer $id
 * @property integer $game_id
 * @property string $draw_date
 * @property string $prize_date
 * @property string $est_jackpot
 * @property string $cutoff_date
 * @property string $rollover
 *
 * @property Game $game
 * @property Game[] $games
 * @property Result[] $results
 * @property Syndicate[] $syndicates
 */
class Draw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'draw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id'], 'integer'],
            [['draw_date', 'cutoff_date'], 'safe'],
            [['est_jackpot'], 'number'],
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
            'draw_date' => 'Draw Date',
            'est_jackpot' => 'Est Jackpot',
            'cutoff_date' => 'Cutoff Date',
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
    public function getGames()
    {
        return $this->hasMany(Game::className(), ['next_draw_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResults()
    {
        return $this->hasMany(Result::className(), ['draw_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicates()
    {
        return $this->hasMany(Syndicate::className(), ['draw_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function findAvailableDraws()
    {
        return self::find()->where(['>', 'draw_date', date("Y-m-d H:i:s")]);
    }

    public function formatDrawDate()
    {
        return Yii::$app->dates->mysql2ukTextDateTime($this->draw_date);
    }

    public function formatEstJackpot()
    {
        //return number_format($this->est_jackpot, 0, '', ',');
				return Yii::$app->global->format_cash($this->est_jackpot);
    }
}
