<?php

use app\models\Students;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\StudentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Студенты');
?>
<div class="students-index">

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-2 w-full flex items-center justify-between">
        <h1 class="text-2xl font-semibold mb-0"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="/web/admin/user" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Пользователи</a>
        <a href="/web/admin/students" class="w-36 bg-green-500 text-white py-2 px-5 rounded-lg text-sm text-center">Студенты</a>
        <a href="/web/admin/practices" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Практики</a>
        <a href="/web/admin/groups" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Группы</a>
        <a href="/web/admin/templates" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Шаблоны</a>
        <a href="/web/admin/supervisors" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Руководители</a>
        <a href="/web/admin/student-assignments" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Назначение</a>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Добавить студента'), ['create'], ['class' => 'inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-300', 'style' => 'margin-top: 20px; margin-bottom: 20px; font-size: 14px']) ?>
    </p>

    <div class="overflow-x-auto">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'min-w-full bg-blue-500/80 border-collapse table-auto text-xs tracking-wide align-middle m-0', // Tailwind классы
            'style' => 'border-collapse: collapse; border-radius: 8px; overflow: hidden; width: 1060px'
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
                'header' => 'Пользователь',
                'attribute' => 'user_id',
                'headerOptions' => ['class' => 'text-left font-semibold px-5 whitespace-nowrap'],
                'contentOptions' => ['class' => 'text-left font-semibold text-gray-800 p-3 align-middle text-sm'],
                'value' => function ($model) {
                    // Выводим полное имя, если отношение настроено (добавил вывод фамилии, если поле surname доступно в user)
                    if ($model->user) {
                        $fullName = trim(($model->user->surname ?? '') . ' ' . ($model->user->name ?? ''));
                        return !empty($fullName) ? $fullName : 'Неизвестно';
                    }
                    return 'Неизвестно';
                },
            ],
            [
                'header' => 'Группа',
                'attribute' => 'group_id',
                'headerOptions' => ['class' => 'text-center font-semibold px-5 whitespace-nowrap w-1/4'],
                'contentOptions' => ['class' => 'text-center font-bold text-gray-600 p-3 align-middle text-sm whitespace-nowrap'],
                'value' => function ($model) {
                    return $model->group->group_name ?? '—';
                },
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Действия',
                'headerOptions' => ['class' => 'text-center font-semibold px-4 whitespace-nowrap w-1/4'],
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            'Редактировать',
                            $url,
                            ['class' => 'inline-flex items-center justify-center text-xs font-semibold px-3 h-7 rounded-lg border border-[#2B7FFF] text-[#2B7FFF] bg-white hover:bg-[#2B7FFF] hover:text-white transition-all shadow-sm min-w-[110px]']
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            'Удалить',
                            $url,
                            [
                                'class' => 'inline-flex items-center justify-center text-xs font-semibold px-3 h-7 rounded-lg border border-[#FF3B30] text-[#FF3B30] bg-white hover:bg-[#FF3B30] hover:text-white transition-all shadow-sm min-w-[70px]',
                                'data-confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                                'data-method' => 'post'
                            ]
                        );
                    },
                ],
                'contentOptions' => [
                    'class' => 'text-center p-3 align-middle whitespace-nowrap space-x-1.5',
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>

</div>
