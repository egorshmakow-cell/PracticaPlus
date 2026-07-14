<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DiaryEntriesForm */

$this->title = 'Создать запись';
?>
<div>
        <ol class="inline-flex items-center space-x-1 md:space-x-2 mb-4">
            <li class="inline-flex items-center">
                <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
                <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
                </svg>
            </li>
            <li class="inline-flex items-center">
                <?= Html::a('Мои практики', ['site/practice'], ['class' => 'text-black hover:text-gray-500']) ?>
                <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
                </svg>
            </li>
            <li class="inline-flex items-center">
                <?= Html::a('Журнал практики', ['diary/index'], ['class' => 'text-black hover:text-gray-500']) ?>
                <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
                </svg>
            </li>
            <li class="inline-flex items-center text-black" aria-current="page">
                Создать запись
            </li>
        </ol>
    </div>
<div class="max-w-xl mx-auto mt-8 bg-white p-8 rounded shadow">
    <h2 class="text-xl font-bold mb-6"><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'bg-white p-4 rounded shadow'],
        'fieldConfig' => [
            'template' => '<div class="mb-4">{label}{input}{error}</div>',
            'labelOptions' => ['class' => 'block mb-1 font-medium'],
            'inputOptions' => ['class' => 'w-full border border-gray-300 p-2 rounded-lg'],
            'errorOptions' => ['class' => 'text-red-500 text-sm'],
        ],
    ]); ?>

    <?= $form->field($model, 'date')->input('date', [
        'class' => 'block w-full border border-gray-300 rounded-lg py-2 px-3 mb-4',
        'min' => date('Y-m-d'),
        'value' => $model->date ?? date('Y-m-d'), // установка текущей даты по умолчанию
    ])->label('Дата') ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 3, 'class' => 'block w-full border border-gray-300 rounded-lg py-2 px-3 mb-4'])->label('Выполненные задания') ?>

    <?= $form->field($model, 'hours')->input('number', [
        'class' => 'w-full border border-gray-300 p-2 rounded-lg',
        'min' => 0,
    ])->label('Часы') ?>

    <div class="flex justify-between mt-6">
        <?= Html::submitButton( 'Создать', [
            'class' => 'bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded-xl'
        ]) ?>
        <?= Html::a('Отмена', ['index'], [
            'class' => 'bg-red-500 text-white py-2 px-4 rounded-xl'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

