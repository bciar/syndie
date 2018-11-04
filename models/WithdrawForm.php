<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/6/17
 * Time: 5:30 PM
 */

namespace app\models;

use Yii;
use yii\base\Model;

class WithdrawForm extends Model
{
    public $amount;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['amount', 'required'],
            ['amount', 'number', 'min' => '0.01'],
            ['amount', 'checkWallet']
        ];
    }

    public function checkWallet()
    {
        if($this->amount > Yii::$app->user->identity->wallet->balance){
            $this->addError('amount', 'Insufficient funds');
            return false;
        }

        return true;
    }

    public function withdraw()
    {
        /* @var \app\models\Wallet $wallet */
        $wallet = Yii::$app->user->identity->wallet;

        $wallet->balance = $wallet->balance - $this->amount;
        $wallet->save(false);

        $transaction_history = new TransactionHistory();
        $transaction_history->user_id = Yii::$app->user->id;
        $transaction_history->transaction_date = date("Y-m-d H:i:s");
        $transaction_history->amount = $this->amount;
        $transaction_history->reference = md5(time());
        $transaction_history->type = TransactionHistory::TYPE_WITHDRAWAL;
        $transaction_history->save(false);

        return true;
    }

}
