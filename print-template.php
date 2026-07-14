<?php
use yii\helpers\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

/* @var $diaryEntries app\models\DiaryEntries[] */
/* @var $student app\models\Students */

$this->title = 'Проверка дневника студента';
?>
<div class="mb-4">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 mb-4">
        <li class="inline-flex items-center">
            <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center">
            <?= Html::a('Страница руководителя', ['supervisor/student'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Проверка дневника студента
        </li>
    </ol>
</div>
<div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-2 w-full flex items-center justify-between font-sans">
    <h1 class="text-2xl mb-1 font-bold text-gray-800">
        <?= Html::encode($this->title) ?> (<?= isset($diaryEntries[0]->assignment->student) ? Html::encode($diaryEntries[0]->assignment->student->user->surname . ' ' . $diaryEntries[0]->assignment->student->user->name) : 'Студент не найден' ?>)
    </h1>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full bg-blue-400 rounded-xl overflow-hidden">
        <thead>
        <tr>
            <th class="px-4 py-2 text-left" style="font-weight: 100;">Дата</th>
            <th class="px-4 py-2 text-left" style="font-weight: 100;">Выполненная работа</th>
            <th class="px-4 py-2 text-left" style="font-weight: 100;">Часы</th>
            <th class="px-4 py-2 text-left" style="font-weight: 100;">Комментарий</th>
            <th class="px-4 py-2 text-left" style="font-weight: 100;">Оценка</th>
            <th class="px-4 py-2 text-left" style="font-weight: 100;">Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($diaryEntries as $entry): ?>
            <tr class="odd:bg-white even:bg-blue-100">
                <td class="border-gray-200 px-4 py-3"><?= Yii::$app->formatter->asDate($entry->date, 'php:d.m.Y') ?></td>
                <td class="border-gray-200 px-4 py-3"><?= htmlspecialchars($entry->content) ?></td>
                <td class="border-gray-200 px-4 py-3"><?= $entry->hours ?> ч.</td>
                <td class="border-gray-200 px-4 py-3"><?= $entry->supervisor_comment ?></td>
                <td class="border-gray-200 px-4 py-3">
                    <?php if ($entry->is_locked): ?>
                        <!-- Плашка Проверено (Зеленая) -->
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                Оценка: <?= $entry->grade ?>
                            </span>
                    <?php else: ?>
                        <!-- Плашка На проверке (Желтая) -->
                        <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                Требует проверки
                            </span>
                    <?php endif; ?>
                </td>
                <td class="border-gray-200 px-4 py-3">
                    <div class="flex flex-col md:flex-row md:space-x-2 space-y-2 md:space-y-0">
                        <?php if (!$entry->is_locked): ?>
                            <?= Html::a('Оценить', ['diary/evaluate', 'id' => $entry->id], [
                                'class' => 'bg-green-500 hover:bg-green-300 text-white py-1 px-3 rounded-xl w-full md:w-auto',
                            ]) ?>
                        <?php else: ?>
                            <span class="text-sm text-gray-400 w-full md:w-auto">Заблокировано</span>
                        <?php endif; ?>
                        <?= Html::a('Завершить практику', ['student-assignments/download-certificate', 'id' => $entry->id], [
                            'class' => 'bg-blue-500 hover:bg-blue-300 text-white py-1 px-3 rounded-xl w-full md:w-auto',
                        ]) ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
