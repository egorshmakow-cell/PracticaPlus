<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%practice_progress}}`.
 */
class m260430_145113_create_practice_progress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%practice_progress}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(),
            'practice_id' => $this->integer(),
            'current_task' => $this->string(255),
            'deadline' => $this->date(),
            'status' => $this->string(50)->notNull(),
            'last_update' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'comments' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-practice_progress-student',
            'practice_progress',
            'student_id',
            'students',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-practice_progress-practice',
            'practice_progress',
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
        $this->dropTable('{{%practice_progress}}');
    }
}
