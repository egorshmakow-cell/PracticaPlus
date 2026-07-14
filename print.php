<?php
$src = Yii::$app->request->hostInfo . Yii::$app->request->baseUrl . '/uploads/reports/' . $file;
$officeUrl = "https://view.officeapps.live.com/op/view.aspx?src=" . urlencode($src);
?>
<div class="bg-white p-6 rounded-lg shadow max-w-4xl mx-auto">
    <h3 class="text-xl font-semibold mb-4">Просмотр документа</h3>
    <iframe src="<?= $officeUrl ?>" width="100%" height="600px" frameborder="0"></iframe>
</div>