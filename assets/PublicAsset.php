<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/bootstrap.min.css',
        'css/style.css',
        'css/mystyle.min.css',
    ];
    public $js = [
        'js/fontawesome/all.min.js',
        'js/scripts.min.js',
        'js/bootstrap.min.js',
        //'js/owl.carousel.min.js',
        //'js/jquery.stickit.min.js',
        //'js/menu.js',
        //'js/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
        //'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
