<?php
namespace app\controllers;

use app\models\DiaryEntries;
use app\models\DiaryEntriesForm;
use app\models\GroupPractices;
use app\models\Groups;
use app\models\Practices;
use app\models\StudentAssignments;
use app\models\Students;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DiaryController extends Controller
{
    /**
     * Поведения контроллера: настройка прав доступа
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        // Студент имеет право просматривать дневник и добавлять новые записи
                        'actions' => ['index', 'view', 'create', 'update', 'print-template'],
                        'allow' => true,
                        'roles' => ['@'], // Только авторизованные
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === 'student';
                        }
                    ],
                    [
                        // Руководитель имеет право оценивать записи (действие evaluate)
                        'actions' => ['index', 'view', 'evaluate'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === 'supervisor';
                        }
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $assignmentId = Yii::$app->user->id; 
        $entries = DiaryEntries::find()->where(['assignment_id' => $assignmentId])->orderBy(['date'=>SORT_ASC])->all();

        return $this->render('index', ['entries' => $entries]);
    }

    public function actionCreate()
    {
        $model = new DiaryEntriesForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $entries = new DiaryEntries();
            $entries->assignment_id = (int)Yii::$app->user->identity->id;
            $entries->date = $model->date;
            $entries->content = $model->content;
            $entries->hours = $model->hours;
            $entries->supervisor_comment = $model->supervisor_comment;
            $entries->grade = $model->grade;
            $entries->is_locked = 0;

            if ($entries->save()) {
                Yii::$app->session->setFlash('success', 'Запись успешно создана.');
                return $this->redirect(['diary/index']);
            } else {
                var_dump($entries->getErrors());
                die;
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $entries = DiaryEntries::findOne($id);
        if (!$entries) {
            throw new NotFoundHttpException('Запись не найдена.');
        }
        $model = new DiaryEntriesForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Обновляем поля модели
            $entries->assignment_id = Yii::$app->user->id;
            $entries->date = $model->date;
            $entries->content = $model->content;
            $entries->hours = $model->hours;
            $entries->supervisor_comment = $model->supervisor_comment;
            $entries->grade = $model->grade;
            $entries->save();

            return $this->redirect(['index']);
        } else {
            // Загружаем текущие данные в модель для формы
            $model->date = $entries->date;
            $model->content = $entries->content;
            $model->hours = $entries->hours;
            $model->supervisor_comment = $entries->supervisor_comment;
            $model->grade = $entries->grade;
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Запись удалена.');
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = DiaryEntries::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }

    public function actionView($id)
    {
        $student = Students::findOne($id);
        $diaryEntries = DiaryEntries::find()->where(['assignment_id' => $id])->all();

        return $this->render('view', [
            'student' => $student,
            'diaryEntries' => $diaryEntries,
        ]);
    }

    public function actionEvaluate($id) 
    { 
        $model = DiaryEntries::findOne($id); 
        if (!$model) { 
            throw new NotFoundHttpException("Запись не найдена"); 
        } 
    
        // Включаем сценарий оценивания
        $model->scenario = 'evaluate'; 
    
        if (Yii::$app->request->isPost) { 
            if ($model->load(Yii::$app->request->post())) { 
                $model->is_locked = 1; // Блокируем запись после оценки
    
                if ($model->save()) { 
                    Yii::$app->session->setFlash('success', 'Оценка успешно сохранена!'); 
                    return $this->redirect(['view', 'id' => $model->assignment_id]); 
                } 
                
                // Если валидация не прошла, ошибки отобразятся в форме evaluate
                Yii::$app->session->setFlash('error', 'Ошибка при сохранении оценки.');
            } 
        } 
    
        return $this->render('evaluate', ['model' => $model]); 
    }

    public function actionPrintTemplate($assignment_id = null)
    {
        // ID текущего авторизованного пользователя Yii
        $currentUserId = Yii::$app->user->id;
    
        if ($assignment_id === null) {
            // Студент - пользователь
            $student = \app\models\Students::findOne(['user_id' => $currentUserId]);
    
            // Назначение практики - студент
            $assignment = \app\models\StudentAssignments::findOne(['student_id' => $student->id]);
        } else {
            $assignment = \app\models\StudentAssignments::findOne($assignment_id);
        }
    
        if (!$assignment) {
            throw new \yii\web\NotFoundHttpException('Назначение не найдено.');
        }
    
        // Запрос к записям дневника
        $entries = \app\models\DiaryEntries::find()
            ->where(['assignment_id' => $assignment->id])
            ->orderBy(['date' => SORT_ASC])
            ->all();
    
        return $this->render('print-template', [
            'assignment' => $assignment,
            'entries' => $entries,
        ]);
    }

}