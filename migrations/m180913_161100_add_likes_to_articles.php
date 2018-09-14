<?php

use yii\db\Migration;

/**
 * Class m180913_161100_add_likes_to_articles
 */
class m180913_161100_add_likes_to_articles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('article', 'like_up', $this->integer()->defaultValue(0));
      $this->addColumn('article', 'like_down', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('article', 'like_up');
      $this->dropColumn('article', 'like_down');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180913_161100_add_likes_to_articles cannot be reverted.\n";

        return false;
    }
    */
}
