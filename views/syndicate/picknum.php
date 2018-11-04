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
<div style="padding:20px;">

<div class="col-md-4">
    <div class="card">
        <div class="card-block">
        <div class="row" data-info="1" data-type="2"
             data-max="1">

            <div class="col-md-12 nopadding color-black">
                <div data-count="3234" data-max="1">

                </div>

            </div>
            <?php for ($i = 1; $i < 76; $i++): ?>
                <div class="col-md-1 col-xs-6 button-checkbox nopadding">

                    <button type="button" class="btn btn-sm btn-default btn-block btn-number"
                            data-color="primary">
                        <span class="off"><?= $i ?></span>
                        <span class="on"><i class="fa fa-times"></i></span>
                    </button>

                    <input type="hidden" name="PlayForm[checked][3234][2][1]" value="0">
                    <input type="checkbox" id="playform-checked-3234-2-1" class="hidden" name="PlayForm[checked][3234][2][1]" value="1" data-line="3234" data-number="1">
                </div>
            <?php endfor ?>
        </div>
        </div>
    </div>
</div>

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
                    text = "Select " + (max - selected) + " numbers";
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
