<?php
namespace app\controllers;

use app\models\StudentAssignments;
use Yii;
use yii\web\Controller;
use app\models\Practices;
use yii\web\NotFoundHttpException;

class PracticeController extends Controller
{
    public function actionView($id)
    {
        $model = Practices::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Практика не найдена');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionPrintSummary($id)
    {
        $model = StudentAssignments::find()->all();

        // Передача данных в представление для отображения или печати
        return $this->render('print-summary', [
            'model' => $model,
        ]);
    }

    public function actionDownloadPdf($id) {
        $model = StudentAssignments::findOne($id);
        $html = $this->renderPartial('print-summary', ['model' => $model]);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output("Attestat_{$model->id}.pdf", 'D'); // 'D' — принудительное скачивание
    }


}