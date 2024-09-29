<?php

namespace admin\controllers;

use engine\App;
use admin\models\UsersModel;
use admin\models\SearchModels\UsersSearchModel;
use engine\base\controllers\Controller;
use engine\components\AccessManager\AccessManager;

/**
 * Users - admin\controllers Контроллер
 */
/// Users - admin\controllers Контроллер
class Users extends Controller
{

    /**
     * Права доступа
     */
    public function accessRights(): array
    {
        return
            [
                'access' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'error', 'password'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'error'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'error'],
                        'roles' => ['*'],
                    ]
                ],
                'redirect' => [
                    'controller' => 'home',
                    'view' => 'login'
                ]
            ];
    }

    /**
     * action - Главная страница
     */
    public function actionIndex(): string
    {
        $searchModel = new UsersSearchModel();
        $dataProvider = $searchModel->search(App::$request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * action - Обновить запись
     */
    public function actionUpdate($id)
    {
        $model = new UsersModel();

        if ($model->load(App::$request->post())) {
            $model->save();
            $this->redirect(['view', 'id' => $id]);
        } else {
            $error = $model->getErrorsLoad();
            $model = $model->findOne($id);
            return $this->render('update', [
                'model' => $model,
                'error' => $error
            ]);
        }
    }

    /**
     * action - Обновить запись
     */
    public function actionPassword($id)
    {
        $model = new UsersModel();
        $password =  App::$request->post()['password']; // ?? 123456;
        if ($password) {
            $model = $model->findOne($id);
            $model->password = AccessManager::encryptPassword($password);
            $model->save(false);
            $this->redirect(['view', 'id' => $id]);
        } else {
            $model = $model->findOne($id);
            return $this->render('password', ['model' => $model]);
        }
    }

    /**
     * Action - Создать запись
     */
    public function actionCreate()
    {
        $model = new UsersModel();
        if ($model->load(App::$request->post())) {
            $model->save();
            $this->redirect(['index']);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * action - Просмотреть запись
     */
    public function actionView($id)
    {
        $model = new UsersModel();
        $model = $model->findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * action - Удалить запись
     */
    public function actionDelete($id)
    {
        $model = new UsersModel();
        $model = $model->findOne($id)->delete();
        $this->redirect(['index']);
    }

}
