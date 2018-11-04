<?php
/**
 * Created with love.
 * User: benas
 * Date: 4/13/17
 * Time: 9:13 PM
 */

namespace app\assets;

use yii\web\AssetBundle;

class TouchSwipeAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-touchswipe';

    public $publishOptions = [
        'except'=>['/demos/','/docs/'],
        'only'=>['*.js']
    ];

    public $depends = [ 'yii\web\JqueryAsset'];

    public function init()
    {
        if (YII_DEBUG) {
            $this->js = ['jquery.touchSwipe.js'];
        } else {
            $this->js = ['jquery.touchSwipe.min.js'];
        }
    }
}