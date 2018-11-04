<?php

namespace app\models;

use app\components\Exaloc;
use Yii;
use yii\httpclient\Client;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property string $value
 * @property string $brombat_id
 * @property string $exaloc_id
 * @property integer $user_id
 * @property integer $game_id
 * @property integer $transaction_id
 * @property integer $ticket_status_id
 *
 * @property Line[] $lines
 * @property Syndicate $syndicate
 * @property User $user
 * @property Game $game
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    const STATUS_NOT_PAID = 1;
    const STATUS_RESERVED = 2;
    const STATUS_IN_PLAY = 3;
    const STATUS_RESOLVED = 4;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'number'],
            [['user_id', 'transaction_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'user_id' => 'User ID',
            'transaction_id' => 'Transaction ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLines()
    {
        return $this->hasMany(Line::className(), ['ticket_id' => 'id']);
    }

    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicate()
    {
        return $this->hasOne(Syndicate::className(), ['id' => 'syndicate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Reserve ticket with exaloc
     */
    public function reserve()
    {
        if ($this->exaloc_id) return true;

        $client = new Client();
        $user = Yii::$app->user->identity;

        //@TODO change provider_id AND game_id on prod
        $data = [
            'ticket[platform_id]' => '5962c487dd380af5c612f913',
            'ticket[platform_unit_id]' => '5962c534dd380af5c612f92e',
            'ticket[provider_id]' => '58acb356dfa016104a36ba33',
            'ticket[game_id]' => '58acb356dfa016104a36ba23',
            'ticket[ticket_id]' => $this->id,
            'ticket[stake]' => $this->calculateValue(),
            'ticket[currency]' => Yii::$app->params['currency'],
        ];

        $url = Yii::$app->params['exaloc_ticket_url'] . '/tickets/reserved?apikey=' . Yii::$app->params['exaloc_key'];

        $response = $client->createRequest()
            ->setMethod('POST')
            ->setHeaders([
                'content-type' => 'multipart/form-data',
                'x­auth­token' => $user->exalocTokenDecrypted
            ])
            ->setUrl($url)
            ->setData($data)
            ->send()
            ->getData();
Yii::$app->global->var_error_log($data);
        if (!is_array($response) || !$response['status']) {
            throw new ServerErrorHttpException(YII_ENV_DEV ? 'Reserving ticket failed ' . json_encode($data) . json_encode($response) : '');
        }
        $this->exaloc_id = $response['ticket']['_id'];
    }

    /**
     * Buy ticket from brombat
     */
    public function buy()
    {
        $client = new Client();
        $brombat_url = Yii::$app->params['brombat_url'];
        $brombat_brand_id = Yii::$app->params['brand_id'];

        $ticket_details = [];

        $explode = explode(' ', $this->syndicate->draw->draw_date);
        $date = $explode[0];

        $ticket_details[$date] = [];

        $i = 0;
        foreach ($this->lines as $line) {
            $i++;
            $add = [
                'nums' => [],
                'stars' => []
            ];

            foreach ($line->choices as $choice) {
                if ($choice->ballType->hierarchy == 1) {
                    $add['nums'][] = $choice->chosen_number;
                } else if ($choice->ballType->hierarchy == 2) {
                    $add['stars'][] = $choice->chosen_number;
                }
            }

            $ticket_details[$date][$i] = $add;
        }

        $x = [
            'subscription' => false,
            'chaser' => null,
            'ticket_details' => $ticket_details
        ];

        $data = [
            'user_id' => Yii::$app->user->identity->brombat_id,
            'ticket_details' => [
                $this->game->lottery_id => $x
            ]
        ];
Yii::$app->global->var_error_log($data);
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl("{$brombat_url}/tickets?brand_id={$brombat_brand_id}")
            ->addHeaders(['authorization' => Yii::$app->params['brombat_auth']])
            ->addHeaders(['content-type' => 'application/json'])
            ->setContent(json_encode($data))
            ->send();

        $data = $response->getData();

        if (!is_array($data) || !isset($data['ticket_ids'])) {
            if (YII_ENV_DEV) {
                throw new ServerErrorHttpException('Buying ticket failed ' . json_encode($this->attributes) . json_encode($data));
            } else {
                throw new ServerErrorHttpException();
            }


        }

        $this->brombat_id = $data['ticket_ids'][0];
    }

    /**
     * Confirm ticket with exaloc
     */
    public function confirm()
    {
        $params = Yii::$app->params;
        $client = new Client();

        $url = $params['exaloc_ticket_url'] . "/tickets/players_tickets/{$this->exaloc_id}/confirm_reserved?apikey=" . $params['exaloc_key'];
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setHeaders([
                'content-type' => 'application/json',
                'x-auth-token' => Yii::$app->user->identity->exalocTokenDecrypted
            ])
            ->setUrl($url);
        $response = $response
            ->send()
            ->getData();
        if (!is_array($response) || !$response['status']) {
            throw new ServerErrorHttpException(YII_ENV_DEV ? 'Confirming ticket failed ' . json_encode($response) : '');
        }
    }

    /**
     * Result ticket with brombat
     * @param $amount
     * @return mixed
     */
    public function result($amount)
    {
        $data = [
            'ticket[status]' => (bool)$amount,
            'ticket[type]' => 'player',
            'ticket[auto_payout]' => 0
        ];

        $response = Exaloc::createRequest('PUT', "ticket/{$this->exaloc_id}/result", $data);


        if (is_array($response) && $response['status']) {
            return true;
        } else {
            throw new ServerErrorHttpException("Resulting ticket #{$this->id} failed" . json_encode($response));
        }
    }

    public function calculateValue()
    {
        return $this->game->price_per_line * $this->getLines()->count();
    }
}
