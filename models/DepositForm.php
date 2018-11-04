<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/6/17
 * Time: 5:23 PM
 */

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class DepositForm
 * @package app\models
 *
 * @property float $amount
 */

class DepositForm extends Model
{
    public $amount;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['amount', 'required'],
            ['amount', 'number', 'min' => '0.01']
        ];
    }

    public function deposit()
    {
        /* @var \app\models\Wallet $wallet */
        $wallet = Yii::$app->user->identity->wallet;

        $wallet->balance = $wallet->balance + $this->amount;
        $wallet->save(false);

        $transaction_history = new TransactionHistory();
        $transaction_history->user_id = Yii::$app->user->id;
        $transaction_history->transaction_date = date("Y-m-d H:i:s");
        $transaction_history->amount = $this->amount;
        $transaction_history->reference = md5(time());
        $transaction_history->type = TransactionHistory::TYPE_DEPOSIT;

        if(false){
            //Failure when billing
            $transaction_history->status = $transaction_history::STATUS_FAILURE;
        } else {
            $transaction_history->status = $transaction_history::STATUS_PAID;
        }


        $transaction_history->save(false);

        return true;
    }

}
