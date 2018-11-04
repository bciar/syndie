<?php

/**
 * @var $model \app\models\Syndicate
 */
?>
<div class="midHolder" style="padding:50px;">
    <h2 class="whiteText text-center">Create Your Syndie!</h2>
    <?php

    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;

    //echo '<img src="' . $game->logo_path . '" />';


    ?>
    <div class="row">
    <div class="col-md-3" style="padding:3%;">
        <div class="well game-choose row">

                <div class="col-md-12">
                    <?= Html::img($game->logo_path, ['class' => 'img-fluid', 'style'=>'padding:15px 10px;']) ?>
                </div>
                <div class="col-md-12" style="padding:10px 50px;">
                    <p class="strip-content">
                        <i class="fa fa-calendar"></i>
                        Next: <?= Yii::$app->dates->mysql2ukTextDateTime($game->nextDraw->draw_date) ?>
                    </p>
                    <p class="strip-content">
                    <span>
                        <i class="fa fa-money"></i>
                        Jackpot: <?= '£' . number_format($game->nextDraw->est_jackpot, 0, '', ',') ?>
                        </span>
                    </p>
                </div>
        </div>
        <script>
            $(function(){
                $('#btn-submit').on('click', function(e){
                    e.preventDefault();
                    $('#form-new').submit();
                });
            });
        </script>
    </div>
    <div class="syndicate-form col-md-9" style="padding:30px 50px;">

        <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id'=>'form-new'/*, 'action'=>Yii::$app->homeUrl.'syndicate/picknum'*/]); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>



        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
        <?php

        echo $form->field($model, 'draw_id')->dropDownList($draws);


        ?>
        <?= $form->field($model, 'syndie_lines_per_person')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'number_of_draws')->textInput(['maxlength' => true]) ?>
        <?php // $form->field($model, 'min_players')->textInput(['maxlength' => true, 'placeholder' => 'No Minimum']) ?>
        <?= $form->field($model, 'max_players')->textInput(['maxlength' => true, 'placeholder' => 'No Maximum']) ?>

        <?= $form->field($model, 'privacy_level_id')->dropDownList($model->getAvailablePrivacies()) ?>
        <!--
            <p>If you select a minimum number of players, the syndicate, and any games associate with it, will not be activated until the threshold is met.</p>
            <p>Once the threshold has been met, the syndicate will become active for the next draw and continue for the number of draws selected.</p>
        i-->
        <?php $model->syndie_style = 1; ?>
        <?= $form->field($model, 'syndie_style')->hiddenInput()->label(false); ?>
<!--
        <div class="form-group col-md-9 hidden">
            // Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) 
        </div>
-->
        <div class="form-group row field-submit">

					<label class="form-control-label col-sm-3" for="submit"></label>


            <?= Html::a($model->isNewRecord ? 'Create' : 'Update', $game->getJoinUrl(), ['class' => 'bigBut btn-sep btn-new-syn nav-link col-sm-2', 'id'=>'btn-submit']) ?>
				</div>
        <?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
