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
use yii\httpclient\Client;
use yii\web\ServerErrorHttpException;

class BuyForm extends Model
{
    public $amount;
    public $tIdStr;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['tIdStr', 'required'],
            ['tIdStr', 'string'],


        ];
    }

    public function buy()
    {
        $t = new Transaction;
        $t->transaction_status_id = 1; // pending
        $t->save();
        $tid = $t->id;

        /**
         * @var $user User
         */
        $user = Yii::$app->user->identity;


        foreach (explode(",", $this->tIdStr) as $tick) {
            /**
             * @var $ticket Ticket
             */
            $ticket = Ticket::findOne($tick);

            $draw_date = $ticket->syndicate->draw->draw_date;
            if(!$draw_date) continue;

            $ticket->transaction_id = $tid;

            if(true){
                //$ticket->reserve();
                //$ticket->buy();
                //$ticket->confirm();
            }


            $ticket->save(false);
        }

        $wallet = $user->wallet;
        $wallet->balance = $wallet->balance - $this->amount;
        $wallet->save(false);

        foreach (explode(",", $this->tIdStr) as $tick) {
            /**
             * @var $ticket Ticket
             */
            $ticket = Ticket::findOne($tick);
            $ticket->ticket_status_id = Ticket::STATUS_IN_PLAY;
            $ticket->save();
            // increment shares and lines
            $s = $ticket->syndicate;
            $s->num_shares++;
            $s->num_lines += count($ticket->lines);
            $s->calculatePlayers();
            $s->save();

            $transaction_history = new TransactionHistory();
            $transaction_history->user_id = $user->id;
            $transaction_history->transaction_date = date("Y-m-d H:i:s");
            $transaction_history->amount = $ticket->syndicate->costOfLines;
            $transaction_history->reference = 'Syndie #' . $ticket->syndicate_id;
            $transaction_history->type = TransactionHistory::TYPE_BUY;
            $transaction_history->save(false);

        }

        $t->transaction_status_id = 3; // complete
        $t->save();
        // @TODO transaction history
        return $t->id;
    }

}
