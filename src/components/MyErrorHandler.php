<?php

namespace modava\temp\components;


class MyErrorHandler extends \yii\web\ErrorHandler
{
    public $errorView = '@temp/views/temp/error.php';

}