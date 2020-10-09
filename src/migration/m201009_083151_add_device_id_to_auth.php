<?php

use yii\db\Migration;

/**
 * Class m201009_083151_add_device_id_to_auth
 */
class m201009_083151_add_device_id_to_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'device', $this->string()->defaultValue(null)->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'device');
    }
}
