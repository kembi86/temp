<?php

namespace modava\auth\controllers;

use modava\auth\models\form\LoginForm;
use modava\auth\components\MyAuthController;
use modava\auth\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class AuthController extends MyAuthController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['login']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/site/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/site/index']);
        } else {
            $model->password = '';
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword()
    {
        return $this->render('resetPassword', [

        ]);
    }

    public function actionRequestPasswordReset()
    {
        return $this->render('requestPasswordReset', [

        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
