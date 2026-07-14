<?php
namespace app\controllers;

use app\models\StudentAssignments;
use Mpdf\Mpdf;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class StudentAssignmentsController extends Controller
{
    public function actionDownloadCertificate($id)
    {
        // 1. Извлекаем модель распределения со всеми связями из БД
        $model = StudentAssignments::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Запись не найдена.');
        }
    
        // остальные проверки и логика
        if (Yii::$app->user->identity->role !== 'supervisor' && Yii::$app->user->identity->id !== $model->supervisor_id) {
            throw new ForbiddenHttpException('У вас нет прав для генерации данного документа.');
        }
    
        if ($model->status === 'draft') {
            $model->final_grade = $model->getAverageGrade();
            $model->status = 'completed';
            $model->save(false);
        }
    
        $htmlContent = $this->renderPartial('download-certificate', [
            'model' => $model
        ]);
    
        try {
            // создание pdf
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 20,
                'margin_bottom' => 20,
            ]);
            $mpdf->allow_charset_conversion = true;
            $mpdf->charset_in = 'utf-8';
            $mpdf->SetTitle('Аттестационный лист - ' . $model->student->user->surname);
            $mpdf->WriteHTML($htmlContent);
    
            $filename = "Attestat_Лист_" . $model->student->user->surname . ".pdf";
            return $mpdf->Output($filename, 'D');
    
        } catch (\Mpdf\MpdfException $e) {
            Yii::$app->session->setFlash('error', 'Ошибка при генерации PDF: ' . $e->getMessage());
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('download-certificate', [
            'model' => $model,
        ]);
    }
}