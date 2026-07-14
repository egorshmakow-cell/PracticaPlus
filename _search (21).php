<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\DocumentTemplates */
/* @var $this yii\web\View */

$this->title = 'Загрузить файл шаблона';

?>
<div class="bg-white max-w-xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'upload-form',
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'space-y-4']
    ]) ?>

    <div>
        <?= $form->field($model, 'file', [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'block mb-1 font-medium text-gray-700']
        ])->fileInput()->label('Файл') ?>
    </div>

    <div>
        <?= Html::submitButton('Загрузить', [
            'class' => 'w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded'
        ]) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>