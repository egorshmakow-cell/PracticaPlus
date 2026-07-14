<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\StudentDocuments $model */

$this->title = Yii::t('app', 'Создать документы студента');
?>
<div class="student-documents-create max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md mt-4">

    <h1 class="text-2xl mb-4" style="margin-top: 20px"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
