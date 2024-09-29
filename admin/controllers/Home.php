<?php

namespace admin\controllers;

use admin\models\LoginFormModel;
use admin\models\UsersModel;
use engine\App;
use engine\base\controllers\Controller;
use engine\db\DataProvider\DataProvider;

/**
 * Home контроллер по-умолчанию
 */
/// Home контроллер по-умолчанию
class Home extends Controller
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
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'logout', 'error'],
                        'roles' => ['admin', '*'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'error', 'signup'],
                        'roles' => ['?'],
                    ],
                ],
                'redirect' => [
                    'controller' => 'home',
                    'view' => 'login'
                ]
            ];
    }

    /**
     * action - действие по-умолчанию
     */
    public function action(): string
    {
        $model = new FilmsModel();
        return $this->render('index', ['model' => $model]);
    }

    /**
     * action - Главная страница
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * action - Обновить запись
     */
    public function actionUpdate($id)
    {
        $model = new FilmsModel();
        //if($model->load(WebApp::$request->post())){
        if (App::$request->post()) {
            $model->save();
            $this->redirect(['view', 'id' => $id]);
        } else {
            $model = $model->findOne($id);
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * action - Создать запись
     */
    public function actionView($id)
    {
        /// TODO: Сделать свойство Table статическим
        $model = new FilmsModel();
        $model = $model->findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * Авторизация
     */
    public function actionLogin()
    {
        $model = new LoginFormModel();
        if ($model->load(App::$request->post()) && $model->login()) {
            $this->redirect(['index']);
        } else {
            return $this->render('login', ['model' => $model]);
        }
    }

    /**
     * Авторизация
     */
    public function actionSignup()
    {
        $model = new LoginFormModel();
        return $this->render('signup', ['model' => $model]);
    }


    /**
     * Выход из аккаунта
     */
    public function actionLogout()
    {
        App::$user->logout();
        return $this->redirect(['index'], 'home');
    }

}

?>