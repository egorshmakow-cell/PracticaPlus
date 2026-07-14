<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportFeedback */
/* @var $report_id app\models\ReportFeedback */
$this->title = 'Добавить отзыв';

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
            <?= Html::a('Обратная связь', ['site/practice'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Добавить связь
        </li>
    </ol>
</div>
<h1 class="text-2xl font-bold mb-4"><?= Html::encode($this->title) ?></h1>

<div class="max-w-xl bg-white p-6 rounded-lg shadow">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'space-y-4']
    ]); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 4, 'class' => 'w-full border rounded-lg px-3 py-2']) ?>

    <?= Html::submitButton('Отправить', ['class' => 'bg-blue-500 hover:bg-blue-600 text-white font-regular py-2 px-4 rounded-lg']) ?>

    <?php ActiveForm::end(); ?>
</div>
