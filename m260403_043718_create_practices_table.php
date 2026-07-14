<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%practice_diary_entries}}`.
 */
class m260422_055732_create_practice_diary_entries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%diary_entries}}', [
            'id' => $this->primaryKey(),
            'practice_id' => $this->integer(),
            'date' => $this->date()->notNull(),
            'content' => $this->text(),
            'achievements' => $this->text(),
            'problems' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-diary_entries-practice_id',
            'diary_entries',
            'practice_id',
            'practices',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%practice_diary_entries}}');
    }
}
