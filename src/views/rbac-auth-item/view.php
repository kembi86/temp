<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\auth\widgets\NavbarWidgets;
use modava\auth\AuthModule;

/* @var $this yii\web\View */
/* @var $model modava\auth\models\RbacAuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => AuthModule::t('auth', 'Rbac Auth Items'), 'url' => ['index']];
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
            <?= Html::a(AuthModule::t('auth', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(AuthModule::t('auth', 'Delete'), ['delete', 'id' => $model->name], [
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
                        'name',
                        [
                            'attribute' => 'type',
                            'value' => function ($model) {
                                return \modava\auth\models\RbacAuthItem::TYPE[$model->type];
                            }
                        ],
                        'description:ntext',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
