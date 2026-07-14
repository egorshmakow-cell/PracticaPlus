<?php

use app\models\Reports;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\ReportsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Отчёты');
$statusLabels = [
    'submitted' => 'Подано',
    'reviewed'  => 'На рассмотрении',
    'approved'  => 'Одобрено',
    'rejected'  => 'Отклонено',
];
?>
<div class="reports-index">

    <h1 class="text-2xl font-bold mb-4" style="margin-top: 20px"><?= Html::encode($this->title) ?></h1>
    <div class="flex flex-wrap gap-2">
        <a href="/web/admin/user" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Пользователи</a>
        <a href="/web/admin/students" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Студенты</a>
        <a href="/web/admin/practices" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Практики</a>
        <a href="/web/admin/groups" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Группы</a>
        <a href="/web/admin/reports" class="bg-blue-500 text-white font-semibold py-2 px-5 rounded-full text-sm">Отчеты</a>
        <a href="/web/admin/supervisors" class="bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-full text-sm">Руководители</a>
        <a href="/web/admin/student-assignments" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Назначение</a>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Добавить отчёт'), ['create'], ['class' => 'inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600', 'style' => 'margin-top: 20px; margin-bottom: 20px']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'min-w-full bg-blue-200 rounded-xl overflow-hidden', // Tailwind классы
            'style' => 'border-collapse: collapse; border-radius: 8px; overflow: hidden;'
        ],
        'headerRowOptions' => [
            'class' => 'px-4 py-2 text-left',
            'style' => 'background-color: #A6CCFF; text-transform: uppercase; font-size: 0.875rem; color: #000;',
        ],
        'rowOptions' => function($model, $key, $index, $grid) {
            // Чередование цветов строк без CSS
            return [
                'class' => 'odd:bg-white even:bg-blue-200 hover:bg-blue-300',
            ];
        },
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'width: 50px; padding: 0.5rem;'],
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
            ],

            [
                'header' => 'Назначение',
                'attribute' => 'assignment_id',
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
                'value' => function ($model) {
                    // Предположим, у модели есть отношение 'user'
                    return $model->assignment->practice->title ?? 'Неизвестно'; // замените 'name' на нужное поле
                },
            ],
            [
                'header' => 'Название отчёта',
                'attribute' => 'report_title',
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
            ],
            [
                'header' => 'Статус',
                'attribute' => 'status',
                'value' => function($model) use ($statusLabels) {
                    return $statusLabels[$model->status] ?? $model->status;
                },
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
            ],
            //'document_path',
            //'grade',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'header' => 'Действия',
                'template' => '{update} {delete}', // набросок, можно оставить пустым
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            'Редактировать',
                            $url,
                            ['class' => 'inline-block px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mx-1']
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            'Удалить',
                            $url,
                            [
                                'class' => 'inline-block px-2 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 mx-1',
                                'data-confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                                'data-method' => 'post'
                            ]
                        );
                    },
                ],
                'contentOptions' => [
                    'class' => 'flex-row gap-2 justify-center items-center',
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
