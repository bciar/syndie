<?php

use dektrium\user\widgets\Connect;
use dektrium\user\widgets\Login;
use yii\helpers\Html;

/**
 * @var array $syndicates
 */

$social = Yii::$app->getModule('social');
$fb = $social->getFb(); // gets facebook object based on module settings
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken();

?>
<?= Html::cssFile('@web/css/owl.carousel.min.css') ?>
<?= Html::cssFile('@web/css/owl.theme.default.min.css') ?>

<div class="purplerec orangeBord">
    <div id="bigrec">
        <?php Login::widget() ?>

        <?php Connect::widget([
            'baseAuthUrl' => ['/user/security/auth'],
        ]) ?>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->avatarPath): ?>
            <?php //Html::img(Yii::$app->user->identity->getAvatar()) ?>

            <?php // Html::a('<i class="fa fa-facebook"></i> Share', Yii::$app->user->identity->shareUrl, ['class' => 'btn btn-info']) ?>
        <?php endif ?>

    </div>
</div>


<?php
echo $this->render("_strip");
echo '<div id="syndie-panel" class="hidden hidden-lg-up">';
/*if (Yii::$app->user->isGuest):*/?>
<div class="owl-carousel owl-theme">
<?php 
    foreach ($syndicates as $index) {
        foreach ($index as $syndi) {
            echo $this->render('//syndicate/_box', [
                'model' => $syndi,
                'transaction' => false]);
        }
    }
?>
</div>
<?php /*else:
$i = 0;
foreach ($syndicates as $title => $_syndicates) {
    if (!count($_syndicates)) continue;

    //echo Html::tag('h2', $title);
    echo $this->render('//syndicate/_slider', [
        'syndicates' => $_syndicates,
        'transaction' => false
    ]);
		$i++;
		if ($i == 1) {
			echo $this->render('_midBar');
		}
}
endif;*/
echo '</div>';

echo '<div class="hidden-md-down">';
$i = 0;
foreach ($syndicates as $title => $_syndicates) {
    if (!count($_syndicates)) continue;

    //echo Html::tag('h2', $title);
    echo $this->render('//syndicate/_slider', [
        'syndicates' => $_syndicates,
        'transaction' => false
    ]);
        $i++;
        if ($i == 1) {
            echo $this->render('_midBar');
        }
}

echo '</div>';
?>
<div class="row hidden-lg-up">
<div class="container-original" style="margin:0; width:100%;">
<?php if (Yii::$app->user->isGuest): ?>
    <div class="col-12" style="margin-bottom:20px;">
        <div class="well game row">
            <a class="mobile-btn-signup" href="#top" data-toggle="jpanel-menu" data-target=".navbar-main" data-direction="right" >Signup / Login</a>
        </div>
    </div>
<?php endif; ?>
    <div class="col-12" style="margin-bottom:20px;">
        <div class="well game row">
            <a class="mobile-btn-show-syndie" id="toggle-syndie-panel">+ Show Syndicates</a>
        </div>
    </div>
</div>
</div>

<?= Html::jsFile('@web/js/owl.carousel.min.js') ?>
<script>
    $(function(){
        var isShownSyndies = false;
        $('#toggle-syndie-panel').on('click', function(e){
            e.preventDefault();
            isShownSyndies = !isShownSyndies;
            if (isShownSyndies){
                $('#syndie-panel').show();
                $('#toggle-syndie-panel').html("- Hide Syndicates");
            }
            else{
                $('#syndie-panel').hide();
                $('#toggle-syndie-panel').html("+ Show Syndicates");
            }
        });
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
    });
</script>
