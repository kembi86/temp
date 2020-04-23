<?php

namespace modava\temp;

use yii\base\BootstrapInterface;
use yii\web\Application;

/**
 * Temp module definition class
 */
class Temp extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'modava\temp\controllers';

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

        $handler = $this->get('errorHandler');
        \Yii::$app->set('errorHandler', $handler);
        $handler->register();
    }

    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            //Script here
        }
    }
}
