<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\StudentAssignments $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\Students $students */
/** @var app\models\Groups $groups */
/** @var app\models\Supervisors $supervisors */
/** @var app\models\Practices $practices */
$students = \yii\helpers\ArrayHelper::map(\app\models\Students::find()->joinWith('user')->all(), 'id', function($s) {
    return $s->user->surname . ' ' . $s->user->name;
});
$groups = \yii\helpers\ArrayHelper::map(\app\models\Groups::find()->all(), 'id', 'group_name');
$supervisors = \yii\helpers\ArrayHelper::map(\app\models\Supervisors::find()->joinWith('user')->all(), 'id', function($m) {
    return $m->user->surname . ' ' . $m->user->name;
});
$practices = \yii\helpers\ArrayHelper::map(\app\models\Practices::find()->all(), 'id', 'title');
?>

<div class="student-assignments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($students, ['prompt' => 'Выберите учащегося...'])->label('Студент') ?>

    <?= $form->field($model, 'group_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($groups, ['prompt' => 'Выберите группу...'])->label('Группа') ?>
    
     <?= $form->field($model, 'practice_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($practices, ['prompt' => 'Выберите практику...'])->label('Практика') ?>

    <?= $form->field($model, 'supervisor_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($supervisors, ['prompt' => 'Выберите преподавателя...'])->label('Руководитель') ?>

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
