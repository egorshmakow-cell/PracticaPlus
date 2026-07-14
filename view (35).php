<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'surname', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput(['maxlength' => true])->label('Фамилия') ?>

    <?= $form->field($model, 'name', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput(['maxlength' => true])->label('Имя') ?>

    <?= $form->field($model, 'patronymic', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput(['maxlength' => true])->label('Отчество') ?>

    <?= $form->field($model, 'username', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->textInput(['maxlength' => true])->label('Логин') ?>

    <?= $form->field($model, 'password', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->passwordInput(['maxlength' => true])->label('Пароль') ?>

    <?= $form->field($model, 'role', [
        'template' => "<div class='form-group flex flex-col'>{label}\n{input}\n{error}",
        'inputOptions' => ['class' => 'w-100 px-3 py-1 mt-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'],
        'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
        'errorOptions' => ['class' => 'text-gray-300 text-sm'],
    ])->dropDownList([ 'student' => 'Студент', 'supervisor' => 'Руководитель', 'admin' => 'Администратор', ], ['prompt' => ''])->label('Роль') ?>

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
