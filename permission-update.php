<?php
/** @var $model app\models\DocumentTemplatesForm */
/** @var $practices app\models\Practices */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить шаблон';
$practices = \yii\helpers\ArrayHelper::map(\app\models\Practices::find()->all(), 'id', 'title');
?>
<div>
    <li class="inline-flex items-center">
        <?= Html::a('Главная', ['/site/index'], ['class' => 'hover:text-blue-600 transition-colors']) ?>
            <svg class="w-3 h-3 mx-2 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
    </li>
    <li class="inline-flex items-center">
        <?= Html::a('Шаблоны', ['index'], ['class' => 'hover:text-blue-600 transition-colors']) ?>
        <svg class="w-3 h-3 mx-2 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
        </svg>
    </li>
    <li class="inline-flex items-center text-gray-800 truncate max-w-[200px]" aria-current="page" title="<?= Html::encode($this->title) ?>">
        <?= Html::encode($this->title) ?>
    </li>
</div>
<div class="max-w-4xl mx-auto p-4">
    <h2 class="text-xl font-bold mb-6"><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'bg-white p-4 rounded shadow'],
        'fieldConfig' => [
            'template' => '<div class="mb-4">{label}{input}{error}</div>',
            'labelOptions' => ['class' => 'block mb-1 font-medium'],
            'inputOptions' => ['class' => 'w-full border border-gray-300 p-2 rounded-lg'],
            'hintOptions' => ['class' => 'text-gray-300 text-sm'], 
            'errorOptions' => ['class' => 'text-gray-300 text-sm'],
        ],
    ]); ?>
    
    <?= $form->field($model, 'practice_id')->dropDownList($practices, ['prompt' => 'Выберите практику'])->label('Практика') ?>

    <?= $form->field($model, 'name')->textInput()->label('Название') ?>

    <?= $form->field($model, 'description')->textarea()->label('Описание') ?>

    <?= $form->field($model, 'file_path')->fileInput()->label('Файл') ?>

    <div class="flex justify-between mt-6">
        <?= Html::submitButton('Создать', [
            'class' => 'bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded-xl'
        ]) ?>
        <?= Html::a('Отмена', ['index'], [
            'class' => 'bg-red-500 text-white py-2 px-4 rounded-xl'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>