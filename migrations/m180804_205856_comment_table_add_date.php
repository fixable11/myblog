<?php

use yii\db\Migration;

/**
 * Class m180804_205856_comment_table_add_date
 */
class m180804_205856_comment_table_add_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment', 'date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('comment', 'date');
    }

}
