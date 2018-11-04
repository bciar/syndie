<?php

namespace app\controllers;

use app\models\BuyForm;
use app\models\Choice;
use app\models\Game;
use app\models\PlayForm;
use app\models\Syndicate;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Game::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Game model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerBallType = new \yii\data\ArrayDataProvider([
            'allModels' => $model->ballTypes,
        ]);
        $providerDraw = new \yii\data\ArrayDataProvider([
            'allModels' => $model->draws,
        ]);
        $providerLine = new \yii\data\ArrayDataProvider([
            'allModels' => $model->lines,
        ]);
        $providerPrize = new \yii\data\ArrayDataProvider([
            'allModels' => $model->prizes,
        ]);
        $providerSyndicateGame = new \yii\data\ArrayDataProvider([
            'allModels' => $model->syndicateGames,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerBallType' => $providerBallType,
            'providerDraw' => $providerDraw,
            'providerLine' => $providerLine,
            'providerPrize' => $providerPrize,
            'providerSyndicateGame' => $providerSyndicateGame,
        ]);
    }

    /**
     * Creates a new Game model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Game();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Game model.
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
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Game::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Action to load a tabular form grid
     * for BallType
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddBallType()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('BallType');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formBallType', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Action to load a tabular form grid
     * for Draw
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddDraw()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Draw');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formDraw', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Action to load a tabular form grid
     * for Line
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddLine()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Line');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formLine', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Action to load a tabular form grid
     * for Prize
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddPrize()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Prize');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formPrize', ['row' => $row]);
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
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formSyndicateGame', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBasket()
    {
        $buyForm = new BuyForm;
        return $this->render('/basket/buy', [
            'model' => $buyForm
        ]);
    }

    public function actionPlay($id = '', $syndicate)
    {

        $syndicate = Syndicate::findOne($syndicate);
        if(!$syndicate){
            throw new NotFoundHttpException();
        }

        $game = $syndicate->game;
        if (!$game) {
            throw new NotFoundHttpException();
        }
        $model = new PlayForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // record choices against lines
            foreach ($model->checked as $id => $hierarchy) {
                $pos = 1;
                foreach ($hierarchy as $hval => $selection) {
                    foreach ($selection as $number => $chosen) {
                        if ($chosen == 1) {
                            $c = new Choice;
                            $c->position = $pos;
                            $c->chosen_number = $number;
                            $c->ball_hierarchy = $hval;
                            $c->line_id = $id;
                            if (!$c->save()) {
                                // @TODO BENAS - do something sensible!
                            } else {
                                $pos++;
                            }
                        }
                    }

                }
            }
            $buyForm = new BuyForm;
            return $this->render('/basket/buy', [
                'model' => $buyForm
            ]);

            //var_dump($model->checked);
            //Yii::$app->global->var_error_log($model->checked);
        }

        return $this->render('play', [
            'game' => $game,
            'syndicate' => $syndicate,
            'model' => $model
        ]);
    }

    public function actionLucky($id)
    {

        $game = Game::findOne($id);

        if(!$game || !$game->ballTypes){
            throw new NotFoundHttpException();
        }

        $return = [];

        foreach($game->ballTypes as $type){

            $var = array_rand(range(1, $type->quantity_in_pot), $type->quantity_drawn);
            //array_rand returns keys not values so we will increase by 1

            if (is_array($var)) {
                foreach ($var as $i){
                    $return[$type->id][] = $i +1;
                }
            } else {
                $return[$type->id] = [$var + 1];
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $return;

    }
}
