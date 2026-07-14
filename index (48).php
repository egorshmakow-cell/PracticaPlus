<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\StudentDocuments $model */
/** @var yii\widgets\ActiveForm $form */
$template = \yii\helpers\ArrayHelper::map(\app\models\DocumentTemplates::find()->all(), 'id', 'name');
$assignment = \yii\helpers\ArrayHelper::map(\app\models\StudentAssignments::find()->joinWith('practice')->all(), 'id', function($s) {
    return $s->practice->title;
});
?>

<div class="student-documents-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'template_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($template, ['prompt' => 'Выберите шаблон...'])->label('Шаблон') ?>

    <?= $form->field($model, 'assignment_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($assignment, ['prompt' => 'Выберите назначение...'])->label('Назначение') ?>

    <?= $form->field($model, 'student_content', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textarea(['rows' => 6])->label('Содержимое документа') ?>

    <?= $form->field($model, 'status', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList([ 'draft' => 'Draft', 'submitted' => 'Submitted', 'rejected' => 'Rejected', 'approved' => 'Approved', ], ['prompt' => ''])->label('Статус') ?>

    <?= $form->field($model, 'comment', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textarea(['rows' => 6])->label('Комментарий') ?>

    <?= $form->field($model, 'document_path', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->fileInput()->label('Файл') ?>
    
    <?= $form->field($model, 'draft_path', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->fileInput()->label('Черновик') ?>

    <?= $form->field($model, 'created_at', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput()->label('Дата создания') ?>

    <?= $form->field($model, 'updated_at', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput()->label('Дата обновления') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'bg-blue-500 text-white hover:bg-blue-600 py-2 px-5 rounded-xl']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
