<?php

namespace modava\auth\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AuthAsset extends AssetBundle
{
    public $sourcePath = '@authweb';
    public $css = [
        'css/my-loading.css',
        'dist/css/style.css',
        'dist/css/auth.css',
    ];
    public $js = [
        'vendors/popper.js/dist/umd/popper.min.js',
        'vendors/bootstrap/dist/js/bootstrap.min.js',
        'dist/js/jquery.slimscroll.js',
        'dist/js/dropdown-bootstrap-extended.js',
        'vendors/owl.carousel/dist/owl.carousel.min.js',
        'dist/js/feather.min.js',
        'dist/js/init.js',
        'dist/js/login-data.js',
        'js/my-loading.js',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
