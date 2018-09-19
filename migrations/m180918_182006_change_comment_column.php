<?php

use yii\db\Migration;

/**
 * Class m180918_182006_change_comment_column
 */
class m180918_182006_change_comment_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->alterColumn('comment', 'date', 'datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('comment', 'date', 'date');
    }

}
