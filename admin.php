<?php

use yii\helpers\Html;
use yii\helpers\Url;
/** @var $models app\models\DocumentTemplates */
/** @var $sortAttribute string */
/** @var $order string */

function renderExternalSortButton($attribute, $label, $currentSort, $currentOrder) {
    $isCurrent = ($currentSort === $attribute);
    $nextOrder = ($isCurrent && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
    
    // Динамические стили: активная кнопка темнее
    $baseClass = "px-3 py-1.5 rounded-lg text-xs font-medium border transition-colors ";
    if ($isCurrent) {
        $baseClass .= "bg-blue-700 text-white border-blue-700";
        $arrow = $currentOrder === 'ASC' ? ' ↑' : ' ↓';
    } else {
        $baseClass .= "bg-white text-blue-600 border-blue-500 hover:bg-blue-50";
        $arrow = '';
    }

    return Html::a(
        Html::encode($label) . $arrow, 
        Url::to(['', 'sort' => $attribute, 'order' => $nextOrder]), 
        ['class' => $baseClass]
    );
}

$this->title = 'Шаблоны отчетов и форм';

?>
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-2 w-full flex items-center justify-between">
        <h1 class="text-2xl font-semibold mb-0"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="/web/admin/user" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Пользователи</a>
        <a href="/web/admin/students" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Студенты</a>
        <a href="/web/admin/practices" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Практики</a>
        <a href="/web/admin/groups" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Группы</a>
        <a href="/web/admin/templates" class="w-36 bg-green-500 text-white py-2 px-5 rounded-lg text-sm text-center">Шаблоны</a>
        <a href="/web/admin/supervisors" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Руководители</a>
        <a href="/web/admin/student-assignments" class="w-36 bg-blue-500 text-white hover:bg-blue-300 py-2 px-5 rounded-lg text-sm text-center">Назначение</a>
    </div>
<div class="flex flex-wrap items-center justify-start gap-4 mt-4">
    <!-- Кнопка добавления -->
    <?= Html::a('Добавить шаблон', ['create'], ['class' => 'inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-300', 'style' => 'font-size: 14px']) ?>
    
    <!-- Выпадающее меню сортировки -->
    <div class="relative inline-block text-left">
        <!-- Кнопка сортировки -->
        <button type="button" onclick="document.getElementById('sort-dropdown').classList.toggle('hidden')" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
            </svg>
            Сортировка
            <?php 
                // Выводим индикатор направления у главной кнопки в зависимости от того, какое поле выбрано
                if ($sortAttribute === 'practice_title') {
                    echo $order === 'ASC' ? ' (↑)' : ' (↓)';
                } elseif ($sortAttribute === 'name') {
                    echo $order === 'ASC' ? ' (↑)' : ' (↓)';
                }
            ?>
        </button>
    
        <!-- Выпадающее меню -->
        <div id="sort-dropdown" class="hidden absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
            <div class="py-1">
                <?php
                    // 1. ПУНКТ: Наименование практики
                    $isPractice = ($sortAttribute === 'practice_title');
                    $nextPracticeOrder = ($isPractice && $order === 'ASC') ? 'DESC' : 'ASC';
                    $practiceArrow = $isPractice ? ($order === 'ASC' ? ' ↑' : ' ↓') : '';
                    $practiceClass = 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100' . ($isPractice ? ' font-bold bg-blue-50' : '');

                    echo Html::a(
                        'Наименование практики' . $practiceArrow, 
                        Url::to(['', 'sort' => 'practice_title', 'order' => $nextPracticeOrder]), 
                        ['class' => $practiceClass]
                    );

                    // 2. ПУНКТ: Название шаблона (document_templates.name)
                    $isName = ($sortAttribute === 'name');
                    $nextNameOrder = ($isName && $order === 'ASC') ? 'DESC' : 'ASC';
                    $nameArrow = $isName ? ($order === 'ASC' ? ' ↑' : ' ↓') : '';
                    $nameClass = 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100' . ($isName ? ' font-bold bg-blue-50' : '');

                    echo Html::a(
                        'Название шаблона' . $nameArrow, 
                        Url::to(['', 'sort' => 'name', 'order' => $nextNameOrder]), 
                        ['class' => $nameClass]
                    );
                ?>
            </div>
        </div>
    </div>
</div>

<div class="overflow-x-auto rounded-xl shadow-sm border border-blue-300/30 w-full mt-2">
        <table class="min-w-full bg-blue-400 border-collapse table-auto text-xs tracking-wide align-middle m-0">
            <thead class="text-white bg-blue-500/80 uppercase tracking-wider text-[11px] font-bold h-12">
            <tr>
                <th class="px-5 py-4 text-left">Практика</th>
                <th class="px-5 py-4 text-left">Название</th>
                <th class="px-5 py-4 text-left whitespace-nowrap w-1/3">Описание</th>
                <th class="px-5 py-4 text-center whitespace-nowrap w-1/6">Файл</th>
                <th class="px-4 py-4 text-center whitespace-nowrap w-1/5">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $model): ?>
                <tr class="odd:bg-white even:bg-blue-100 hover:bg-blue-50/40 transition-colors">
                    
                    <!-- 2. Практика (выровнена по левому краю) -->
                    <td class="px-5 py-3 text-left font-semibold text-gray-800 text-sm align-middle leading-tight"><?= Html::encode($model->practice->title ?? '') ?></td>
                    
                    <!-- 3. Название шаблона (выровнено по левому краю) -->
                    <td class="px-5 py-3 text-left font-medium text-gray-700 text-sm align-middle leading-tight"><?= Html::encode($model->name) ?></td>
                    
                    <!-- 4. Описание (выровнено по левому краю) -->
                    <td class="px-5 py-3 text-left font-normal text-gray-600 text-sm align-middle leading-normal"><?= Html::encode($model->description) ?></td>
                    
                    <!-- 5. Ссылка на файл (центрирована) -->
                    <td class="px-5 py-3 text-center whitespace-nowrap text-sm align-middle">
                        <?php if ($model->file_path): ?>
                            <?= Html::a('Открыть шаблон', ['template-view', 'id' => $model->id], [
                                'class' => 'text-blue-500 underline hover:text-blue-700 font-semibold',
                                'target' => '_blank'
                            ]) ?>
                        <?php else: ?>
                            <span class="text-gray-400 italic">Файл не загружен</span>
                        <?php endif; ?>
                    </td>
                    
                    <!-- 6. Кнопки действий (идеально отцентрированы и выровнены по размеру) -->
                    <td class="px-4 py-3 text-center whitespace-nowrap align-middle">
                        <div class="flex items-center justify-center gap-1.5 py-1">
                            <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                                'class' => 'inline-flex items-center justify-center text-xs font-semibold px-3 h-7 rounded-lg border border-[#2B7FFF] text-[#2B7FFF] bg-white hover:bg-[#2B7FFF] hover:text-white transition-all shadow-sm min-w-[110px]'
                            ]) ?>
                            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                                'class' => 'inline-flex items-center justify-center text-xs font-semibold px-3 h-7 rounded-lg border border-[#FF3B30] text-[#FF3B30] bg-white hover:bg-[#FF3B30] hover:text-white transition-all shadow-sm min-w-[70px]',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить этот шаблон?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
