<?php

namespace modava\auth\controllers;

use backend\components\Email;
use modava\auth\components\MyAuthController;
use modava\auth\models\form\LoginForm;
use modava\auth\models\form\RequestPasswordResetForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;


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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RequestPasswordResetForm();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
                return [
                    'code' => 400,
                    'msg' => 'Thất bại. Vui lòng liên hệ bộ phận kỹ thuật',
                ];
            }

            Email::sendEmail($model->email);

            return [
                'code' => 200,
                'msg' => 'Thành công. Vui lòng kiểm tra email và làm theo hướng dẫn.',
            ];
        }

        return $this->render('requestPasswordReset', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
