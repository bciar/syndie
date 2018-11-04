<?php

namespace app\controllers;

use app\components\Controller;
use app\models\Draw;
use app\models\Game;
use app\models\Line;
use app\models\Syndicate;
use app\models\SyndicateCodeForm;
use app\models\Ticket;
use app\models\Transaction;
use app\models\User;
use Yii;
use yii\authclient\clients\Facebook;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * SyndicateController implements the CRUD actions for Syndicate model.
 */
class SyndicateController extends Controller
{

	public function actionChooseGame() {
		return $this->render('_chooseGame');

	}

    public function actionPicknum(){
        return $this->render('picknum');
    }

    public function actionShowUserImage($id) {
      $user = User::findOne($id);
			$src = $user->avatar;
      return $this->renderPartial('/user/show-image',['src' => $src]);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['share', 'join', 'create', 'choose-game', 'picknum'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'public']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionPublic($username, $transaction_id = 0)
    {
        /**
         * @var $user User
         */
        $user = User::find()->where(['username' => $username])->one();

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $ids = [];
        if ($transaction_id) {
            $transaction = Transaction::findOne($transaction_id);
            foreach ($transaction->tickets as $ticket) {
                $ids[] = $ticket->syndicate_id;
                if ($ticket->user_id != Yii::$app->user->id) {
                    throw new ForbiddenHttpException();
                }
            }

        } else {
            $transaction = false;
        }

        $member_syndicates = false;
        if (!Yii::$app->user->isGuest && $user->id == Yii::$app->user->id) {
            $syndicates = $user->getSyndicates()->where(['!=', 'name', '']);
            $member_syndicates = Yii::$app->user->identity->getSyndicatesImIn()
                ->andWhere(['!=', 'creator_user_id', Yii::$app->user->identity->id]);
        } else {
            $syndicates = Syndicate::findJoinable()->andWhere(['creator_user_id' => $user->id]);
        }



        if (!empty($ids)) {
            $ids = implode(',', $ids);
            $order = new Expression("case when id in ($ids) then -1 else id end,id");
            $syndicates->orderBy($order);
            $member_syndicates->orderBy($order);
        }


        return $this->render('public', [
            'user' => $user,
            'transaction' => $transaction,
            'syndicates' => $syndicates->all(),
            'member_syndicates' => $member_syndicates ? $member_syndicates->all() : false
        ]);
    }


    /**
     * Lists all Syndicate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Syndicate::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShare($id)
    {
        $model = $this->findModel($id);

        if ($model->isFull) {
            throw new ServerErrorHttpException("Sorry you can't share this syndicate because it's full");
        }

        if (!$model->can('share')) {
            throw new ServerErrorHttpException("Sorry you can't share this syndicate");
        }

        if(Yii::$app->user->isGuest){
            Yii::$app->session->setFlash('danger', "Please login first");
            return $this->redirect(['user/security/login']);
        }
        $client = Yii::$app->authClientCollection->getClient('facebook');

        $url = Yii::$app->urlManager->createAbsoluteUrl(['syndicate/view', 'id' => $id, 'share' => false]);


        $response = $client->api('/me/feed', 'POST', [
            'link' => $url
        ]);

        if($response && isset($response['id'])){
            Yii::$app->session->setFlash('success', 'Sharing successful');
        } else {
            Yii::$app->session->setFlash('danger', 'Sharing Failed');
        }

        return $this->redirect(['syndicate/public', 'username' => Yii::$app->user->identity->username]);
    }

    /**
     * Displays a single Syndicate model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

				// set session if user is guest
				if (Yii::$app->user->isGuest) {
					$session = Yii::$app->session;
					$session['pending-syndie'] = $id;
				}

        $model = $this->findModel($id);
        $owner = $model->creatorUser;

        $dt = '';
        // populate description text
        foreach ($model->tickets as $t) {
            if (count($t->lines) == 1) {
                $x = 'line ';
            } else {
                $x = 'lines ';
            }
						$dt = $t->syndicate->name;
						if (isset($t->syndicate->description)) {
							$dt .= ':&nbsp;' . $t->syndicate->description;
						}
            $dt .= "&nbsp;" . count($t->lines) . $x . '&nbsp;on&nbsp; ' . $t->game->name . ",&nbsp;" .
						$t->syndicate->draw->formatDrawDate() . "&nbsp;for only&nbsp;" . 
						"£" . $t->syndicate->cost_per_share . " per share!";
        }
        //Yii::$app->global->var_error_log($owner->profile);
        $this->view->params['url'] = Yii::$app->urlManager->createAbsoluteUrl(['syndicate/view', 'id' => $id]);
        $this->view->params['type'] = 'website';
        $this->view->params['title'] = $owner->profile->name . ' wants you to join their syndicate!';
        $this->view->params['description'] = $dt;
        $this->view->params['image'] = Yii::$app->urlManager->createAbsoluteUrl(['site/ad', 'id' => $owner->id]);

        $social = Yii::$app->getModule('social');
        $faid = $social->facebook['appId'];

        $this->view->params['faid'] = $faid;


        if($model->privacy_level_id === 1){
            $code = new SyndicateCodeForm();
            $code->syndicate_code = $model->privacy_code;

            if ($code->load(Yii::$app->request->post()) && $code->validate()) {

            } else {
                if ($code->retries > 1) {
                    return $this->render('intro');
                } else {
                    return $this->render('code', [
                        'code' => $code
                    ]);
                }
            }

        } else if($model->privacy_level_id === 3){

            if(strpos(Yii::$app->request->userAgent, 'facebookexternalhit') !== false){
                return $this->render('meta');
            }

            if(Yii::$app->user->isGuest){
                throw new ForbiddenHttpException();
            }

            /**
             * @var $client Facebook
             */
            $client = Yii::$app->authClientCollection->getClient('facebook');

            $creator = $model->creatorUser;
            if(!$creator){
                throw new ServerErrorHttpException();
            }

            $creator_fb = $creator->getSocialAccounts()->andWhere(['provider' => 'facebook'])->one();

            if(!$creator_fb){
                throw new ServerErrorHttpException();
            }

            $creator_fb_id = $creator_fb->client_id;
            $response = $client->api('/me/friends/'. $creator_fb_id, 'GET');

            if($response && isset($response['data']) && isset($response['data'][0]) && $response['data'][0]['id'] == $creator_fb_id){

            } else {
                //But maybe we have mutual friends ?
                $response = $client->api("/{$creator_fb_id}?fields=context.fields(mutual_friends)", 'GET');
                if(is_array($response) && isset($response['context']) && isset($response['context']['mutual_friends']) && count($response['context']['mutual_friends']) > 0){

                } else {
                    return $this->render('intro');
                    //throw new ForbiddenHttpException("You need to be logged in via facebook and be friends with the creator of this syndicate to view this");
                }

            }

        }


        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionJoin($id)
    {

        // @TODO ensure maximum isn't reached
        $model = Syndicate::findOne($id);

        if ($model->isFull) {
            throw new ServerErrorHttpException("Sorry you can't join this syndicate because it's full");
        }

        $ti = new Ticket;
        $ti->user_id = Yii::$app->user->id;
        $ti->ticket_status_id = Ticket::STATUS_NOT_PAID; // not yet paid
        $ti->game_id = $model->game->id;
        $ti->syndicate_id = $model->id;
        if (!$ti->save()) {
            error_log("ticket did not save");
        }
        for ($i = 0; $i < $model->syndie_lines_per_person; $i++) {
            $line = new Line;
            $line->draw_id = $model->draw_id;
            $line->game_id = $model->game_id;
            $line->ticket_id = $ti->id;
            $line->syndicate_id = $model->id;
            $line->line_status_id = 5; // not yet paid
            if (!$line->save()) {
                print_r($line->getErrors());
            } else {
                // increment number of lines
                //$model->num_lines = $model->num_lines + 1;
                $model->save();
            }
        }
        return $this->redirect([
            'game/play',
            'id' => $model->game_id,
            'draw' => $model->draw_id,
            'syndicate' => $model->id,
            'ti' => $ti->id
        ]);


    }

    /**
     * Creates a new Syndicate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $game_id
     * @param $draw_id
     * @return mixed
     */
    public function actionCreate($game_id)
    {
        $model = new Syndicate();
        $game = Game::findOne($game_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $ti = new Ticket;
            $ti->user_id = Yii::$app->user->id;
            $ti->ticket_status_id = Ticket::STATUS_NOT_PAID; // not yet paid
            $ti->game_id = $game->id;
            $ti->save();
            $model->creator_user_id = Yii::$app->user->id;
            $model->num_shares = 0;
            $model->num_lines = 0;
            $model->game_id = $game->id;
            if ($model->syndie_style == 1) {
                $model->cost_per_share = $model->syndie_lines_per_person * $game->price_per_line;
            }
            if (!$model->save()) {
                print_r($model->getErrors());
            } else {
                // increment number of shares
                //$model->num_shares = $model->num_shares + 1;
                $model->save();
                $ti->syndicate_id = $model->id;
                if (!$ti->save()) {
                    error_log("ticket did not save");
                }
            }

            for ($i = 0; $i < $model->syndie_lines_per_person; $i++) {
                $line = new Line;
                $line->draw_id = $model->draw_id;
                $line->game_id = $game->id;
                $line->ticket_id = $ti->id;
                $line->syndicate_id = $model->id;
                $line->line_status_id = 5; // not yet paid
                if (!$line->save()) {
                    print_r($line->getErrors());
                } else {
                    // increment number of lines
                    //$model->num_lines = $model->num_lines + 1;
                    $model->save();
                }
            }

            if ($model->privacy_code) {
                Yii::$app->session->setFlash('success', "Syndicate created. Privacy code is <b>{$model->privacy_code}</b>");
            }

            return $this->redirect([
                'game/play',
                'id' => $game->id,
                'draw' => $model->draw->id,
                'syndicate' => $model->id,
                'ti' => $ti->id
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'game' => $game,
                'draws' => ArrayHelper::map(Draw::findAvailableDraws()->andWhere(['game_id' => $game->id])->all(), 'id', function ($model) {
                    $date = date("D j{{x}} M - ga", strtotime($model->draw_date));
                    $date = str_replace('{{x}}', 'th', $date);
                    return $date;
                })
            ]);
        }
    }

    /**
     * Updates an existing Syndicate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Syndicate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the Syndicate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Syndicate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Syndicate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for SyndicateGame
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddSyndicateGame()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('SyndicateGame');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formSyndicateGame', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for SyndicateLine
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddSyndicateLine()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('SyndicateLine');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formSyndicateLine', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for SyndicateMember
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddSyndicateMember()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('SyndicateMember');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formSyndicateMember', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
