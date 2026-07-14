<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Управление пользователями');
$userLabels = [
    'student' => 'Студент',
    'supervisor'  => 'Руководитель',
    'admin'  => 'Администратор',
];
?>
<div class="user-index">
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-2 w-full flex items-center justify-between">
        <h1 class="text-2xl font-semibold mb-0"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="/web/admin/user" class="w-36 bg-green-500 text-white py-2 px-5 rounded-lg text-sm text-center">Пользователи</a>
        <a href="/web/admin/students" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Студенты</a>
        <a href="/web/admin/practices" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Практики</a>
        <a href="/web/admin/groups" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Группы</a>
        <a href="/web/admin/templates" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Шаблоны</a>
        <a href="/web/admin/supervisors" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Руководители</a>
        <a href="/web/admin/student-assignments" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Назначение</a>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Добавить пользователя'), ['create'], ['class' => 'inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-300', 'style' => 'margin-top: 20px; margin-bottom: 20px; font-size: 14px']) ?>
    </p>
    <div class="relative inline-block text-left mb-4">
        <!-- Кнопка сортировки -->
        <button type="button" onclick="document.getElementById('sort-dropdown').classList.toggle('hidden')" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
            </svg>
            Сортировка
        </button>
    
        <!-- Выпадающее меню -->
        <div id="sort-dropdown" class="hidden absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
            <div class="py-1">
                <?= $dataProvider->sort->link('group_name', ['label' => 'Название группы', 'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100']) ?>
                <?= $dataProvider->sort->link('practice_title', ['label' => 'Наименование практики', 'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100']) ?>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'min-w-full bg-blue-400 border-collapse table-auto text-xs tracking-wide align-middle m-0', // Tailwind классы
            'style' => 'border-collapse: collapse; border-radius: 8px; overflow: hidden;'
        ],
        'headerRowOptions' => [
            'class' => 'text-white bg-blue-500/80 uppercase tracking-wider text-[11px] font-bold h-12',
            'style' => 'background-color: #60A5FA; text-transform: uppercase; font-size: 0.875rem; color: #fff;',
        ],
        'rowOptions' => function($model, $key, $index, $grid) {
            // Чередование цветов строк без CSS
            return [
                'class' => ($index % 2 === 0) ? 'bg-white hover:bg-blue-50/40 transition-colors' : 'bg-blue-100 hover:bg-blue-50/40 transition-colors',
            ];
        },
        'columns' => [
            [
                'header' => 'Логин',
                'attribute' => 'username',
                'headerOptions' => ['class' => 'text-left font-semibold px-4 whitespace-nowrap'],
                'contentOptions' => ['class' => 'text-left font-semibold text-gray-800 p-3 align-middle text-sm'],
            ],
            [
                'header' => 'Фамилия',
                'attribute' => 'surname',
                'headerOptions' => ['class' => 'text-left font-semibold px-4 whitespace-nowrap'],
                'contentOptions' => ['class' => 'text-left font-medium text-gray-700 p-3 align-middle text-sm'],
            ],
            [
                'header' => 'Имя',
                'attribute' => 'name',
                'headerOptions' => ['class' => 'text-left font-semibold px-4 whitespace-nowrap'],
                'contentOptions' => ['class' => 'text-left font-medium text-gray-700 p-3 align-middle text-sm'],
            ],
            [
                'header' => 'Отчество',
                'attribute' => 'patronymic',
                'headerOptions' => ['class' => 'text-left font-semibold px-4 whitespace-nowrap'],
                'contentOptions' => ['class' => 'text-left font-medium text-gray-700 p-3 align-middle text-sm'],
            ],
            [
                'header' => 'Группа',
                'attribute' => 'group_name', 
                'headerOptions' => ['class' => 'text-center font-semibold px-4 whitespace-nowrap'],
                'value' => function($model) {
                    return $model->group ? $model->group->group_name : '—';
                },
                'contentOptions' => ['class' => 'text-center font-medium text-gray-600 p-3 align-middle text-sm whitespace-nowrap'],
            ],
            [
                'header' => 'Практика',
                'attribute' => 'practice_title',
                'headerOptions' => ['class' => 'text-left font-semibold px-4 whitespace-nowrap'],
                'value' => function($model) {
                    return $model->practice ? $model->practice->title : '—';
                },
                'contentOptions' => ['class' => 'text-left font-medium text-gray-700 p-3 align-middle text-sm'],
            ],
            [
                'header' => 'Роль',
                'attribute' => 'role',
                'headerOptions' => ['class' => 'text-center font-semibold px-4 whitespace-nowrap'],
                'contentOptions' => ['class' => 'text-center p-3 align-middle'],
                'value' => function($model) use ($userLabels) {
                    return isset($userLabels[$model->role]) ? $userLabels[$model->role] : $model->role;
                },
                // Стилизация роли в виде аккуратного бейджа
                'format' => 'raw',
                'value' => function($model) use ($userLabels) {
                    $labelText = isset($userLabels[$model->role]) ? $userLabels[$model->role] : $model->role;
                    $badgeClass = 'bg-gray-100 text-gray-700';
                    if ($model->role === 'admin') $badgeClass = 'bg-red-100 text-red-800';
                    if ($model->role === 'supervisor') $badgeClass = 'bg-green-100 text-green-800';
                    if ($model->role === 'student') $badgeClass = 'bg-blue-100 text-blue-800';
                    return Html::tag('span', Html::encode($labelText), ['class' => 'px-2 py-0.5 rounded-md font-bold uppercase tracking-wide text-[10px] ' . $badgeClass]);
                }
            ],
            [
                'header' => 'Действия',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center font-semibold px-4 whitespace-nowrap w-1/6'],
                'contentOptions' => ['class' => 'text-center p-3 align-middle whitespace-nowrap'],
                'value' => function($model) {
                    $blockText = $model->isBlocked ? 'Разблокировать' : 'Заблокировать';
                    $blockClass = $model->isBlocked 
                        ? 'border-green-500 text-green-600 hover:bg-green-500' 
                        : 'border-gray-400 text-gray-500 hover:bg-gray-500';
                        
                    return Html::button($blockText, [
                        'class' => 'inline-flex items-center justify-center text-xs font-semibold px-3 h-7 rounded-lg border hover:text-white transition-all shadow-sm min-w-[110px] bg-white ' 
                        . $blockClass,'data-user-id' => $model->id,'data-blocked' => $model->isBlocked ? 0 : 1,]) 
                        . ' ' . Html::a('Удалить', ['delete', 'id' => $model->id], 
                        ['class' => 'inline-flex items-center justify-center text-xs font-semibold px-3 h-7 rounded-lg border border-[#FF3B30] text-[#FF3B30] hover:bg-[#FF3B30] hover:text-white transition-all shadow-sm min-w-[70px] bg-white',
                        'data-confirm' => 'Удалить этого пользователя?',
                        'data-method' => 'post',
                        ]);
                },
            ],
        ],
    ]); ?>

<?php Pjax::end(); ?>
    </div>

</div>
