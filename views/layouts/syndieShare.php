<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--
				<meta property="og:url" content="http://www.nytimes.com/2015/02/19/arts/international/when-great-minds-dont-think-alike.html" />
				<meta property="og:type" content="article" />
				<meta property="og:title" content="When Great Minds Don’t Think Alike" />
				<meta property="og:description" content="How much does culture influence creative thinking?" />
				<meta property="og:image" content="http://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />
-->
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
<?php echo $this->params['egg']; ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => 'Syndie',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
				$userDisplay = '';
				$balDisplay = '';
				if (!Yii::$app->user->isGuest) {
					$balDisplay .= '<li><a href="index.php?r=wallet/index">' . '£' . Yii::$app->user->identity->wallet->balance . '</a></li>';
				}
				if (isset(Yii::$app->user->identity->avatar)) {
					$userDisplay = '<img class="avatarMini" src="' . Yii::$app->user->identity->avatar . '" />';
				} elseif (!Yii::$app->user->isGuest) {	
					$userDisplay = Yii::$app->user->identity->username;
				}
		
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
								$balDisplay,
							//	['label' => '£' . Yii::$app->user->identity->wallet->balance, 'url' => ['/wallet/index'], 'visible' => !Yii::$app->user->isGuest],

                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
                ) : (
                [
                    'encode' => false,
                    'label' => $userDisplay,
                    'url' => ['site/language','set'=>'en'],
                    'items' => [
                        '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Sign Out',
                            ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'

                    ]
                ]
/*
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . $userDisplay . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
*/
                )
            ],
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Syndie Ltd <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
