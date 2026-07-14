<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Students $model */
/** @var yii\widgets\ActiveForm $form */
$user = \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(), 'id', 'name');
$groups = \yii\helpers\ArrayHelper::map(\app\models\Groups::find()->all(), 'id', 'group_name');
?>

<div class="students-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($user, ['prompt' => 'Выберите пользователя'])->label('Пользователь') ?>

    <?= $form->field($model, 'group_id', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList($groups, ['prompt' => 'Выберите группу'])->label('Группа') ?>

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
