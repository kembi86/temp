<?php

namespace modava\temp\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class TempAsset extends AssetBundle
{
    public $sourcePath = '@tempweb';
    public $css = [
        'dist/css/style.css',
    ];
    public $js = [
        'vendors/jquery/dist/jquery.min.js',
        'vendors/popper.js/dist/umd/popper.min.js',
        'vendors/bootstrap/dist/js/bootstrap.min.js',
        'dist/js/jquery.slimscroll.js',
        'dist/js/dropdown-bootstrap-extended.js',
        'vendors/owl.carousel/dist/owl.carousel.min.js',
        'dist/js/feather.min.js',
        'dist/js/init.js',
        'dist/js/login-data.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
