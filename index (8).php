<?php
/** @var $assignment app\models\StudentAssignments[] */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Мои практики';
?>

<section class="max-w-7xl mx-auto px-4 py-2 font-sans">
    <div>
    <ol class="inline-flex items-center space-x-1 md:space-x-2 mb-4">
        <li class="inline-flex items-center">
            <?= Html::a('Главная', ['/site/index'], ['class' => 'text-black hover:text-gray-500']) ?>
            <svg class="w-4 h-4 mx-1 text-black" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M7.05 3.05a.75.75 0 011.06 0l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.06-1.06L11.94 10 7.05 5.12a.75.75 0 010-1.06z"/>
            </svg>
        </li>
        <li class="inline-flex items-center text-black" aria-current="page">
            Мои практики
        </li>
    </ol>
    </div>
    <!-- Выровненный заголовок страницы в отдельном блоке -->
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6 w-full flex items-center justify-between font-sans">
        <h1 class="text-3xl font-semibold mb-2">
            <span><?= Html::encode($this->title) ?>:</span>
            <span class="text-blue-600 mb-2">
                <?= Html::encode(Yii::$app->user->identity->surname) ?> <?= Html::encode(Yii::$app->user->identity->name) ?> <?= Html::encode(Yii::$app->user->identity->patronymic) ?>
            </span>
        </h1>
    </div>

    <div class="grid md:grid-cols-1 gap-6 min-h-[300px] w-full px-2 font-sans">
        <div class="grid md:grid-cols-1 gap-6 w-full mx-auto">
            <div>

        <?php if (empty($assignment)): ?>
            <!-- Сообщение об отсутствии практик -->
            <div class="bg-white rounded-xl shadow p-8 text-center border border-gray-100 max-w-2xl mx-auto font-sans">
                <p class="text-gray-500 text-lg font-medium">Нет доступных практик в данный момент.</p>
            </div>
        <?php else: ?>
            <div class="flex flex-col w-full space-y-6">
                <?php foreach ($assignment as $item): ?>
                <?php
                $startDate = $item->practice->start_date;
                $endDate = $item->practice->end_date;
                $totalDays = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
                $progressPercent = 0;
                if ($totalDays > 0) {
                    $progressPercent = min(100, ($item->completed_hours / 160) * 100);
                }
                $progressPercent = round($progressPercent, 1);
                ?>
                    <!-- Карточка практики с информацией -->
                     <div class="flex flex-col lg:flex-row gap-6 w-full items-stretch font-sans">
                        <!-- Основной блок с описанием -->
                        <div class="bg-white rounded-xl shadow border border-gray-100 p-6 flex-1 flex flex-col justify-between min-w-0">
                            <div>
                                <!-- Название практики выровнено по центру строки -->
                                <h2 class="text-xl font-semibold mb-4">
                                    <?= Html::encode($item->practice->title) ?>
                                </h2>
                                <div class="space-y-2 text-sm text-gray-600 mb-4 font-normal tracking-wide">
                                    <p><span class="font-medium text-gray-400">Тип практики:</span> <?= Html::encode($item->practice->type) ?></p>
                                    <p><span class="font-medium text-gray-400">Начало:</span> <?= Yii::$app->formatter->asDate($item->practice->start_date, 'php:d.m.Y') ?></p>
                                    <p><span class="font-medium text-gray-400">Конец:</span> <?= Yii::$app->formatter->asDate($item->practice->end_date, 'php:d.m.Y') ?></p>
                                    <p>
                                        <span class="font-medium text-gray-400">Руководитель:</span> 
                                        <?= Html::encode($item->supervisor->user->surname ?? '') ?> 
                                        <?= Html::encode($item->supervisor->user->name ?? '') ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Индикатор прогресса -->
                            <div class="mt-4">
                                <div class="flex justify-between items-center mb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <span>Прогресс обучения</span>
                                    <span class="text-blue-600 font-bold"><?= $progressPercent ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                                    <div class="bg-green-600 h-2.5 rounded-full transition-all duration-500" style="width: <?= $progressPercent ?>%;"></div>
                                </div>
                            </div>
                            
                            <!-- Выровненные кнопки управления одинакового размера -->
                            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                                <a href="<?= Url::to(['/diary/index', 'assignment_id' => $item->id]) ?>"
                                   class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-xl text-center text-sm transition-colors shadow-sm h-[40px] flex items-center justify-center tracking-wide">
                                    Журнал практики
                                </a>
                                <a href="<?= Url::to(['/reports/index', 'id' => $item->id]) ?>"
                                   class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-xl text-center text-sm transition-colors shadow-sm h-[40px] flex items-center justify-center tracking-wide">
                                    Отчётность
                                </a>
                            </div>
                        </div>

                        <!-- Правая колонка "Информация" -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 lg:w-[320px] flex flex-col justify-start shrink-0">
                            <h3 class="text-base font-semibold mb-4">Информация</h3>
                            <div class="text-sm text-gray-600 leading-relaxed mb-4 font-normal tracking-wide">
                                <p><span class="font-medium text-gray-500 block mb-1">Цель практики:</span> <?= Html::encode($item->practice->description) ?></p>
                            </div>
                            
                            <!-- Блок скачивания шаблонов документов -->
                            <div class="mt-auto pt-3 border-t border-gray-200 w-full">
                                <h4 class="text-xs font-bold uppercase tracking-wider mb-2">Шаблоны документов:</h4>
                                <?php if (!empty($item->practice->documentTemplates)): ?>
                                    <ul class="space-y-2 w-full">
                                        <?php foreach ($item->practice->documentTemplates as $template): ?>
                                            <li class="flex items-center justify-between bg-white p-2 rounded border border-gray-100 shadow-sm text-xs h-[36px]">
                                                <span class="text-gray-700 truncate mr-2 font-medium align-middle tracking-wide" title="<?= Html::encode($template->name) ?>">
                                                    📄 <?= Html::encode($template->name) ?>
                                                </span>
                                                <?= Html::a('Скачать', Url::to('@web/' . $template->file_path), [
                                                    'class' => 'text-blue-500 hover:text-blue-700 font-bold underline shrink-0 align-middle tracking-wide',
                                                    'download' => true
                                                ]) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-xs text-gray-400 italic">Шаблоны документов не загружены.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
        </div>
    </div>
</section>