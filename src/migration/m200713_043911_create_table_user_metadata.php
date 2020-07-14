<?php

use yii\db\Migration;

/**
 * Class m200713_043911_create_table_user_metadata
 */
class m200713_043911_create_table_user_metadata extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* check table exists */
        $check_table = Yii::$app->db->getTableSchema('user_metadata');
        if ($check_table === null) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('user_metadata', [
                'user_id' => $this->primaryKey(),
                'metadata' => $this->json()->null()
            ], $tableOptions);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200713_043911_create_table_user_metadata cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200713_043911_create_table_user_metadata cannot be reverted.\n";

        return false;
    }
    */
}
