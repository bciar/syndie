<?php

namespace app\controllers;

use app\models\Ticket;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;


class ApiController extends Controller
{

    public $secret = 'batman6';

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['win'],
                    ],
                ],
            ],
        ];
    }

    public function actionWin($secret)
    {

        if ($this->secret != $secret) {
            throw new ForbiddenHttpException("Wrong secret");
        }

        $data = Yii::$app->request->post();

        if (empty($data)) {
            $data = [
                'winningTicket' => [
                    'ea0a85a0-702c-11e6-8e7c-7f45a8a997a1' => [
                        '591cccc1ef9a23085f0a7565' => [
                            'prize_level' => 5 + 2,
                            'amount' => 600000
                        ],
                    ]
                ],
            ];
        }

        foreach ($data['winningTicket'] as $lottery_id => $tickets) {

            foreach ($tickets as $exaloc_id => $data) {
                /**
                 * @var $ticket Ticket
                 */
                $ticket = Ticket::find()->where(['exaloc_id' => $exaloc_id])->one();

                if (!$ticket) throw new NotFoundHttpException("Ticket not found {$exaloc_id}.");
                if ($ticket->ticket_status_id == Ticket::STATUS_RESOLVED) continue;

                $ticket->ticket_status_id = Ticket::STATUS_RESOLVED;
                $ticket->result($data['amount']);
                $ticket->save(false);

            }
        }

        echo "DONE";

    }

}
