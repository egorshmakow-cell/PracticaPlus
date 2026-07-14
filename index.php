<?php

namespace app\modules\admin\controllers;

use app\models\Practices;
use app\models\PracticesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * PracticesController implements the CRUD actions for Practices model.
 */
class PracticesController extends Controller
{
    public $layout = 'admin';
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Practices models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PracticesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Practices model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Practices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $supervisors = \app\models\Supervisors::find()->innerJoinWith('user')->all();
        $supervisorsList = \yii\helpers\ArrayHelper::map($supervisors, 'id', function($model) {
            return $model->user->surname . ' ' . $model->user->name . ' ' . $model->user->patronymic;
        });
        
       $model = new \app\models\PracticeForm();
       
       if ($this->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
           $practice = new Practices();
            $practice->title = $model->title;
            $practice->type = $model->type;
            $practice->description = $model->description;
            $practice->start_date = $model->start_date;
            $practice->end_date = $model->end_date;
            $practice->total_hours = $model->total_hours;
            $practice->main_supervisor_id = 1;
            if ($practice->save()) {
                Yii::$app->session->setFlash('success', 'Программа практики успешно создана.');
                return $this->redirect(['index']);
            } else {
                // Останавливаем код и смотрим ошибки валидации ActiveRecord
                echo '<pre>';
                print_r($practice->getErrors());
                echo '</pre>';
                die();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'supervisorsList' => $supervisorsList,
        ]);
    }

    /**
     * Updates an existing Practices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Practices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Practices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Practices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Practices::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionLoadTemplate($practice_id)
    {
        // Находим шаблон по ID
        $model = new DocumentTemplates();
        $model->practice_id = $practice_id;

        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName('template_file');
            
            if ($file) {
                // Создаем безопасное уникальное имя файла
                $fileName = 'template_' . $practice_id . '_' . time() . '.' . $file->extension;
                $directory = Yii::getAlias('@webroot/uploads/templates/');
                
                // Проверяем и создаем директорию, если её нет
                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);
                }

                if ($file->saveAs($directory . $fileName)) {
                    $model->name = $file->baseName;
                    $model->file_path = 'uploads/templates/' . $fileName;
                    $model->created_at = time();
                    
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Шаблон успешно загружен.');
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            }
            Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла.');
        }
    
        return $this->render('load-template', [
            'model' => $model,
        ]);
    }
}
