<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $entries app\models\DiaryEntries[] */

$this->title = 'Дневник практики';
$totalHours = 0;

if (!empty($entries)) {
    foreach ($entries as $entry) {
        $totalHours += (int)$entry->hours;
    }
    $hasGrade = !empty($entries[0]->grade);
} else {
    $hasGrade = false;
}

$currentUser = Yii::$app->user->identity;
?>
<div class="container max-w-7xl mx-auto px-4 pt-0 pb-4 flex flex-col min-h-screen">
    <!-- Кнопка Назад -->
    <div>
        <ol class="inline-flex items-center space-x-1 md:space-x-2 mb-4">
            <li class="inline-flex items-center">
                <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
                <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
                </svg>
            </li>
            <li class="inline-flex items-center">
                <?= Html::a('Мои практики', ['site/practice'], ['class' => 'text-black hover:text-gray-500']) ?>
                <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
                </svg>
            </li>
            <li class="inline-flex items-center text-black" aria-current="page">
                Журнал практики
            </li>
        </ol>
    </div>

    <!-- Заголовок и блок прогресса -->
    <div class="flex flex-col mb-6 space-y-4">
        <div class="bg-white rounded-xl shadow border border-gray-100 p-6 w-full font-sans">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold text-gray-800 break-words">
                Журнал практики (<?= $currentUser ? Html::encode($currentUser->name . ' ' . $currentUser->surname) : 'Студент не найден' ?>)
            </h1>
        </div>
        
        <!-- Кнопки управления -->
        <div class="flex flex-wrap gap-3 print-hide">
            <?= Html::a('Добавить новую запись', ['create'], [
                'class' => 'bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white font-medium py-2 px-5 rounded-xl text-center shadow-sm transition-colors text-sm min-w-[180px] flex-1 sm:flex-none', 
            ]) ?>
            <?= Html::a('Печать журнала', ['print-template', 'assignment_id' => Yii::$app->user->id], [
                'target' => '_blank',
                'class' => 'bg-green-500 hover:bg-green-600 active:bg-green-700 text-white font-medium py-2 px-5 rounded-xl text-center shadow-sm transition-colors text-sm min-w-[180px] flex-1 sm:flex-none', 
            ]) ?>
        </div>

        <!-- Индикатор прогресса количества часов -->
        <div class="w-full max-w-md bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <h2 class="text-base font-semibold text-gray-700">Общее количество часов: <span class="text-blue-600"><?= $totalHours ?> ч.</span></h2>
            <?php
            $goalHours = 100; 
            $progressPercent = $goalHours > 0 ? ($totalHours / $goalHours) * 100 : 0;
            $progressPercent = min($progressPercent, 100);
            ?>
            <div class="w-full bg-gray-200 rounded-full h-3 mt-2 shadow-inner">
                <div class="bg-green-500 h-3 rounded-full transition-all duration-500" style="width: <?= $progressPercent ?>%;"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1 font-medium">Прогресс: <?= round($progressPercent, 1) ?>% (Цель: <?= $goalHours ?> ч.)</p>
        </div>
    </div>

    <!-- Адаптивная таблица дневника -->
    <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-200 w-full bg-white">
        <!-- Изменено на table-fixed, убрана жесткая заливка bg-blue-400 с самой таблицы -->
        <table class="min-w-full border-collapse table-fixed text-xs">
            <thead class="text-white bg-blue-600 uppercase tracking-wider text-[11px]">
            <tr>
                <!-- Распределяем ширину колонок в процентах (в сумме 100%) -->
                <th class="px-4 py-4 text-center font-semibold w-[12%]">Дата</th>
                <th class="px-4 py-4 text-left font-semibold w-[35%]">Отчёт по практике</th>
                <th class="px-4 py-4 text-center font-semibold w-[13%]">Кол-во часов</th>
                <th class="px-4 py-4 text-left font-semibold w-[20%]">Замечание руководителя</th>
                <th class="px-4 py-4 text-center font-semibold w-[10%]">Оценка</th>
                <th class="px-4 py-4 text-center font-semibold action-column w-[10%] print-hide">Действие</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            <?php foreach ($entries as $entry): ?>
            <tr class="odd:bg-white even:bg-slate-50 hover:bg-blue-50/50 transition-colors">
                <!-- 1. Дата -->
                <td class="px-4 py-3 text-center text-gray-700 font-medium whitespace-nowrap align-middle">
                    <?= Yii::$app->formatter->asDate($entry->date, 'php:d.m.Y') ?>
                </td>
                
                <!-- 2. Содержимое отчета (разрешен перенос строк, выравнивание по левому краю) -->
                <td class="px-4 py-3 text-left text-gray-600 font-normal align-middle break-words">
                    <?= Html::encode($entry->content) ?>
                </td>
                
                <!-- 3. Количество часов -->
                <td class="px-4 py-3 text-center font-semibold text-gray-700 align-middle whitespace-nowrap">
                    <?= Html::encode($entry->hours) ?> ч.
                </td>
                
                <!-- 4. Замечание (разрешен перенос строк, выравнивание по левому краю) -->
                <td class="px-4 py-3 text-left font-normal align-middle break-words">
                    <?php if (!empty($entry->supervisor_comment)): ?>
                        <span class="text-gray-600"><?= Html::encode($entry->supervisor_comment) ?></span>
                    <?php else: ?>
                        <span class="text-gray-400 italic">Нет замечаний</span>
                    <?php endif; ?>
                </td>
                
                <!-- 5. Оценка -->
                <td class="px-4 py-3 text-center align-middle whitespace-nowrap">
                    <?php if (!empty($entry->grade)): ?>
                        <span class="font-bold text-green-600 bg-green-50 px-2 py-1 rounded-md border border-green-200 inline-block min-w-[32px] text-center">
                            <?= Html::encode($entry->grade) ?>
                        </span>
                    <?php else: ?>
                        <span class="text-gray-400 italic">Нет</span>
                    <?php endif; ?>
                </td>
                
                <!-- 6. Действия -->
                <td class="px-4 py-3 text-center align-middle whitespace-nowrap print-hide action-column">
                    <div class="flex items-center justify-center">
                        <?php if (!$hasGrade): ?>
                            <?= Html::a('Редактировать', ['update', 'id' => $entry->id], [
                                'class' => 'bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-3 rounded-lg text-center text-xs transition-colors shadow-sm inline-block',
                            ]) ?>
                        <?php else: ?>
                            <span class="text-xs text-gray-400 italic">Заблокировано</span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>