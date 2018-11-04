<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\components\Nav;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

$items = [
];

if (Yii::$app->user->isGuest) {
    //$items[] = ['label' => 'Sign up', 'url' => ['/user/registration/register'], 'options' => ['class' => 'btn-login mr30']];
    $items[] = ['label' => 'Join / Login', 'url' => ['/user/security/login'], 'options' => ['class' => 'btn-login mr30']];
} else {

    if (isset(Yii::$app->user->identity->avatar)) {
        $userDisplay = '<img class="avatarMini" src="' . Yii::$app->user->identity->avatar . '" />';
    } else {
        $userDisplay = Yii::$app->user->identity->username;
    }
    $items = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'New Syndie', 'url' => ['/syndicate/choose-game']],
        ['label' => 'Wallet', 'url' => ['wallet/index']],
        ['label' => 'Setting', 'url' => ['/site/setting']],
        ['label' => 'Sign out', 'url' => ['site/logout'], 'linkOptions' => ['data-method' => 'post']],
    ];

    /*$items[] = [
        'label' => 'Wallet',//'£' . Yii::$app->user->identity->wallet->balance,
        'url' => ['wallet/index']
    ];

    $item[] = [
        'label' => 'Sign out',
        'url' => ['site/logout']
    ];*/
    /*$items[] = [
        'encode' => false,
        'label' => $userDisplay,
        'linkOptions' => ['class' => 'avatar-dropdown'],
        'url' => ['site/language', 'set' => 'en'],
        'items' => [
            [
                'label' => 'Brand',
                'url' => ['/brand/update'],
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->type == User::TYPE_SPONSOR
            ],
            [
                'label' => 'Logout',
                'url' => ['/site/logout'],
            ],

        ]
    ];*/
}
?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="<?= Yii::$app->charset ?>8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <?php
    if (isset($this->params['url'])) {
        echo Html::tag('meta', '', ['property' => 'og:url', 'content' => $this->params['url']]);
        echo Html::tag('meta', '', ['property' => 'og:description', 'content' => $this->params['description']]);
        echo Html::tag('meta', '', ['property' => 'og:image', 'content' => $this->params['image']]);
        echo Html::tag('meta', '', ['property' => 'og:app_id', 'content' => $this->params['faid']]);
        echo Html::tag('meta', '', ['property' => 'og:type', 'content' => $this->params['type']]);
        echo Html::tag('meta', '', ['property' => 'og:title', 'content' => $this->params['title']]);
    }
    ?>
    <?= Html::csrfMetaTags() ?>

    <!--Your custom colour override-->
    <link href="#" id="colour-scheme" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Rambla' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>

    <!--Plugin: Retina.js (high def image replacement) - @see: http://retinajs.com/-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/retina.js/1.3.0/retina.min.js"></script>

    <?php $this->head() ?>
</head>

<!-- ======== @Region: body ======== -->
<body class="page page-404 navbar-layout-default page-centred header-translucent header-compact">

<?php $this->beginBody() ?>
<a href="#content" id="top" class="sr-only">Skip to content</a>

<!-- ======== @Region: #header ======== -->
<div id="header">

    <!--Hidden Header Region-->
    <div class="header-hidden collapse">
        <div class="header-hidden-inner container">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        About Us
                    </h3>
                    <p>Making the web a prettier place one template at a time! We make beautiful, quality, responsive
                        Drupal & web templates!</p>
                    <a href="about.htm" class="btn btn-sm btn-primary">Find out more</a>
                </div>
                <div class="col-sm-6">
                    <!--@todo: replace with company contact details-->
                    <h3>
                        Contact Us
                    </h3>
                    <address>
                        <p>
                            <abbr title="Phone"><i class="fa fa-phone"></i></abbr>
                            019223 8092344
                        </p>
                        <p>
                            <abbr title="Email"><i class="fa fa-envelope"></i></abbr>
                            info@themelize.me
                        </p>
                        <p>
                            <abbr title="Address"><i class="fa fa-home"></i></abbr>
                            Sunshine House, Sunville. SUN12 8LU.
                        </p>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div data-toggle="sticky">

        <!--Header search region - hidden by default -->
        <div class="header-search collapse" id="search">
            <form class="search-form container">
                <input type="text" name="search" class="form-control search" value="" placeholder="Search">
                <button type="button" class="btn btn-link"><span class="sr-only">Search </span><i
                        class="fa fa-search fa-flip-horizontal search-icon"></i></button>
                <button type="button" class="btn btn-link close-btn" data-toggle="search-form-close"><span
                        class="sr-only">Close </span><i class="fa fa-times search-icon"></i></button>
            </form>
        </div>

        <!--Header & Branding region-->
        <div class="header">
            <!-- all direct children of the .header-inner element will be vertically aligned with each other you can override all the behaviours using the flexbox utilities (flexbox.htm) All elements with .header-brand & .header-block-flex wrappers will automatically be aligned inline & vertically using flexbox, this can be overridden using the flexbox utilities (flexbox.htm) Use .header-block to stack elements within on small screen & "float" on larger screens use .flex-first or/and .flex-last classes to make an element show first or last within .header-inner or .headr-block elements -->
            <div class="header-inner container">
                <!--branding/logo -->
                <div class="header-brand flex-first col-lg-6 col-8">
                    <a class="header-brand-text" href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>"
                       title="Home">
                    <img class="logoHead img-fluid" src="<?php echo Yii::$app->request->baseUrl . '/images/logo.png';?>" />
                    </a>
                </div>
                <!-- other header content -->
                <div class="header-block flex-last col-lg-6 col-4 row">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <a href="#top" data-toggle="jpanel-menu" data-target=".navbar-main" data-direction="right" style="padding:5px 0px;" class="col-sm-4 offset-sm-4 col-12 hidden-lg-up text-center">
                    <img src="<?= Yii::$app->user->identity->getAvatar() ?>" class="img-fluid mobile-personal-img" alt="photo"/>
                    <i class="fa fa-caret-down" aria-hidden="true" style="color:#db3aea"></i>
                    </a>
                <?php elseif (Yii::$app->user->isGuest && Yii::$app->controller->id==Yii::$app->defaultRoute && Yii::$app->controller->action->id === Yii::$app->controller->defaultAction): ?>
                    <ul id="w1" class="nav navbar-nav float-lg-right dropdown-effect-fade hidden-lg-up" style="width:150px; margin-left:auto;">
                    <li class="btn-login">
                    <a class="nav-link-login" href="<?=Url::to(['user/login']);?>">Join / Login</a></li>
                    </ul>
                 <?php endif; ?>
                </div>
                    <!--Search trigger -->
                    <!--<a href="#search" class="btn btn-icon btn-link header-btn float-right flex-last"
                       data-toggle="search-form" data-target=".header-search"><i
                            class="fa fa-search fa-flip-horizontal search-icon"></i></a>-->

                    <!-- mobile collapse menu button - data-toggle="collapse" = default BS menu - data-toggle="jpanel-menu" = jPanel Menu - data-toggle="overlay" = Overlay Menu -->
                    <!--<div class="col-8">
                    </div>
                    <div class="col-4">
                    <a href="#top" class="btn btn-link btn-icon header-btn float-right hidden-lg-up"
                       data-toggle="jpanel-menu" data-target=".navbar-main" data-direction="right" style="padding:0px;"> <i class="fa fa-bars"></i> </a>
                    </div>-->

                <div class="navbar navbar-toggleable-md">
                    <!--everything within this div is collapsed on mobile-->
                    <div class="hidden-lg-up">
                    <div class="navbar-main collapse">
                        <!--main navigation-->
                        <ul class="nav navbar-nav float-lg-right dropdown-effect-fade">
                            <?php
                            echo Nav::widget([
                                'options' => ['class' => 'nav navbar-nav float-lg-right dropdown-effect-fade'],
                                'items' => $items
                            ]);
                            ?>
                        </ul>

                    </div>
                    </div>
                    <!--/.navbar-collapse -->
                    <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="hidden-md-down">
                        <ul class="navbar-nav">
                        <li class="nav-item btn-login mr30">
                            <!-- <a class="nav-link" href="<?= Url::toRoute('syndicate/choose-game') ?>">New Syndie</a> -->
                        </li>
                        <li class="nav-item btn-login mr30">
                            <a class="nav-link" href="<?= Url::toRoute('wallet/index') ?>"><?='£'.Yii::$app->user->identity->wallet->balance ?></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?= Yii::$app->user->identity->getAvatar() ?>" class="img-fluid desktop-personal-img" style="height: 60px; width: 60px" alt="photo"/>
                                <i class="fa fa-caret-down" aria-hidden="true" style="color:#db3aea"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="<?= Url::home() ?>">Home</a>
                              <a class="dropdown-item" href="<?php echo Url::home() . 'syndicate/choose-game' ?>">Create Syndie</a>
                              <a class="dropdown-item" href="<?php echo Url::home() . 'syndicate/public?username=' . Yii::$app->user->identity->username ?>">My Syndies</a>
                              <a class="dropdown-item" href="<?php echo Url::home() . 'wallet/history' ?>">My Wallet</a>
                              <a class="dropdown-item" href="<?php echo Url::home() . 'basket/buy' ?>">My Basket</a>

                              <?= Html::a('Sign out', ['site/logout'], ['data-method' => 'post', 'class'=>'dropdown-item']); ?>
                              <!--<a class="dropdown-item" href="#">Sign out</a>-->
                            </div>
                          </li>
                        </ul>
                    </div>
                    <?php else: 
                        echo '<div class="hidden-md-down">';
                        echo Nav::widget([
                            'options' => ['class' => 'nav navbar-nav float-lg-right dropdown-effect-fade'],
                            'items' => $items
                        ]);
                        echo '</div>';
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($this->context->id == 'site' && $this->context->action->id == 'index') {
    echo $this->render('//site/carousel');
}
?>

<div id="content">
    <div class="container main-container">


        <?php foreach(Yii::$app->session->getAllFlashes() as $class => $message): ?>
            <div class="alert alert-<?= $class ?>">
                <?= $message ?>
            </div>
        <?php endforeach; ?>

        <?= $content ?>
    </div>
</div>

<div class="footer">
<div class="container">
<?php

echo $this->render("//site/footer");

?>
</div>
</div>
<!-- Tether 1.1.1 via CDN, needed for Bootstrap Tooltips & Popovers -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.1.1/js/tether.min.js"></script>


<!-- JS plugins required on all pages NOTE: Additional non-required plugins are loaded ondemand as of AppStrap 2.5 -->

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
