<?php

use yii\db\Migration;

/**
 * Class m200428_061830_create_table_user_profile
 */
class m200428_061830_create_table_user_profile extends Migration
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

        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'fullname' => $this->string(255)->notNull(),
            'birthday' => $this->string(12)->null(),
            'about' => $this->text()->null(),
            'address' => $this->string(255)->null(),
            'phone' => $this->string(25)->notNull()->unique(),
            'facebook' => $this->string(255)->null(),
            'avatar' => $this->string(255)->null(),
            'cover' => $this->string(255)->null(),
            'locale' => $this->string(32)->notNull()->defaultValue('vi'),
            'gender' => $this->smallInteger(6)->null(),


        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
    }

}
