<?php
/* @var $this yii\web\View */
/* @var $report app\models\Reports */

use yii\helpers\Html;

$this->title = 'Печать документа';

?>
<h1><?= Html::encode($report->report_title) ?></h1>
<p>Статус: <?= Html::encode($statusLabels[$report->status] ?? $report->status) ?></p>
<?php if ($report->document_path): ?>
    <iframe src="<?= Yii::$app->urlManager->createUrl(['view', 'id' => $report->id]) ?>" style="width:100%; height:800px; border:none;"></iframe>
<?php else: ?>
    <p>Файл не загружен.</p>
<?php endif; ?>
<button onclick="window.print()">Печать документа</button>