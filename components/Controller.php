<?php
/**
 * Created with love.
 * User: benas
 * Date: 5/21/17
 * Time: 10:57 PM
 */

namespace app\components;

use Yii;

class Controller extends \yii\web\Controller
{
    public function beforeAction($event)
    {
        if (parent::beforeAction($event)) {
            $action = $this->action->id;
            if ($action != 'tac' && !Yii::$app->user->isGuest && !Yii::$app->user->identity->tac) {
                return $this->redirect(['site/tac']);
            }
            return true;
        } else {
            return false;
        }
    }
    public function afterAction($action, $result)
    {
        // your custom code here
        $action = $this->action->id;
        if ($action != 'tac' && !Yii::$app->user->isGuest && !Yii::$app->user->identity->tac){
            return $this->redirect(['site/tac']);
        }
        return parent::afterAction($action, $result);
    }

}
