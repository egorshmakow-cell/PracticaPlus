<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\StudentAssignments;
use app\models\StudentAssignmentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentAssignmentsController implements the CRUD actions for StudentAssignments model.
 */
class StudentAssignmentsController extends Controller
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
     * Lists all StudentAssignments models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentAssignmentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentAssignments model.
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
     * Creates a new StudentAssignments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StudentAssignments();
        
        if ($this->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Карточка назначения успешно сформирована.');
            return $this->redirect(['index']);
        }

        $students = \yii\helpers\ArrayHelper::map(\app\models\Students::find()->joinWith('user')->all(), 'id', function($s) {
            return $s->user->surname . ' ' . $s->user->name;
        });
        $groups = \yii\helpers\ArrayHelper::map(\app\models\Groups::find()->all(), 'id', 'group_name');
        $supervisors = \yii\helpers\ArrayHelper::map(\app\models\Supervisors::find()->joinWith('user')->all(), 'id', function($m) {
            return $m->user->surname . ' ' . $m->user->name;
        });
        $practices = \yii\helpers\ArrayHelper::map(\app\models\Practices::find()->all(), 'id', 'title');


        return $this->render('create', [
            'model' => $model,
            'students' => $students,
            'groups' => $groups,
            'supervisors' => $supervisors,
            'practices' => $practices,
        ]);

    }

    /**
     * Updates an existing StudentAssignments model.
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
     * Deletes an existing StudentAssignments model.
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
     * Finds the StudentAssignments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StudentAssignments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentAssignments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
