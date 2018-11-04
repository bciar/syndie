<?php

namespace app\controllers;

use app\models\Basket;
use app\models\BuyForm;
use Yii;
use yii\filters\AccessControl;


class BasketController extends \yii\web\Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['buy'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actionBuy()
    {
        $model = new BuyForm();

        $balance = Yii::$app->user->identity->wallet->balance;
        $tickets = Basket::getTickets();
        $total_cost = 0;
        foreach ($tickets as $ticket) {
            $total_cost += (double) $ticket->syndicate->costOfLines;
        }
        $model->amount = $total_cost;

        if ($balance > $total_cost) {

            if ($model->load(Yii::$app->request->post()) && $model->validate() && $tid = $model->buy()) {

                return $this->redirect([
                    'syndicate/public',
                    'username' => Yii::$app->user->identity->username,
                    'transaction_id' => $tid
                ]);

            }
        }


        return $this->render('buy', [
            'model' => $model,
        ]);


    }

}
