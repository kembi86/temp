<?php

namespace modava\auth\controllers;

use backend\components\Email;
use cheatsheet\Time;
use common\models\UserToken;
use modava\auth\components\MyAuthController;
use modava\auth\models\form\LoginForm;
use modava\auth\models\form\RequestPasswordResetForm;
use modava\auth\models\form\ResetPasswordForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
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

    public function actionResetPassword($token = null)
    {

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $exception) {
            return $this->redirect(['/auth/login']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->resetPassword()) {
                Yii::$app->session->setFlash('toastr-reset-password', [
                    'text' => 'Thành công. Vui lòng đăng nhập lại',
                    'type' => 'success',
                ]);
            } else {
                Yii::$app->session->setFlash('toastr-reset-password', [
                    'text' => 'Thất bại. Vui lòng liên hệ bộ phận kỹ thuật',
                    'type' => 'bg-danger',
                ]);
            }
            return $this->refresh();
        }

        return $this->render('resetPassword', [
            'model' => $model
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
                Yii::$app->session->setFlash('toastr-request-password-reset', [
                    'text' => 'Thất bại. Vui lòng liên hệ bộ phận kỹ thuật',
                    'type' => 'warning'
                ]);

                return ['code' => 400,];
            }

            Email::sendEmail($model->email);

            Yii::$app->session->setFlash('toastr-request-password-reset', [
                'text' => 'Thành công. Vui lòng kiểm tra email và làm theo hướng dẫn.',
                'type' => 'success'
            ]);

            return ['code' => 200,];
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
