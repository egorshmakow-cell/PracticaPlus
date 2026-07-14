<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Supervisors $model */

// В качестве заголовка выводим ФИО или логин вместо обычного ID для большей информативности
$supervisorName = $model->user ? trim(($model->user->surname ?? '') . ' ' . ($model->user->name ?? '')) : '';
$this->title = !empty($supervisorName) ? $supervisorName : 'Руководитель №' . $model->id;
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
            <?= Html::a('Руководители', ['supervisors/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            <?= Html::encode($this->title) ?>
        </li>
    </ol>
</div>
<div class="supervisors-view font-sans max-w-7xl mx-auto px-4 py-2 flex flex-col">

    <!-- Заголовок карточки просмотра -->
    <h1 class="text-3xl font-bold text-gray-800 mb-6 tracking-tight">
        Профиль: <?= Html::encode($this->title) ?>
    </h1>

    <!-- Блок кнопок действий (выровнены по высоте 38px и размеру под общий стиль) -->
    <div class="flex flex-wrap gap-2 mb-6">
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
            'class' => 'inline-flex items-center justify-center px-4 h-[38px] bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-300 text-xs transition-colors shadow-sm min-w-[120px]'
        ]) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'inline-flex items-center justify-center px-4 h-[38px] bg-red-500 text-white font-semibold rounded-xl hover:bg-red-300 text-xs transition-colors shadow-sm min-w-[80px]',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого руководителя?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <!-- Выровненная таблица детальной информации в фирменном стиле -->
    <div class="overflow-x-auto rounded-xl shadow-sm border border-blue-300/30 w-full max-w-3xl">
        <?= DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'min-w-full bg-blue-400 border-collapse table-auto text-xs tracking-wide align-middle m-0'
            ],
            'template' => '<tr class="odd:bg-white even:bg-blue-100 transition-colors border-b border-blue-200/40"><th class="px-5 py-3.5 text-left font-bold text-gray-500 uppercase tracking-wider text-[10px] w-1/3 border-r border-blue-200/30 bg-gray-50/50">{label}</th><td class="px-5 py-3.5 text-left font-semibold text-gray-800 text-sm align-middle">{value}</td></tr>',
            'attributes' => [
                [
                    'attribute' => 'id',
                    'label' => 'ID Записи',
                ],
                [
                    'attribute' => 'user_id',
                    'label' => 'Пользователь (Логин)',
                    'value' => function($model) {
                        return $model->user ? $model->user->username : '—';
                    }
                ],
                [
                    'attribute' => 'phone',
                    'label' => 'Номер телефона',
                    'value' => function($model) {
                        return $model->phone ? $model->phone : '—';
                    }
                ],
                [
                    'attribute' => 'department',
                    'label' => 'Кафедра / Отдел',
                    'value' => function($model) {
                        return $model->department ? $model->department : '—';
                    }
                ],
            ],
        ]) ?>
    </div>

</div>
