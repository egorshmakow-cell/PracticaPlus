<?php
namespace app\controllers;

use app\models\StudentAssignments;
use Yii;
use app\models\Reports;
use app\models\Groups;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Supervisors;

class SupervisorController extends Controller
{
    public function actionStudent()
    {
        $searchSurname = Yii::$app->request->get('surname', '');
        $searchPractice = Yii::$app->request->get('practice', '');
        $searchGroup = Yii::$app->request->get('group', '');
        
        $query = StudentAssignments::find()
            ->joinWith('practice')
            ->with(['student.user', 'group', 'practice']);
        
        // Фильтр по фамилии
        if ($searchSurname !== '') {
            $query->andWhere(['like', 'user.surname', $searchSurname]);
        }
        
        // Фильтр по практике
        if ($searchPractice !== '') {
            $query->andWhere(['like', 'practices.title', $searchPractice]);
        }
    
        // Фильтр по группе
        if ($searchGroup !== '') {
            $query->joinWith('group');
            $query->andWhere(['like', 'groups.group_name', $searchGroup]);
        }
        
        $assignments = $query->all();
        
        // Отобразить сообщение или вернуть ошибку
        return $this->render('student', [
            'assignments' => $assignments,
            'searchSurname' => $searchSurname,
            'searchPractice' => $searchPractice,
            'searchGroup' => $searchGroup,
        ]);
    }

    public function actionReviewReports()
    {
        // Получим все отчеты для руководителя
        $reports = Reports::find()->all();

        return $this->render('review-reports', [
            'reports' => $reports,
        ]);
    }

    public function actionSubmitReview($id)
    {
        $model = StudentAssignments::findOne($id);
        if (!$model || $model->status !== 'under_review') {
            throw new NotFoundHttpException('Документ не найден или не требует проверки.');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Меняем статус на 'completed' (Готов к печати)
            $model->status = 'completed';
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Документ утвержден. Студент может его распечатать.');
                return $this->redirect(['review-reports']);
            }
        }
        
        return $this->render('submit-review', [
            'model' => $model,
            'supervisorUser' => Yii::$app->user->identity // Профиль руководителя для автоподстановки на экране
        ]);

    }

    public function actionMonitoring()
    {
        // Получаем параметры поиска из GET-запроса
        $searchName = Yii::$app->request->get('searchName', '');
        $searchPractice = Yii::$app->request->get('searchPractice', '');
        $searchGroup = Yii::$app->request->get('searchGroup', '');

        // Строим запрос
        $query = StudentAssignments::find()
            ->joinWith(['student.user', 'practice.practice', 'group.group']);

        if ($searchName) {
            $query->andWhere(['or',
                ['like', 'user.surname', $searchName],
                ['like', 'user.name', $searchName],
                ['like', 'user.patronymic', $searchName],
            ]);
        }

        if ($searchPractice) {
            $query->andWhere(['like', 'practices.title', $searchPractice]);
        }

        if ($searchGroup) {
            $query->andWhere(['like', 'groups.group_name', $searchGroup]);
        }

        $assignments = $query->orderBy(['student_id' => SORT_ASC])->all();

        return $this->render('monitoring', [
            'assignments' => $assignments,
            'searchName' => $searchName,
            'searchPractice' => $searchPractice,
            'searchGroup' => $searchGroup,
        ]);
    }

    public function actionGroups()
    {
        $assignments = StudentAssignments::find()->with(['student.user', 'group', 'practice'])->all();
        return $this->render('groups', ['assignments' => $assignments]);
    }

    public function actionPractice()
    {
        $assignments = StudentAssignments::find()->with(['student.user', 'group', 'practice'])->all();

        return $this->render('practice', [
            'assignments' => $assignments,
        ]);
    }
}