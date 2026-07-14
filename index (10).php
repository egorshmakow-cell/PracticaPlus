<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReportsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reports-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'assignment_id') ?>

    <?= $form->field($model, 'report_title') ?>

    <?= $form->field($model, 'submission_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'document_path') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'grade') ?>

    <?php // echo $form->field($model, 'reviewed_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
