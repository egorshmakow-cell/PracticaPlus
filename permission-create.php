<?php
use yii\helpers\Html;

/* @var $templates app\models\DocumentTemplates */

// Добавляем таймстамп для предотвращения кеширования
$cacheBuster = '?t=' . time();

// Полный путь к документу с учетом кешбастера
$src = Yii::$app->request->hostInfo . '/' . $templates->file_path . $cacheBuster;

// URL для просмотра документа через Office Online
$officeUrl = "https://view.officeapps.live.com/op/view.aspx?src=" . urlencode($src);

$downloadUrl = $src;
?>
<div class="mb-4">
    <?= Html::a(
        '← Назад', 
        ['/admin/templates'], 
        ['class' => 'inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors']
    ) ?>
</div>
<div class="container max-w-3xl mx-auto py-8">
    <div class="flex flex-col md:flex-row md:justify-between mb-4 gap-2">
        <a href="<?= $downloadUrl ?>" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Скачать документ
        </a>
        <!-- Можно добавить кнопку для редактирования, если файл хранится онлайн -->
        <!-- Например, ссылка на облачный редактор, если поддерживается -->
    </div>
    
    <h1 class="text-2xl font-bold mb-6"><?= Html::encode($templates->name) ?></h1>
    <div class="border rounded-xl overflow-hidden">
       <iframe
            src="<?= $officeUrl ?>"
            width="100%"
            height="800px"
            class="w-full h-[800px] border-0"
            allowfullscreen>
       </iframe>
    </div>
</div>