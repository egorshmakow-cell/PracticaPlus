<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model app\models\StudentDocuments */

// Проверяем, утвержден ли уже документ. Если да — редактирование и кнопки блокируются
$isApproved = ($model->status === 'approved');

// Настройка динамической ссылки для скачивания файла руководителем
$fileUrl = '#';
$fileExists = false;

if (!empty($model->document_path)) {
    $fileUrl = Yii::getAlias('@web/') . $model->document_path;
    $fileExists = file_exists(Yii::getAlias('@webroot/') . $model->document_path);
} elseif (!empty($model->draft_path)) {
    $fileUrl = Yii::getAlias('@web/') . $model->draft_path;
    $fileExists = file_exists(Yii::getAlias('@webroot/') . $model->draft_path);
}
?>
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <div class="mb-4">
        <?= Html::a(
            '← Назад', 
            ['/reports/index'], 
            ['class' => 'inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors']
        ) ?>
    </div>
    <h1 class="text-2xl font-bold mb-4">Проверка документа: <?= Html::encode($model->template->name) ?></h1>
    <p class="text-sm text-gray-600 mb-6">Студент: <?= Html::encode($model->studentUser->surname . ' ' . $model->studentUser->name) ?></p>
    
    <?php $form = ActiveForm::begin(); ?>
    <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-blue-50 rounded">
        <div>
            <label class="block text-sm font-medium text-blue-900">Проверяющий руководитель</label>
            <input type="text" 
                   value="<?= Html::encode(($model->supervisorUser->surname ?? '') . ' ' . ($model->supervisorUser->name ?? '')) ?>" 
                   class="mt-1 block w-full rounded-md border-blue-200 bg-blue-100 text-blue-800 cursor-not-allowed shadow-sm" readonly>
        </div>
        <div>
            <label class="block text-sm font-medium text-blue-900">Кафедра</label>
            <input type="text" 
                   value="<?= Html::encode($model->supervisorProfile->department ?? 'Не указана') ?>" 
                   class="mt-1 block w-full rounded-md border-blue-200 bg-blue-100 text-blue-800 cursor-not-allowed shadow-sm" readonly>
        </div>
    </div>
    
    <div class="mb-6">
        <?= $form->field($model, 'student_content')->textarea([
            'rows' => 12,
            'disabled' => $isApproved,
            'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 ' . 
                       ($isApproved ? 'bg-gray-100 cursor-not-allowed text-gray-500' : '')
        ])->label('Содержимое документа (Доступно для редактирования руководителем)') ?>
    </div>
    
    <div class="mb-6">
        <?= $form->field($model, 'comment')->textarea([
            'rows' => 3, 
            'disabled' => $isApproved,
            'placeholder' => 'Заполните в случае возврата на доработку...',
            'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 ' .
                       ($isApproved ? 'bg-gray-100 cursor-not-allowed text-gray-500' : '')
        ])->label('Замечания / Комментарий к проверке') ?>
    </div>
    
    <div class="mb-6">
        <?php if ($fileExists): ?>
            <a href="<?= $fileUrl ?>" 
               download
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900 transition-colors text-sm font-medium">
                📥 Скачать текущий файл (<?= $isApproved ? 'Из готовых' : 'Из черновиков' ?>)
            </a>
        <?php else: ?>
            <span class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-500 rounded text-sm font-medium">
                ⚠️ Файл черновика/готового документа еще не создан
            </span>
        <?php endif; ?>
    </div>
    
    <div class="flex justify-end space-x-3">
        <?php if (!$isApproved): ?>
            <?= Html::submitButton('Вернуть на доработку', [
                'name' => 'status_action', 
                'value' => 'reject', 
                'class' => 'px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors font-medium'
            ]) ?>
            <?= Html::submitButton('Одобрить (В готовые документы)', [
                'name' => 'status_action', 
                'value' => 'approve', 
                'class' => 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors font-medium'
            ]) ?>
        <?php else: ?>
            <div class="flex items-center space-x-3">
                <span class="text-green-600 font-medium flex items-center">
                    ✅ Документ утвержден и защищен от изменений
                </span>
                <button type="button" 
                        onclick="window.print()" 
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-semibold shadow transition-colors">
                    🖨 Распечатать
                </button>
            </div>
        <?php endif; ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>