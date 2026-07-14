<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $assignment app\models\StudentAssignments */
/* @var $reports app\models\Reports[] */

$this->title = 'Документы по практике';
// Получаем ровно те же шаблоны, что и в карточке практики
$templates = $assignment->practice->documentTemplates ?? [];
$currentUser = Yii::$app->user->identity;
?>
<div class="container max-w-7xl mx-auto px-4 py-2 flex flex-col">
    <div>
        <ol class="inline-flex items-center space-x-1 md:space-x-2 mb-4">
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
                Документы по практике
            </li>
        </ol>
    </div>
    <div class="flex flex-col mb-6 space-y-4">
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-2 w-full flex items-center justify-between font-sans">
         <h1 class="text-3xl font-semibold mb-2">
             Отчётность (<?= Html::encode($assignment->practice->title) ?>) (<?= $assignment->student ? Html::encode($assignment->student->user->name . ' ' . $assignment->student->user->surname) : 'Студент не найден' ?>)
         </h1>
     </div>
</div>

    <div class="mt-1 w-full">
        <div class="w-full overflow-x-auto max-w-full inline-block">
            <?php if (empty($templates)): ?>
                <div class="bg-blue-100 p-4 rounded-xl text-gray-700 text-sm">
                    Шаблоны документов для этой практики еще не загружены администратором.
                </div>
            <?php else: ?>
                <div class="bg-blue-200 rounded-xl overflow-hidden shadow-sm text-xs">
                    <table class="w-full table-auto bg-blue-500/80 rounded-xl overflow-hidden text-xs">
                        <thead class="text-white text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-2 md:px-6 py-4 text-left font-semibold text-xs md:text-sm">Наименование</th>
                            <th class="px-2 md:px-6 py-4 text-center font-semibold text-xs md:text-sm">Шаблоны</th>
                            <th class="px-2 md:px-6 py-4 text-center font-semibold text-xs md:text-sm">Текущий документ</th>
                            <th class="px-2 md:px-6 py-4 text-center font-semibold text-xs md:text-sm">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($templates as $template): ?>
                            <?php 
                            // Ищем сданную работу по совпадению названия (из массива отчетов, индексированного по report_title)
                            $report = $reports[$template->name] ?? null; 
                            ?>
                            <tr class="odd:bg-white even:bg-blue-100 transition-colors">
                                
                                <!-- 1. Наименование (Ровно то же, что и в карточке) -->
                                <td class="border-gray-200 px-2 md:px-5 py-2 text-left font-medium text-gray-800 text-xs md:text-sm align-middle break-words max-w-[120px] md:max-w-none">
                                    <?= Html::encode($template->name) ?>
                                </td>
                                
                                <!-- 2. Ссылка на файл шаблона администратора (Ровно та же ссылка, что и в карточке) -->
                                <td class="border-gray-200 px-2 md:px-5 py-2 text-center text-xs md:text-sm align-middle">
                                    <?php if (!empty($template->file_path)): ?>
                                        <?= Html::a('Скачать шаблон', Url::to('@web/' . $template->file_path), [
                                            'class' => 'text-blue-500 underline hover:text-blue-700 font-medium',
                                            'target' => '_blank',
                                            'download' => true
                                        ]) ?>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Нет шаблона</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- 3. Текущий документ студента (Связанная работа из ready-documents) -->
                                <td class="border-gray-200 px-5 py-2 text-center whitespace-nowrap text-sm align-middle">
                                    <div class="flex items-center justify-center h-full w-full">
                                        <?php if ($report && !empty($report->document_path) && $report->status === 'ready'): ?>
                                            <?= Html::a('Скачать работу', Url::to('@web/' . $report->document_path), [
                                                'class' => 'text-green-600 hover:text-green-800 font-medium underline flex items-center justify-center gap-1',
                                                'download' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <span class="text-amber-600 font-medium bg-amber-50 px-3 py-1 rounded-md border border-amber-200 text-center inline-block">Не сдано</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <!-- 4. Действия (Форма отправки привязывается к имени шаблона) -->
                                <td class="border-gray-200 px-5 py-2 text-center whitespace-nowrap align-middle">
                                    <div class="flex flex-wrap items-center justify-center gap-2 py-1">
                                        <!-- Кнопка Печать -->
                                        <?php if ($report && $report->status === 'ready'): ?>
                                            <?= Html::a('Печать', ['print', 'id' => $report->id], [
                                                'class' => 'bg-green-500 hover:bg-green-300 text-white py-1 px-2 md:py-1.5 md:px-3 rounded-lg text-center text-[11px] md:text-sm font-medium shadow-sm transition-colors min-w-0 sm:min-w-[80px]',
                                                'target' => '_blank',
                                            ]) ?>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white py-1.5 px-3 rounded-lg cursor-not-allowed font-medium min-w-[80px]" disabled>
                                                Печать
                                            </button>
                                        <?php endif; ?>
                                        
                                        <!-- Кнопка Скачать -->
                                        <?php if ($report && !empty($report->document_path) && $report->status === 'ready'): ?>
                                            <?= Html::a('Скачать', Url::to('@web/' . $report->document_path), [
                                                'class' => 'bg-blue-500 hover:bg-blue-300 text-white py-1.5 px-3 rounded-lg text-center font-medium shadow-sm transition-colors min-w-[80px]',
                                                'download' => true
                                            ]) ?>
                                        <?php endif; ?>

                                        <!-- Форма асинхронной загрузки -->
                                        <?= Html::beginForm(['reports/uploads', 'assignment_id' => $assignment->id], 'post', [
                                            'enctype' => 'multipart/form-data', 
                                            'class' => 'inline-block m-0 p-0'
                                        ]) ?>
                                            <!-- Передаем имя шаблона, чтобы бэкенд записал его в report_title -->
                                            <?= Html::hiddenInput('report_title', $template->name) ?>
                                           <label class="bg-blue-500 hover:bg-blue-300 text-white py-1 px-2 md:py-1.5 md:px-4 rounded-lg cursor-pointer inline-block text-center text-[11px] md:text-sm font-medium shadow-sm transition-colors min-w-0 sm:min-w-[150px]">
                                                <span><?= ($report && $report->status === 'ready') ? 'Пересдать работу' : 'Загрузить документ' ?></span>
                                                <input type="file" name="student_file" class="hidden" onchange="this.form.submit()">
                                            </label>
                                        <?= Html::endForm() ?>
                                        
                                        <!-- Кнопка Удалить -->
                                        <?php if ($report && !empty($report->document_path)): ?>
                                            <?= Html::a('Удалить', ['delete', 'id' => $report->id], [
                                                'class' => 'bg-red-500 hover:bg-red-300 text-white py-1.5 px-3 rounded-lg text-center font-medium shadow-sm transition-colors min-w-[80px]',
                                                'data' => [
                                                    'confirm' => 'Удалить вашу загруженную работу?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
