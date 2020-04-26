<?php

namespace modava\temp;

use yii\base\BootstrapInterface;
use Yii;
use yii\base\Event;
use \yii\base\Module;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\Controller;

/**
 * Temp module definition class
 */
class Temp extends Module implements BootstrapInterface
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
        // custom initialization code goes here
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config/temp.php'));
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
        $this->layout = 'temp';
        $this->registerTranslations();
    }

    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_ACTION, function () {

        });
        Event::on(Controller::class, Controller::EVENT_BEFORE_ACTION, function (Event $event) {
            $controller = $event->sender;
        });
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['temp/messages/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@modava/temp/messages',
            'fileMap' => [
                'temp/messages/login' => 'login.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('temp/messages/' . $category, $message, $params, $language);
    }

}
