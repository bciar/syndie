<?php

namespace app\controllers;

use Yii;
use app\models\SyndicateMember;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SyndicateMemberController implements the CRUD actions for SyndicateMember model.
 */
class SyndicateMemberController extends Controller
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
     * Lists all SyndicateMember models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SyndicateMember::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SyndicateMember model.
     * 
     * @return mixed
     */
    public function actionView($)
    {
        $model = $this->findModel($);
        return $this->render('view', [
            'model' => $this->findModel($),
        ]);
    }

    /**
     * Creates a new SyndicateMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SyndicateMember();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SyndicateMember model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionUpdate($)
    {
        $model = $this->findModel($);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SyndicateMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @return mixed
     */
    public function actionDelete($)
    {
        $this->findModel($)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the SyndicateMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @return SyndicateMember the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($)
    {
        if (($model = SyndicateMember::findOne([])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
