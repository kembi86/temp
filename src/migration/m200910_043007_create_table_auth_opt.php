<?php

use yii\db\Migration;

/**
 * Class m200910_043007_create_table_auth_opt
 */
class m200910_043007_create_table_auth_opt extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_table = Yii::$app->db->getTableSchema('user_otp');
        if ($check_table === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('user_otp', [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(11)->notNull(),
                'otp' => $this->string(10)->notNull()->comment('Mã otp gửi cho khách hàng'),
                'time_expired' => $this->integer(11),
                'status' => $this->smallInteger()->defaultValue(0)->comment('Đã sử dụng hay chưa sử dụng'),
                'created_at' => $this->integer(11),
            ], $tableOptions);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_otp}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200910_043007_create_table_auth_opt cannot be reverted.\n";

        return false;
    }
    */
}
