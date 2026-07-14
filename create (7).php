<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\RegisterForm $model */

?>
<div>
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Регистрация
        </li>
    </ol>
</div>
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
    <h1 class="text-3xl font-regular mb-4 text-center">Регистрация</h1>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput([]) ?>

    <div class="mt-4">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'bg-blue-500 hover:bg-blue-300 text-white font-regular py-2 px-4 rounded-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <p class="mt-4 text-center">
        Уже есть аккаунт? <?= Html::a('Войти', ['/site/login'], ['class' => 'underline text-blue-500']) ?>
    </p>
</div>

