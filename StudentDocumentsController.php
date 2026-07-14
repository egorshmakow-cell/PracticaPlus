<?php
namespace app\modules\admin\controllers;

use Yii;
use app\models\DocumentTemplates;
use app\models\DocumentTemplatesForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class TemplatesController extends Controller
{
    public $layout = 'admin';
    
    public function actionIndex()
    {
        $query = DocumentTemplates::find()->joinWith(['practice']);
        
        $sortAttribute = Yii::$app->request->get('sort', 'id'); 
        $order = Yii::$app->request->get('order', 'ASC');
        
        $sortableFields = [
            'practice_title' => 'practices.title',
            'name'           => 'document_templates.name',
        ];

        if (isset($sortableFields[$sortAttribute])) {
            $query->orderBy([$sortableFields[$sortAttribute] => $order === 'DESC' ? SORT_DESC : SORT_ASC]);
        }
        
        $models = $query->all();
        
        return $this->render('index', [
            'models' => $models,
            'sortAttribute' => $sortAttribute,
            'order' => $order,
        ]);
    }

    public function actionCreate()
    {
        $model = new DocumentTemplatesForm();
        $practices = \yii\helpers\ArrayHelper::map(\app\models\Practices::find()->all(), 'id', 'title');
    
        if ($model->load(Yii::$app->request->post())) {
            // Привязываем загруженный файл к свойству формы BEFORE валидации
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file_path');
    
            // Валидируем форму (включая проверку расширения файла и его размера)
            if ($model->validate()) {
                $template = new \app\models\DocumentTemplates();
                $template->practice_id = $model->practice_id;
                $template->name = $model->name;
                $template->description = $model->description;
                $template->created_by = Yii::$app->user->id;
    
                // Если файл прикреплен, обрабатываем его загрузку
                if ($model->file) {
                    $dir = 'uploads/templates/';
                    if (!is_dir($dir)) {
                        mkdir($dir, 0775, true);
                    }
    
                    $path = $dir . uniqid() . '_' . $model->file->name;
                    
                    if ($model->file->saveAs($path)) {
                        $template->file_path = $path;
                    }
                }
    
                // Сохраняем модель в базу данных
                if ($template->save(false)) { // false, так как форму мы уже провалидировали
                    Yii::$app->session->addFlash('success', 'Шаблон успешно создан и файл загружен.');
                    return $this->redirect(['index']);
                }
            }
            
            // Если валидация формы провалилась, выводим ошибки
            $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->getErrors(), 0));
            Yii::$app->session->addFlash('error', 'Ошибка валидации формы: ' . $errors);
        }
    
        return $this->render('create', [
            'model' => $model,
            'practices' => $practices,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = DocumentTemplates::findOne($id);
        $oldFilePath = $model->file_path;

        if ($model->load(Yii::$app->request->post())) {
            $uploadedFile = UploadedFile::getInstance($model, 'file_path');
            if ($uploadedFile) {
                $path = 'uploads/templates/' . uniqid() . '_' . $uploadedFile->name;
                if ($uploadedFile->saveAs($path)) {
                    $model->file_path = $path;
                }
            } else {
                // оставить старый файл, если новый не загружен
                $model->file_path = $oldFilePath;
            }

            if ($model->save()) {
                Yii::$app->session->addFlash('success', 'Отчёт обновлен.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->addFlash('error', 'Ошибка при обновлении отчёта.');
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = DocumentTemplates::findOne($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Шаблон удалён.');
        }
        return $this->redirect(['index']);
    }
    
    public function actionTemplateView($id)
    {
        $templates = DocumentTemplates::findOne($id);
        if (!$templates || !$templates->file_path) {
            throw new NotFoundHttpException('Документ не найден.');
        }
        return $this->render('template-view', ['templates' => $templates]);
    }

}