<?php

use yii\db\Migration;

/**
 * Class m200428_071830_create_table_auth_profile
 */
class m200428_071830_insert_account_login extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'id' => '1',
            'username' => 'admin',
            'auth_key' => 'A8DUoLxLHFdxvVzVOdS4OrvzY8xjk97s',
            'password_hash' => '$2y$13$86/bGSUBrrWjvLBQWMO62.aJT2TxRCVErW7mIbYFG5VQnQ4D2zskK',
            'email' => 'mongdaovan86.wd@gmail.com',
            'status' => '10',
            'created_at' => time(),
            'updated_at' => time(),
            'verification_token' => '-vEWls76poYIP-ZknXwaR4l_6TF5n9cF_1588060274',
        ]);
        $this->insert('user_profile', [
            'user_id' => '1',
            'fullname' => 'Đào Văn Mong',
            'bithday' => '12/08/1986',
            'address' => '466 Cao Thắng, P.12, Q.10, HCM',
            'phone' => '0906904884',
            'gender' => '1',
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
