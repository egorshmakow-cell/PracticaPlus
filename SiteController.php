<?php
namespace app\controllers;

use Yii;
use app\models\StudentDocuments;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StudentDocumentsController extends Controller
{
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // 1. Если контент пуст, загружаем шаблон, делаем автозамену и создаем черновик
        if (empty($model->student_content) && !empty($model->template->file_path)) {
            $templatePath = Yii::getAlias('@webroot/uploads/templates/') . $model->template->file_path;
            
            if (file_exists($templatePath)) {
                $templateContent = file_get_contents($templatePath);
                
                // Автоматически заменяем метки в тексте шаблона на данные из БД
                $search = ['{student_name}', '{group}', '{supervisor_name}'];
                $replace = [
                    $model->studentUser->surname . ' ' . $model->studentUser->name,
                    $model->assignment->group->group_name ?? '',
                    $model->supervisorUser->surname . ' ' . $model->supervisorUser->name
                ];
                
                $model->student_content = str_replace($search, $replace, $templateContent);
                
                // 2. Создаем физический файл-черновик в папке draft
                $draftFolder = Yii::getAlias('@webroot/uploads/draft/');
                if (!is_dir($draftFolder)) {
                    mkdir($draftFolder, 0775, true); // Создаем папку, если её нет
                }
                
                // Генерируем уникальное имя файла для черновика
                $draftFileName = 'draft_' . $model->id . '_' . time() . '.txt'; // или расширение исходного шаблона
                $draftPath = $draftFolder . $draftFileName;
                
                // Сохраняем измененный текст в файл черновика
                if (file_put_contents($draftPath, $model->student_content) !== false) {
                    // Записываем путь к черновику в модель (предположим, у вас есть поле draft_path)
                    $model->draft_path = $draftFileName; 
                }
            }
        }
        
        $action = Yii::$app->request->post('action');
        
        // 3. Обработка сохранения изменений студентом
        if ($model->load(Yii::$app->request->post())) {
            if ($action === 'submit') {
                $model->status = 'submitted'; // Статус "Требует проверки"
            } else {
                $model->status = 'draft'; // Если просто сохраняет — статус "Черновик"
            }
            
            // Перезаписываем файл черновика актуальным текстом из формы
            if (!empty($model->draft_path)) {
                $draftPath = Yii::getAlias('@webroot/uploads/draft/') . $model->draft_path;
                file_put_contents($draftPath, $model->student_content);
            }
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Документ успешно сохранен.');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        
        return $this->render('update', ['model' => $model]);
    }
    
    public function actionReview($id)
    {
        $model = $this->findModel($id);
        if (empty($model->student_content) && !empty($model->draft_path)) {
            $draftPath = Yii::getAlias('@webroot/uploads/draft/') . $model->draft_path;
            if (file_exists($draftPath)) {
                $model->student_content = file_get_contents($draftPath);
            }
        }
        $statusAction = Yii::$app->request->post('status_action');
        
        if ($model->load(Yii::$app->request->post())) {
            if ($statusAction === 'approve') {
                $model->status = 'approved'; // "Готово к печати"
                $model->comment = null; // Очищаем прошлые замечания
                
                $readyFolder = Yii::getAlias('@webroot/uploads/ready-documents/');
                if (!is_dir($readyFolder)) {
                    mkdir($readyFolder, 0775, true); // Создаем папку, если её нет
                }
                
                $readyFileName = 'ready_' . $model->id . '_' . time() . '.txt'; // или расширение вашего шаблона
                $readyPath = $readyFolder . $readyFileName;
                
                if (file_put_contents($readyPath, $model->student_content) !== false) {
                    $model->document_path = $readyFileName;
                    
                    if (!empty($model->draft_path)) {
                        $oldDraftPath = Yii::getAlias('@webroot/uploads/draft/') . $model->draft_path;
                        if (file_exists($oldDraftPath)) {
                            unlink($oldDraftPath);
                        }
                        $model->draft_path = null; // Обнуляем ссылку на черновик
                    }
                }
            } elseif ($statusAction === 'reject') {
                $model->status = 'rejected'; // Статус "Требует изменений"
                
                // Если руководитель внес правки, но отклонил — сохраняем изменения обратно в файл черновика
                if (!empty($model->draft_path)) {
                    $draftPath = Yii::getAlias('@webroot/uploads/draft/') . $model->draft_path;
                    file_put_contents($draftPath, $model->student_content);
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Статус документа обновлен.');
                return $this->redirect(['review', 'id' => $model->id]);
            }
        }
        
        return $this->render('review', ['model' => $model]);
    }
    
    protected function findModel($id)
    {
        if (($model = StudentDocuments::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Документ не найден.');
    }
}