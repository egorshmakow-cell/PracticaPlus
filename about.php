<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model app\models\Reports */

?>
<div class="max-w-2xl mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Загрузка файла для "<?= Html::encode($model->report_title) ?>"</h2>

    <?php $form = ActiveForm::begin([
        'action' => ['uploads', 'id' => $model->id],
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'bg-white p-4 rounded shadow'],
        'fieldConfig' => [
            'template' => '<div class="mb-4">{label}{input}{error}</div>',
            'labelOptions' => ['class' => 'block mb-1 font-medium'],
            'inputOptions' => ['class' => 'w-full border border-gray-300 p-2 rounded-lg'],
            'errorOptions' => ['class' => 'text-red-500 text-sm'],
        ],
    ]); ?>

    <?= $form->field($model, 'file')->fileInput()->label('Файл') ?>

    <div class="flex space-x-2 mt-4">
        <?= Html::submitButton('Загрузить', ['class' => 'bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
