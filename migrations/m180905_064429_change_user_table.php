<?php

use yii\db\Migration;

/**
 * Class m180905_064429_change_user_table
 */
class m180905_064429_change_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'fb_uid', $this->bigInteger());
        $this->createIndex('fb_uid_unique', 'user', 'fb_uid', true);
        $this->dropIndex('username_unique', 'user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('fb_uid_unique', 'user');
        $this->dropColumn('user', 'fb_uid');
        $this->createIndex('username_unique', 'user', 'username', true);
    }
}
