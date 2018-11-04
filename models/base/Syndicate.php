<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "syndicate".
 *
 * @property integer $id
 * @property integer $draw_id
 * @property integer $creator_user_id
 * @property integer $num_lines
 * @property integer $num_shares
 * @property string $cost_per_share
 *
 * @property \app\models\Draw $draw
 * @property \app\models\User $creatorUser
 * @property \app\models\SyndicateGame[] $syndicateGames
 * @property \app\models\SyndicateLine[] $syndicateLines
 * @property \app\models\SyndicateMember[] $syndicateMembers
 */
class Syndicate extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['draw_id', 'creator_user_id', 'num_lines', 'num_shares'], 'integer'],
            [['cost_per_share'], 'number'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'syndicate';
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
            'draw_id' => 'Draw ID',
            'creator_user_id' => 'Creator User ID',
            'num_lines' => 'Num Lines',
            'num_shares' => 'Num Shares',
            'cost_per_share' => 'Cost Per Share',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraw()
    {
        return $this->hasOne(\app\models\Draw::className(), ['id' => 'draw_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatorUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'creator_user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateGames()
    {
        return $this->hasMany(\app\models\SyndicateGame::className(), ['syndicate_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateLines()
    {
        return $this->hasMany(\app\models\SyndicateLine::className(), ['syndicate_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateMembers()
    {
        return $this->hasMany(\app\models\SyndicateMember::className(), ['syndicate_id' => 'id']);
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
     * @return \app\models\SyndicateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\SyndicateQuery(get_called_class());
    }
}
