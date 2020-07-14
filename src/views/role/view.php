<?php

use yii\widgets\DetailView;
use modava\auth\widgets\NavbarWidgets;
use modava\auth\AuthModule;
use yii\helpers\Url;
use yii\helpers\Html;

\modava\auth\assets\RoleAsset::register($this);
$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User'), 'url' => ['user']];
$this->params['breadcrumbs'][] = ['label' => 'Phân Quyền', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container-fluid px-xxl-25 px-xl-10">
        <?= NavbarWidgets::widget(); ?>

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                            class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
            </h4>
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
                            'description:html',
                            'ruleName',
                            'data',
                        ],
                    ]) ?>
                    <p>
                        <?php
                        if (in_array('loginToBackend', array_keys(Yii::$app->authManager->getPermissionsByRole($model->name)))) {
                            echo '<span style="color:red">' . $model->description . ': có quyền truy cập backend</span>';
                        } else {
                            echo '<span style="color:red">' . $model->description . ': không có quyền truy cập backend</span>';
                        }
                        ?>
                    </p>
                    <hr>
                    <div class="card-dashboard user-permission">
                        <section class="without-filter">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Phân Quyền</h4>
                                        </div>
                                        <?php
                                        $permission = Yii::$app->authManager->getPermissions();
                                        $permission_user = array_keys(Yii::$app->authManager->getPermissionsByRole($model->name));
                                        ?>
                                        <div class="card-content collapse show ">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <select multiple="multiple" size="20" class="duallistbox"
                                                            id="duallistbox"
                                                            data-name="<?php echo $model->name; ?>">
                                                    </select>
                                                </div>
                                                <div style="color: red" id="permission-rerult"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php
$urlPermissionForrole = \yii\helpers\Url::toRoute(['/auth/role/permission-for-role']);
$urlPermissionChange = \yii\helpers\Url::toRoute(['/auth/role/permission-change']);
$script = <<< JS
    var e = document.getElementById('duallistbox');
    var name = e.getAttribute('data-name');
    $.ajax({
        url: '$urlPermissionForrole',
        method: "GET",
        dataType: "json",
        data:{"name": name},
        success: function (data) {
            $.each(data, function (i, val) {
                var opt  = "<option value=\'" + val.name + "\' " + val.selected + ">" + val.description + "</option>";
                $(".duallistbox").append(opt);
            });
            
            $('.duallistbox').bootstrapDualListbox({
                moveOnSelect: false,
                infoTextEmpty: 'Danh sách rỗng',
                infoText: 'Hiện có {0} quyền',
                moveAllLabel: 'Chọn tất cả',
                removeAllLabel: 'Xóa bỏ tất cả',
                filterPlaceHolder: 'Tìm kiếm',
                nonSelectedListLabel: 'Quyền đang có',
                selectedListLabel: 'Quyền đã có',
            });
        }
    });
    $('.duallistbox').on('change', function(e){
        var item = $(this).val(),
            name = $(this).attr("data-name"),
            result = '',
            options = $('#duallistbox').find('option'),
            c = true;
        if(item.length > 0 && item.length == options.length) c = confirm('Bạn muốn cấp toàn bộ quyền cho người dùng?');
        if(c){
            $.ajax({
                url: '$urlPermissionChange',
                method: "POST",
                dataType: "text",
                data:{"name": name, "item":item},
                success: function (data) {
                    if(data == 1) {
                        result = 'Thành công';
                    } else if(data == 0) {
                        result = "Hãy liên hệ ban quản trị";
                    }
                    $('#permission-rerult').html(result);
                }
            });
        } else {
            window.location.reload();
        }
    });
JS;
$this->registerJs($script, \yii\web\View::POS_END);

?>