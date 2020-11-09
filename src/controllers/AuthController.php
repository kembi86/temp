<?php

namespace modava\auth\controllers;

use backend\components\Email;
use modava\auth\components\MyAuthController;
use modava\auth\models\form\ChangePassWordForm;
use modava\auth\models\form\LoginForm;
use modava\auth\models\form\RequestPasswordResetForm;
use modava\auth\models\form\ResetPasswordForm;
use modava\auth\models\UserModel;
use modava\auth\models\UserProfile;
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

    public function actionProfile()
    {
        $this->layout = 'user';

        $user = new UserModel();
        $roleUser = $user->getRoleName(Yii::$app->user->id);
        $model = UserProfile::findOne(Yii::$app->user->id);

        $auth = Yii::$app->authManager;
        $roleName = $auth->getChildRoles($roleUser);

        return $this->render('profile', [
            'roleUser' => $roleUser,
            'roleName' => $roleName,
            'model' => $model
        ]);
    }

    public function actionUpdateProfile()
    {
        $this->layout = 'user';

        $user = new UserModel();
        $roleUser = $user->getRoleName(Yii::$app->user->id);
        $model = UserProfile::findOne(Yii::$app->user->id);

        $auth = Yii::$app->authManager;
        $roleName = $auth->getChildRoles($roleUser);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                Yii::$app->session->setFlash('toastr-update-profile', [
                    'text' => Yii::$app->params['update-success'],
                    'type' => 'success',
                ]);
            } else {
                Yii::$app->session->setFlash('toastr-update-profile', [
                    'text' => Yii::$app->params['update-warning'],
                    'type' => 'warning',
                ]);
            }
            return $this->redirect(Url::toRoute(['profile']));
        }

        return $this->render('update', [
            'roleUser' => $roleUser,
            'roleName' => $roleName,
            'model' => $model
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

    public function actionChangePassword()
    {
        $this->layout = 'user';

        $id = Yii::$app->user->id;
        $model = new ChangePassWordForm($id);

        $user = new UserModel();
        $userInfo = UserProfile::findOne(Yii::$app->user->id);

        $auth = Yii::$app->authManager;
        $roleUser = $user->getRoleName(Yii::$app->user->id);
        $roleName = $auth->getChildRoles($roleUser);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('toastr-change-password', [
                    'text' => Yii::$app->params['change-password-success'],
                    'type' => 'success',
                ]);
            } else {
                Yii::$app->session->setFlash('toastr-change-password', [
                    'text' => Yii::$app->params['change-password-error'],
                    'type' => 'danger',
                ]);
            }
            return $this->refresh();
        }

        return $this->render('changePassword', [
            'model' => $model,
            'userInfo' => $userInfo,
            'roleUser' => $roleUser,
            'roleName' => $roleName,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
