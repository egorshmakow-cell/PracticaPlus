<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Practices $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div>
    <li class="inline-flex items-center">
        <?= Html::a('Главная', ['/site/index'], ['class' => 'hover:text-blue-600 transition-colors']) ?>
            <svg class="w-3 h-3 mx-2 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
    </li>
    <li class="inline-flex items-center">
        <?= Html::a('Практики', ['index'], ['class' => 'hover:text-blue-600 transition-colors']) ?>
        <svg class="w-3 h-3 mx-2 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
        </svg>
    </li>
    <li class="inline-flex items-center text-gray-800 font-semibold truncate max-w-[200px]" aria-current="page" title="<?= Html::encode($this->title) ?>">
        <?= Html::encode($this->title) ?>
    </li>
</div>
<div class="practices-view font-sans max-w-7xl mx-auto px-4 py-2 flex flex-col">

    <h1 class="text-3xl font-bold text-gray-800 mb-6 tracking-tight leading-tight">
        Практика: <?= Html::encode($this->title) ?>
    </h1>

    <!-- Блок кнопок действий (выровнены по высоте 38px и размеру под общий стиль) -->
    <div class="flex flex-wrap gap-2 mb-6">
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
            'class' => 'inline-flex items-center justify-center px-4 h-[38px] bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-300 text-xs transition-colors shadow-sm min-w-[120px]'
        ]) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'inline-flex items-center justify-center px-4 h-[38px] bg-red-500 text-white font-semibold rounded-xl hover:bg-red-300 text-xs transition-colors shadow-sm min-w-[80px]',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту практику?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="overflow-x-auto rounded-xl shadow-sm border border-blue-300/30 w-full max-w-3xl">
        <?= DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'min-w-full bg-blue-400 border-collapse table-auto text-xs tracking-wide align-middle m-0'
            ],
            'template' => '<tr class="odd:bg-white even:bg-blue-100 transition-colors border-b border-blue-200/40"><th class="px-5 py-3.5 text-left font-bold text-gray-500 uppercase tracking-wider text-[10px] w-1/3 border-r border-blue-200/30 bg-gray-50/50">{label}</th><td class="px-5 py-3.5 text-left font-semibold text-gray-800 text-sm align-middle leading-normal">{value}</td></tr>',
            'attributes' => [
                [
                    'attribute' => 'id',
                    'label' => 'ID Записи',
                ],
                [
                    'attribute' => 'title',
                    'label' => 'Наименование',
                ],
                [
                    'attribute' => 'type',
                    'label' => 'Тип практики',
                ],
                [
                    'attribute' => 'description',
                    'label' => 'Цель и описание',
                    'format' => 'ntext',
                ],
                [
                    'attribute' => 'start_date',
                    'label' => 'Дата начала',
                    'value' => function($model) {
                        return $model->start_date ? Yii::$app->formatter->asDate($model->start_date, 'php:d.m.Y') : '—';
                    }
                ],
                [
                    'attribute' => 'end_date',
                    'label' => 'Дата окончания',
                    'value' => function($model) {
                        return $model->end_date ? Yii::$app->formatter->asDate($model->end_date, 'php:d.m.Y') : '—';
                    }
                ],
                [
                    'attribute' => 'total_hours',
                    'label' => 'Всего часов',
                    'value' => function($model) {
                        return $model->total_hours ? $model->total_hours . ' ч.' : '—';
                    }
                ],
                [
                    'attribute' => 'main_supervisor_id',
                    'label' => 'Главный руководитель',
                    'value' => function($model) {
                        // Вывод читаемого имени руководителя, если настроена связь
                        if ($model->mainSupervisor && $model->mainSupervisor->user) {
                            return trim(($model->mainSupervisor->user->surname ?? '') . ' ' . ($model->mainSupervisor->user->name ?? ''));
                        }
                        return $model->main_supervisor_id ?? '—';
                    }
                ],
            ],
        ]) ?>
    </div>

</div>
