<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Reports $model */

$this->title = Yii::t('app', 'Обновить отчет: {name}', [
    'name' => $model->id,
]);
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
            <?= Html::a('Отчёты', ['reports/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            <?= Html::encode($this->title) ?>
        </li>
    </ol>
</div>
<div class="user-update max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">

    <h1 class="text-2xl font-bold mb-4" style="margin-top: 20px"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
