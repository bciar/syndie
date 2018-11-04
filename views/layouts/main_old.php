<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->head() ?>
  <?= Html::csrfMetaTags() ?>

<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>Syndie</title>
<!-- Bootstrap core CSS -->
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Karla:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="onepage">
<div id="preloader"><div class="textload">Loading</div><div id="status"><div class="spinner"></div></div></div>
<main class="body-wrapper">
  <nav class="navbar bottomBord">
    <div class="navbar-header">
      <div class="basic-wrapper">
        <div class="navbar-brand"> <a href="onepage.html"><img src="#" srcset="images/logo.png 1x, images/logo@2x.png 2x" class="logo-light" alt="" />
</div>
        <a class="btn responsive-menu" data-toggle="collapse" data-target=".navbar-collapse"><i></i></a> </div>
      <!-- /.basic-wrapper -->
    </div>
    <!-- /.navbar-header -->
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="current"><a href="#home">Home</a></li>
        <li><a href="#services">FAQ</a></li>
        <?php
        if (!Yii::$app->user->isGuest) {
          $url = Yii::$app->urlManager->createUrl(['wallet/index']);
          echo '<li><a href="#gallery">Sign Out</a></li>';
          echo '<li class="whiteText"><a class="whiteText" href="'. $url .'">£' . Yii::$app->user->identity->wallet->balance . '</a></li>';
        } else {
          echo '<li><a href="index.php?r=/user/security/login">Sign In</a></li>';
        }
        ?>

      </ul>
      <!-- /.navbar-nav -->
    </div>
    <!-- /.navbar-collapse -->

    <div class="social-wrapper">


      <ul class="social naked">
      <li><a href="#"><i class="icon-s-facebook"></i></a></li>
        <li><a href="#"><i class="icon-s-twitter"></i></a></li>
        <li><a href="#"><i class="icon-s-flickr"></i></a></li>
        <li><a href="#"><i class="icon-s-instagram"></i></a></li>
      </ul>
      <!-- /.social -->
    </div>

    <!-- /.social-wrapper -->
  </nav>
  <!-- /.navbar -->

  <section id="home">

  <div class="parallax parallax4 inverse-wrapper customers">
    <div class="container inner text-center">


		</div>

    <?php foreach(Yii::$app->session->getAllFlashes() as $class => $message): ?>
      <div class="alert alert-<?= $class ?>">
        <?= $message ?>
      </div>
    <?php endforeach; ?>

        <?= $content ?>

	</div>
  </section>
  <!--/#home -->



  <div class="parallax parallax3 inverse-wrapper customers bottomBord">
    <div class="container innerSmaller text-center">
      <h3 class="section-title">Some other stuff</h3>
      <div class="testimonials owl-carousel thin">
        <div class="item">
          <blockquote>
            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur. Nullam dolor nibh ultricies vehicula elit vulputate tristique egestas.<small class="meta">Nikolas Brooten</small></p>
          </blockquote>
        </div>
        <!-- /.item -->
        <div class="item">
          <blockquote>
            <p>Cras justo odio, dapibus facilisis in, egestas eget quam. Maecenas faucibus mollis interdum. Etiam porta sem malesuada magna mollis euismod.<small class="meta">Coriss Ambady</small></p>
          </blockquote>
        </div>
        <!-- /.item -->
        <div class="item">
          <blockquote>
            <p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis id vestibulum. Donec sed odio dui. Sed posuere consectetur est at lobortis.<small class="meta">Barclay Widerski</small></p>
          </blockquote>
        </div>
        <!-- /.item -->
        <div class="item">
          <blockquote>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Maecenas faucibus mollis interdum. Vivamus sagittis lacus vel augue laoreet.<small class="meta">Elsie Spear</small></p>
          </blockquote>
        </div>
        <!-- /.item -->
      </div>
      <!-- /.testimonials -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.parallax -->


  <section id="contact">
    <div class="light-wrapper bottomBord">
      <div class="container innerSmallish">
        <div class="thin">
          <h3 class="section-title text-center greyish">Syndie Ltd</h3>
          <p class="text-center"></p>
          <ul class="contact-info text-center">
            <li><i class="icon-location"></i>Registered in Scotland, company number SC558940.  2-4 Salamander Place, Edinburgh, United Kingdom, EH6 7JB</li><br />
            <!-- <li><i class="icon-phone"></i>+00 (123) 456 78 90</li> -->
            <li><i class="icon-mail"></i><a href="first.last@email.com">info@syndie.co.uk</a> </li>
          </ul>
        </div>
        <!-- /.thin -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.light-wrapper -->

<script>



</script>
  <!--/#contact -->

  <footer class="footer inverse-wrapper bottomBord">
    <div class="container inner">
      <div class="row">
        <div class="col-sm-4">
          <!-- /.widget -->
        </div>
        <!-- /column -->

        <div class="col-sm-4">
          <div class="widget">
            <ul class="social">
              <li><a href="#"><i class="icon-s-rss"></i></a></li>
              <li><a href="#"><i class="icon-s-twitter"></i></a></li>
              <li><a href="#"><i class="icon-s-facebook"></i></a></li>
              <li><a href="#"><i class="icon-s-pinterest"></i></a></li>
              <li><a href="#"><i class="icon-s-linkedin"></i></a></li>
            </ul>
            <!-- .social -->

          </div>
        </div>
        <!-- /column -->

        <div class="col-sm-4">

        </div>
        <!-- /column -->

      </div>
      <!-- /.row -->
    </div>
    <!-- .container -->

    <div class="sub-footer ">
      <div class="container inner">
        <p class="text-center">© 2015 Syndie Ltd. All rights reserved.</p>
      </div>
      <!-- .container -->
    </div>
    <!-- .sub-footer -->
  </footer>
  <!-- /footer -->
  <div class="slide-portfolio-overlay"></div><!-- overlay that appears when slide portfolio content is open -->
</main>
<!--/.body-wrapper -->

<!-- slide-portfolio-item-content -->
<a href="#0" class="slide-portfolio-item-content-close"><i class="budicon-cancel-1"></i></a> <!-- close slide portfolio content -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

