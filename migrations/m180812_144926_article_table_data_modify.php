<?php

use yii\db\Migration;

/**
 * Class m180812_144926_article_table_data_modify
 */
class m180812_144926_article_table_data_modify extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->alterColumn('article', 'date', 'datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('article', 'date', 'date');
    }

}
