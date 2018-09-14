<?php

use yii\db\Migration;

/**
 * Handles the creation of table `likes`.
 */
class m180913_171049_create_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function safeUp()
    {
        $this->createTable('likes', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'user_id' => $this->integer(),
            'liked' => $this->boolean(),
            'disliked' => $this->boolean(),
        ]);
        
        $this->addForeignKey(
          'fk-likes-article',
          'likes',
          'article_id',
          'article',
          'id',
          'CASCADE'
        );
        
        $this->addForeignKey(
          'fk-likes-user',
          'likes',
          'user_id',
          'user',
          'id',
          'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('fk-likes-article', 'likes');
      $this->dropForeignKey('fk-likes-user', 'likes');
      $this->dropTable('likes');
    }
}
