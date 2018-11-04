<?php
/**
 * Created with love.
 * User: benas
 * Date: 5/20/17
 * Time: 10:50 PM
 */

/**
 * @var $transaction \app\models\Transaction
 * @var $syndicates \app\models\Syndicate[]
 */

//$test = 0;
?>
<div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-10">
        <div class="slider syndicates row">
            <?php
            foreach ($syndicates as $syndicate) {
                /*if ($test == 1)
                {
                    for ($i=0; $i<4; $i++)
                    {
                        echo $this->render('_box', [
                            'model' => $syndicate,
                            'transaction' => $transaction]);
                    }
                }
                else {*/
                    echo $this->render('_box', [
                            'model' => $syndicate,
                            'transaction' => $transaction]);
                //}
            }
            ?>
        </div>
    </div>
    <div class="col-md-1">

    </div>
</div>
