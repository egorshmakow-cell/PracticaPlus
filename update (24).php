<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\StudentAssignmentsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-assignments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'group_id') ?>

    <?= $form->field($model, 'practice_id') ?>

    <?= $form->field($model, 'supervisor_id') ?>

    <?php // echo $form->field($model, 'completed_hours') ?>

    <?php // echo $form->field($model, 'final_grade') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
