<?php
namespace app\controllers;

use app\models\Practices;
use app\models\StudentAssignments;
use app\models\ReportsForm;
use Yii;
use app\models\Reports;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ReportsController extends Controller
{
    // Показываем список отчетов студента (или по практике)
    public function actionIndex($id)
    {
        $assignmentId = $id;

        $assignment = StudentAssignments::find()
            ->where(['student_assignments.id' => $assignmentId])
            ->joinWith(['student.user'])
            ->one();
    
        if (!$assignment) {
            throw new NotFoundHttpException('Назначение практики не найдено.');
        }
    
        // Получаем все отчеты, привязанные к этой практике
        $reports = Reports::find()
            ->where(['assignment_id' => $assignmentId])
            ->all();
    
        // Обработка формы проверки от руководителя
        if (Yii::$app->request->isPost) {
            $reportId = Yii::$app->request->post('report_id');
            $status = Yii::$app->request->post('status');
            $comment = Yii::$app->request->post('comment');
    
            $report = Reports::findOne($reportId);
            if ($report && $report->assignment_id == $assignmentId) {
                $report->status = $status;
                
                // Если в вашей таблице reports есть поле для комментариев
                if (property_exists($report, 'comment')) {
                    $report->comment = $comment;
                }
                
                if ($report->save(false)) {
                    Yii::$app->session->setFlash('success', 'Статус документа успешно обновлен.');
                    // Исправлено: перенаправляем на текущий экшен 'index' с правильным параметром 'id'
                    return $this->redirect(['index', 'id' => $assignmentId]);
                }
            }
        }
    
        return $this->render('index', [
            'assignment' => $assignment,
            'reports' => $reports,
        ]);
    }

    // Создание нового документа для отчета
   public function actionCreate()
    {
        $model = new ReportsForm();
    
        if ($model->load(Yii::$app->request->post())) {
            // Привязываем загруженный файл к свойству формы BEFORE валидации
            $model->file = \yii\web\UploadedFile::getInstance($model, 'document_path');
    
            // Валидируем форму (включая проверку расширения файла и его размера)
            if ($model->validate()) {
                $report = new Reports();
                $report->assignment_id = Yii::$app->user->id;
                $report->report_title = $model->report_title;
                $report->submission_date = date('Y-m-d H:i:s'); 
    
                // Если файл прикреплен, обрабатываем его загрузку
                if ($model->file) {
                    $dir = 'uploads/reports/';
                    if (!is_dir($dir)) {
                        mkdir($dir, 0775, true);
                    }
    
                    $path = $dir . uniqid() . '_' . $model->file->name;
                    
                    if ($model->file->saveAs($path)) {
                        $report->document_path = $path; 
                    }
                }
    
                if ($report->save(false)) { 
                    Yii::$app->session->addFlash('success', 'Документ успешно создан и файл загружен.');
                    return $this->redirect(['index']);
                }
            }
            
            // Если валидация формы провалилась, выводим ошибки
            $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
            Yii::$app->session->addFlash('error', 'Ошибка валидации формы: ' . $errors);
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Действие для редактирования отчета
    public function actionUpdate($id)
    {
        // Получаем существующую модель отчёта из базы
        $report = Reports::findOne($id);
        if (!$report) {
            throw new NotFoundHttpException('Отчёт не найден.');
        }

        // Создаём форму отчёта и заполняем её данными из модели
        $model = new ReportsForm();

        // Перед загрузкой данных — заполняем модель текущими данными
        if ($model->load(Yii::$app->request->post())) {
            // Получаем загруженный файл, если есть
            $model->file = UploadedFile::getInstance($model, 'file');

            // Если есть новый файл, загружаем и обновляем путь
            if ($model->file) {
                if ($model->upload()) {
                  unlink($report->document_path);
                } else {
                    // Не удалось загрузить файл — показываем ошибку
                    Yii::$app->session->setFlash('error', 'Не удалось загрузить файл.');
                    return $this->render('update', ['model' => $model]);
                }
            } else {
                // Если файл не загружен, оставляем старый путь
                $model->document_path = $report->document_path;
            }

            // Обновляем модель ActiveRecord
            $report->report_title = $model->report_title;
            $report->status = $model->status;
            $report->document_path = $model->document_path;
            $report->grade = $model->grade;

            if ($report->save()) {
                Yii::$app->session->setFlash('success', 'Отчёт успешно обновлён.');
                return $this->redirect(['view', 'id' => $report->id]);
            }
        } else {
            // Заполняем форму текущими данными из модели
            $model->report_title = $report->report_title;
            $model->status = $report->status;
            $model->document_path = $report->document_path;
            $model->grade = $report->grade;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Действие для удаления отчёта
    public function actionDelete($id, $type)
    {
        $model = StudentDocuments::findOne($id);
        if ($model) {
            $assignmentId = $model->assignment_id;
            $targetField = ($type === 'draft') ? 'draft_path' : 'document_path';

            if (!empty($model->$targetField) && file_exists(Yii::getAlias('@webroot/' . $model->$targetField))) {
                unlink(Yii::getAlias('@webroot/' . $model->$targetField));
            }

            $model->$targetField = null;
            $model->updated_at = date('Y-m-d H:i:s');

            if (empty($model->draft_path) && empty($model->document_path)) {
                $model->delete();
            } else {
                $model->save(false);
            }
            
            Yii::$app->session->setFlash('success', 'Файл удален.');
            return $this->redirect(['index', 'id' => $assignmentId]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionDownload($id)
    {
        $report = $this->findModel($id);

        if ($report && $report->document_path) {
            $filePath = Yii::getAlias('@webroot') . '/' . $report->document_path;

            if (file_exists($filePath)) {
                return Yii::$app->response->sendFile($filePath, $report->report_title . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
            } else {
                Yii::$app->session->setFlash('error', 'Файл не найден на сервере.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Отчет или путь к файлу не найдены.');
        }

        // Если произошла ошибка или файл не найден, перенаправляем обратно в список отчетов
        return $this->redirect(['index']); // Предполагается, что 'index' - это экшн, отображающий список отчетов
    }


    public function actionView($id)
    {
        $report = Reports::findOne($id);
        if (!$report || !$report->document_path) {
            throw new NotFoundHttpException('Документ не найден.');
        }
        return $this->render('view', ['report' => $report]);
    }

    // Вспомогательный метод для поиска модели
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрос не найден.');
    }

    public function actionUploads($id)
    {
        if (Yii::$app->request->isPost) {
            $model = Reports::findOne($id);
            if (!$model) {
                throw new NotFoundHttpException('Запись отчета не найдена.');
            }

            $file = UploadedFile::getInstanceByName('student_file');
            if ($file) {
                // Путь к папке чистовиков
                $directory = Yii::getAlias('@webroot/uploads/ready-documents/');
                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);
                }

                // Генерируем уникальное имя для работы студента
                $fileName = 'student_work_rep_' . $id . '_' . time() . '.' . $file->extension;

                // Удаляем старый файл студента, если он уже пересдает работу
                if (!empty($model->document_path) && file_exists(Yii::getAlias('@webroot/' . $model->document_path))) {
                    unlink(Yii::getAlias('@webroot/' . $model->document_path));
                }

                if ($file->saveAs($directory . $fileName)) {
                    // Перезаписываем путь к готовой работе студента и меняем статус
                    $model->document_path = 'uploads/ready-documents/' . $fileName;
                    $model->status = 'ready'; // Статус готовности для руководителя

                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Документ успешно сдан на проверку.');
                    }
                }
            }
        }

        // Возвращаем студента обратно на страницу отчетов
        $model = Reports::findOne($id);
        return $this->redirect(['index', 'id' => $model->assignment_id]);
    }
    
    public function actionPrint($id)
    {
        $report = $this->findModel($id);

        if ($report->status !== 'approved') {
            throw new ForbiddenHttpException('Документ не подтвержден для печати.');
        }

        // Можно либо показать сам документ, либо подготовить его для печати
        return $this->render('print', ['report' => $report]);
    }
    
    public function actionViewDocument($file)
    {
        $baseUrl = Yii::$app->request->hostInfo . Yii::$app->request->baseUrl . '/uploads/reports/' . $file;
        // Можно добавить проверку на существование файла и права доступа
    
        return $this->render('view-document', [
            'url' => $baseUrl,
            'file' => $file
        ]);
    }
    
    public function actionApprove($id)
    {
        $report = $this->findModel($id);
        if (Yii::$app->user->identity->role !== 'supervisor') {
            throw new ForbiddenHttpException('Доступ запрещен.');
        }

        if ($report->status === 'reviewed') {
            $report->status = 'approved';
            $report->save();
            Yii::$app->session->setFlash('success', 'Документ успешно принят.');
        }

        return $this->redirect(['reports/index']); // или ваш текущий рендер
    }
}