<?php

namespace app\models;

use \app\models\base\BallCategory as BaseBallCategory;

/**
 * This is the model class for table "ball_category".
 */
class BallCategory extends BaseBallCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'string', 'max' => 50],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
