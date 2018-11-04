<?php
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;

class DatesComponent extends Component
{

  public function uk2mysql($date) {
     if ($date == '') { return $date; }
     if (preg_match('/\//', $date)) {
       $chdate = explode('/',$date);
     }
     if (preg_match('/-/', $date)) {
       $chdate = explode('-',$date);
     }

     if (strlen($chdate[2]) == 2) { $prefix = '20'; } else { $prefix = ''; }
     $changedate = $prefix . $chdate[2].'-'.$chdate[1].'-'.$chdate[0];
     return $changedate;
  }

  public function mysql2uk($date) {
     if ($date == '') { return $date; }
     if ($date == '0000-00-00') { return ''; }
     $chdate = explode('-',$date);
     $changedate = $chdate[2].'/'.$chdate[1].'/'.substr($chdate[0],2,2);
     return $changedate;
  }

  public function mysql2uklong($date) {
     if ($date == '') { return $date; }
     if ($date == '0000-00-00') { return ''; }
     $chdate = explode('-',$date);
     $changedate = $chdate[2].'/'.$chdate[1].'/'.$chdate[0];
     return $changedate;
  }

  public function mysqldt2uk($date) {
     if ($date == '') { return $date; }
     if ($date == '0000-00-00') { return ''; }
     $dt = explode(' ', $date);
     $chdate = explode('-',$dt[0]);
     $changedate = $chdate[2].'/'.$chdate[1].'/'.substr($chdate[0],2,2);
     return $changedate . ' ' . $dt[1];
  }

  public function mysqldt2ukdate($date) {
     if ($date == '') { return $date; }
     if ($date == '0000-00-00') { return ''; }
     $dt = explode(' ', $date);
     $chdate = explode('-',$dt[0]);
     $changedate = $chdate[2].'/'.$chdate[1].'/'.substr($chdate[0],2,2);
     return $changedate;
  }
  public function mysql2ukTextDate($date) {
     if ($date == '') { return $date; }
     if ($date == '0000-00-00') { return ''; }
     return date_format(date_create($date), 'd M Y');

  }

  public function mysql2ukTextDateTime($date) {
     if ($date == '') { return $date; }
     if ($date == '0000-00-00') { return ''; }
     return date_format(date_create($date), 'd M Y H:i');

  }

  public function isSqlFormat($date) {

    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
      return true;
    } else {
      return false;
    }

  }

  public function sql2uk($sqldate) {

    if ($sqldate == '') { return ''; }
    $hash = array(

      '01' => 'Jan',
      '02' => 'Feb',
      '03' => 'Mar',
      '04' => 'Apr',
      '05' => 'May',
      '06' => 'Jun',
      '07' => 'Jul',
      '08' => 'Aug',
      '09' => 'Sep',
      '10' => 'Oct',
      '11' => 'Nov',
      '12' => 'Dec'
    );
    $monthHash = array_flip($hash);
    $dates = explode("-", $sqldate);
    if (in_array($dates[1],array_keys($monthHash))) {
      // do it that way
      return $dates[2] . '-' . $monthHash[$dates[1]] . '-' . $dates[0];
    } else {
      # TODO CHECK 4 digit YEAR
      $chars = str_split($dates[2]);
      return $chars[0] . $chars[1] . "-" . $hash[$dates[1]] . "-" . $dates[0];
    }
  }


}


?>

