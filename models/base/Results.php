<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "results".
 *
 * @property integer $id
 * @property integer $draw_id
 * @property integer $drawn_number
 * @property integer $position
 * @property integer $ball_category_id
 *
 * @property \app\models\BallCategory $ballCategory
 * @property \app\models\Draw $draw
 */
class Results extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['draw_id', 'drawn_number', 'position', 'ball_category_id'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'results';
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
            'drawn_number' => 'Drawn Number',
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
    public function getDraw()
    {
        return $this->hasOne(\app\models\Draw::className(), ['id' => 'draw_id']);
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
     * @return \app\models\ResultsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ResultsQuery(get_called_class());
    }
}
