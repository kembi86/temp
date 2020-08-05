<?php

namespace modava\auth\assets;

use yii\web\AssetBundle;

class RoleAsset extends AssetBundle
{
    public $sourcePath = '@authweb';
    public $css = [
        'fonts/feather/style.min.css',
        'vendors/css/forms/listbox/bootstrap-duallistbox.min.css',
        'css/plugins/forms/dual-listbox.css',
    ];
    public $js = [
        'vendors/js/forms/listbox/jquery.bootstrap-duallistbox.min.js'
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}