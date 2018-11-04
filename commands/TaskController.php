<?php

namespace app\commands;

use app\models\Draw;
use app\models\Game;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\httpclient\Client;

class TaskController extends Controller
{

    private $brombat_url;
    private $brombat_brand_id;
    private $exaloc_url;
    private $authorization;

    private $client;

    public function actionIndex()
    {

        $params = Yii::$app->params;
        $this->client = new Client();

        $this->brombat_brand_id = $params['brand_id'];
        $this->brombat_url = $params['brombat_url'];
        $this->exaloc_url = $params['exaloc_url'];
        $this->authorization = $params['brombat_auth'];

        $completed_tasks = [
            'key' => 1
        ];

        while (true) {

            $key = 'pullLoteries' . date("Y-m-d H");
            if(!isset($completed_tasks[$key])){
                $this->pullLoteries();
                $completed_tasks[$key] = true;
            }


            $this->registerPlayers();
            $this->fetchAvatars();

            sleep(2);

        }

    }

    public function actionTest()
    {
        $this->fetchAvatars();
    }

    public function fetchAvatars()
    {
        $query = ['<=', 'updated_at', time() - 3600 * 24];

        foreach(User::find()->where($query)->all() as $user){
            if(!isset($user->accounts['facebook'])) continue;
            $facebook = $user->accounts['facebook'];

            file_put_contents($user->getAvatarPath(), file_get_contents("https://graph.facebook.com/" . $facebook->client_id ."/picture?width=300&height=300"));

            $user->updated_at = time();
            $user->save(false);

        }
    }


    private function pullLoteries()
    {
        $response = $this->client->createRequest()
            ->setUrl("{$this->brombat_url}/lotteries?brand_id={$this->brombat_brand_id}")
            ->addHeaders(['authorization' => $this->authorization])
            ->send();

        $data = $response->getData();

        foreach ($data as $lottery) {
            /**
             * @var $game Game
             */
            $game = Game::find()->where(['lottery_id' => $lottery['lottery_id']])->one();

            if(!$game){
                throw new Exception("Game not found" . json_encode($lottery));
                $game = new Game();
                $game->lottery_id = $lottery['lottery_id'];
                $game->name = $lottery['lottery_name'];
            }

            if(isset($lottery['lottery_logo'])){
                $path = pathinfo($lottery['lottery_logo']);
                $cache = Yii::$app->cache;
                $key = 'lottery___logo' . $game->id;
                $file_name = 'game_' . $game->id . '.' . $path['extension'];
                $file = Yii::getAlias("@app/web/images/$file_name");
                if(!$cache->get($key)){
                    file_put_contents($file, file_get_contents($lottery['lottery_logo']));
                    $game->logo_path = '/images/' . $file_name;

                    $cache->set($key, 3600 * 24 * 7);
                }
            }

            $game->save(false);

            $start_date = new \DateTime();
            $interval = new \DateInterval('P1W');
            $recurrences = 5;

            foreach (new \DatePeriod($start_date, $interval, $recurrences) as $date) {

                //echo $date->format('Y-m-d -> l') . "\n";

                foreach ($lottery['draw_times'] as $time) {
                    $x = clone $date;
                    $x->modify($time['draw_time']);
                    $draw_date = $x->format('Y-m-d H:i:s');
                    $x->modify($time['prize_time']);
                    $prize_date = $x->format('Y-m-d H:i:s');


                    $draw = $game->getDraws()
                        ->andWhere(['draw_date' => $draw_date])
                        ->one();

                    if ($draw) {
                        //continue;
                    } else {
                        $draw = new Draw();
                        $draw->draw_date = $draw_date;
                        $draw->game_id = $game->id;
                    }


                    $draw->prize_date = $prize_date;

                    if(isset($lottery['upcoming_results'])){
                        foreach ($lottery['upcoming_results'] as $_draw_date => $data){
                            if($draw_date == $_draw_date){
                                $draw->est_jackpot = $data['estimate_jp'];
                                $draw->rollover = $data['rollover'];
                            }
                        }
                    }


                    $draw->save(false);
                }
            }

        }

    }

    private function registerPlayers()
    {

        /**
         * @var $users User[]
         */
        $users = User::find()
            ->where([
                'or',
                ['brombat_id' => ''],
                ['exaloc_id' => '']
            ])
            ->andWhere(['!=', 'username', '',])
            ->all();


        $client = new Client();

        $security = Yii::$app->security;

        foreach ($users as $user) {

            if (!$user->brombat_id) {
                $url = "{$this->brombat_url}/registerPlayer?brand_id={$this->brombat_brand_id}&player_reference={$user->username}";

                $response = $client->createRequest()
                    ->setMethod('post')
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['authorization' => $this->authorization])
                    ->setUrl($url)
                    ->setData([])
                    ->send();

                $data = $response->getData();

                if ($data && is_array($data) && isset($data['id'])) {
                    $user->brombat_id = $data['id'];
                    $user->save(false);
                } else {
                    $data = json_encode($data);
                    throw new Exception("Tried to create brombat_id for user {$user->id}. API returned: {$data}");
                }
            }


            if (!$user->exaloc_id) {
                $url = "{$this->exaloc_url}/players/register?apikey=" . Yii::$app->params['exaloc_key'];

                $username = str_replace('@', '_eta_', $user->username);
                $password = md5($username . time());
                $password = substr($password, 0, 8);

                $response = $client->createRequest()
                    ->setMethod('post')
                    ->addHeaders(['content-type' => 'application/json'])
                    ->setUrl($url)
                    ->setData([
                        'player[username]' => $username,
                        'player[password]' => $password,
                        'player[password_repeat]' => $password,
                        'player[currency]' => 'GBP'
                    ])
                    ->send();


                $data = $response->getData();

                if ($data && is_array($data) && isset($data['status']) && $data['status'] == true) {
                    $user->exaloc_token = utf8_encode($security->encryptByPassword($data['token'], $user->id));
                    //@TODO $decrypted = Yii::$app->security->decryptByKey(utf8_decode($encrypted), $key);
                    $user->exaloc_id = $data['player']['player_id'];
                    $user->save(false);
                } else {
                    $data = json_encode($data);
                    throw new Exception("Tried to create exaloc_id for user {$user->id}. API returned: {$data}");
                }

            }

        }
    }
}
