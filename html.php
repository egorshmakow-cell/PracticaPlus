<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\ReportFeedback;
use app\models\Reports;
use yii\filters\AccessControl;

class FeedbackController extends Controller
{
    public function actionIndex()
    {
        $supervisorId = Yii::$app->user->id;

        // Получить отчеты текущего студента
        $reports = Reports::find()->where(['assignment_id' => $supervisorId])->select('id')->column();

        // Получить отзывы на эти отчеты
        $feedbacks = ReportFeedback::find()
            ->where(['report_id' => $reports])
            ->with(['report', 'reviewer'])
            ->orderBy(['feedback_date' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'feedbacks' => $feedbacks,
        ]);
    }

    public function actionCreate()
    {
        $model = new ReportFeedback();
        $model->feedback_date = date('Y-m-d'); // дата по умолчанию — сегодня

        // Предполагаем, что пользователь — руководитель (reviewer)
        $model->reviewer_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->addFlash('success', 'Отзыв успешно добавлен.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->addFlash('error', 'Ошибка при сохранении отзыва.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = ReportFeedback::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Обратная связь сохранена.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('view', ['model' => $model]);
    }
}