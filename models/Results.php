<?php

namespace app\models;

use \app\models\base\Results as BaseResults;

/**
 * This is the model class for table "results".
 */
class Results extends BaseResults
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['draw_id', 'drawn_number', 'position', 'ball_category_id'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
