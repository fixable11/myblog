<?php

use yii\db\Migration;

/**
 * Class m180812_090337_user_table_add_fields
 */
class m180812_090337_user_table_add_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'last_name', $this->string());
        $this->addColumn('user', 'photo_rec', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'photo_rec');
    }

}
