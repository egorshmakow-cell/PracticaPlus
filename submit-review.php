<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $reports app\models\Reports */
/* @var $feedbacks app\models\ReportFeedback[] */

$this->title = 'Обратная связь с руководителем';
$statusLabels = [
    'submitted' => 'Подано',
    'reviewed'  => 'На рассмотрении',
    'approved'  => 'Одобрено',
    'rejected'  => 'Отклонено',
];
?>
<div>
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Обратная связь
        </li>
    </ol>
</div>
<div class="container max-w-7xl mx-auto px-4 py-8 flex flex-col">
<h1 class="text-2xl font-bold mb-4"><?= Html::encode($this->title) ?></h1>

<?= Html::a('Добавить отзыв', ['create'], ['class' => 'bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-xl max-w-[160px]']) ?>
<div class="mt-px">
<?php if (empty($feedbacks)): ?>
    <p class="text-gray-600">Нет отзывов.</p>
<?php else: ?>
    <div class="overflow-x-auto">
    <table class="min-w-1/2 bg-blue-200 rounded-xl overflow-hidden">
        <thead>
        <tr>
            <th class="px-4 py-2 text-left">Заголовок</th>
            <th class="px-4 py-2 text-left">Руководитель</th>
            <th class="px-4 py-2 text-left">Дата подачи</th>
            <th class="px-4 py-2 text-left">Статус</th>
            <th class="px-4 py-2 text-left">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($feedbacks as $feedback): ?>
            <tr class="odd:bg-white even:bg-blue-200 hover:bg-blue-300">
                <td class="border-gray-200 px-4 py-3"><?= Html::encode($feedback->report->report_title ?? 'Отчет') ?></td>
                <td class="border-gray-200 px-4 py-3"><?= Html::encode($feedback->reviewer->user->name ?? 'Руководитель') ?></td>
                <td class="border-gray-200 px-4 py-3"><?= Yii::$app->formatter->asDate($feedback->feedback_date, 'php:d.m.Y') ?></td>
                <td class="border-gray-200 px-4 py-3"><?= Html::encode($statusLabels[$feedback->status] ?? $feedback->status) ?></td>
                <td class="border-gray-200 px-4 py-3">
                    <?= Html::a('Посмотреть', ['view', 'id' => $feedback->id], ['class' => 'text-blue-500 hover:underline']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>
</div>
</div>