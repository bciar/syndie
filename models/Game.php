<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @property string $price_per_line
 * @property string $logo_path
 * @property string $lottery_id
 * @property integer $next_draw_id
 * @property integer $active
 * @property string $draw_frequency
 *
 * @property BallType[] $ballTypes
 * @property Draw[] $draws
 * @property Country $country
 * @property Draw $nextDraw
 * @property Line[] $lines
 * @property Prize[] $prizes
 * @property SyndicateGame[] $syndicateGames
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'next_draw_id', 'active'], 'integer'],
            [['price_per_line'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['logo_path'], 'string', 'max' => 150],
            [['draw_frequency'], 'string', 'max' => 20],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['next_draw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draw::className(), 'targetAttribute' => ['next_draw_id' => 'id']],
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
            'country_id' => 'Country ID',
            'price_per_line' => 'Price Per Line',
            'logo_path' => 'Logo Path',
            'next_draw_id' => 'Next Draw ID',
            'active' => 'Active',
            'draw_frequency' => 'Draw Frequency',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBallTypes()
    {
        return $this->hasMany(BallType::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraws()
    {
        return $this->hasMany(Draw::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNextDraw()
    {
        return Draw::findAvailableDraws()->where(['game_id' => $this->id]);
        return $this->hasOne(Draw::className(), ['id' => 'next_draw_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLines()
    {
        return $this->hasMany(Line::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizes()
    {
        return $this->hasMany(Prize::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateGames()
    {
        return $this->hasMany(SyndicateGame::className(), ['game_id' => 'id']);
    }

    public function getJoinUrl()
    {
        return [
            '/syndicate/create',
            'game_id' => $this->id,
            'draw_id' => $this->nextDraw->id
        ];
    }
    public function getInfoUrl()
    {
			return [
				'/game/info',
				'game_id' => $this->id
			];
		}
}
