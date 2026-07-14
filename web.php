<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%practice_place}}`.
 */
class m260502_030250_create_practice_place_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%practice_place}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'direction' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%practice_place}}');
    }
}
