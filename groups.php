<?php
/** @var $model app\models\Practices */
use yii\helpers\Html;

$this->title = $model->title;
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
            <?= Html::a('Мои практики', ['site/practice'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            <?= Html::encode($model->title) ?>
        </li>
    </ol>
</div>
<div class="mt-12 max-w-4xl mx-auto px-4 mb-12">
    <div class="max-w-4xl mx-auto px-4 py-8 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-semibold mb-4 text-center"><?= Html::encode($model->title) ?></h1>
        <p class="mb-4 text-center">Тип практики: <?= Html::encode($model->type) ?></p>
        <p class="mb-4"><strong>Сроки:</strong> <?= Yii::$app->formatter->asDate($model->start_date, 'php:d.m.Y') ?> - <?= Yii::$app->formatter->asDate($model->end_date, 'php:d.m.Y') ?></p>
        <p class="mb-4"><strong>Цель:</strong> <?= Html::encode($model->description) ?></p>
    </div>
    <div class="flex justify-center space-x-4 mt-6">
        <?= Html::a('Содержание', ['site/view-document', 'file' => 'Soderzhanie_praktiki.doc'], [
            'class' => 'w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg text-center'
        ]) ?>
        <a href="/web/reports/index" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg text-center">Отчётность</a>
    </div>
</div>