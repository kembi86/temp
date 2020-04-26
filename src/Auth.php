<?php

namespace modava\auth;

use yii\base\BootstrapInterface;
use Yii;
use yii\base\Event;
use \yii\base\Module;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\Controller;

/**
 * Auth module definition class
 */
class Auth extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'modava\auth\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // custom initialization code goes here
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config/auth.php'));
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
        $this->layout = 'auth';
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
        Yii::$app->i18n->translations['auth/messages/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@modava/auth/messages',
            'fileMap' => [
                'auth/messages/login' => 'login.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('auth/messages/' . $category, $message, $params, $language);
    }

}
