<?php

use app\models\StudentAssignments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\StudentAssignmentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Назначения студентов');
?>
<div class="student-assignments-index">

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-2 w-full flex items-center justify-between">
        <h1 class="text-2xl font-semibold mb-0"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="/web/admin/user" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Пользователи</a>
        <a href="/web/admin/students" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Студенты</a>
        <a href="/web/admin/practices" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Практики</a>
        <a href="/web/admin/groups" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Группы</a>
        <a href="/web/admin/templates" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Шаблоны</a>
        <a href="/web/admin/supervisors" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Руководители</a>
        <a href="/web/admin/student-assignments" class="w-36 bg-green-500 text-white py-2 px-5 rounded-lg text-sm text-center">Назначение</a>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Добавить назначение'), ['create'], ['class' => 'inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-300', 'style' => 'margin-top: 20px; margin-bottom: 20px; font-size: 14px']) ?>
    </p>

<div class="overflow-x-auto">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'min-w-full bg-blue-400 border-collapse table-auto text-xs tracking-wide align-middle m-0', // Tailwind классы
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
                'header' => 'Студент',
                'attribute' => 'student_id',
                'headerOptions' => ['class' => 'text-left font-semibold px-5 whitespace-nowrap w-1/10'],
                'contentOptions' => ['class' => 'text-left font-semibold text-gray-800 p-3 align-middle text-sm whitespace-nowrap'],
                'value' => function ($model) {
                    if ($model->student && $model->student->user) {
                        return trim(($model->student->user->surname ?? '') . ' ' . ($model->student->user->name ?? ''));
                    }
                    return 'Неизвестно';
                },
            ],
            [
                'header' => 'Группа',
                'attribute' => 'group_id',
                'headerOptions' => ['class' => 'text-center font-semibold px-4 whitespace-nowrap w-1/5'],
                'contentOptions' => ['class' => 'text-center font-bold text-gray-600 p-3 align-middle text-sm whitespace-nowrap'],
                'value' => function ($model) {
                    return $model->group->group_name ?? '—';
                },
            ],
            [
                'header' => 'Практика',
                'attribute' => 'practice_id',
                'headerOptions' => ['class' => 'text-left font-semibold px-5 whitespace-nowrap w-1/8'],
                'contentOptions' => ['class' => 'text-left font-medium text-gray-700 p-3 align-middle text-sm leading-snug'],
                'value' => function ($model) {
                    return $model->practice->title ?? '—';
                },
            ],
            [
                'header' => 'Руководитель',
                'attribute' => 'supervisor_id',
                'headerOptions' => ['class' => 'text-left font-semibold px-5 whitespace-nowrap'],
                'contentOptions' => ['class' => 'text-left font-medium text-gray-700 p-3 align-middle text-sm whitespace-nowrap'],
                'value' => function ($model) {
                    if ($model->supervisor && $model->supervisor->user) {
                        return trim(($model->supervisor->user->surname ?? '') . ' ' . ($model->supervisor->user->name ?? ''));
                    }
                    return '—';
                },
            ],
            [
                'header' => 'Количество часов',
                'attribute' => 'completed_hours',
                'headerOptions' => ['class' => 'text-center font-semibold px-4 whitespace-nowrap w-1/5'],
                'contentOptions' => ['class' => 'text-center p-3 align-middle w-1/5'],
                'format' => 'raw',
                'value' => function($model) {
                    $max_hours = (int)($model->practice->total_hours ?? 160);
                    $hours = (int)$model->completed_hours;
                    $percentage = $max_hours > 0 ? min(100, ($hours / $max_hours) * 100) : 0;
                    
                    return Html::beginTag('div', ['class' => 'flex flex-col items-center justify-center space-y-1 w-full min-w-[130px] mx-auto']) .
                        // Выровненный прогресс-бар в вашем стиле
                        Html::beginTag('div', ['class' => 'w-full bg-gray-200 rounded-full h-2.5 shadow-inner']) .
                            Html::tag('div', '', [
                                'class' => 'bg-blue-600 h-2.5 rounded-full transition-all duration-500',
                                'style' => "width: $percentage%;",
                            ]) .
                        Html::endTag('div') .
                        // Подпись часов снизу
                        Html::tag('span', $hours . ' из ' . $max_hours . ' ч.', [
                            'class' => 'text-[11px] font-bold text-gray-500 whitespace-nowrap',
                        ]) .
                    Html::endTag('div');
                },
            ],
            [
                'class' => yii\grid\ActionColumn::className(),
                'header' => 'Действия',
                'headerOptions' => ['class' => 'text-center font-semibold px-4 whitespace-nowrap w-1/5'],
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
                        return Html::beginForm(['delete', 'id' => $model->id], 'post', [
                            'class' => 'inline-block m-0 p-0',
                            'onsubmit' => 'return confirm("Вы уверены, что хотите удалить это назначение?");'
                        ]) .
                        Html::submitButton('Удалить', [
                            'class' => 'inline-flex items-center justify-center text-xs font-semibold px-3 h-7 rounded-lg border border-[#FF3B30] text-[#FF3B30] bg-white hover:bg-[#FF3B30] hover:text-white transition-all shadow-sm min-w-[70px]',
                        ]) .
                        Html::endForm();
                    }
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
