<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $entries app\models\DiaryEntries */

$this->title = 'Комментарии';

?>
<div class="breadcrumbs-container">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Комментарии
        </li>
    </ol>
</div>
<h1 class="text-2xl font-bold mb-4"><?= Html::encode($this->title) ?></h1>

<?php foreach ($entries as $entry): ?>
    <div class="bg-white border border-gray-300 rounded-lg p-4 mb-6 shadow hover:shadow-lg transition-shadow duration-300">
        <!-- Комментарий руководителя -->
        <div class="mt-4">
            <h3 class="font-semibold mb-2 text-lg">Комментарий руководителя:</h3>
            <?php if (!empty($entry->supervisor_comment)): ?>
                <div class="bg-gray-100 p-3 rounded whitespace-pre-line"><?= Html::encode($entry->supervisor_comment) ?></div>
            <?php else: ?>
                <div class="text-gray-500 italic">Отсутствует</div>
            <?php endif; ?>
        </div>
        <!-- Оценка -->
        <div class="mt-4">
            <span class="font-semibold">Оценка:</span> <?= htmlspecialchars($entry->grade) ?>
        </div>
    </div>
<?php endforeach; ?>
</div>