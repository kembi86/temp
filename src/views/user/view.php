<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\auth\widgets\NavbarWidgets;
use modava\auth\AuthModule;

/* @var $this yii\web\View */
/* @var $model modava\auth\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => AuthModule::t('auth', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-view']) ?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <p>
            <a class="btn btn-outline-light" href="<?= Url::to(['create']); ?>"
                title="<?= AuthModule::t('auth', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= AuthModule::t('auth', 'Create'); ?></a>
            <?= Html::a(AuthModule::t('auth', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(AuthModule::t('auth', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => AuthModule::t('auth', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
						'id',
						'username',
						'auth_key',
						'password_hash',
						'oauth_client',
						'oauth_client_user_id',
						'password_reset_token',
						'email:email',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return Yii::$app->getModule('auth')->params['status'][$model->status];
                            }
                        ],
						'created_at',
						'updated_at',
						'logged_at',
						'verification_token',
                        [
                            'attribute' => 'userCreated.userProfile.fullname',
                            'label' => AuthModule::t('auth', 'Created By')
                        ],
                        [
                            'attribute' => 'userUpdated.userProfile.fullname',
                            'label' => AuthModule::t('auth', 'Updated By')
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
