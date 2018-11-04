<?php

namespace app\commands;

use yii\console\Controller;

class DeleteUserController extends Controller
{

public function actionIndex($id) {

$sql = "
delete from choice where line_id in (select id from line where ticket_id in (select id from ticket where user_id = $id))";
\Yii::$app->dbhelper->execute($sql);


$sql = "delete from line where ticket_id in (select id from ticket where user_id = $id)";
\Yii::$app->dbhelper->execute($sql);

$sql = "delete from ticket where user_id = $id";
\Yii::$app->dbhelper->execute($sql);

$sql = "delete from syndicate where creator_user_id = $id";
\Yii::$app->dbhelper->execute($sql);

$sql = "delete from wallet where user_id = $id";
\Yii::$app->dbhelper->execute($sql);

$sql = "delete from user where id = $id";
\Yii::$app->dbhelper->execute($sql);

}
}
?>
