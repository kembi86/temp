<?php

namespace modava\auth\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class UserCustomAsset extends AssetBundle
{
    public $sourcePath = '@authweb';
    public $css = [
        'css/customUser.css',
    ];
    public $js = [
        'js/customUser.js'
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
