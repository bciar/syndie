<?php
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;

class GlobalComponent extends Component
{

  public function var_error_log( $object=null ){
    ob_start();                    // start buffer capture
    var_dump( $object );           // dump the values
    $contents = ob_get_contents(); // put the buffer into a variable
    ob_end_clean();                // end capture
    error_log( $contents );        // log contents of the result of var_dump( $object )
  }



public function format_cash($cash) {
    // strip any commas 
    $cash = (0 + str_replace(',', '', $cash));
 
    // make sure it's a number...
    if(!is_numeric($cash)){ return false;}
 
    // filter and format it 
    if($cash>1000000000000){ 
		return round(($cash/1000000000000),2).'t';
    }elseif($cash>1000000000){ 
		return round(($cash/1000000000),2).'b';
    }elseif($cash>1000000){ 
		return round(($cash/1000000),2).'m';
    }elseif($cash>1000){ 
		return round(($cash/1000),2).'k';
	}
 
    return number_format($cash);
}

}
?>

