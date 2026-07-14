<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\StudentDocumentsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-documents-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'template_id') ?>

    <?= $form->field($model, 'assignment_id') ?>

    <?= $form->field($model, 'student_content') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'document_path') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
