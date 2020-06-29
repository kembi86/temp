<?php

use yii\db\Migration;

/**
 * Class m200515_073938_create_table_auth
 */
class m200515_073938_create_table_auth extends Migration
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

        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string(255)->notNull(),
            'source_id' => $this->string(255)->notNull(),

        ], $tableOptions);

        $this->addForeignKey('fk_auth_user', 'auth', 'user_id', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_user_token_user', 'user_token', 'user_id', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_user_profile_user', 'user_profile', 'user_id', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_assignment_user', 'rbac_auth_assignment', 'user_id', 'user', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth}}');
    }
}
