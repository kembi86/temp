<?php

namespace modava\auth\components;


class MyErrorHandler extends \yii\web\ErrorHandler
{
    public $errorView = '@auth/views/auth/error.php';

}