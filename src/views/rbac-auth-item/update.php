<?php

use modava\auth\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\helpers\Url;
use modava\auth\AuthModule;

/* @var $this yii\web\View */
/* @var $model modava\auth\models\RbacAuthItem */

$this->title = AuthModule::t('auth', 'Update : {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => AuthModule::t('auth', 'Rbac Auth Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = AuthModule::t('auth', 'Update');
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <a class="btn btn-outline-light" href="<?= Url::to(['create']); ?>"
           title="<?= AuthModule::t('auth', 'Create'); ?>">
            <i class="fa fa-plus"></i> <?= AuthModule::t('auth', 'Create'); ?></a>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </section>
        </div>
    </div>
</div>
