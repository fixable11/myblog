<?php

use yii\db\Migration;

/**
 * Class m180818_152806_expand_user_table
 */
class m180818_152806_expand_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('user', 'auth_key', 'string(32)');
       $this->addColumn('user', 'password_reset_token', 'string');
       $this->createIndex('password_token_unique', 'user', 'password_reset_token', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('password_token_unique', 'user');
        $this->dropColumn('user', 'auth_key');
        $this->dropColumn('user', 'password_reset_token');
        
    }

}
