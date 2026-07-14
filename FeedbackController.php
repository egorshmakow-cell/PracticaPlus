<?php

namespace app\controllers;

use app\models\DiaryEntries;
use app\models\Practices;
use app\models\RegisterForm;
use app\models\ReportFeedback;
use app\models\Reports;
use app\models\StudentAssignments;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index'], // только для действия index
                'rules' => [
                    [
                        'allow' => true, // запрещаем доступ
                        'actions' => ['index'],
                        'roles' => ['@'], // для аутентифицированных
                    ],
                ],
                'denyCallback' => function () {
                    // при отказе — перенаправляем на логин
                    return \Yii::$app->response->redirect(['site/login']);
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex()
    {
        // перенаправляем на страницу авторизации
        return $this->render('index'); // или другой URL логина
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->isSupervisor()) {
                return $this->redirect(['supervisor/student']);
            } elseif (Yii::$app->user->identity->isAdmin()) {
                return $this->redirect(['admin/user/index']);
            } else {
                return $this->redirect(['site/practice']);
            }
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPractice($student_id = null)
    {
        $query = StudentAssignments::find();
    
        // 1. Определение ID студента
        if ($student_id !== null) {
            $query->andWhere(['student_id' => $student_id]);
        } else {
            $currentUserId = Yii::$app->user->id;
            $studentRecord = \app\models\Students::findOne(['user_id' => $currentUserId]);
    
            if ($studentRecord) {
                $query->andWhere(['student_id' => $studentRecord->id]);
            } else {
                // Возвращаем пустой результат (0 записей) безопасным способом
                $query->andWhere(['id' => 0]); 
            }
        }
    
        // Жадная загрузка связи для оптимизации SQL-запросов (избавляет от проблемы N+1)
        $query->joinWith('practice');
    
        // 2. Исправленная фильтрация по дате (добавлено имя связанной таблицы)
        $startDate = Yii::$app->request->get('start_date');
        if ($startDate) {
            $query->andWhere(['>=', 'practices.start_date', $startDate]);
        }
    
        // 3. Сортировка по убыванию даты начала практики
        $query->orderBy(['practices.start_date' => SORT_DESC]);
    
        $assignment = $query->all();
    
        return $this->render('practice', [
            'assignment' => $assignment,
        ]);
    }

    public function actionReports()
    {
        $model = new Reports();

        if ($model->load(Yii::$app->request->post())) {
            // Проверка папки
            $uploadDir = 'uploads/reports/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadedFile = \yii\web\UploadedFile::getInstance($model, 'file');
            if ($uploadedFile) {
                $path = $uploadDir . uniqid() . '_' . $uploadedFile->name;
                if ($uploadedFile->saveAs($path)) {
                    $model->document_path = $path;
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла.');
                    return $this->render('create', ['model' => $model]);
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Отчёт успешно загружен.');
                return $this->redirect(['reports']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при сохранении отчёта.');
            }
        }

        // Получение списка практик
        $practices = ArrayHelper::map(Practices::find()->all(), 'id', 'title');

        return $this->render('reports', [
            'model' => $model,
            'practices' => $practices,
        ]);
    }

    public function actionPracticeStatus($id)
    {
        $practice = Practices::findOne($id);

        $currentReport = Reports::find()
            ->where(['assignment_id' => $id])
            ->one();

        $reports = Reports::find()
            ->where(['assignment_id' => $id])
            ->all();

        // Собираем обратную связь для всех отчётов
        // данные из одного столбца многомерного массива
        $feedbacks = ReportFeedback::find()
            ->where(['report_id' => array_column($reports, 'id')])
            ->orderBy(['feedback_date' => SORT_ASC])
            ->all();

        return $this->render('practice-status', [
            'practice' => $practice,
            'currentReport' => $currentReport,
            'reports' => $reports,
            'feedbacks' => $feedbacks,
        ]);
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
    
    public function actionComment(){
        $entries = DiaryEntries::find()->all();
        return $this->render('comment', [
            'entries' => $entries,
        ]);
    }
}
