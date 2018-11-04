<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{


public $jsOptions = array(
    'position' => \yii\web\View::POS_HEAD
);

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'theme/css/theme-style.min.css',
        'css/custom.css',
				'css/fonts.css',
        'theme/plugins/_overrides/plugin-slider-revolution.min.css'
    ];

    public $js = [
        'js/bsSlider.jquery.js',
        'js/site.js',
        'theme/js/script.js',
        'theme/plugins/jPanelMenu/jquery.jpanelmenu.min.js',
        //'theme/plugins/slider-revolution/revolution/js/jquery.themepunch.tools.min.js'
    ];

   /* public $js = [
			'js/plugins.js',
			'js/classie.js',
			'js/jquery.themepunch.tools.min.js',
			'js/scripts.js'

    ];*/
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\jui\JuiAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'app\assets\TouchSwipeAsset',
        'xj\bootbox\BootboxOverrideAsset',
        'evgeniyrru\yii2slick\SlickAsset'
    ];
}

