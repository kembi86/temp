<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\auth\AuthModule;
use modava\auth\models\UserModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model modava\auth\models\User */
/* @var $modelProfile \modava\auth\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <?php if ($model->scenario === UserModel::SCENARIO_DEV) { ?>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($modelProfile, 'fullname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($modelProfile, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'status')->dropDownList(UserModel::STATUS, []) ?>
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group field-user-status">
                <?php
                $user = new UserModel();
                $auth = Yii::$app->authManager;
                $model->role_name = $user->getRoleName($model->id);
                ?>
                <?= $form->field($model, 'role_name')->dropDownList(ArrayHelper::map($auth->getChildRoles($user->getRoleName(Yii::$app->user->id)), 'name', 'description'), [
                    'class' => 'form-control',
                    'id' => 'user-role-name'
                ])->label('Quyền') ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(AuthModule::t('auth', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>