<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DiaryEntries */

$this->title = 'Оценка работы';
?>
<div>
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center">
            <?= Html::a('Список студентов', ['supervisor/student'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center">
            <?= Html::a('Проверка дневника', ['supervisor/student'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            <?= Html::encode($this->title) ?>
        </li>
    </ol>
</div>
    <div class="max-w-xl mx-auto mt-8 bg-white p-8 rounded shadow">
        <h1 class="text-3xl font-bold"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'class' => 'bg-white p-4 rounded shadow'],
            'fieldConfig' => [
                'template' => '<div class="mb-4">{label}{input}{error}</div>',
                'labelOptions' => ['class' => 'block mb-1 font-medium'],
                'inputOptions' => ['class' => 'w-full border border-gray-300 p-2 rounded-lg'],
                'errorOptions' => ['class' => 'text-red-500 text-sm'],
            ],
        ]); ?>

        <?= $form->field($model, 'grade')->dropDownList([
            5 => '5 (Отлично)',
            4 => '4 (Хорошо)',
            3 => '3 (Удовлетворительно)',
            2 => '2 (Неудовлетворительно)',
        ], ['prompt' => 'Выберите оценку'])->label('Оценка') ?>
        
        <?= $form->field($model, 'supervisor_comment')->textarea()->label('Комментарий') ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', [
                    'class' => 'bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded-xl'
                ]) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
