<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Practices $model */

$this->title = Yii::t('app', 'Создать практику');
?>

<div>
    <li class="inline-flex items-center">
        <?= Html::a('Главная', ['/site/index'], ['class' => 'hover:text-blue-600 transition-colors']) ?>
            <svg class="w-3 h-3 mx-2 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
    </li>
    <li class="inline-flex items-center">
        <?= Html::a('Практики', ['index'], ['class' => 'hover:text-blue-600 transition-colors']) ?>
        <svg class="w-3 h-3 mx-2 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
        </svg>
    </li>
    <li class="inline-flex items-center text-gray-800 truncate max-w-[200px]" aria-current="page" title="<?= Html::encode($this->title) ?>">
        <?= Html::encode($this->title) ?>
    </li>
</div>
<div class="practices-create max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md mt-4">

    <h1 class="text-2xl font-bold mb-4" style="margin-top: 20px"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
