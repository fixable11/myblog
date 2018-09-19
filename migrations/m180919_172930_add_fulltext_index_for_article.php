<?php

use yii\db\Migration;

/**
 * Class m180919_172930_add_fulltext_index_for_article
 */
class m180919_172930_add_fulltext_index_for_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->execute('ALTER TABLE article ADD FULLTEXT INDEX idx_title (title, description, content)');
      //$this->execute('ALTER TABLE article ADD FULLTEXT INDEX idx_description (description)');
      //$this->execute('ALTER TABLE article ADD FULLTEXT INDEX idx_content (content)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropIndex('idx_title', 'article');
      //$this->dropIndex('idx_description', 'article');
      //$this->dropIndex('idx_content', 'article');
    }

}
