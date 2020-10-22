<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('backend', 'Reset password');
$css = <<< CSS
.brand-img{max-height: 120px;}
.hk-pg-wrapper.hk-auth-wrapper .auth-form-wrap .auth-form{padding: 25px;background-color: #fff;border-radius: .25rem;}
CSS;
$this->registerCss($css);

?>
<div class="hk-wrapper">

    <!-- Main Content -->
    <div class="hk-pg-wrapper hk-auth-wrapper">

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 pa-0">
                    <div class="auth-form-wrap pt-xl-0 pt-70">
                        <div class="auth-form w-xl-30 w-sm-50 w-100">
                            <a class="auth-brand text-center d-block mb-20" href="#">
                                <img class="brand-img"
                                     src="<?= Yii::$app->getAssetManager()->publish('@authweb/dist/img/site-logo.png')[1]; ?>"
                                     alt="brand"/>
                            </a>
                            <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'options' => ['class' => 'form-horizontal form-simple', 'novalidate' => true]]); ?>
                            <h1 class="display-5 mb-30 text-center"><?= Yii::t('backend', 'Please reset your password'); ?></h1>
                            <div class="form-group">
                                <?php echo $form->field($model, 'password')
                                    ->passwordInput(['class' => 'form-control', 'placeholder' => 'Mật khẩu', 'required' => ''])
                                    ->label(false) ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <?php echo $form->field($model, 'confirm_password')
                                        ->passwordInput(['class' => 'form-control', 'placeholder' => 'Xác nhận mật khẩu', 'required' => ''])
                                        ->label(false) ?>
                                    <div class="input-group-append">
                                            <span class="input-group-text"><span class="feather-icon"><i
                                                            data-feather="eye-off"></i></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative text-center">
                                <?= $form->field($model, 'reCaptcha')->widget(
                                    \himiklab\yii2\recaptcha\ReCaptcha2::class,
                                    ['siteKey' => RECAPTCHA_GOOGLE_SITEKEY]
                                )->label(false) ?>
                            </div>
                            <?php echo Html::submitButton('<i class="ft-unlock"></i> ' . Yii::t('backend', \Yii::t('backend', 'Reset password')), [
                                'class' => 'btn btn-success btn-block mb-20',
                                'name' => 'login-button'
                            ]) ?>

                            <p class="text-right"><a
                                        href="#"><?= Yii::t('backend', 'Back to login'); ?></a></p>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Content -->

</div>
<!-- /HK Wrapper -->
