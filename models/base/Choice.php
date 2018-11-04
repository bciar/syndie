<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "choice".
 *
 * @property integer $id
 * @property integer $line_id
 * @property integer $chosen_number
 * @property integer $position
 * @property integer $ball_category_id
 *
 * @property \app\models\BallCategory $ballCategory
 * @property \app\models\Line $line
 */
class Choice extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['line_id', 'chosen_number', 'position', 'ball_category_id'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'choice';
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
            'line_id' => 'Line ID',
            'chosen_number' => 'Chosen Number',
            'position' => 'Position',
            'ball_category_id' => 'Ball Category ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBallCategory()
    {
        return $this->hasOne(\app\models\BallCategory::className(), ['id' => 'ball_category_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(\app\models\Line::className(), ['id' => 'line_id']);
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
     * @return \app\models\ChoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ChoiceQuery(get_called_class());
    }
}
