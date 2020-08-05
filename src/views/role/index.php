<?php

use yii\helpers\ArrayHelper;
use modava\auth\AuthModule;
use modava\auth\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\widgets\ToastrWidget;
use yii\widgets\Pjax;
use modava\auth\models\RbacAuthItem;

/* @var $this yii\web\View */
/* @var $searchModel modava\auth\models\search\RbacAuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = AuthModule::t('auth', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $searchModel->toastr_key . '-index']) ?>
    <div class="container-fluid px-xxl-25 px-xl-10">
        <?= NavbarWidgets::widget(); ?>

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                            class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
            </h4>
            <a class="btn btn-outline-light" href="<?= \yii\helpers\Url::to(['create']); ?>"
               title="<?= AuthModule::t('auth', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= AuthModule::t('auth', 'Create'); ?></a>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">

                    <?php Pjax::begin(); ?>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'layout' => '
                                        {errors}
                                        <div class="row">
                                            <div class="col-sm-12">
                                                {items}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-5">
                                                <div class="dataTables_info" role="status" aria-live="polite">
                                                    {pager}
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-7">
                                                <div class="dataTables_paginate paging_simple_numbers">
                                                    {summary}
                                                </div>
                                            </div>
                                        </div>
                                    ',
                                        'pager' => [
                                            'firstPageLabel' => AuthModule::t('auth', 'First'),
                                            'lastPageLabel' => AuthModule::t('auth', 'Last'),
                                            'prevPageLabel' => AuthModule::t('auth', 'Previous'),
                                            'nextPageLabel' => AuthModule::t('auth', 'Next'),
                                            'maxButtonCount' => 5,

                                            'options' => [
                                                'tag' => 'ul',
                                                'class' => 'pagination',
                                            ],

                                            // Customzing CSS class for pager link
                                            'linkOptions' => ['class' => 'page-link'],
                                            'activePageCssClass' => 'active',
                                            'disabledPageCssClass' => 'disabled page-disabled',
                                            'pageCssClass' => 'page-item',

                                            // Customzing CSS class for navigating link
                                            'prevPageCssClass' => 'paginate_button page-item',
                                            'nextPageCssClass' => 'paginate_button page-item',
                                            'firstPageCssClass' => 'paginate_button page-item',
                                            'lastPageCssClass' => 'paginate_button page-item',
                                        ],
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn',
                                                'headerOptions' => [
                                                    'width' => 60,
                                                    'rowspan' => 2
                                                ],
                                                'filterOptions' => [
                                                    'class' => 'd-none'
                                                ],
                                            ],
                                            [
                                                'attribute' => 'description',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a($model->description, yii\helpers\Url::to(['view', 'id' => $model->name]), ['data-pjax' => 0]);
                                                },
                                                'headerOptions' => [
                                                    'width' => 200,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'name',
                                                'headerOptions' => [
                                                    'width' => 200,
                                                ],
                                            ],
                                            [
                                                'class' => \common\grid\EnumColumn::class,
                                                'attribute' => 'ruleName',
                                                'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
                                                'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('rbac', 'Select Rule')],
                                                'headerOptions' => [
                                                    'width' => 60,
                                                    'rowspan' => 2
                                                ],
                                                'filterOptions' => [
                                                    'class' => 'd-none'
                                                ],
                                            ],
//                                [
//                                    'class' => \common\grid\EnumColumn::class,
//                                    'attribute' => 'type',
//                                    'enum' => RbacAuthItem::getRoleType(),
//                                    'filter' => RbacAuthItem::getRoleType(),
//                                ],
//                                [
//                                    'class' => \common\grid\EnumColumn::class,
//                                    'attribute' => 'rule_name',
//                                    'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
//                                    'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('rbac', 'Select Rule')],
//                                ],

                                        ],
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php Pjax::end(); ?>
                </section>
            </div>
        </div>
    </div>
<?php
$script = <<< JS
$('body').on('click', '.success-delete', function(e){
    e.preventDefault();
    var url = $(this).attr('href') || null;
    if(url !== null){
        $.post(url);
    }
    return false;
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);