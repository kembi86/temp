<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('backend', 'Request password reset');
$css = <<< CSS
.brand-img{max-height: 120px;}
CSS;
$this->registerCss($css);
?>
    <div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper" style="min-height: 947px;">
            <?php echo \backend\widgets\ToastrWidget::widget(['key' => 'toastr-request-password-reset']); ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 pa-0">
                        <div class="auth-form-wrap pt-xl-0 pt-70">
                            <div class="auth-form w-xl-30 w-lg-65 w-sm-85 w-100 card pa-25 shadow-lg">
                                <a class="auth-brand text-center d-block mb-20" href="#">
                                    <img class="brand-img"
                                         src="<?= Url::to($this->assetManager->publish('@authweb/dist/img/site-logo.png')[1]); ?>"
                                         alt="brand"/>
                                </a>
                                <?php $form = ActiveForm::begin([
                                    'id' => 'request-password-reset-form',
                                    'options' => [
                                        'class' => "form-horizontal",
                                        'novalidate' => true,
                                        'redirect-on-submit' => Url::toRoute(['/auth/login']),
                                    ]
                                ]); ?>
                                <form>
                                    <h1 class="display-5 mb-10 text-center">Need help with your Password?</h1>
                                    <p class="mb-30 text-center">Chúng tôi sẽ gửi mã mới đến <a href="#">email khôi
                                            phục</a> của bạn để đặt lại mật khẩu của bạn.</p>

                                    <div class="form-group">
                                        <?php echo $form->field($model, 'email', ['options' => ['tag' => false]])->textInput(['class' => 'form-control', 'placeholder' => \Yii::t('backend', 'E-mail')])->label(false); ?>
                                    </div>
                                    <div class="position-relative text-center">
                                        <?= $form->field($model, 'reCaptcha')->widget(
                                            \himiklab\yii2\recaptcha\ReCaptcha2::class,
                                            ['siteKey' => RECAPTCHA_GOOGLE_SITEKEY]
                                        )->label(false) ?>
                                    </div>
                                    <?php echo Html::submitButton('<i class="ft-unlock"></i> ' . \Yii::t('backend', 'Khôi phục mật khẩu'), ['class' => 'btn btn-success btn-block mb-2']) ?>
                                    <p class="text-right"><a href="<?= Url::toRoute('login') ?>">Đăng nhập</a></p>
                                </form>
                                <?php ActiveForm::end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->

    </div>

<?php
$script = <<< JS
$('body').on('submit', 'form#request-password-reset-form', function (e) {
    e.preventDefault();
    
    $('.auth-form').myLoading({
        msg: 'Loading...',
        opacity: true,
        size: 'sm'
    });
    
    let action = $('#request-password-reset-form').attr('action'),
        form_data = new FormData($('#request-password-reset-form')[0]);
    
    $.ajax({
        type: 'POST',
        url: action,
        dataType: 'json',
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (res) {
        // console.log('reset password res', res);
        if (res.code === 200) {
            grecaptcha.reset();
            var redirect_on_submit = $('#request-password-reset-form').attr('redirect-on-submit') || window.location.href;
            setTimeout(function () {
                window.location.href = redirect_on_submit;
            }, 2000);
        } else {
            grecaptcha.reset();
            $('.reset-content').myUnloading();
        }
    }).fail(function (err) {
        grecaptcha.reset();
        $('.reset-content').myUnloading();
        console.log('reset failed', err);
    });
    
    return false;
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);
