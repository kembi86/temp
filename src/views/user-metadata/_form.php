<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\auth\AuthModule;

/* @var $this yii\web\View */
/* @var $model modava\auth\models\UserMetadata */
/* @var $form yii\widgets\ActiveForm */
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <h5 class="form-group">Voip24h</h5>
    <div class="row">
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'WSServer')->textInput([
                'placeholder' => AuthModule::t('auth', 'WSServer')
            ]) ?>
        </div>
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'Realm')->textInput([
                'placeholder' => AuthModule::t('auth', 'Realm')])
            ?>
        </div>
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'User')->textInput([
                'placeholder' => AuthModule::t('auth', 'User')
            ]) ?>
        </div>
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'Pass')->textInput([
                'placeholder' => AuthModule::t('auth', 'Pass')])
            ?>
        </div>
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'Display')->textInput([
                'placeholder' => AuthModule::t('auth', 'Display')
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(AuthModule::t('auth', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>