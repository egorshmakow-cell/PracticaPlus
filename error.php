<?php
/** @var $practice app\models\Practices */
/** @var $currentReport app\models\Reports */
/** @var $reports app\models\Reports[] */
/** @var $feedbacks app\models\ReportFeedback[] */

use yii\helpers\Html;

$this->title = 'Прогресс практики';
$statusLabels = [
    'submitted' => 'Заполнено',
    'reviewed'  => 'На рассмотрении',
    'approved'  => 'Одобрено',
    'rejected'  => 'Отклонено',
];
?>
<div>
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <?= Html::a('Мои практики', ['site/practice'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Прогресс практики
        </li>
</div>
<h1 class="text-2xl font-bold mb-4"><?= Html::encode($this->title) ?></h1>

<div class="mb-6 p-4 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-2">Текущий статус практики</h2>
    <p><strong>Практика:</strong> <?= Html::encode($practice->title ?? 'Нет информации') ?></p>
    <p><strong>Статус:</strong> <?= Html::encode($statusLabels[$currentReport->status] ?? 'Нет текущего отчёта') ?></p>
    
     <?php
    // Задайте нужный вам процент выполнения практики
    $progressPercent = 14; // тут меняйте значение от 0 до 100
    ?>

    <!-- Прогресс-бар -->
    <div class="w-full bg-gray-200 rounded-full h-4 mt-3">
        <div class="bg-blue-500 h-4 rounded-full" style="width: <?= $progressPercent ?>%;"></div>
    </div>
    <!-- Отображение процента -->
    <p class="text-sm text-gray-600 mt-2">Прогресс: <?= $progressPercent ?>%</p>
    <!-- Можно добавить прогресс или комментарии -->
</div>

<h2 class="text-xl font-semibold mb-2">Записи</h2>
<div class="overflow-x-auto mb-6">
    <table class="min-w-full bg-blue-200 rounded-xl overflow-hidden">
        <thead>
        <tr>
            <th class="px-4 py-2 text-left">Документ</th>
            <th class="px-4 py-2 text-left">Дата создания</th>
            <th class="px-4 py-2 text-left">Статус</th>
            <th class="px-4 py-2 text-left">Обратная связь</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reports as $report): ?>
            <tr class="odd:bg-white even:bg-blue-200 hover:bg-blue-300">
                <td class="border-gray-200 px-4 py-3"><?= Html::encode($report->report_title) ?></td>
                <td class="border-gray-200 px-4 py-3"><?= Yii::$app->formatter->asDatetime($report->created_at, 'php:d.m.Y h:m') ?></td>
                <td class="border-gray-200 px-4 py-3"><?= Html::encode($statusLabels[$report->status] ?? $report->status) ?></td>
                <td class="border-gray-200 px-4 py-3">
                    <!-- Обратная связь для отчёта -->
                    <?php
                    // Выбираем фидбэк для этого отчёта
                    $feedbacksForReport = array_filter($feedbacks, fn($fb) => $fb->report_id == $report->id);
                    ?>
                    <?php if ($feedbacksForReport): ?>
                        <?php foreach ($feedbacksForReport as $fb): ?>
                            <div class="mb-2 p-2 bg-gray-100 rounded shadow-sm">
                                <p class="text-sm font-medium"><?= Html::encode($fb->reviewer->user->name) ?? 'Руководитель' ?> <?= Html::encode($fb->reviewer->user->surname) ?? 'Руководитель' ?></p>
                                <p class="text-sm text-gray-700"><?= Html::encode($fb->comment) ?></p>
                                <p class="text-xs text-gray-500"><?= Yii::$app->formatter->asDatetime($fb->feedback_date, 'php:d.m.Y h:m') ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-gray-500 text-sm">Нет комментариев</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>