<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "syndicate_line".
 *
 * @property integer $syndicate_id
 * @property integer $line_id
 *
 * @property \app\models\Line $line
 * @property \app\models\Syndicate $syndicate
 */
class SyndicateLine extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['syndicate_id', 'line_id'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'syndicate_line';
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
            'line_id' => 'Line ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(\app\models\Line::className(), ['id' => 'line_id']);
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
     * @return \app\models\SyndicateLineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\SyndicateLineQuery(get_called_class());
    }
}
