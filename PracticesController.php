<?php
namespace app\modules\admin\controllers;

use app\models\PermissionForm;
use app\models\User;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class RoleController extends Controller
{
    public $layout = 'admin';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        $permissions = $auth->getPermissions();

        $assignments = [];
        foreach ($roles as $role) {
            $assignments[$role->name] = $auth->getChildren($role->name);
        }

        return $this->render('index', [
            'roles' => $roles,
            'permissions' => $permissions,
            'assignments' => $assignments,
        ]);
    }

    public function actionCreate()
    {
        $auth = Yii::$app->authManager;
        $model = new \app\models\RoleForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $name = trim($model->name);
            $description = trim($model->description);

            if ($auth->getRole($name)) {
                $model->addError('name', 'Роль с таким названием уже существует.');
            } else {
                $role = $auth->createRole($name);
                $role->description = $description;
                $auth->add($role);
                Yii::$app->session->setFlash('success', 'Роль успешно создана.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        if (!$role) {
            throw new NotFoundHttpException('Роль не найдена.');
        }

        $model = new \app\models\RoleForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Проверка уникальности имени, если изменяете название
            if ($model->name !== $role->name && $auth->getRole($model->name)) {
                $model->addError('name', 'Такая роль уже существует.');
            } else {
                // Обновляем роль
                $role->name = $model->name;
                $role->description = $model->description;
                $auth->update($name, $role);

                Yii::$app->session->setFlash('success', 'Роль успешно обновлена.');
                return $this->redirect(['index']);
            }
        } else {
            // Загружаем текущие данные роли в форму
            $model->name = $role->name;
            $model->description = $role->description;
        }

        return $this->render('update', [
            'model' => $model,
            'roleName' => $name,
        ]);
    }

    public function actionPermissionCreate()
    {
        $model = new \app\models\PermissionForm();
        $auth = \Yii::$app->authManager;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($auth->getPermission($model->name)) {
                $model->addError('name', 'Разрешение с таким именем уже существует.');
            } else {
                $permission = $auth->createPermission($model->name);
                $permission->description = $model->description;
                $auth->add($permission);
                \Yii::$app->session->setFlash('success', 'Разрешение успешно создано.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('permission-create', [
            'model' => $model,
        ]);
    }

    public function actionPermissionUpdate($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        if (!$role) {
            throw new NotFoundHttpException("Роль не найдена");
        }

        $model = new PermissionForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $permission = $auth->getPermission($model->name);
            if (!$permission) {
                // создаем новую разрешение
                $permission = $auth->createPermission($model->name);
            }
            $permission->description = $model->description;
            $auth->update($name, $permission);
            Yii::$app->session->setFlash('success', 'Разрешение сохранено.');
            return $this->refresh();
        } elseif (Yii::$app->request->isGet) {
            // Загружаем текущие данные разрешения, если есть
            $existingPerm = $auth->getPermission($role->name);
            if ($existingPerm) {
                $model->name = $existingPerm->name;
                $model->description = $existingPerm->description;
            }
        }

        return $this->render('permission-update', [
            'model' => $model,
            'role' => $role,
        ]);
    }

    public function actionDelete($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);

        if (!$role) {
            throw new NotFoundHttpException('Роль не найдена.');
        }

        // Удаляем роль
        $auth->remove($role);
        Yii::$app->session->setFlash('success', 'Роль успешно удалена.');

        return $this->redirect(['index']);
    }

}