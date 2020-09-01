<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\auth\widgets\NavbarWidgets;
use modava\auth\AuthModule;

/* @var $this yii\web\View */
/* @var $model modava\auth\models\User */

$this->title = $model->userProfile->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
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
            <a class="btn btn-outline-light btn-sm" href="<?= Url::to(['create']); ?>"
               title="<?= Yii::t('backend', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= Yii::t('backend', 'Create'); ?></a>
            <a class="btn btn-success btn-sm" href="<?= Url::to(['/auth/user-metadata/update', 'id' => $model->id]); ?>"
               title="<?= Yii::t('backend', 'Metadata'); ?>">
                <i class="glyphicon glyphicon-cog"></i> <?= Yii::t('backend', 'Metadata'); ?></a>
            <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
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
                        'auth',
                        'access_token',
                        'oauth_client',
                        'oauth_client_user_id',
                        'email',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \modava\auth\models\User::STATUS[$model->status];
                            }
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                        'logged_at:datetime',
                        [
                            'attribute' => 'created_by',
                            'value' => function ($model) {
                                if ($model->userCreated == null) return null;
                                return $model->userCreated->userProfile->fullname;
                            },
                            'label' => Yii::t('backend', 'Created By')
                        ],
                        [
                            'attribute' => 'updated_by',
                            'value' => function ($model) {
                                if ($model->userUpdated == null) return null;
                                return $model->userUpdated->userProfile->fullname;
                            },
                            'label' => Yii::t('backend', 'Updated By')
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
