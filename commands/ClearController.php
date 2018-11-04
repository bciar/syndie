<?php

namespace app\commands;

use yii\console\Controller;

class ClearController extends Controller
{

public function actionIndex() {

$sql = "DELETE FROM choice";
\Yii::$app->dbhelper->execute($sql);
$sql = "DELETE FROM line";
\Yii::$app->dbhelper->execute($sql);
$sql = "DELETE FROM ticket";
\Yii::$app->dbhelper->execute($sql);
$sql = "DELETE FROM syndicate";
\Yii::$app->dbhelper->execute($sql);
$sql = "DELETE FROM transaction";
\Yii::$app->dbhelper->execute($sql);

}
}
?>
