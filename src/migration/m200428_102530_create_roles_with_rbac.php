<?php

use yii\db\Migration;

/**
 * Class m200428_102530_create_roles_with_rbac
 */
class m200428_102530_create_roles_with_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('rbac_auth_item', [
            'name' => 'develop',
            'type' => 1,
            'description' => 'Lập trình viên',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('rbac_auth_item', [
            'name' => 'loginToBackend',
            'type' => 2,
            'description' => 'Đăng nhập quản trị',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('rbac_auth_item', [
            'name' => 'debug',
            'type' => 2,
            'description' => 'Tool debug',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('rbac_auth_item_child', [
            'parent' => 'develop',
            'child' => 'loginToBackend',
        ]);
        $this->insert('rbac_auth_assignment', [
            'item_name' => 'develop',
            'user_id' => 1,
            'created_at' => time(),
        ]);
        $this->insert('rbac_auth_item_child', [
            'parent' => 'develop',
            'child' => 'debug',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
