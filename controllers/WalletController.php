<?php

namespace app\controllers;

use app\components\Controller;
use app\models\DepositForm;
use app\models\Wallet;
use app\models\WithdrawForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * WalletController implements the CRUD actions for Wallet model.
 */
class WalletController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'deposit', 'withdraw', 'success', 'history'],
                        'roles' => ['@']
                    ],
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


    /**
     * Shows wallet history and deposit/withdraw buttons
     */
    public function actionIndex()
    {
        return $this->redirect('history');
        //return $this->render('index');
    }

    /**
     * Show transactions history
     */
    public function actionHistory()
    {
        $transactions = Yii::$app->user->identity->transactions;

        return $this->render('history', [
            'transactions' => $transactions,
            'dataProvider' => new ActiveDataProvider([
                'query' => Yii::$app->user->identity->getTransactions()
            ])
        ]);
    }

    /**
     * Deposit form
     */
    public function actionDeposit()
    {

        $user = Yii::$app->user->identity;

        if(!$user->username || !$user->dob || $user->dob == '0000-00-00' || !$user->address){
            $user->scenario = 'deposit';

            if($user->load(Yii::$app->request->post()) && $user->save()){

            } else {
                return $this->render('before_deposit', [
                    'user' => $user
                ]);
            }
        }

        $model = new DepositForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->deposit()) {
            //Yii::$app->session->setFlash('success', 'Thank you');
            if (isset($_POST['referrer'])) {
                return $this->redirect($_POST['referrer']);
            } else {
                return $this->redirect(['wallet/success']);
            }
        } else {
            $referrer = Yii::$app->request->referrer;
        }

        return $this->render('deposit', [
            'model' => $model,
            'referrer' => $referrer
        ]);
    }

    /**
     * Withdraw form
     */
    public function actionWithdraw()
    {

        $model = new WithdrawForm();
Yii::$app->global->var_error_log(Yii::$app->request->post());

        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->withdraw()){
            //Yii::$app->session->setFlash('success', 'Withdraw successful');


            return $this->redirect(['wallet/success']);
        }

        return $this->render('withdraw', [
            'model' => $model
        ]);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    /**
     * Displays a single Wallet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerTransaction = new \yii\data\ArrayDataProvider([
            'allModels' => $model->transactions,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerTransaction' => $providerTransaction,
        ]);
    }

    /**
     * Creates a new Wallet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wallet();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Wallet model.
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
     * Deletes an existing Wallet model.
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
     * Finds the Wallet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wallet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wallet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Transaction
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddTransaction()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Transaction');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formTransaction', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
