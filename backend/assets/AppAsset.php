<?php

namespace backend\assets;

use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/sb-admin-2.min.css',
        'vendor/fontawesome-free/css/all.min.css',
        'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
    ];
    public $js = [
        'vendor/jquery-easing/jquery.easing.min.js',
        'js/sb-admin-2.min.js',
    ];
    public $depends = [
        JqueryAsset::class,
        BootstrapPluginAsset::class,
        'yii\web\YiiAsset',
    ];
}
