<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/3/17
 * Time: 9:30 PM
 */

/**
 * @var $game \app\models\Game
 * @var $model \app\models\PlayForm
 * @var $syndicate \app\models\Syndicate
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="container whiteBack">
	<div class="mainHeader">
		<?php
			if ($syndicate->creator_user_id == Yii::$app->user->id) {
				echo 'You are creating the following syndicate:';
			} else {
				echo 'You are joining the following syndicate:';
			}
		?>
	</div>
	<?php
		echo $this->render('/syndicate/_basketTable', ['hideActions' => 1]);
		echo $this->render('/syndicate/_table', ['purchased' => [],'model' => $syndicate, 'transaction' => 0, 'hideActions' => 1]);
		echo '</div><br />';
	?>
</div>
<div class="container play picknum-container">
    <!--<h3><?= $game->name ?> - <?= $game->nextDraw->draw_date ?></h3>-->
    <div style="padding:10px 20px;margin-bottom:30px" class="row">
        <?= Html::button('<i class="glyphicon glyphicon-trash"></i> Clear all', [
            'class' => 'btn btn-letsgo col-md-2',
            'data-trigger' => 'remove_all'
        ]) ?>
        <div class="col-md-8 text-center">
        <h1 style="text-transform: uppercase;color:#b151bc;"> Pick your numbers </h1>
        </div>
        <?= Html::button('<i class="glyphicon glyphicon-trash"></i> Quick Pick All', [
            'class' => 'btn btn-letsgo col-md-2',
            'data-trigger' => 'lucky_all'
        ]) ?>
    </div>

<?php
//$lines = $syndicate->getLines()->joinWith('ticket')->where(['user_id' => Yii::$app->user->id])->select('line.id')->all();
// $box_count =  count($lines);
 ?>
    <?php $form = ActiveForm::begin() ?>

    <div class="col-lg-12 bs-slider bs-size-xs box-size-sm">

        <div class="row">

            <?php foreach ($syndicate->getLines()->joinWith('ticket')->where(['user_id' => Yii::$app->user->id])->select('line.id')->all() as $line): ?>
                <div class="col-md-6 col-xs-12 bs-slide bs-slide-xs picknum-box-padding" data-line="<?= $line->id ?>">

                    <div class="card knockout-around picknum-box">
                        <div class="card-block">


                            <p>
                                <button type="button" class="btn bigBut picknum-btn-text col-md-3" data-trigger="lucky"
                                        data-game_id="<?= $game->id ?>">
                                    <i class="glyphicon glyphicon-flash"></i> Quick Pick
                                </button>
                                <button type="button" class="btn bigBut picknum-btn-text col-md-3 offset-md-3" data-trigger="remove"
                                        data-game_id="<?= $game->id ?>">
                                    <i class="glyphicon glyphicon-trash"></i> Clear
                                </button>
                            </p>


                            <?php foreach ($game->ballTypes as $type): ?>
                                <div class="row" data-info="1" data-type="<?= $type->id ?>"
                                     data-max="<?= $type->quantity_drawn ?>">

                                    <div class="col-md-12 nopadding color-black">
                                        <div data-count="<?= $line->id ?>" data-max="<?= $type->quantity_drawn ?>" class="picknum-command">

                                        </div>

                                    </div>
                                    <?php for ($i = 1; $i < $type->quantity_in_pot + 1; $i++): ?>
                                        <div class="col-md-1 col-xs-6 button-checkbox nopadding">

                                            <button type="button" class="btn number btn-sm btn-default btn-block btn-number" data-color="primary">
                                                <span class="off"><?= $i ?></span>
                                                <span class="on"><i class="fa fa-times"></i></span>
                                            </button>


                                            <?= Html::activeCheckbox($model, "checked[{$line->id}][$type->id][$i]", [
                                                'class' => 'hidden',
                                                'data-line' => $line->id,
                                                'data-number' => $i,
                                                'value' => 1,
                                                'label' => null
                                            ]) ?>

                                        </div>
                                    <?php endfor ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <div class="text-center col-md-2 offset-md-5">
        <?= Html::submitButton("Let's go", [
            'id' => 'play',
            'class' => 'btn btn-letsgo btn-lg',
            'disabled' => 'disabled'
        ]) ?>
    </div>



    <?php ActiveForm::end() ?>
</div>
<style>

    .nopadding {
        padding: 2px;
    }

    .color-black {
        color: black;
    }


    .play .button-checkbox .btn-primary {
        background-color: red;
    }

    .play .button-checkbox .btn {
        text-align: center !important;
    }

    .play .button-checkbox .btn-default span.on {
        display: none;
    }

    .play .button-checkbox .btn-default span.off {
        visibility: visible;
    }

    .play .button-checkbox .btn-primary span.on {
        visibility: visible;
    }

    .play .button-checkbox .btn-primary span.off {
        display: none;
    }

</style>
<script>
    $(function () {

        $('.bs-slider').bsSlider({
            autoChange: false,
            offset: 10
        });

        function updateDisplay() {

            var counts = $("[data-count]");

            var finished = true;

            counts.each(function (count) {
                var max = $(this).attr("data-max");
                var selected = $(this).closest('[data-info]').find("input:checkbox:checked").length;

                var text = null;
                if (selected < max) {
										if (max - selected > 1) {
											var numText = ' numbers';
										} else {
											var numText = ' number';
										}
                    text = "Select " + (max - selected) + numText;
                    finished = false;
                } else {
                    text = "DONE";
                }
                $(this).html(text);
            });

            if (finished) {
                $("#play").removeAttr('disabled');
            }
        }

        updateDisplay();

        var url = '<?= Yii::$app->urlManager->createUrl(['game/lucky', 'id' => 'param1']) ?>';

        $('[data-trigger=remove').on('click', function () {
            $(this).closest('[data-line]').find('input:checkbox').each(function () {
                uncheck($(this));
            });
            updateDisplay();
        });

        $('[data-trigger=remove_all').on('click', function () {
            $(document.body).find('input[data-number]').each(function () {
                uncheck($(this));
            });
        });

        $('[data-trigger=lucky_all').on('click', function () {
            $(document.body).find('input[data-number]').each(function () {
                uncheck($(this));
            });
            $('[data-trigger=lucky]').each(function(){
                var url_replaced = url
                    .replace('param1', $(this).attr("data-game_id")),
                self = $(this);

                $.ajax({
                    url: url_replaced,
                    dataType: 'json',
                    success: function (choices) {
                        var line = self.closest('[data-line]');
                        for (var type_id in choices) {
                            var data = choices[type_id];

                            line.find('[data-type=' + type_id + ']').find('input').each(function () {
                                if (data.indexOf(parseInt($(this).attr("data-number"))) != -1) {
                                    check($(this));
                                } else {
                                    uncheck($(this));
                                }
                            });
                        }

                        updateDisplay();
                    }
                });
            });          
        });

        $('[data-trigger=lucky]').on('click', function () {
            var url_replaced = url
                    .replace('param1', $(this).attr("data-game_id")),
                self = $(this);

            $.ajax({
                url: url_replaced,
                dataType: 'json',
                success: function (choices) {
                    var line = self.closest('[data-line]');
                    for (var type_id in choices) {
                        var data = choices[type_id];

                        line.find('[data-type=' + type_id + ']').find('input').each(function () {
                            if (data.indexOf(parseInt($(this).attr("data-number"))) != -1) {
                                check($(this));
                            } else {
                                uncheck($(this));
                            }
                        });
                    }

                    updateDisplay();
                }
            });
        });

        function check(input) {
            input.prop('checked', true);
            var btn = input.closest('.button-checkbox').find('.btn');
            btn.addClass('btn-primary').removeClass('btn-default');
        }

        function uncheck(input) {
            input.prop('checked', false);
            var btn = input.closest('.button-checkbox').find('.btn');
            btn.addClass('btn-default').removeClass('btn-primary');
        }

        $('.button-checkbox').on('click', function () {

            var info = $(this).closest('[data-info]');
            var selected = info.find("input:checkbox:checked").length;

            var input = $(this).find('input');
            var checked = input.is(':checked');

            if (checked) {
                uncheck(input);
                updateDisplay();
            } else {
                if (selected < info.attr('data-max')) {
                    check(input);
                    updateDisplay();
                }

            }
        });
    });
</script>
