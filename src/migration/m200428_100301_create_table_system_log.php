<?php

use yii\db\Migration;

/**
 * Class m200428_100301_create_table_system_log
 */
class m200428_100301_create_table_system_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%system_log}}', [
            'id' => $this->bigPrimaryKey(20),
            'level' => $this->integer(11)->null(),
            'category' => $this->string(255)->null(),
            'log_time' => $this->double()->null(),
            'prefix' => $this->text()->null(),
            'message' => $this->text()->null(),
        ], $tableOptions);

        $this->createIndex('idx_log_level', 'system_log', ['level']);
        $this->createIndex('dx_log_category', 'system_log', ['category']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%system_log}}');
    }

}
