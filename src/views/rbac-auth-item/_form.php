<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\auth\AuthModule;
use modava\auth\models\RbacAuthItem;

/* @var $this yii\web\View */
/* @var $model modava\auth\models\RbacAuthItem */
/* @var $form yii\widgets\ActiveForm */
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="rbac-auth-item-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(array_merge(['maxlength' => true], ($model->name == null ? [] : ['disabled' => true]))) ?>

    <?= $form->field($model, 'type')->dropDownList(RbacAuthItem::TYPE, []) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(AuthModule::t('auth', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
