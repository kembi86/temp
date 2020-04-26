<?php

use yii\helpers\Html;
use yii\helpers\Url;

$a = \modava\auth\assets\AuthAsset::register($this);

$this->title = 'Login';

?>
<div class="hk-wrapper">

    <!-- Main Content -->
    <div class="hk-pg-wrapper hk-auth-wrapper">
        <header class="d-flex justify-content-between align-items-center">
            <a class="d-flex auth-brand" href="#">
                <img class="brand-img" src="<?= Url::to($this->assetManager->publish('@authweb/dist/img/site-logo.png')[1]); ?>" alt="brand"/>
            </a>

        </header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 pa-0">
                    <div id="owl_demo_1" class="owl-carousel dots-on-item owl-theme">
                        <div class="fadeOut item auth-cover-img overlay-wrap"
                             style="background-image:url(<?= Url::to($this->assetManager->publish('@authweb/dist/img/bg2.png')[1]); ?>);">
                            <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                    <h1 class="display-3 text-white mb-20">Thất bại và thành công?</h1>
                                    <p class="text-white">Sự khác biệt giữa những người thành công và những người thất bại ko phải là ở sức mạnh, kiến thức hay sự hiểu biết – mà chính là ở ý chí.</p>
                                </div>
                            </div>
                            <div class="bg-overlay bg-trans-dark-50"></div>
                        </div>
                        <div class="fadeOut item auth-cover-img overlay-wrap"
                             style="background-image:url(<?= Url::to($this->assetManager->publish('@authweb/dist/img/bg1.png')[1]); ?>);">
                            <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                    <h1 class="display-3 text-white mb-20">Chiến thắng?</h1>
                                    <p class="text-white">Trong cuộc sống, nơi nào có một người chiến thắng, nơi đó có một người thua cuộc. Nhưng người biết hi sinh vì người khác luôn luôn là người chiến thắng</p>
                                </div>
                            </div>
                            <div class="bg-overlay bg-trans-dark-50"></div>
                        </div>
                        <div class="fadeOut item auth-cover-img overlay-wrap"
                             style="background-image:url(<?= Url::to($this->assetManager->publish('@authweb/dist/img/bg3.png')[1]); ?>);">
                            <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                    <h1 class="display-3 text-white mb-20">Nỗ lực và buông xuôi?</h1>
                                    <p class="text-white">
                                        Đôi khi, trong cuộc sống, có những thời điểm mà tất cả mọi thứ đều dường như chống lại bạn, đến nỗi bạn có cảm tưởng mình ko thể chịu đựng thêm một phút nào nữa. Nhưng hãy cố đừng buông xuôi và bỏ cuộc, vì sớm muộn gì mọi thứ rồi cũng sẽ thay đổi
                                    </p>
                                </div>
                            </div>
                            <div class="bg-overlay bg-trans-dark-50"></div>
                        </div>
                        <div class="fadeOut item auth-cover-img overlay-wrap"
                             style="background-image:url(<?= Url::to($this->assetManager->publish('@authweb/dist/img/bg4.png')[1]); ?>);">
                            <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                    <h1 class="display-3 text-white mb-20">Kiến thức?</h1>
                                    <p class="text-white">Tất cả những gì tốt đẹp trong tôi, tôi đều chịu ơn sách. Khi nói đến sách, tôi không thể nào không cảm thấy mối cảm động sâu sắc và niềm vui mừng phấn khởi</p>
                                </div>
                            </div>
                            <div class="bg-overlay bg-trans-dark-50"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 pa-0">
                    <div class="auth-form-wrap py-xl-0 py-50">
                        <div class="auth-form w-xxl-65 w-xl-75 w-sm-90 w-100 card pa-25 shadow-lg">
                            <form>
                                <h1 class="display-4 mb-10"><?=\modava\auth\Auth::t('login', 'Welcome Back'); ?> :)</h1>
                                <p class="mb-30"><?=\modava\auth\Auth::t('login', 'Sign in to your account and enjoy unlimited perks'); ?></p>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" type="email">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="<?=\modava\auth\Auth::t('login', 'Password'); ?>" type="password">
                                        <div class="input-group-append">
                                                <span class="input-group-text"><span class="feather-icon"><i
                                                                data-feather="eye-off"></i></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox mb-25">
                                    <input class="custom-control-input" id="same-address" type="checkbox" checked>
                                    <label class="custom-control-label font-14" for="same-address">
                                        <?=\modava\auth\Auth::t('login', 'Keep me logged in'); ?></label>
                                </div>
                                <button class="btn btn-success btn-block" type="submit">Login</button>
                                <p class="font-14 text-center mt-15"><?=\modava\auth\Auth::t('login', 'Having trouble logging in'); ?>?</p>
                                <div class="option-sep"><?=\modava\auth\Auth::t('login', 'or'); ?></div>
                                <div class="form-row">
                                    <div class="col-sm-6 mb-20">
                                        <button class="btn btn-indigo btn-block btn-wth-icon"><span
                                                    class="icon-label"><i class="fa fa-facebook"></i> </span><span
                                                    class="btn-text"><?=\modava\auth\Auth::t('login', 'Login with facebook'); ?></span></button>
                                    </div>
                                    <div class="col-sm-6 mb-20">
                                        <button class="btn btn-primary btn-block btn-wth-icon"><span
                                                    class="icon-label"><i class="fa fa-twitter"></i> </span><span
                                                    class="btn-text"><?=\modava\auth\Auth::t('login', 'Login with Twitter'); ?></span></button>
                                    </div>
                                </div>
                                <p class="text-center"><?=\modava\auth\Auth::t('login', 'Do have an account yet'); ?>? <a href="#"><?=\modava\auth\Auth::t('login', 'Sign Up'); ?></a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Content -->

</div>
