<div class="container">
<?php

use yii\bootstrap\Carousel;

echo Carousel::widget([
    'items' => [
        [
            'content' => '<div class="col-lg-12 row" style="position:relative">
                    <div class="hidden-md-down">
                        <img src="images/top_slider_bkgrnd.png"/>
                    </div>
                    <div class="hidden-lg-up">
                        <img src="images/mobile-caro-img.png" class="mobile-caro-img"/>
                    </div>
                    </div>
                    ',
            'caption' => '<div class="col-lg-12" style="padding:0px 10px;"><div class="col-lg-8 col-12"><p class="caroBig">The newest, simplest way<br />to go viral and win big</p><p class="caroSmall">Set up your own syndicates and share with friends</p></div><div class="col-lg-4"></div></div>',
            /*'options' => [
							'style' => 'max-height: 570px;'
						],
*/
        ],
		[
            'content' => '<div class="col-lg-12 row" style="position:relative">
                    <div class="hidden-md-down">
                        <img src="images/top_slider_bkgrnd.png"/>
                    </div>
                    <div class="hidden-lg-up">
                        <img src="images/mobile-caro-img.png" class="mobile-caro-img"/>
                    </div>
                    </div>
                    ',
            'caption' => '<div class="col-lg-12" style="padding:0px 10px;"><div class="col-lg-8 col-12"><p class="caroBig">Mode people join,  More people share</p><p class="caroSmall">More chances to win up to $1.5 billion!</p></div><div class="col-lg-4"></div></div>'
		]
    ],
    'controls' => [
        '<div class="carousel-arrow-left hidden-md-down"><label> < </label></div>',
        '<div class="carousel-arrow-right hidden-md-down"><label> > </label></div>'
    ]
]);

?>


    <div class="text-center" style="background-image: url('images/Slider_Bottom.png'); color:#d4d4d4;<?php if (Yii::$app->user->isGuest) echo 'margin-top: 20px;'; ?>">
        <b class="b-win-up-to">win up to $</b>
        <b class="b-one-five">1.5</b>
        <b class="b-billion">Billion !!</b>
    </div>
</div>

