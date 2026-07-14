<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reports}}`.
 */
class m260403_045242_create_reports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reports}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(),
            'practice_id' => $this->integer(),
            'report_title' => $this->string()->notNull(),
            'submission_date' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => "ENUM('submitted', 'reviewed', 'approved', 'rejected') DEFAULT 'submitted'",
            'document_path' => $this->string()->notNull(),
            'comments' => $this->text(),
            'grade' => $this->decimal(3,1),
            'reviewed_by' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-reports-student_id',
            'reports',
            'student_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-reports-practice_id',
            'reports',
            'practice_id',
            'practices',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-reports-reviewed_by',
            'reports',
            'reviewed_by',
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
        $this->dropTable('{{%reports}}');
    }
}
