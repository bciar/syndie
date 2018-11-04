<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SyndicateCodeForm extends Model
{
    public $code;
    public $syndicate_code;
    public $retries;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['retries'], 'safe']
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->code != $this->syndicate_code) {
                $this->addError('code', 'Invalid code.');
                $this->retries++;
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

}
