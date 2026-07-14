<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportFeedback */

$this->title = 'Обратная связь: ' . ($model->report->report_title ?? 'Отчет');
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
        <li class="inline-flex items-center">
            <?= Html::a('Обратная связь', ['site/practice'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            <?= Html::encode($this->title) ?>
        </li>
    </ol>
</div>
<div class="report-feedback-view max-w-4xl mx-auto px-4 py-8 bg-white rounded-xl shadow-md">

    <h1 class="text-2xl font-bold mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="mb-4">
        <strong>Отчет:</strong> <?= Html::encode($model->report->report_title ?? 'Отчет не найден') ?><br>
        <strong>Руководитель:</strong> <?= Html::encode($model->reviewer->name ?? 'Руководитель') ?><br>
        <strong>Дата:</strong> <?= Yii::$app->formatter->asDate($model->feedback_date, 'php:d.m.Y') ?><br>
        <strong>Статус:</strong> <?= Html::encode($statusLabels[$model->status] ?? $model->status) ?><br>
        <strong>Комментарии:</strong> <?= Html::encode($model->comment ?? 'Нет комментариев') ?>
    </div>
</div>
