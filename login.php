<?php
/** @var $this yii\web\View */
/** @var $model app\models\StudentAssignments */

use yii\helpers\Html;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Аттестационный лист - <?= Html::encode($model->student->user->surname) ?></title>
    <style>
        body {
            font-family: "Times New Roman", sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
        }
        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            width: 45%;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Аттестационный лист</h1>

<div class="section-title">Информация о студенте:</div>
<table>
    <tr>
        <th>Фамилия</th>
        <td><?= Html::encode($model->student->user->surname) ?></td>
    </tr>
    <tr>
        <th>Имя</th>
        <td><?= Html::encode($model->student->user->name) ?></td>
    </tr>
    <tr>
        <th>Отчество</th>
        <td><?= Html::encode($model->student->user->patronymic) ?></td>
    </tr>
    <tr>
        <th>Группа</th>
        <td><?= Html::encode($model->group->group_name) ?></td>
    </tr>
    <tr>
        <th>Общее количество отработанных часов</th>
        <td><?= Html::encode($model->completed_hours) ?></td>
    </tr>
    <tr>
        <th>Оценка</th>
        <td><?= Html::encode($model->final_grade !== null ? $model->final_grade : 'Еще не выставлена') ?></td>
    </tr>
    <tr>
        <th>Статус практики</th>
        <td><?= Html::encode($model->status) ?></td>
    </tr>
</table>

<div class="section-title">Информация о руководителе:</div>
<table>
    <tr>
        <th>Фамилия</th>
        <td><?= Html::encode($model->supervisor->user->surname) ?? 'Не указан' ?></td>
    </tr>
    <tr>
        <th>Имя</th>
        <td><?= Html::encode($model->supervisor->user->name) ?? 'Не указан' ?></td>
    </tr>
    <tr>
        <th>Отчество</th>
        <td><?= Html::encode($model->supervisor->user->patronymic) ?? 'Не указан' ?></td>
    </tr>
</table>

<div class="section-title">Дополнительная информация:</div>
<p>Дата формирования листа: <?= date('d.m.Y') ?></p>

<div class="footer">
    <div class="signature">
        <div>
            ________________<br>
            Подпись руководителя
        </div>
        <div>
            ________________<br>
            Печать/подпись студента
        </div>
    </div>
</div>

</body>
</html>