<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "syndicate_game".
 *
 * @property integer $syndicate_id
 * @property integer $game_id
 *
 * @property \app\models\Game $game
 * @property \app\models\Syndicate $syndicate
 */
class SyndicateGame extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['syndicate_id', 'game_id'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'syndicate_game';
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
            'syndicate_id' => 'Syndicate ID',
            'game_id' => 'Game ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(\app\models\Game::className(), ['id' => 'game_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicate()
    {
        return $this->hasOne(\app\models\Syndicate::className(), ['id' => 'syndicate_id']);
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
     * @return \app\models\SyndicateGameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\SyndicateGameQuery(get_called_class());
    }
}
