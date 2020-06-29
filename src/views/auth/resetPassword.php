<?php

$this->title = \modava\auth\AuthModule::t('auth', 'Reset password');
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
                            <form>
                                <h1 class="display-5 mb-30 text-center"><?= \modava\auth\AuthModule::t('auth', 'Please reset your password'); ?></h1>
                                <div class="form-group">
                                    <input class="form-control"
                                           placeholder="<?= \modava\auth\AuthModule::t('auth', 'New password'); ?>"
                                           type="password">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control"
                                               placeholder="<?= \modava\auth\AuthModule::t('auth', 'Re-enter new password'); ?>"
                                               type="password">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><span class="feather-icon"><i
                                                            data-feather="eye-off"></i></span></span>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block mb-20"
                                        type="submit"><?= \modava\auth\AuthModule::t('auth', 'Reset password'); ?></button>
                                <p class="text-right"><a
                                            href="#"><?= \modava\auth\AuthModule::t('auth', 'Back to login'); ?></a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Content -->

</div>
<!-- /HK Wrapper -->
