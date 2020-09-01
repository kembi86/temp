<?php

use yii\helpers\Url;
use modava\auth\AuthModule;

?>
<ul class="nav nav-tabs nav-sm nav-light mb-10">
    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'user') echo ' active' ?>"
           href="<?= Url::toRoute(['/auth/user']); ?>">
            <i class="ion ion-ios-locate"></i><?= Yii::t('backend', 'User'); ?>
        </a>
    </li>
    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'rbac-auth-item') echo ' active' ?>"
           href="<?= Url::toRoute(['/auth/rbac-auth-item']); ?>">
            <i class="ion ion-ios-locate"></i><?= Yii::t('backend', 'Rbac Auth Item'); ?>
        </a>
    </li>
    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'role') echo ' active' ?>"
           href="<?= Url::toRoute(['/auth/role']); ?>">
            <i class="ion ion-ios-locate"></i><?= Yii::t('backend', 'Role'); ?>
        </a>
    </li>
    <?php if (Yii::$app->controller->id == 'user-metadata') { ?>
        <li class="nav-item mb-5">
            <a class="nav-link link-icon-left active"
               href="<?= Url::toRoute(['/auth/user-metadata']); ?>">
                <i class="ion ion-ios-locate"></i><?= Yii::t('backend', 'User Metadata'); ?>
            </a>
        </li>
    <?php } ?>
</ul>
