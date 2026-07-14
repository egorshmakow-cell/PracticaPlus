<?php
/** @var $model app\models\DocumentTemplatesForm */
/** @var $practices app\models\Practices */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать шаблон';
$practices = \yii\helpers\ArrayHelper::map(\app\models\Practices::find()->all(), 'id', 'title');
?>
    <div class="flex flex-wrap gap-2">
        <a href="/web/admin/user" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Пользователи</a>
        <a href="/web/admin/students" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Студенты</a>
        <a href="/web/admin/practices" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Практики</a>
        <a href="/web/admin/groups" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Группы</a>
        <a href="/web/admin/templates" class="w-36 bg-green-500 text-white py-2 px-5 rounded-lg text-sm text-center">Шаблоны</a>
        <a href="/web/admin/supervisors" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Руководители</a>
        <a href="/web/admin/student-assignments" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Назначение</a>
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
        <?= Html::submitButton('Сохранить', [
            'class' => 'bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded-xl'
        ]) ?>
        <?= Html::a('Отмена', ['index'], [
            'class' => 'bg-red-500 text-white py-2 px-4 rounded-xl'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>