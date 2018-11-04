<?php
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class DbHelperComponent extends Component
{

    public function dpExportCsv($dp, $filename) {
      $data = $dp->getModels();
      $i = 1;
      $file = 'tmpdownload/' . $filename;
      $str = '';
      foreach ($data as $line) {
        foreach ($line as $k => $v) {
          if ($i == 1) {
            $str .= $k . ',';
          } else {
            $str .= $v . ',';
          }
        }
        if ($i == 1) {
          $str .= "\n";
          $i++;
          $continue;
        }
          // loop again for values
        //foreach ($line as $k => $v) {
        //  if ($i == 1) {
        //    $str .= $v . ',';
        //  }

        $i++;
      }
      $fh = fopen($file, 'w');
      fwrite($fh, $str);
      fclose($fh);

    }

    public function one($sql) {

      $connection = Yii::$app->getDb();
      $command = $connection->createCommand($sql);
      $res = $command->queryOne();
      return $res;
    }
    public function getOne($sql,$field) {

      $connection = Yii::$app->getDb();
      $command = $connection->createCommand($sql);
      $res = $command->queryOne();
      return $res[$field];
    }


    public function all($sql) {

      $connection = Yii::$app->getDb();
      $command = $connection->createCommand($sql);
      $res = $command->queryAll();
      return $res;
    }

    public function execute($sql) {

      $connection = Yii::$app->getDb();
      $command = $connection->createCommand($sql);
      $res = $command->execute();
      return $res;
    }
}


?>

