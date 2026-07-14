<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PracticeForm $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\Supervisors $supervisorsList */

$practiceTypes = [
    'Учебная' => 'Учебная',
    'Производственная' => 'Производственная',
    'Преддипломная' => 'Преддипломная',
];

$supervisors = \app\models\Supervisors::find()->innerJoinWith('user')->all();
$supervisorsList = \yii\helpers\ArrayHelper::map($supervisors, 'id', function($model) {
    return $model->user->surname . ' ' . $model->user->name . ' ' . $model->user->patronymic;
});
?>

<div class="practices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput(['maxlength' => true])->label('Заголовок') ?>

    <?= $form->field($model, 'type', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList([
            'Учебная' => 'Учебная практика',
            'Производственная' => 'Производственная практика',
            'Преддипломная' => 'Преддипломная практика'], 
        ['prompt' => 'Выберите тип из списка...'])->label('Тип практики') ?>

    <?= $form->field($model, 'description', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textarea(['rows' => 6])->label('Описание') ?>

    <?= $form->field($model, 'start_date', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->input('date', ['min' => date('Y-m-d')])->label('Дата начала') ?>

    <?= $form->field($model, 'end_date', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->input('date', ['min' => date('Y-m-d')])->label('Дата окончания') ?>

    <?= $form->field($model, 'total_hours', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput(['type' => 'number'])->label('Всего часов') ?>

    <?= $form->field($model, 'main_supervisor_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($supervisorsList, ['prompt' => 'Выберите руководителя'])->label('Главный руководитель (Куратор)') ?>

    <div class="flex justify-between mt-6">
        <?= Html::submitButton('Сохранить', [
            'class' => 'bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded-xl'
        ]) ?>
        <?= Html::a('Отмена', ['index'], [
            'class' => 'bg-red-500 text-white py-2 px-4 rounded-xl'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

