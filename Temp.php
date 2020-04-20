<?php

namespace app\modules\temp;

/**
 * affiliate module definition class
 */
class Temp extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\temp\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        \Yii::configure($this, require(__DIR__ . '/config/temp.php'));
        \Yii::$app->setComponents([

        ]);
    }
}
