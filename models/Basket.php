<?php

namespace app\models;

use Yii;
use app\models\Ticket;


class Basket extends \yii\db\ActiveRecord {

    public static function getTickets()
    {

		return Ticket::find()->where(['ticket_status_id' => 1, 'user_id' => Yii::$app->user->id])->all();

	}


}

?>
