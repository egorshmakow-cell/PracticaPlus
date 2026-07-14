<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%students}}`.
 */
class m260427_043019_create_students_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%students}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'practice_id' => $this->integer(),
            'status' => $this->string()->notNull(),
            'progress' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%students}}');
    }
}
