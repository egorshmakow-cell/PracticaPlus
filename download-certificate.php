<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $report app\models\Reports */

$cacheBuster = '?t=' . time();
$src = Yii::$app->request->hostInfo . '/' . $report->document_path . $cacheBuster;
$officeUrl = "https://view.officeapps.live.com/op/view.aspx?src=" . urlencode($src);
$downloadUrl = $src;
$userRole = Yii::$app->user->identity->role ?? null;
$isSupervisor = ($userRole === 'supervisor');
?>
<div class="container max-w-3xl mx-auto py-8">
    <div class="mb-4">
        <?php if ($report->status == 'ready'): ?>
            <span class="bg-green-100 text-green-800 text-sm font-semibold mr-2 px-3 py-1 rounded-full border border-green-300">
                Статус: Готов к печати (Редактирование закрыто)
            </span>
        <?php else: ?>
            <span class="bg-yellow-100 text-yellow-800 text-sm font-semibold mr-2 px-3 py-1 rounded-full border border-yellow-300">
                Статус: Черновик (Разрешено редактирование)
            </span>
        <?php endif; ?>
    </div>
    
    <?php if ($report->status != 'ready'): ?>
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl mb-6 shadow-sm">
            <h2 class="text-lg font-semibold text-blue-900 mb-2">
                <?= $isSupervisor ? 'Панель руководителя:' : 'Панель студента:' ?>
            </h2>
            <p class="text-sm text-blue-800 mb-4">
                Скачайте файл, внесите правки и загрузите новую версию. 
                <?php if (!$isSupervisor): ?>
                    Вы можете сохранять документ только в качестве черновика.
                <?php else: ?>
                    Вы можете сохранить документ как черновик или окончательно утвердить его для печати.
                <?php endif; ?>
            </p>
    
            <!-- Форма отправляет данные на ваш actionUploads($id) -->
            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'action' => ['uploads', 'id' => $report->id] // Название вашего экшена: uploads
            ]) ?>
                <div class="mb-4">
                    <?= $form->field($report, 'document_path')->fileInput([
                        'class' => 'block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100',
                        'required' => true
                    ])->label(false) ?>
                </div>

                <!-- Две разные кнопки submit с именами для контроллера -->
                <div class="flex flex-wrap gap-3">
                    <!-- Эта кнопка доступна ВСЕМ (и студенту, и руководителю) -->
                    <button type="submit" name="save_draft" value="1" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-md text-sm transition-colors shadow">
                        Сохранить как черновик
                    </button>
                    
                    <!-- Эта кнопка отображается ТОЛЬКО руководителю -->
                    <?php if ($isSupervisor): ?>
                        <button type="submit" name="save_final" value="1" onclick="return confirm('Вы уверены, что хотите утвердить документ? Студент больше не сможет вносить правки.');" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm transition-colors shadow">
                            Утвердить: "Готов к печати"
                        </button>
                    <?php endif; ?>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    <?php else: ?>
        <div class="bg-green-50 border border-green-200 p-6 rounded-xl mb-6 text-green-800 text-sm shadow-sm">
            <strong>Документ успешно утвержден руководителем!</strong> Изменения больше не принимаются. Скачайте финальную версию для печати.
        </div>
    <?php endif; ?>
    
    <div class="flex flex-col md:flex-row md:justify-between mb-4 gap-2 items-center">
        <h1 class="text-2xl font-bold text-gray-800"><?= Html::encode($report->report_title) ?></h1>
        <a href="<?= $downloadUrl ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm transition-colors shadow">
            Скачать текущую версию
        </a>
    </div>
    
    <div class="border rounded-xl overflow-hidden shadow-md bg-white">
       <iframe src="<?= $officeUrl ?>" width="100%" height="800px" class="w-full h-[800px] border-0" allowfullscreen></iframe>
    </div>
</div>