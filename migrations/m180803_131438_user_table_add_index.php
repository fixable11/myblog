<?php

use yii\db\Migration;

/**
 * Class m180803_131438_user_table_add_index
 */
class m180803_131438_user_table_add_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('username_unique', 'user', 'username', true);
        $this->createIndex('email_unique', 'user', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('username_unique', 'user');
        $this->dropIndex('email_unique', 'user');
    }

}
