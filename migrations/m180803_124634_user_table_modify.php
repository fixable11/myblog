<?php

use yii\db\Migration;

/**
 * Class m180803_124634_user_table_modify
 */
class m180803_124634_user_table_modify extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user', 'name', 'username');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user', 'username', 'name');
    }

}
