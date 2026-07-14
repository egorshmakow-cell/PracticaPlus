<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

// Собираем полное ФИО пользователя для информативного и красивого заголовка
$userFullName = trim(($model->surname ?? '') . ' ' . ($model->name ?? '') . ' ' . ($model->patronymic ?? ''));
$this->title = !empty($userFullName) ? $userFullName : 'Пользователь №' . $model->id;

$userLabels = [
    'student' => 'Студент',
    'supervisor'  => 'Руководитель',
    'admin'  => 'Администратор',
];

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
        <?= Html::a('Пользователи', ['index'], ['class' => 'hover:text-blue-600 transition-colors']) ?>
        <svg class="w-3 h-3 mx-2 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
        </svg>
    </li>
    <li class="inline-flex items-center text-gray-800 font-semibold truncate max-w-[200px]" aria-current="page" title="<?= Html::encode($this->title) ?>">
        <?= Html::encode($this->title) ?>
    </li>
</div>
<div class="user-view font-sans max-w-7xl mx-auto px-4 py-2 flex flex-col">

    <h1 class="text-3xl font-bold text-gray-800 mb-6 tracking-tight leading-tight">
        Профиль: <?= Html::encode($this->title) ?>
    </h1>

    <!-- Блок кнопок действий (высота 38px, закругления xl и тени под общий стиль) -->
    <div class="flex flex-wrap gap-2 mb-6">
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
            'class' => 'inline-flex items-center justify-center px-4 h-[38px] bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-300 text-xs transition-colors shadow-sm min-w-[120px]'
        ]) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'inline-flex items-center justify-center px-4 h-[38px] bg-red-500 text-white font-semibold rounded-xl hover:bg-red-300 text-xs transition-colors shadow-sm min-w-[80px]',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
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
            'template' => '<tr class="odd:bg-white even:bg-blue-100 transition-colors border-b border-blue-200/40"><th class="px-5 py-3.5 text-left font-bold text-gray-500 uppercase tracking-wider text-[10px] w-1/3 border-r border-blue-200/30 bg-gray-50/50">{label}</th><td class="px-5 py-3.5 text-left font-semibold text-gray-800 text-sm align-middle">{value}</td></tr>',
            'attributes' => [
                [
                    'attribute' => 'id',
                    'label' => 'ID Пользователя',
                ],
                [
                    'attribute' => 'username',
                    'label' => 'Логин / Username',
                ],
                [
                    'attribute' => 'surname',
                    'label' => 'Фамилия',
                ],
                [
                    'attribute' => 'name',
                    'label' => 'Имя',
                ],
                [
                    'attribute' => 'patronymic',
                    'label' => 'Отчество',
                    'value' => function($model) {
                        return $model->patronymic ? $model->patronymic : '—';
                    }
                ],
                [
                    'attribute' => 'password',
                    'label' => 'Пароль',
                    'value' => '********', // Скрываем реальный хэш пароля из соображений безопасности
                ],
                [
                    'attribute' => 'role',
                    'label' => 'Роль в системе',
                    'format' => 'raw',
                    'value' => function($model) use ($userLabels) {
                        $labelText = isset($userLabels[$model->role]) ? $userLabels[$model->role] : $model->role;
                        $badgeClass = 'bg-gray-100 text-gray-700';
                        if ($model->role === 'admin') $badgeClass = 'bg-red-100 text-red-800';
                        if ($model->role === 'supervisor') $badgeClass = 'bg-green-100 text-green-800';
                        if ($model->role === 'student') $badgeClass = 'bg-blue-100 text-blue-800';
                        
                        return Html::tag('span', Html::encode($labelText), [
                            'class' => 'px-2 py-0.5 rounded-md font-bold uppercase tracking-wide text-[10px] ' . $badgeClass
                        ]);
                    }
                ],
                [
                    'attribute' => 'is_blocked',
                    'label' => 'Статус учетной записи',
                    'format' => 'raw',
                    'value' => function($model) {
                        // Адаптация под логику булевого или текстового флага блокировки
                        $isBlocked = (bool)$model->is_blocked;
                        return $isBlocked 
                            ? Html::tag('span', 'Заблокирован', ['class' => 'px-2 py-0.5 rounded-md font-bold uppercase tracking-wide text-[10px] bg-red-100 text-red-800'])
                            : Html::tag('span', 'Активен', ['class' => 'px-2 py-0.5 rounded-md font-bold uppercase tracking-wide text-[10px] bg-green-100 text-green-800']);
                    }
                ],
            ],
        ]) ?>
    </div>

</div>
