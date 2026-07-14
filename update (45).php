<?php

use app\models\StudentDocuments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\StudentDocumentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Документы');
$statusLabels = [
    'draft' => 'Черновик',
    'submitted'  => 'Требует проверки',
    'rejected'  => 'Требует изменений',
    'approved'  => 'Готово к печати',
];
?>
<div class="student-documents-index">

    <h1 class="text-2xl mb-4" style="margin-top: 20px"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Создать документ студента'), ['create'], ['class' => 'inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-300', 'style' => 'margin-top: 20px; margin-bottom: 20px; font-size: 14px']) ?>
    </p>
<div class="overflow-x-auto">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'bg-blue-400 rounded-xl overflow-hidden', // Tailwind классы
            'style' => 'border-collapse: collapse; border-radius: 8px; overflow: hidden; width: 1060px'
        ],
        'headerRowOptions' => [
            'class' => 'px-4 py-2 text-left',
            'style' => 'background-color: #60A5FA; text-transform: uppercase; font-size: 0.875rem; color: #fff;',
        ],
        'rowOptions' => function($model, $key, $index, $grid) {
            // Чередование цветов строк без CSS
            return [
                'class' => 'odd:bg-white even:bg-blue-100',
            ];
        },
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'width: 50px; padding: 0.5rem; font-weight: 100'],
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
            ],
            [
                'header' => 'Шаблон',
                'attribute' => 'template_id',
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
                'headerOptions' => ['style' => 'font-weight: 100'],
                'value' => function ($model) {
                    // Предположим, у модели есть отношение 'user'
                    return $model->template->name ?? 'Неизвестно'; // замените 'name' на нужное поле
                },
            ],
            [
                'header' => 'Назначение',
                'attribute' => 'assignment_id',
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
                'headerOptions' => ['style' => 'font-weight: 100'],
                'value' => function ($model) {
                    // Предположим, у модели есть отношение 'user'
                    return $model->assignment->practice->title ?? 'Неизвестно'; // замените 'name' на нужное поле
                },
            ],
            [
                'header' => 'Содержимое документа',
                'attribute' => 'student_content',
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
                'headerOptions' => ['style' => 'font-weight: 100'],
                'value' => function ($model) {
                    // Предположим, у модели есть отношение 'user'
                    return $model->assignment->practice->title ?? 'Неизвестно'; // замените 'name' на нужное поле
                },
            ],
            [
                'header' => 'Статус',
                'attribute' => 'status',
                'contentOptions' => ['style' => 'padding: 0.5rem;'],
                'headerOptions' => ['style' => 'font-weight: 100'],
                'value' => function($model) use ($statusLabels) {
                    return $statusLabels[$model->status] ?? $model->status;
                },
            ],
            //'comment:ntext',
            //'document_path',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'header' => 'Действия',
                'headerOptions' => ['style' => 'font-weight: 100'],
                'template' => '{update} {delete}', // набросок, можно оставить пустым
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            'Редактировать',
                            $url,
                            ['class' => 'inline-flex items-center text-xs font-semibold px-3 py-1.5 rounded-xl border border-[#2B7FFF] text-[#2B7FFF] hover:bg-[#2B7FFF] hover:text-white transition-all']
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            'Удалить',
                            $url,
                            [
                                'class' => 'inline-flex items-center text-xs font-semibold px-3 py-1.5 rounded-xl border border-[#FF3B30] text-[#FF3B30] hover:bg-[#FF3B30] hover:text-white transition-all',
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
</div>
