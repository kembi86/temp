<?php

use backend\widgets\ToastrWidget;
use modava\auth\AuthModule;
use modava\auth\widgets\NavbarWidgets;
use common\grid\MyGridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

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
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">

                    <?php Pjax::begin(['id' => 'role-pjax', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]); ?>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <?= MyGridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'layout' => '
                                            {errors} 
                                            <div class="pane-single-table">
                                                {items}
                                            </div>
                                            <div class="pager-wrap clearfix">
                                                {summary}' .
                                            Yii::$app->controller->renderPartial('@backend/views/layouts/my-gridview/_pageTo', [
                                                'totalPage' => $totalPage,
                                                'currentPage' => Yii::$app->request->get($dataProvider->getPagination()->pageParam)
                                            ]) .
                                            Yii::$app->controller->renderPartial('@backend/views/layouts/my-gridview/_pageSize') .
                                            '{pager}
                                            </div>
                                        ',
                                        'tableOptions' => [
                                            'id' => 'dataTable',
                                            'class' => 'dt-grid dt-widget pane-hScroll',
                                        ],
                                        'myOptions' => [
                                            'class' => 'dt-grid-content my-content pane-vScroll',
                                            'data-minus' => '{"0":95,"1":".hk-navbar","2":".nav-tabs","3":".hk-pg-header","4":".hk-footer-wrap"}'
                                        ],
                                        'summaryOptions' => [
                                            'class' => 'summary pull-right',
                                        ],
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
                                            'prevPageCssClass' => 'paginate_button page-item prev',
                                            'nextPageCssClass' => 'paginate_button page-item next',
                                            'firstPageCssClass' => 'paginate_button page-item first',
                                            'lastPageCssClass' => 'paginate_button page-item last',
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
                                                'filterInputOptions' => ['class' => 'form-control', 'prompt' => AuthModule::t('auth', 'Select Rule')],
                                                'headerOptions' => [
                                                    'width' => 60,
                                                    'rowspan' => 2
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
//                                    'filterInputOptions' => ['class' => 'form-control', 'prompt' => AuthModule::t('auth', 'Select Rule')],
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
$urlChangePageSize = \yii\helpers\Url::toRoute(['perpage']);
$script = <<< JS
var customPjax = new myGridView();
customPjax.init({
    pjaxId: '#role-pjax',
    urlChangePageSize: '$urlChangePageSize',
});
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