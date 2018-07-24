<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180724_122754_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'description'=>$this->text(),
            'content'=>$this->text(),
            'date'=>$this->date(),
            'image'=>$this->string(),
            'viewed'=>$this->integer(),
            'user_id'=>$this->integer(),
            'status'=>$this->integer(),
            'category_id'=>$this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article');
    }
}
