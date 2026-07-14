<?php
/* @var $this yii\web\View */
/* @var $entries app\models\DiaryEntries[] */

$this->title = 'Печать дневника практики';

// --- ДИНАМИЧЕСКИЙ РАСЧЕТ ИТОГОВОГО БАЛЛА И ЧАСОВ ---
$totalGrade = 0;
$gradeCount = 0;
$totalHours = 0; // Фактически отработанные часы из записей дневника
$allGradesFilled = true;

// Получаем плановое количество часов практики из StudentAssignments (через связь assignment)
$requiredHours = !empty($entries) && isset($entries[0]->assignment) ? ($entries[0]->assignment->completed_hours ?? 0) : 0;

if (!empty($entries) && is_array($entries)) {
    foreach ($entries as $entry) {
        if (empty($entry)) {
            $allGradesFilled = false;
            continue;
        }

        // Подсчет фактически выполненных часов из дневника
        if (is_numeric($entry->hours)) {
            $totalHours += $entry->hours;
        }

        // Проверка заполненности оценок
        if ($entry->grade === null || $entry->grade === '' || !is_numeric($entry->grade)) {
            $allGradesFilled = false; // Найдена пустая или нечисловая ячейка
        } else {
            $totalGrade += $entry->grade;
            $gradeCount++;
        }
    }
} else {
    $allGradesFilled = false;
}

// Проверяем, совпадает ли сумма часов из дневника с планом из StudentAssignments
$hoursRequirementMet = ($totalHours >= $requiredHours && $requiredHours > 0);

// Средний балл считается ТОЛЬКО при выполнении обоих условий: все оценки стоят + норма часов выполнена
$averageGrade = ($allGradesFilled && $hoursRequirementMet && $gradeCount > 0) ? round($totalGrade / $gradeCount, 2) : null;
?>

<div class="max-w-4xl mx-auto bg-white p-6 shadow print:shadow-none print:max-w-full">
    <div class="flex justify-end mb-6 print:hidden">
        <button onclick="window.print()" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded cursor-pointer transition">
            🖨️ Распечатать дневник
        </button>
    </div>
    
    <div class="text-center mb-6">
        <h1 class="text-xl font-bold uppercase tracking-wide text-gray-900">Журнал прохождения практики</h1>
        <p class="text-sm text-gray-600 mt-2">
            Группа: <span class="font-semibold"><?= htmlspecialchars($entries[0]->assignment->student->group->group_name ?? '') ?></span> |
            Студент: <span class="font-semibold"><?= htmlspecialchars($entries[0]->assignment->student->user->name ?? '') ?> <?= htmlspecialchars($entries[0]->assignment->student->user->surname ?? '') ?></span>
        </p>
        <p class="text-sm text-gray-600">
            Руководитель: <span class="font-semibold"><?= htmlspecialchars($entries[0]->assignment->supervisor->user->name ?? 'Не назначен') ?> <?= htmlspecialchars($entries[0]->assignment->supervisor->user->surname ?? 'Не назначен') ?></span>
        </p>
        <!-- Информация о плане часов из StudentAssignments -->
        <p class="text-xs text-gray-500 mt-1">
            План часов по программе: <span class="font-semibold text-gray-700"><?= $requiredHours ?> ч.</span>
        </p>
    </div>

    <table class="w-full border-collapse border border-gray-400 text-sm">
        <thead>
            <tr class="bg-gray-100 print:bg-transparent">
                <th class="border border-gray-400 p-3 w-32 text-black">Дата</th>
                <th class="border border-gray-400 p-3 text-left text-black">Содержание выполненных работ</th>
                <th class="border border-gray-400 p-3 w-20 text-center text-black">Часы</th>
                <th class="border border-gray-400 p-3 w-24 text-center text-black">Оценка</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($entries)): ?>
            <?php foreach ($entries as $entry): ?>
                <?php if (!empty($entry)): ?>
                    <tr class="hover:bg-gray-50 print:hover:bg-transparent">
                        <td class="border border-gray-400 p-3 text-center">
                            <?= date('d.m.Y', strtotime($entry->date)) ?>
                        </td>
                        <td class="border border-gray-400 p-3 text-left leading-relaxed">
                            <?= htmlspecialchars($entry->content) ?>
                        </td>
                        <td class="border border-gray-400 p-3 text-center font-medium">
                            <?= $entry->hours ?> ч.
                        </td>
                        <td class="border border-gray-400 p-3 text-center font-bold text-teal-700 print:text-black">
                            <?= ($entry->grade !== null && $entry->grade !== '') ? $entry->grade : '—' ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <!-- ЕДИНАЯ ИТОГОВАЯ СТРОКА В КОНЦЕ ТАБЛИЦЫ -->
            <tr class="bg-gray-50 font-semibold print:bg-transparent">
                <td colspan="2" class="border border-gray-400 p-3 text-right text-gray-900">
                    Итого (Выполнено часов / Средний балл):
                </td>
                <td class="border border-gray-400 p-3 text-center text-gray-900 font-bold">
                    <?= $totalHours ?> из <?= $requiredHours ?> ч.
                </td>
                <td class="border border-gray-400 p-3 text-center text-teal-800 print:text-black text-base font-bold">
                    <?= $averageGrade !== null ? $averageGrade : '—' ?>
                </td>
            </tr>
            
        <?php else: ?>
            <tr>
                <td colspan="4" class="border border-gray-400 p-4 text-center text-gray-500">
                    Записи в дневнике отсутствуют.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- ЭКРАННЫЕ ПРЕДУПРЕЖДЕНИЯ (СКРЫТЫ ПРИ ПЕЧАТИ) -->
    <?php if (!$hoursRequirementMet && !empty($entries)): ?>
        <div class="mt-4 p-3 bg-red-50 text-red-700 text-sm font-medium rounded border border-red-200 print:hidden">
            ⚠️ Итоговый балл заблокирован: суммарно в дневнике отработано <?= $totalHours ?> ч. из требуемых <?= $requiredHours ?> ч. по плану.
        </div>
    <?php elseif (!$allGradesFilled && !empty($entries)): ?>
        <div class="mt-4 p-3 bg-amber-50 text-amber-800 text-sm font-medium rounded border border-amber-200 print:hidden">
            ⚠️ Итоговый балл заблокирован: обнаружены пропущенные ячейки с оценками.
        </div>
    <?php endif; ?>

    <div class="mt-12 flex justify-between text-sm">
        <div>Студент: ___________________</div>
        <div>Руководитель: ___________________</div>
    </div>
</div>

<style>
    @media print {
        .print-hide {
            display: none;
        }
        table, th, td, div, span {
            color: #000000 !important;
            border-color: #000000 !important;
        }
    }
</style>