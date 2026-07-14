<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\StudentDocuments;
use app\models\StudentDocumentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * StudentDocumentsController implements the CRUD actions for StudentDocuments model.
 */
class StudentDocumentsController extends Controller
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
     * Lists all StudentDocuments models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentDocumentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentDocuments model.
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
     * Creates a new StudentDocuments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StudentDocuments();
        $template = \yii\helpers\ArrayHelper::map(\app\models\DocumentTemplates::find()->all(), 'id', 'name');
        $assignment = \yii\helpers\ArrayHelper::map(\app\models\StudentAssignments::find()->joinWith('practice')->all(), 'id', function($s) {
            return $s->practice->title;
        });
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                // Обработка файла
                $uploadedFile = UploadedFile::getInstance($model, 'document_path');
                if ($uploadedFile) {
                    $path = 'uploads/ready-documents/' . uniqid() . '_' . $uploadedFile->name;
                    if ($uploadedFile->saveAs($path)) {
                        $model->document_path = $path;
                    }
                }
                
                $draftFile = UploadedFile::getInstance($model, 'draft_path');
                if ($draftFile) {
                    $draftPath = 'uploads/draft/' . uniqid() . '_' . $draftFile->name;
                    if ($draftFile->saveAs($draftPath)) {
                        $model->draft_path = $draftPath; 
                    }
                }
    
                if ($model->save()) {
                    Yii::$app->session->addFlash('success', 'Отчёт успешно загружен.');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->addFlash('error', 'Ошибка при сохранении отчёта.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'template' => $template,
            'assignment' => $assignment,
        ]);
    }

    /**
     * Updates an existing StudentDocuments model.
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
     * Deletes an existing StudentDocuments model.
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
     * Finds the StudentDocuments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StudentDocuments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentDocuments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
