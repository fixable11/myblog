<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180724_122857_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'text'=>$this->string(),
            'user_id'=>$this->integer(),
            'article_id'=>$this->integer(),
            'status'=>$this->integer()
        ], $tableOptions);
        
        $this->createIndex(
            'idx-user_id',
            'comment',
            'user_id'
        );

        $this->addForeignKey(
            'fk-comment-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-article_id',
            'comment',
            'article_id'
        );

        $this->addForeignKey(
            'fk-comment-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {  
        $this->dropForeignKey('fk-comment-user_id', 'comment');
        $this->dropForeignKey('fk-comment-article_id', 'comment');
        $this->dropIndex('idx-user_id', 'comment');
        $this->dropIndex('idx-article_id', 'comment');  
        $this->dropTable('comment');
    }
}
