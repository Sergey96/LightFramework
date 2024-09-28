<?php

namespace engine\base\controllers;

interface IController
{
    public function accessRights(): array;
    public function getViewPath(): string;
    public function action(): string;
    public function actionIndex(): string;

    public function execAction(): string;
}