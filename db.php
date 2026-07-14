<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report_feedback}}`.
 */
class m260403_050615_create_report_feedback_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report_feedback}}', [
            'id' => $this->primaryKey(),
            'report_id' => $this->integer(),
            'reviewer_id' => $this->integer(),
            'comment' => $this->text(),
            'feedback_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => "ENUM('submitted', 'reviewed', 'approved', 'rejected') DEFAULT 'submitted'",
        ]);

        $this->addForeignKey(
            'fk-report_feedback-report_id',
            'report_feedback',
            'report_id',
            'reports',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-report_feedback-reviewer_id',
            'report_feedback',
            'reviewer_id',
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
        $this->dropTable('{{%report_feedback}}');
    }
}
