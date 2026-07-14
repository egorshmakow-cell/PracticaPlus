<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
?>
<div class="max-w-3xl mx-auto p-8 rounded-lg">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'bg-white p-4 rounded shadow'],
        'fieldConfig' => [
            'template' => '<div class="mb-4">{label}{input}{error}</div>',
            'labelOptions' => ['class' => 'block mb-1 font-medium'],
            'inputOptions' => ['class' => 'w-full border border-gray-300 p-2 rounded-lg'],
            'errorOptions' => ['class' => 'text-red-500 text-sm'],
        ],
    ]); ?>

    <h1 class="text-3xl font-regular mb-4 text-center">Авторизация</h1>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput([]) ?>

    <div>
        <?= Html::submitButton('Войти', ['class' => 'bg-blue-500 hover:bg-blue-300 text-white font-regular py-2 px-4 rounded-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>