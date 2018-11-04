<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/13/17
 * Time: 7:33 PM
 */

namespace app\models;

use yii\base\Model;

class PlayForm extends Model
{
    public $checked;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['checked', 'required'],
        ];
    }


}
