<?php
/* @var $model app\models\StudentAssignments */
?>
<div class="max-w-4xl mx-auto my-4 flex justify-end print:hidden">
    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Распечатать документ
    </button>
</div>

<!-- Бланк документа -->
<div class="max-w-4xl mx-auto bg-white p-12 border border-gray-200 shadow-sm print:shadow-none print:border-none print:p-0 font-serif">
    <div class="text-center uppercase font-bold text-lg mb-6">
        АТТЕСТАЦИОННЫЙ ЛИСТ ПО ПРАКТИКЕ
    </div>
    <?php foreach ($model as $item): ?>
    <div class="space-y-4 text-base leading-relaxed text-gray-900">
        <p><strong>Студент:</strong> <?= htmlspecialchars($item->student->user->surname . ' ' . $item->student->user->name) ?></p>
        <p><strong>Группа:</strong> <?= htmlspecialchars($item->group->group_name) ?></p>
        <p><strong>Название практики:</strong> <?= htmlspecialchars($item->practice->title) ?> (<?= htmlspecialchars($item->practice->type) ?>)</p>
        <p><strong>Период проведения:</strong> с <?= Yii::$app->formatter->asDate($item->practice->start_date, 'php:d.m.Y') ?> по <?= Yii::$app->formatter->asDate($item->practice->end_date, 'php:d.m.Y') ?></p>
        <p><strong>Всего отработано часов:</strong> <?= $item->completed_hours ?> из <?= $item->practice->total_hours ?> нормочасов.</p>

        <div class="border-t border-b border-gray-300 py-4 my-6">
            <p class="font-bold text-center text-lg">
                ИТОГОВАЯ ОЦЕНКА (СРЕДНИЙ БАЛЛ):
                <span class="underline ml-2"><?= $item->final_grade ?? $item->getAverageGrade() ?></span>
            </p>
        </div>

        <p class="text-justify">
            За время прохождения практики студент ознакомился с внутренним регламентом, в полном объеме вел журнал практики. Записи в журнале оценены руководителем. Прогресс выполнения программы практики составляет 100%.
        </p>
    </div>

    <!-- Блок подписей -->
    <div class="mt-16 flex justify-between text-base">
        <div>
            <p>Руководитель практики:</p>
            <p class="text-sm text-gray-400 print:hidden">(ФИО, подпись)</p>
            <div class="mt-8 border-b border-black w-48 text-center font-sans text-sm">
                <?= htmlspecialchars($item->supervisor->user->surname . ' ' . \mb_substr($item->supervisor->user->name, 0, 1) . '.') ?>
            </div>
        </div>
        <div class="text-right">
            <p>Дата формирования:</p>
            <div class="mt-14 font-medium text-sm">
                <?= date('d.m.Y') ?> г.
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>

