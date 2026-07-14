<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Reports $model */

$this->title = Yii::t('app', 'Создать отчет');
?>

<div>
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center">
            <?= Html::a('Отчёты', ['reports/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Создать отчет
        </li>
    </ol>
</div>
<div class="flex flex-wrap gap-2 mt-4">
    <a href="/web/admin/user" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Пользователи</a>
    <a href="/web/admin/students" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Студенты</a>
    <a href="/web/admin/practices" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Практики</a>
    <a href="/web/admin/groups" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Группы</a>
    <a href="/web/admin/reports" class="bg-blue-500 text-white font-semibold py-2 px-5 rounded-full text-sm">Отчеты</a>
    <a href="/web/admin/supervisors" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Руководители</a>
</div>
<div class="reports-create max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md mt-4">

    <h1 class="text-2xl font-bold mb-4" style="margin-top: 20px"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
