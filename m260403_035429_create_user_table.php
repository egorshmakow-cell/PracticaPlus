<?php

use yii\db\Migration;

/**
 * Class m260501_101537_init_rbac
 */
class m260501_101537_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Создание таблиц через встроенные миграции Yii
        $auth->removeAll();

        // Создаем таблицы RBAC
        $auth->init();
        // Или вставляем вызов migrate из yii/rbac/migrations
        // Но проще запустить встроенную миграцию командой
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260501_101537_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
