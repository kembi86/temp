<?php

namespace modava\auth\components;


class MyErrorHandler extends \yii\web\ErrorHandler
{
    public $errorView = '@modava/auth/views/error/error.php';

}