<?php

namespace app\controllers;

use app\components\Controller;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Syndicate;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{

    public function actionValidateFb()
    {
        $social = Yii::$app->getModule('social');
        $fb = $social->getFb(); // gets facebook object based on module settings
        try {
            $helper = $fb->getRedirectLoginHelper();
            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // There was an error communicating with Graph
            return $this->render('validate-fb', [
                'out' => '<div class="alert alert-danger">' . $e->getMessage() . '</div>'
            ]);
        }
        if (isset($accessToken)) { // you got a valid facebook authorization token
            $response = $fb->get('/me?fields=id,name,email,picture', $accessToken);
            return $this->render('validate-fb', [
                'out' => '<legend>Facebook User Details</legend>' . '<pre>' . print_r($response->getGraphUser(), true) . '</pre>'
            ]);
        } elseif ($helper->getError()) {
            // the user denied the request
            // You could log this data . . .
            return $this->render('validate-fb', [
                'out' => '<legend>Validation Log</legend><pre>' .
                    '<b>Error:</b>' . print_r($helper->getError(), true) .
                    '<b>Error Code:</b>' . print_r($helper->getErrorCode(), true) .
                    '<b>Error Reason:</b>' . print_r($helper->getErrorReason(), true) .
                    '<b>Error Description:</b>' . print_r($helper->getErrorDescription(), true) .
                    '</pre>'
            ]);
        }
        return $this->render('validate-fb', [
            'out' => '<div class="alert alert-warning"><h4>Oops! Nothing much to process here.</h4></div>'
        ]);
    }

    public function actionFbTest()
    {
        return $this->render('fbtest');
    }

    public function ooAuthSuccess($client)
    {
        // get user data from client
        $userAttributes = $client->getUserAttributes();
        Yii::$app->global->var_error_log($userAttributes);
        // do some thing with user data. for example with $userAttributes['email']
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'confirm'],
                'rules' => [
                    [
                        'actions' => ['logout', 'confirm'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],

            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $syndicates = [
            'Sponsor syndicates' => Syndicate::findSponsors()->limit(20)->orderBy('RAND()')->all(),
            'Affiliate syndicates' => Syndicate::findAffiliates()->limit(20)->orderBy('RAND()')->all(),
            //'Standard user syndicates' => Syndicate::findUsers()->andWhere(['privacy_level_id' => Syndicate::PRIVACY_PUBLIC])->limit(20)->orderBy('RAND()')->all()
        ];

        return $this->render('index', [
            'syndicates' => $syndicates
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /**
     * Displays Terms and Conditions page
     */
    public function actionTac($confirm = false)
    {
        $user = Yii::$app->user->identity;

        if ($confirm) {

            $user->tac = true;
            $user->save(false);
        }

        if ($user->tac) {
						$session = Yii::$app->session;
						if (isset($session['pending-syndie'])) {
							$id = $session['pending-syndie'];
							$session['pending-syndie'] = null;
							return $this->redirect(['/syndicate/join', 'id' => $id]);
						}
            return $this->goHome();
        }

        return $this->render('tac');
    }

    public function actionAd($id)
    {
        //@TODO cache generated images
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $path = $user->getAvatarPath();
        $avatar = imagecreatefromjpeg($user->getAvatarPath());
        $overlay = imagecreatefrompng('/var/www/html/syndie/images/syndie_overlay.png');

        list($overlay_width, $overlay_height) = getimagesize('/var/www/html/syndie/images/syndie_overlay.png');
        list($avatar_width, $avatar_height) = getimagesize($path);
        $out = imagecreatetruecolor($avatar_width, $avatar_height);

        $rate = 320 / $avatar_width;


        imagecopyresampled($out, $avatar, 0, 0, 0, 0, 320, $avatar_height * $rate, $overlay_width, $overlay_height);
        imagecopyresampled($out, $overlay, 0, 0, 0, 0, $avatar_width, $avatar_height, $overlay_width, $overlay_height);


        //$font = Yii::getAlias('@app/arial.ttf');

        header('Content-Type: image/png');
        //imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);
        imagepng($out);

    }
}
