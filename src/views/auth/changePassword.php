<?php
/**
 * Created by PhpStorm.
 * User: luken
 * Date: 10/23/2020
 * Time: 14:35
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = $this->title;

$role = array_key_exists($roleUser, $roleName) ? $roleName[$roleUser]->description : '';
$cover = $userInfo->cover != '' ? $userInfo->cover : Yii::$app->assetManager->publish('@modava-assets/dist/img/trans-bg.jpg')[1];
$avatar = $userInfo->avatar != '' ? $userInfo->avatar : Yii::$app->assetManager->publish('@modava-assets/dist/img/avatar12.jpg')[1];
?>

<?= \backend\widgets\ToastrWidget::widget(['key' => 'toastr-change-password']) ?>

<div class="container-fluid px-xxl-25 px-xl-10">
    <div class="profile-cover-wrap overlay-wrap">
        <div class="profile-cover-img"
             style="background-image:url('<?= $cover; ?>')"></div>
        <div class="bg-overlay bg-trans-dark-60"></div>
        <div class="container-fluid px-xxl-65 px-xl-20 profile-cover-content py-50">
            <div class="row">
                <div class="col-lg-6">
                    <div class="media align-items-center">
                        <div class="media-img-wrap  d-flex">
                            <div class="avatar">
                                <img src="<?= $avatar; ?>"
                                     alt="user" class="avatar-img rounded-circle">
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="text-white text-capitalize display-6 mb-5 font-weight-400"><?= $userInfo->fullname ?></div>
                            <div class="font-14 text-white"><span class="mr-5"><span
                                        class="font-weight-500 pr-5"><?= $role; ?></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="button-list">
                        <a href="#" class="btn btn-dark btn-wth-icon icon-wthot-bg btn-rounded"><span class="btn-text">Message</span><span
                                class="icon-label"><i class="icon ion-md-mail"></i> </span></a>
                        <a href="#" class="btn btn-icon btn-icon-circle btn-indigo btn-icon-style-2"><span
                                class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                        <a href="#" class="btn btn-icon btn-icon-circle btn-sky btn-icon-style-2"><span
                                class="btn-icon-wrap"><i class="fa fa-twitter"></i></span></a>
                        <a href="#" class="btn btn-icon btn-icon-circle btn-purple btn-icon-style-2"><span
                                class="btn-icon-wrap"><i class="fa fa-instagram"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row -->
    <div class="row mt-30">
        <div class="col-xl-8">
            <div class="card card-profile-feed">
                <div class="card-header card-header-action">
                    <h4><i class="icon-user"></i> </h4>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'form-change-pass']); ?>
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'old_password')->passwordInput() ?>
                        </div>
                        <div class="col-12">
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        </div>
                        <div class="col-12">
                            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
                        </div>
                    </div>
                    <?= \yii\helpers\Html::button('Save', ['type' => 'submit', 'class' => 'btn btn-success btn-sm']) ?>
                    <?= \yii\helpers\Html::button('Cancel', ['type' => 'reset', 'class' => 'btn btn-warning btn-sm']) ?>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card card-profile-feed rounded-6 mb-0 overflow-hidden">
                <div class="card-header card-header-action">
                    <div class="media align-items-center">
                        <div class="media-img-wrap d-flex mr-10">
                            <div class="avatar avatar-sm">
                                <img src="<?= $avatar; ?>"
                                     alt="user" class="avatar-img rounded-circle">
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="text-capitalize font-weight-500 text-dark"><?= $userInfo->fullname ?></div>
                            <div class="font-13"><?= $role; ?></div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item mt-0 pb-0"><a href="<?= Url::toRoute(['/auth/auth/profile']) ?>">Thông tin người dùng</a></li>
                        <li class="list-group-item mt-0 pb-0"><a href="<?= Url::toRoute(['/auth/auth/change-password']) ?>">Thay
                                đổi mật khẩu</a></li>
                        <li class="list-group-item mt-0"><a href="#">Cài đặt tài khoản</a></li>
                    </ul>
                </div>
            </div>
            <div class="card bg-blue-dark-3 text-white rounded-6 border-0 p-3 mt-20 mb-0">
                Bạn luôn có thể thay đổi thông tin cá nhân của bạn và bạn chịu trách nhiệm về thông tin của bạn với nhà
                quản lý.
            </div>
        </div>
    </div>
</div>