<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "game".
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @property integer $max_num_primary_ball
 * @property integer $max_num_secondary_ball
 * @property integer $quantity_primary_choice
 * @property integer $quantity_secondary_choice
 * @property integer $num_primary_balls_drawn
 * @property integer $num_secondary_balls_drawn
 * @property string $primary_ball_name
 * @property string $secondary_ball_name
 * @property string $price_per_line
 *
 * @property \app\models\Draw[] $draws
 * @property \app\models\Country $country
 * @property \app\models\Line[] $lines
 * @property \app\models\SyndicateGame[] $syndicateGames
 */
class Game extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'max_num_primary_ball', 'max_num_secondary_ball', 'quantity_primary_choice', 'quantity_secondary_choice', 'num_primary_balls_drawn', 'num_secondary_balls_drawn'], 'integer'],
            [['price_per_line'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['primary_ball_name', 'secondary_ball_name'], 'string', 'max' => 100],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * 
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock 
     * 
     */
    public function optimisticLock() {
        return 'lock';
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
            'max_num_primary_ball' => 'Max Num Primary Ball',
            'max_num_secondary_ball' => 'Max Num Secondary Ball',
            'quantity_primary_choice' => 'Quantity Primary Choice',
            'quantity_secondary_choice' => 'Quantity Secondary Choice',
            'num_primary_balls_drawn' => 'Num Primary Balls Drawn',
            'num_secondary_balls_drawn' => 'Num Secondary Balls Drawn',
            'primary_ball_name' => 'Primary Ball Name',
            'secondary_ball_name' => 'Secondary Ball Name',
            'price_per_line' => 'Price Per Line',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraws()
    {
        return $this->hasMany(\app\models\Draw::className(), ['game_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(\app\models\Country::className(), ['id' => 'country_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLines()
    {
        return $this->hasMany(\app\models\Line::className(), ['game_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateGames()
    {
        return $this->hasMany(\app\models\SyndicateGame::className(), ['game_id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\GameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\GameQuery(get_called_class());
    }
}
