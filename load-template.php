<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reports $model */
/** @var yii\widgets\ActiveForm $form */
$assignment = \yii\helpers\ArrayHelper::map(\app\models\StudentAssignments::find()->joinWith('practice')->all(), 'id', function($s) {
    return $s->practice->title;
});
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'assignment_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']
    ])->dropDownList($assignment, ['prompt' => 'Выберите назначение...'])->label('Назначение') ?>

    <?= $form->field($model, 'report_title', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']
    ])->textInput(['maxlength' => true])->label('Наименование') ?>

    <?= $form->field($model, 'status', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']
    ])->dropDownList([ 'draft' => 'Draft', 'ready' => 'Ready', ], ['prompt' => ''])->label('Статус') ?>

    <?= $form->field($model, 'file', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']
    ])->fileInput()->label('Файл') ?>

    <?= $form->field($model, 'grade', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']
    ])->textInput(['maxlength' => true])->label('Оценка') ?>

    <?= $form->field($model, 'created_at', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']
    ])->textInput()->label('Дата создания') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-xl']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

