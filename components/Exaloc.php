<?php
/**
 * Created with love.
 * User: benas
 * Date: 5/18/17
 * Time: 1:52 AM
 */


namespace app\components;

use Yii;
use yii\httpclient\Client;

class Exaloc extends \yii\base\Component
{

    public static function createRequest($method, $url, $data = [])
    {
        $client = new Client([
            'baseUrl' => Yii::$app->params[strpos($url, 'ticket') === 0 ? 'exaloc_ticket_url' : 'exaloc_url']
        ]);

        return $client
            ->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setData($data)
            ->send()
            ->getData();
    }
}