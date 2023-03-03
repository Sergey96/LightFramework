<?php

namespace engine\core\user;

use engine\base\models\ActiveRecord;
use engine\WebApp;
use engine\core\exceptions as Exceptions;
use engine\components\AccessManager;
use common\User\SearchModels\UsersSearchModel;

class User extends ActiveRecord
{
    public $id;
    public $name;
    public $role;
    public $created;
    public $avatar;

    public $token;
    public static $attributeLabels =
        [
            'id' => ['ID', 'int', 'autoincrement'],
            'name' => ['NAME', 'text', 'required'],
            'role' => ['ROLE', 'text', 'null'],
            'token' => ['TOKEN', 'text', 'null'],
            'created' => ['CREATED', 'datetime', 'required'],
            'avatar' => ['AVATAR', 'text', 'required']
        ];

    private $session;

    public function __get($property)
    {
        if (property_exists(get_class($this), $property)) {
            return $property;
        } else
            throw new Exceptions\PropertyNotFoundException($property);
    }

    public function __construct()
    {
        $this->session = $_SESSION;
        $model = new UsersSearchModel();
        $login = $this->getSessionValue('user');
        if ($login) {
            $models = $model->findName($login);
            if (isset($models[0]))
                $model = $models[0];
            if ($this->compareString($model->token, $this->session['token'])) {
                $this->load($model->getDataAsArray(false));
            }
        }
    }

    private function getSessionValue($name)
    {
        if (isset($this->session[$name]))
            return $this->session[$name];
        else return false;
    }

    public function can()
    {
        $right = WebApp::$controller->accessRights();
        if ($this->id) {
            $roles = AccessManager::findRoles($this->id);
            $roles[] = "*";
        } else {
            $roles = ['?'];
        }

        $access = false;
        $this->roles = $roles;
        if ($right) {
            foreach ($right['access'] as $rule) {
                if ($rule['allow'] == true) {
                    $result = array_intersect($rule['roles'], $roles);
                    if (count($result) > 0) {
                        $method = array_search(WebApp::$controller->Action, $rule['actions']);
                        //var_dump($method);
                        if ($method === false)
                            $access = false;
                        else {
                            $access = true;
                            break;
                        }
                    }
                }
            }
            return $access;
        } else return true;
    }

    public function isRule($rule)
    {
        $method = array_search($rule, $this->roles);
        if ($method === false)
            return false;
        else return true;
    }

    public function login($user)
    {
        $model = new UsersSearchModel();
        $models = $model->findName($user->login);
        if (isset($models[0]))
            $model = $models[0];

        if (AccessManager::decryptPassword($user->password, $model->password)) {
            $this->load($model->getDataAsArray(false));
            $this->auth();
            $model->token = $_SESSION['token'];
            $model->setNotNew();
            $model->save();
            return true;
        }
        $user->error = 'Неверный логин или пароль';
        return false;
    }

    public function logout()
    {
        session_destroy();
    }

    private function auth()
    {
        $_SESSION['user'] = $this->name;
        $_SESSION['token'] = md5($this->name . $this->id . time());
        print_r($_SESSION);
    }

    private function checkPassword($authPassword, $tablePassword)
    {
        return AccessManager::decryptPassword($authPassword, $tablePassword);
    }

    private function compareString($authPassword, $tablePassword)
    {
        return strcmp($authPassword, $tablePassword) === 0;
    }

}