<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/11/17
 * Time: 11:51 PM
 */

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class RegistrationController extends \dektrium\user\controllers\RegistrationController
{

    /**
     * @inheritdocs
     */
    public function actionConnect($code)
    {
        $account = $this->finder->findAccount()->byCode($code)->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException();
        }

        $data = $account->decodedData;

        $user_data = [
            'class' => User::className(),
            'scenario' => 'connect',
        ];

        if(isset($data['screen_name'])){
            //Twitter
            $user_data['email'] = $account->attributes['email'];
            $user_data['username'] = $data['screen_name'];
        } else if(isset($data['email'])){
            //Facebook
            $user_data['email'] = $data['email'];
            $user_data['username'] = $data['email'];
        }

        /** @var User $user */
        $user = \Yii::createObject($user_data);

        $event = $this->getConnectEvent($account, $user);

        $this->trigger(self::EVENT_BEFORE_CONNECT, $event);

        if (Yii::$app->request->isPost) {
            $user->load(Yii::$app->request->post());
        }

        if ($user->create()) {
            $account->connect($user);

            $this->trigger(self::EVENT_AFTER_CONNECT, $event);
            \Yii::$app->user->login($user, $this->module->rememberFor);

            $data = $user->accounts['facebook']->decodedData;

            if (!$user->profile->name) {
                $user->profile->updateAttributes([
                    'name' => $data['name'],
                    'public_email' => $data['email'],
                ]);
            }

            $avatar = $user->getAvatarPath();

            if (isset($data['picture']['data']['url']) && !file_exists($avatar)) {
                $data = file_get_contents($data['picture']['data']['url']);
                file_put_contents($avatar, $data);
            }

            return $this->goBack();
        }

        return $this->render('connect', [
            'model' => $user,
            'account' => $account,
        ]);
    }
}